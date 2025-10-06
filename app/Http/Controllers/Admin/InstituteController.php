<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Institute\InstituteAllRequest;
use App\Http\Requests\Institute\InstituteCreateRequest;
use App\Http\Requests\Institute\InstituteDeleteRequest;
use App\Http\Requests\Institute\InstituteFindRequest;
use App\Http\Requests\Institute\InstituteUpdateFormRequest;
use App\Http\Requests\Institute\InstituteUpdateRequest;
use App\Models\Institute;
use App\Services\InstituteService;
use Illuminate\Http\Request;


class InstituteController extends Controller
{
    public function __construct(readonly private InstituteService $instituteService)
    {

    }
    public function index(InstituteAllRequest $request)
    {
        $title = __('message.institutes');
        $validated = $request->validated();
        $institutes = $this->instituteService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.institute.index', [
            'title' => $title,
            'institutes' => $institutes,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function create(InstituteAllRequest $request)
    {
        $title = __('message.create_institute');

        return view('admin.institute.create', compact('title'));
    }

    public function store(InstituteCreateRequest $request)
    {
        $institute = $this->instituteService->create($request->validated());

        if (!$institute) {
            toast(__('message.server_error'), 'error');
            return back()->withInput();
        }

        toast(__('message.institute_created'), 'success');
        return redirect(session('previous_url') ?? route('admin.institutes.index'));
    }

    public function show(InstituteFindRequest $request,Institute $institute)
    {
        $title = __('message.institute_details');

        $institute = Institute::with([
            'city',
            'manager',
            'photo',
            'departments'
        ])->withCount([
                'teachers',
                'students',
                'staffs',
                'departments',
                'rooms',
                'courses',
                'users'
        ])->findOrFail($institute->id);

        return view('admin.institute.show', compact('institute','title'));
    }

    public function edit(InstituteUpdateFormRequest $request,Institute $institute)
    {
        $title = __('message.edit_institute');

        return view('admin.institute.edit', compact('title', 'institute'));
    }

    public function update(InstituteUpdateRequest $request, Institute $institute)
    {
        $institute = $this->instituteService->update($institute->id,$request->validated());

        if (!$institute) {
            toast(__('message.server_error'), 'error');
            return back()->withInput();
        }

        toast(__('message.institute_updated'), 'success');
        return redirect(session('previous_url') ?? route('admin.institutes.index'));
    }

    public function destroy(InstituteDeleteRequest $request,Institute $institute)
    {
        if ($institute->students()->count() > 0 ||
            $institute->departments()->count() > 0) {
            toast(__('message.cannot_delete_institute_has_records'), 'error');
            return back();
        }
        $deleted = $institute->delete();

        if (!$deleted) {
            toast(__('message.server_error'), 'error');
            return back();
        }
        toast(__('message.institute_deleted'), 'success');
        return redirect(session('previous_url') ?? route('admin.institutes.index'));
    }

    public function search(Request $request)
    {
        $institutes = [];

        if ($request->has('q')) {
            $search = $request->q;
            $institutes = Institute::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%")
                          ->orWhere('code', 'LIKE', "%$search%");
                })
                ->select('id', 'name', 'code')
                ->limit(10)
                ->get();
        }

        return response()->json($institutes);
    }

    public function activate(Institute $institute)
    {
        $institute->update(['is_active' => true]);

        toast(__('message.institute_activated'), 'success');
        return back();
    }

    public function deactivate(Institute $institute)
    {
        $institute->update(['is_active' => false]);

        toast(__('message.institute_deactivated'), 'success');
        return back();
    }

    public function users(Institute $institute, Request $request)
    {
        $title = __('message.institute_users');

        $query = $institute->users()->with(['department', 'level']);

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);

        return view('admin.institute.users', compact('title', 'institute', 'users'));
    }

    public function departments(Institute $institute)
    {
        $title = __('message.institute_departments');

        $departments = $institute->departments()
            ->withCount(['users'])
            ->orderBy('name')
            ->get();

        return view('admin.institute.departments', compact('title', 'institute', 'departments'));
    }

    public function statistics(Institute $institute)
    {
        $title = __('message.institute_statistics');

        $userStats = [
            'total_users' => $institute->users()->count(),
            'students' => $institute->users()->where('role', 'student')->count(),
            'teachers' => $institute->users()->where('role', 'teacher')->count(),
            'staff' => $institute->users()->where('role', 'staff')->count(),
            'active_users' => $institute->users()->where('is_active', true)->count(),
            'inactive_users' => $institute->users()->where('is_active', false)->count(),
        ];

        // Department statistics
        $departmentStats = $institute->departments()
            ->withCount(['users'])
            ->get()
            ->map(function ($dept) {
                return [
                    'name' => $dept->name,
                    'users_count' => $dept->users_count,
                ];
            });

        // Monthly registration trends (last 12 months)
        $monthlyTrends = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = $institute->users()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $monthlyTrends[] = [
                'month' => $month->format('M Y'),
                'count' => $count,
            ];
        }

        return view('admin.institute.statistics', compact(
            'title', 'institute', 'userStats', 'departmentStats', 'monthlyTrends'
        ));
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate',
            'institute_ids' => 'required|array|min:1',
            'institute_ids.*' => 'exists:institutes,id',
        ]);

        $institutes = Institute::whereIn('id', $validated['institute_ids'])->get();
        $count = 0;

        foreach ($institutes as $institute) {
            switch ($validated['action']) {
                case 'activate':
                    $institute->update(['is_active' => true]);
                    $count++;
                    break;

                case 'deactivate':
                    $institute->update(['is_active' => false]);
                    $count++;
                    break;
            }
        }

        $message = match ($validated['action']) {
            'activate' => __('message.institutes_activated', ['count' => $count]),
            'deactivate' => __('message.institutes_deactivated', ['count' => $count]),
        };

        toast($message, 'success');
        return back();
    }
}