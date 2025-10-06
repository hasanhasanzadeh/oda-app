<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileRequest;
use App\Models\User;
use App\Services\AuthService;
use Cassandra\Type\UserType;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function dashboard()
    {
        $user = $this->authService->getProfile();
        return redirect()->route(match ($user->role_type) {
            'admin' => 'admin.dashboard',
            'student' => 'student.dashboard',
            'teacher' => 'teacher.dashboard',
            'staff' => 'staff.dashboard',
            'institute' => 'institute.dashboard',
            default => 'home',
        });
    }

    public function edit()
    {
        $title = __('message.profile');

        $user = $this->authService->getProfile();

        return view('admin.profile.edit', compact(['title', 'user']));
    }

    public function update(ProfileRequest $request)
    {

        $user = User::with('avatar')->findOrFail(auth()->user()->id);

        $user->first_name = $request->first_name;
        $user->first_name_en = $request->first_name_en;
        $user->last_name = $request->last_name;
        $user->last_name_en = $request->last_name_en;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->national_code = $request->national_code;
        $user->email_verified_at = $request->email_verified_at;
        $user->birthday = $request->birthday;
        $user->address = $request->address;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->region = $request->region;
        $user->save();
        if ($request->file('image')) {
            if ($user->avatar) {
                Helper::deleteFile($user->avatar->url);
                $user->avatar()->delete();
            }

            $path = str_replace('public', 'storage', $request->file('image')->store('public/avatars'));
            $user->avatar()->create(['path' => $path]);
        }
        toast(__('message.updated'), 'success');

        return redirect()->back();
    }
}
