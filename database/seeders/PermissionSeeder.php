<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keys = [
            'blog',
            'role',
            'visit',
            'city',
            'service',
            'symbol',
            'setting',
            'contact',
            'content',
            'customer',
            'question',
            'category',
            'permission',
            'province',
            'country',
            'payment',
            'order',
            'product',
            'post',
            'address',
            'page',
        ];

        $values = [
            'all',
            'find',
            'create',
            'update',
            'delete'
        ];

        $role = Role::whereName('admin')->firstOrFail();

        foreach ($keys as $item) {
            foreach ($values as $value) {
                $permission = new Permission();
                $permission->name = $item . '-' . $value;
                $permission->display_name = $item . ' ' . $value;
                $permission->save();
                $role->givePermissionTo($permission);
            }
        }

        $permission = Permission::firstOrCreate([
            'name' => 'dashboard-show',
            'display_name' => 'dashboard show',
            'guard_name' => 'web'
        ]);

        $role->givePermissionTo($permission);

        $user = User::where('national_code','2890065707')->first();
        if (!$user){
            $user = User::create([
                'first_name' => 'hasan',
                'last_name' => 'hasanzadeh',
                'mobile' => '09384446491',
                'role_type' => 'admin',
                'email' => 'hasan.hasanzadeh.dev@gmail.com',
                'national_code' => '2890065707',
                'password' => Hash::make('admin')
                ]);
            $user->assignRole($role);
        }
        else{
            $user->assignRole($role);
        }
    }
}
