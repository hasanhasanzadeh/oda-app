<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct(private readonly RoleService $roleService, private readonly PermissionService $permissionService)
    {
    }

    public function show($id)
    {
        $title = __('message.customers');

        $roles = $this->roleService->all();
        $permissions = $this->permissionService->all();
        $customer = User::with('avatar')->findOrFail($id);

        return view('admin.customer.role_user', compact(['roles', 'permissions', 'customer', 'title']));
    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            toast(__('message.role_exists'), 'warning');

            return back();
        }
        $user->assignRole($request->role);

        toast(__('message.role_assigned'), 'success');

        return back();
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);

            toast(__('message.role_removed'), 'success');

            return back();
        }

        toast(__('message.role_not_exists'), 'warning');

        return back();
    }

    public function givePermission(Request $request, User $user)
    {
        if ($user->hasPermissionTo($request->permission)) {

            toast(__('message.permission_exists'), 'info');

            return back();
        }
        $user->givePermissionTo($request->permission);

        toast(__('message.permission_added'), 'success');

        return back();
    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);

            toast(__('message.permission_revoked'), 'success');

            return back();
        }

        toast(__('message.permission_does_not_exists.'), 'warning');

        return back();
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            toast(__('message.you_are_admin'), 'info');

            return back();
        }

        $user->delete();

        toast(__('message.deleted.'), 'success');

        return back();
    }
}
