<?php

namespace App\Http\Controllers\Admin;

use App\Events\EventPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionAllRequest;
use App\Http\Requests\Permission\PermissionCreateFormRequest;
use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\Permission\PermissionDeleteRequest;
use App\Http\Requests\Permission\PermissionFindRequest;
use App\Http\Requests\Permission\PermissionUpdateFormRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Services\PermissionService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    public function __construct(readonly private PermissionService $permissionService)
    {
    }

    public function index(PermissionAllRequest $request)
    {
        $title = __('message.permissions');
        $validated = $request->validated();
        $permissions = $this->permissionService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.permission.index', [
            'title' => $title,
            'permissions' => $permissions,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function create(PermissionCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.permission.create', compact(['title']));
    }

    public function store(PermissionCreateRequest $request)
    {
        $permission = new Permission();
        $permission->display_name = $request->display_name;
        $permission->name = $request->name;
        $permission->guard_name = 'web';
        $permission->save();

        event(new EventPermission($permission));

        toast(__('message.created'), 'success');

        return redirect(session('previous_url')??route('permissions.index'));
    }

    public function edit(PermissionUpdateFormRequest $request, Permission $permission)
    {
        $title = __('message.edit');

        $roles = Role::all();

        return view('admin.permission.edit', compact(['permission', 'roles', 'title']));
    }

    public function show(PermissionFindRequest $request, Permission $permission)
    {
        $title = __('message.show');

        return view('admin.permission.show', compact(['permission', 'title']));
    }

    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->guard_name = 'web';
        $permission->save();

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('permissions.index'));
    }

    public function destroy(PermissionDeleteRequest $request, Permission $permission)
    {
        DB::table('permissions')->where('id', $permission->id)->delete();

        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('permissions.index'));
    }

    public function assignRole(Request $request, Permission $permission)
    {
        if ($permission->hasRole($request->role)) {
            toast(__('message.roleExists'), 'warning');

            return redirect(session('previous_url')??route('permissions.index'));
        }

        $permission->assignRole($request->role);

        toast(__('message.roleAssigned'), 'info');

        return redirect(session('previous_url')??route('permissions.index'));
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);

            toast(__('message.roleRemoved'), 'success');

            return redirect(session('previous_url')??route('permissions.index'));
        }

        toast(__('message.roleNotExists'), 'warning');

        return redirect(session('previous_url')??route('permissions.index'));
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $permissions = [];
        if ($request->has('q')) {
            $search = $request->q;
            $permissions = Permission::select("id", "display_name", "name")
                ->where('display_name', 'LIKE', "%$search%")
                ->orWhere('name', 'LIKE', "%$search%")
                ->get();
        }

        $permissions = collect($permissions);

        return response()->json($permissions);
    }
}
