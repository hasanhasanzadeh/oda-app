<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\UserNotification;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OtpService;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private readonly SettingService        $settingService,
                                private readonly OtpService $otpService
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
        return view('auth.otp-login', [
            'setting' => $setting,
            'title' => $title,
        ]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^09[0-9]{9}$/']
        ], [
            'phone.required' => 'شماره موبایل الزامی است.',
            'phone.regex' => 'فرمت شماره موبایل صحیح نیست.'
        ]);

        $result = $this->otpService->sendOtp(
            $request->phone,
            $request->ip()
        );

        if (!$result['success'] ?? false) {
            throw ValidationException::withMessages([
                'phone' => [$result['message']]
            ]);
        }
        return response()->json($result);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^09[0-9]{9}$/'],
            'code' => ['required', 'digits:6']
        ], [
            'phone.required' => 'شماره موبایل الزامی است.',
            'phone.regex' => 'فرمت شماره موبایل صحیح نیست.',
            'code.required' => 'کد تایید الزامی است.',
            'code.digits' => 'کد تایید باید 6 رقم باشد.'
        ]);

        $result = $this->otpService->verifyOtp(
            $request->phone,
            $request->code
        );

        if (!$result['success']) {
            throw ValidationException::withMessages([
                'code' => [$result['message']]
            ]);
        }

        Auth::login($result['user'], $request->boolean('remember'));

        return response()->json([
            'success' => true,
            'redirect' => route('dashboard')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
    }
}
