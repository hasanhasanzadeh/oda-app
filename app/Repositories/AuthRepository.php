<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthRepository implements AuthRepositoryInterface
{
    public function findByMobile($mobile){
        return User::where('mobile', $mobile)->first();
    }
    public function create(array $data)
    {
        return User::create([
            'role_type' => $data['role_type']??'user',
            'mobile' => $data['mobile'],
            'password' => $data['mobile'],
        ]);
    }

    public function login(array $data): bool|User
    {
        if (Auth::attempt(['mobile'=>$data['mobile'], 'password' => $data['password']], $data['remember']??false)) {
            return User::where('mobile', $data['mobile'])->first();
        }
        return false;
    }

    public function logout()
    {
        $user = Auth::user();
        return DB::transaction(function () use ($user) {
            $user->tokens()->delete();
        });
    }

    public function getProfile()
    {
        return User::with('avatar')->find(Auth::id());
    }
}
