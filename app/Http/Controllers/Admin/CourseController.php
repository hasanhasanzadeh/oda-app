<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseAllRequest;
use App\Http\Requests\Course\CourseCreateFormRequest;
use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CourseDeleteRequest;
use App\Http\Requests\Course\CourseFindRequest;
use App\Http\Requests\Course\CourseUpdateFormRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Discount;
use App\Models\DiscountUsage;
use App\Models\User;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function __construct(private readonly CourseService $courseService)
    {
    }

    public function index(CourseAllRequest $request)
    {
        $title = __('message.courses');
        $validated = $request->validated();
        $courses = $this->courseService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.course.index', [
            'title' => $title,
            'courses' => $courses,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(CourseCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.course.create', compact([ 'title']));
    }

    public function store(CourseCreateRequest $request)
    {
        $course = $this->courseService->create($request->validated());
        if (!$course) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('courses.index'));
    }


    public function show(CourseFindRequest $request,Course $course)
    {
        $title = __('message.show');

        return view('admin.course.show', compact([ 'title', 'course']));
    }


    public function edit(CourseUpdateFormRequest $request,Course $course)
    {
        $title = __('message.edit');

        return view('admin.course.edit', compact(['title', 'course']));
    }


    public function update(CourseUpdateRequest $request, Course $course)
    {
        $course = $this->courseService->update($course->id,$request->validated());
        if (!$course) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('courses.index'));
    }

    public function destroy(CourseDeleteRequest $request,Course $course)
    {
        $course = $this->courseService->delete($course->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('courses.index'));
    }

    public function search(Request $request)
    {
        $courses = [];
        if ($request->has('q')) {
            $search = $request->q;
            $courses = Course::select("id", "course_persian_name")
                ->where('course_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $courses = collect($courses);

        return response()->json($courses);
    }

    public function purchase(Course $course)
    {
        $title = __('message.purchase_course');

        $availableDiscounts = Discount::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function ($query) use ($course) {
                $query->where('applicable_to', 'all')
                    ->orWhere('applicable_to', 'course')
                    ->orWhere(function ($q) use ($course) {
                        $q->where('applicable_to', 'specific_course')
                          ->where('course_id', $course->id);
                    });
            })
            ->get();

        return view('admin.course.purchase', compact('title', 'course', 'availableDiscounts'));
    }

    public function processPurchase(Request $request, Course $course)
    {
        $validated = $request->validate([
            'discount_codes' => 'nullable|array',
            'discount_codes.*' => 'string|max:50',
            'payment_method' => 'required|in:cash,card,bank_transfer,online,wallet',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $originalAmount = $course->price;
        $discountCodes = $validated['discount_codes'] ?? [];

        $discountResult = $this->calculateDiscounts($discountCodes, 'course', $course->id, $originalAmount, $user->id);

        if (!$discountResult['success']) {
            toast($discountResult['message'], 'error');
            return back()->withInput();
        }

        $finalAmount = $discountResult['final_amount'];
        $appliedDiscounts = $discountResult['discounts'];

        try {
            DB::beginTransaction();

            $enrollment = CourseEnrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'original_amount' => $originalAmount,
                'discount_amount' => $discountResult['total_discount'],
                'final_amount' => $finalAmount,
                'payment_method' => $validated['payment_method'],
                'status' => 'enrolled',
                'enrolled_at' => now(),
                'notes' => $validated['notes'],
            ]);

            foreach ($appliedDiscounts as $discount) {
                DiscountUsage::create([
                    'discount_id' => $discount['id'],
                    'user_id' => $user->id,
                    'item_type' => 'course',
                    'item_id' => $course->id,
                    'original_amount' => $originalAmount,
                    'discount_amount' => $discount['amount'],
                    'final_amount' => $finalAmount,
                    'enrollment_id' => $enrollment->id,
                ]);

                $discountModel = Discount::find($discount['id']);
                $discountModel->increment('usage_count');
            }

            DB::commit();

            toast(__('message.course_purchased_successfully'), 'success');
            return redirect()->route('admin.courses.show', $course);

        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('message.purchase_failed'), 'error');
            return back()->withInput();
        }
    }

    public function applyDiscount(Request $request, Course $course)
    {
        $validated = $request->validate([
            'discount_codes' => 'required|array|min:1',
            'discount_codes.*' => 'string|max:50',
            'amount' => 'required|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $userId = $validated['user_id'] ?? Auth::id();

        $result = $this->calculateDiscounts(
            $validated['discount_codes'],
            'course',
            $course->id,
            $validated['amount'],
            $userId
        );

        return response()->json($result);
    }

    private function calculateDiscounts($codes, $itemType, $itemId, $originalAmount, $userId = null)
    {
        if (empty($codes)) {
            return [
                'success' => true,
                'original_amount' => $originalAmount,
                'total_discount' => 0,
                'final_amount' => $originalAmount,
                'discounts' => [],
                'savings_percentage' => 0
            ];
        }

        $discounts = Discount::whereIn('code', $codes)
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->orderBy('discount_value', 'desc')
            ->get();

        $user = $userId ? User::find($userId) : null;
        $applicableDiscounts = [];
        $totalDiscount = 0;
        $currentAmount = $originalAmount;
        $hasNonStackable = false;

        foreach ($discounts as $discount) {
            if ($hasNonStackable) {
                break;
            }

            if ($user && !empty($discount->user_roles) && !in_array($user->role, $discount->user_roles)) {
                continue;
            }

            if (!$discount->isApplicableTo($itemType, $itemId)) {
                continue;
            }

            if ($discount->usage_limit && $discount->usage_count >= $discount->usage_limit) {
                continue;
            }

            if ($user && $discount->usage_limit_per_user) {
                $userUsageCount = $discount->usages()->where('user_id', $user->id)->count();
                if ($userUsageCount >= $discount->usage_limit_per_user) {
                    continue;
                }
            }

            if ($discount->minimum_amount && $currentAmount < $discount->minimum_amount) {
                continue;
            }

            $discountAmount = $discount->calculateDiscount($currentAmount);

            if ($discount->maximum_discount && $discountAmount > $discount->maximum_discount) {
                $discountAmount = $discount->maximum_discount;
            }

            $applicableDiscounts[] = [
                'id' => $discount->id,
                'name' => $discount->name,
                'code' => $discount->code,
                'type' => $discount->discount_type,
                'value' => $discount->discount_value,
                'amount' => $discountAmount,
                'stackable' => $discount->stackable
            ];

            $totalDiscount += $discountAmount;

            if ($discount->stackable) {
                $currentAmount -= $discountAmount;
            } else {
                $hasNonStackable = true;
            }
        }

        return [
            'success' => true,
            'original_amount' => $originalAmount,
            'total_discount' => $totalDiscount,
            'final_amount' => max(0, $originalAmount - $totalDiscount),
            'discounts' => $applicableDiscounts,
            'savings_percentage' => $originalAmount > 0 ? round(($totalDiscount / $originalAmount) * 100, 2) : 0
        ];
    }

    public function enrollmentHistory(Request $request)
    {
        $title = __('message.course_enrollment_history');

        $query = CourseEnrollment::with(['user', 'course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('course', function ($q) use ($search) {
                $q->where('course_persian_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('enrolled_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('enrolled_at', '<=', $request->date_to . ' 23:59:59');
        }

        $enrollments = $query->orderBy('enrolled_at', 'desc')->paginate(20);

        $courses = Course::where('is_active', true)->orderBy('course_persian_name')->get();

        $statistics = [
            'total_enrollments' => CourseEnrollment::count(),
            'total_revenue' => CourseEnrollment::sum('final_amount'),
            'total_discounts' => CourseEnrollment::sum('discount_amount'),
            'average_discount' => CourseEnrollment::where('discount_amount', '>', 0)->avg('discount_amount'),
        ];

        return view('admin.course.enrollment-history', compact(
            'title', 'enrollments', 'courses', 'statistics'
        ));
    }

    public function discountReport(Request $request)
    {
        $title = __('message.course_discount_report');

        $query = DiscountUsage::with(['discount', 'user'])
            ->where('item_type', 'course');

        if ($request->filled('course_id')) {
            $query->where('item_id', $request->course_id);
        }

        if ($request->filled('discount_code')) {
            $query->whereHas('discount', function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->discount_code . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $usages = $query->orderBy('created_at', 'desc')->paginate(20);

        $courses = Course::where('is_active', true)->orderBy('course_persian_name')->get();

        $statistics = [
            'total_discount_usage' => DiscountUsage::where('item_type', 'course')->count(),
            'total_discount_amount' => DiscountUsage::where('item_type', 'course')->sum('discount_amount'),
            'average_discount' => DiscountUsage::where('item_type', 'course')->avg('discount_amount'),
            'unique_users' => DiscountUsage::where('item_type', 'course')->distinct('user_id')->count(),
        ];

        return view('admin.course.discount-report', compact(
            'title', 'usages', 'courses', 'statistics'
        ));
    }
}
