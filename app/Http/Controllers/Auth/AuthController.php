<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private readonly SettingService        $settingService,
                                private readonly AuthService           $authService
    )
    {
    }

    public function loginFormShow()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        $title = 'ورود';
        $setting = $this->settingService->first();
        return view('auth.login', [
            'setting' => $setting,
            'title' => $title,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->validated());
        if (!$user) {
            toast('نام کاربری یا کلمه عبور اشتباه می باشد', 'error');
            return redirect()->back();
        }
        $request->authenticate();
        $request->session()->regenerate();
        toast('شما با موفقیت وارد سایت شدید', 'success');
        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
    }
}
