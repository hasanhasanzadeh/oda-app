<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentAllRequest;
use App\Http\Requests\Department\DepartmentCreateFormRequest;
use App\Http\Requests\Department\DepartmentCreateRequest;
use App\Http\Requests\Department\DepartmentDeleteRequest;
use App\Http\Requests\Department\DepartmentFindRequest;
use App\Http\Requests\Department\DepartmentUpdateFormRequest;
use App\Http\Requests\Department\DepartmentUpdateRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(private readonly DepartmentService $departmentService)
    {
    }

    public function index(DepartmentAllRequest $request)
    {
        $title = __('message.departments');
        $validated = $request->validated();
        $departments = $this->departmentService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.department.index', [
            'title' => $title,
            'departments' => $departments,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(DepartmentCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.department.create', compact([ 'title']));
    }

    public function store(DepartmentCreateRequest $request)
    {
        $department = $this->departmentService->create($request->validated());
        if (!$department) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('departments.index'));
    }


    public function show(DepartmentFindRequest $request,Department $department)
    {
        $title = __('message.show');

        return view('admin.department.show', compact([ 'title', 'department']));
    }


    public function edit(DepartmentUpdateFormRequest $request,Department $department)
    {
        $title = __('message.edit');

        return view('admin.department.edit', compact(['title', 'department']));
    }


    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        $department = $this->departmentService->update($department->id,$request->validated());
        if (!$department) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('departments.index'));
    }

    public function destroy(DepartmentDeleteRequest $request,Department $department)
    {
        $department = $this->departmentService->delete($department->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('departments.index'));
    }

    public function search(Request $request)
    {
        $departments = [];
        if ($request->has('q')) {
            $search = $request->q;
            $departments = Department::select("id", "department_persian_name")
                ->where('department_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $departments = collect($departments);

        return response()->json($departments);
    }
}
