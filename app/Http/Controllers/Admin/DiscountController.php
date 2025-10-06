<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $title = __('message.discounts');

        $query = Discount::with(['course', 'product']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        if ($request->filled('applicable_to')) {
            $query->where('applicable_to', $request->applicable_to);
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['created_at', 'name', 'code', 'discount_value', 'valid_from', 'valid_until', 'usage_count'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $query->orderBy($sort, $direction);

        $perPage = $request->get('per_page', 15);
        $allowedPerPage = [10, 15, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 15;
        }

        $discounts = $query->paginate($perPage);

        $totalDiscounts = Discount::count();
        $activeDiscounts = Discount::where('is_active', true)->count();
        $expiredDiscounts = Discount::where('valid_until', '<', now())->count();
        $totalUsage = Discount::sum('usage_count');

        session(['previous_url' => url()->full()]);

        return view('admin.discount.index', compact([
            'title', 'discounts', 'totalDiscounts', 'activeDiscounts',
            'expiredDiscounts', 'totalUsage', 'sort', 'direction', 'perPage', 'allowedPerPage'
        ]));
    }

    public function create()
    {
        $title = __('message.create_discount');

        $courses = Course::where('is_active', true)->orderBy('course_persian_name')->get();
        $products = Product::where('is_active', true)->orderBy('product_persian_name')->get();

        return view('admin.discount.create', compact([
            'title', 'courses', 'products'
        ]));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:discounts,code',
            'description' => 'nullable|string|max:1000',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'applicable_to' => 'required|in:all,course,product,specific_course,specific_product',
            'course_id' => 'nullable|exists:courses,id',
            'product_id' => 'nullable|exists:products,id',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'stackable' => 'boolean',
            'user_roles' => 'nullable|array',
            'user_roles.*' => 'in:student,teacher,staff',
        ]);

        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            toast(__('message.percentage_discount_max_100'), 'error');
            return back()->withInput();
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['stackable'] = $request->boolean('stackable', false);
        $validated['user_roles'] = $validated['user_roles'] ?? [];

        $discount = Discount::create($validated);

        if (!$discount) {
            toast(__('message.server_error'), 'error');
            return back()->withInput();
        }

        toast(__('message.discount_created'), 'success');
        return redirect(session('previous_url') ?? route('admin.discounts.index'));
    }

    public function show(Discount $discount)
    {
        $title = __('message.discount_details');

        $discount->load(['course', 'product', 'usages.user']);

        $usageStats = [
            'total_usage' => $discount->usage_count,
            'unique_users' => $discount->usages()->distinct('user_id')->count(),
            'total_savings' => $discount->usages()->sum('discount_amount'),
            'avg_discount' => $discount->usages()->avg('discount_amount'),
        ];

        $recentUsages = $discount->usages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.discount.show', compact(
            'title', 'discount', 'usageStats', 'recentUsages'
        ));
    }

    public function edit(Discount $discount)
    {
        $title = __('message.edit_discount');

        $courses = Course::where('is_active', true)->orderBy('course_persian_name')->get();
        $products = Product::where('is_active', true)->orderBy('product_persian_name')->get();

        return view('admin.discount.edit', compact([
            'title', 'discount', 'courses', 'products'
        ]));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:discounts,code,' . $discount->id,
            'description' => 'nullable|string|max:1000',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'applicable_to' => 'required|in:all,course,product,specific_course,specific_product',
            'course_id' => 'nullable|exists:courses,id',
            'product_id' => 'nullable|exists:products,id',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'stackable' => 'boolean',
            'user_roles' => 'nullable|array',
            'user_roles.*' => 'in:student,teacher,staff',
        ]);

        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            toast(__('message.percentage_discount_max_100'), 'error');
            return back()->withInput();
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['stackable'] = $request->boolean('stackable', false);
        $validated['user_roles'] = $validated['user_roles'] ?? [];

        $updated = $discount->update($validated);

        if (!$updated) {
            toast(__('message.server_error'), 'error');
            return back()->withInput();
        }

        toast(__('message.discount_updated'), 'success');
        return redirect(session('previous_url') ?? route('admin.discounts.index'));
    }

    public function destroy(Discount $discount)
    {
        if ($discount->usage_count > 0) {
            toast(__('message.cannot_delete_used_discount'), 'error');
            return back();
        }

        $deleted = $discount->delete();

        if (!$deleted) {
            toast(__('message.server_error'), 'error');
            return back();
        }

        toast(__('message.discount_deleted'), 'success');
        return redirect(session('previous_url') ?? route('admin.discounts.index'));
    }

    public function validate(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'item_type' => 'required|in:course,product',
            'item_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $discount = Discount::where('code', $validated['code'])
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->first();

        if (!$discount) {
            return response()->json([
                'valid' => false,
                'message' => __('message.invalid_discount_code')
            ]);
        }

        $user = $validated['user_id'] ? User::find($validated['user_id']) : null;

        if ($user && !empty($discount->user_roles) && !in_array($user->role, $discount->user_roles)) {
            return response()->json([
                'valid' => false,
                'message' => __('message.discount_not_applicable_to_user_role')
            ]);
        }

        if (!$discount->isApplicableTo($validated['item_type'], $validated['item_id'])) {
            return response()->json([
                'valid' => false,
                'message' => __('message.discount_not_applicable_to_item')
            ]);
        }

        if ($discount->usage_limit && $discount->usage_count >= $discount->usage_limit) {
            return response()->json([
                'valid' => false,
                'message' => __('message.discount_usage_limit_reached')
            ]);
        }

        if ($user && $discount->usage_limit_per_user) {
            $userUsageCount = $discount->usages()->where('user_id', $user->id)->count();
            if ($userUsageCount >= $discount->usage_limit_per_user) {
                return response()->json([
                    'valid' => false,
                    'message' => __('message.discount_user_limit_reached')
                ]);
            }
        }

        if ($discount->minimum_amount && $validated['amount'] < $discount->minimum_amount) {
            return response()->json([
                'valid' => false,
                'message' => __('message.minimum_amount_required', ['amount' => $discount->minimum_amount])
            ]);
        }

        $discountAmount = $discount->calculateDiscount($validated['amount']);

        return response()->json([
            'valid' => true,
            'discount' => [
                'id' => $discount->id,
                'name' => $discount->name,
                'code' => $discount->code,
                'type' => $discount->discount_type,
                'value' => $discount->discount_value,
                'amount' => $discountAmount,
                'stackable' => $discount->stackable,
                'final_amount' => $validated['amount'] - $discountAmount
            ]
        ]);
    }

    public function calculateMultiple(Request $request)
    {
        $validated = $request->validate([
            'codes' => 'required|array|min:1',
            'codes.*' => 'string|max:50',
            'item_type' => 'required|in:course,product',
            'item_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $discounts = Discount::whereIn('code', $validated['codes'])
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->get();

        $user = $validated['user_id'] ? User::find($validated['user_id']) : null;
        $applicableDiscounts = [];
        $totalDiscount = 0;
        $originalAmount = $validated['amount'];
        $currentAmount = $originalAmount;

        foreach ($discounts as $discount) {
            if ($user && !empty($discount->user_roles) && !in_array($user->role, $discount->user_roles)) {
                continue;
            }

            if (!$discount->isApplicableTo($validated['item_type'], $validated['item_id'])) {
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
                break;
            }
        }

        return response()->json([
            'original_amount' => $originalAmount,
            'total_discount' => $totalDiscount,
            'final_amount' => $originalAmount - $totalDiscount,
            'discounts' => $applicableDiscounts,
            'savings_percentage' => $originalAmount > 0 ? round(($totalDiscount / $originalAmount) * 100, 2) : 0
        ]);
    }

    public function toggle(Discount $discount)
    {
        $discount->is_active = !$discount->is_active;
        $discount->save();

        $status = $discount->is_active ? __('message.activated') : __('message.deactivated');
        toast(__('message.discount_status_updated', ['status' => $status]), 'success');

        return back();
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'discount_ids' => 'required|array|min:1',
            'discount_ids.*' => 'exists:discounts,id',
        ]);

        $discounts = Discount::whereIn('id', $validated['discount_ids'])->get();
        $count = 0;

        foreach ($discounts as $discount) {
            switch ($validated['action']) {
                case 'activate':
                    $discount->update(['is_active' => true]);
                    $count++;
                    break;

                case 'deactivate':
                    $discount->update(['is_active' => false]);
                    $count++;
                    break;

                case 'delete':
                    if ($discount->usage_count == 0) {
                        $discount->delete();
                        $count++;
                    }
                    break;
            }
        }

        $message = match ($validated['action']) {
            'activate' => __('message.discounts_activated', ['count' => $count]),
            'deactivate' => __('message.discounts_deactivated', ['count' => $count]),
            'delete' => __('message.discounts_deleted', ['count' => $count]),
        };

        toast($message, 'success');
        return back();
    }

    public function report(Request $request)
    {
        $title = __('message.discount_usage_report');

        $query = DB::table('discount_usages')
            ->join('discounts', 'discount_usages.discount_id', '=', 'discounts.id')
            ->join('users', 'discount_usages.user_id', '=', 'users.id')
            ->select([
                'discounts.name as discount_name',
                'discounts.code as discount_code',
                'users.name as user_name',
                'discount_usages.original_amount',
                'discount_usages.discount_amount',
                'discount_usages.final_amount',
                'discount_usages.item_type',
                'discount_usages.item_id',
                'discount_usages.created_at'
            ]);

        if ($request->filled('date_from')) {
            $query->where('discount_usages.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('discount_usages.created_at', '<=', $request->date_to . ' 23:59:59');
        }

        if ($request->filled('discount_code')) {
            $query->where('discounts.code', 'like', '%' . $request->discount_code . '%');
        }

        $usages = $query->orderBy('discount_usages.created_at', 'desc')->paginate(20);

        $statistics = [
            'total_usages' => DB::table('discount_usages')->count(),
            'total_discount_given' => DB::table('discount_usages')->sum('discount_amount'),
            'average_discount' => DB::table('discount_usages')->avg('discount_amount'),
            'unique_users' => DB::table('discount_usages')->distinct('user_id')->count(),
        ];

        return view('admin.discount.report', compact('title', 'usages', 'statistics'));
    }
}