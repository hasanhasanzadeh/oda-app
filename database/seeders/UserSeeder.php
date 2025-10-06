<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'حسن',
            'first_name_en' => 'Hasan',
            'last_name' => 'حسن زاده',
            'last_name_en' => 'Hasanzadeh',
            'email' => 'hasan.hasanzadeh.dev@gmail.com',
            'national_code' => '2890065707',
            'gender' => 'male',
            'birthday' => '1991-02-13',
            'role_type' => 'admin',
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(100),
        ]);
    }
}
