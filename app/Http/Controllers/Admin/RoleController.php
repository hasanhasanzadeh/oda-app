<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleAllRequest;
use App\Http\Requests\Role\RoleCreateFormRequest;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\Role\RoleDeleteRequest;
use App\Http\Requests\Role\RoleFindRequest;
use App\Http\Requests\Role\RoleUpdateFormRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Models\Setting;
use App\Models\User;
use App\Services\RoleService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(readonly private RoleService $roleService)
    {
    }

    public function index(RoleAllRequest $request)
    {
        $title = __('message.roles');
        $validated = $request->validated();
        $roles = $this->roleService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.role.index', [
            'title' => $title,
            'roles' => $roles,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function create(RoleCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.role.create', compact(['title']));
    }

    public function store(RoleCreateRequest $request)
    {
        $role = new Role();
        $role->display_name = $request->display_name;
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('roles.index'));
    }

    public function edit(RoleUpdateFormRequest $request, Role $role)
    {
        $title = __('message.edit');

        $permissions = Permission::all();

        return view('admin.role.edit', compact(['role', 'title', 'permissions']));
    }

    public function show(RoleFindRequest $request, Role $role)
    {
        $title = __('message.show');

        $permissions = Permission::all();

        return view('admin.role.show', compact(['role', 'title', 'permissions']));
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->display_name = $request->display_name;
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();
        toast(__('message.updated'), 'success');
        return redirect(session('previous_url')??route('roles.index'));
    }

    public function destroy(RoleDeleteRequest $request, Role $role)
    {
        DB::table('roles')->where('id', $role->id)->delete();
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('roles.index'));
    }

    public function givePermission(Request $request, Role $role)
    {
        $request->validate([
            'permission' => 'required|array',
            'permission.*' => 'string|exists:permissions,name',
        ]);
        $role->syncPermissions($request->permission);
        toast(__('message.permissionAdded'), 'success');
        return back();
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            toast(__('message.permissionRevoked'), 'warning');
            return redirect(session('previous_url')??route('roles.index'));
        }
        toast(__('message.permissionNotExists'), 'warning');
        return back();
    }
}
