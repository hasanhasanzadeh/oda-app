<?php
namespace App\Services;

use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OtpService
{
    protected int $resendDelay = 60; // ثانیه
    protected int $maxAttempts = 5;
    protected int $attemptWindow = 3600; // یک ساعت

    public function canSendOtp(string $phone, string $ip): array
    {
        $attemptKey = "otp_attempts:{$ip}:{$phone}";
        $resendKey = "otp_resend:{$phone}";

        // بررسی تعداد تلاش‌ها
        $attempts = Cache::get($attemptKey, 0);
        if ($attempts >= $this->maxAttempts) {
            return [
                'can_send' => false,
                'message' => 'تعداد تلاش‌های شما بیش از حد مجاز است. لطفاً بعداً تلاش کنید.',
                'retry_after' => Cache::get($attemptKey . '_ttl')
            ];
        }

        // بررسی زمان ارسال مجدد
        if (Cache::has($resendKey)) {
            return [
                'can_send' => false,
                'message' => 'لطفاً برای ارسال مجدد کد صبر کنید.',
                'retry_after' => Cache::get($resendKey)
            ];
        }

        return ['can_send' => true];
    }

    public function sendOtp(string $phone, string $ip): array
    {
        $check = $this->canSendOtp($phone, $ip);
        if (!$check['can_send']) {
            return $check;
        }

        $otp = OtpCode::generate($phone, $ip);

        // ارسال SMS
        $this->sendSms($phone, $otp->code);

        $otp->notify(new UserNotification(message:$otp->code,subject:'Verification Mobile',type:'sms',otpCode: $otp));


        // محدودیت ارسال مجدد
        Cache::put("otp_resend:{$phone}", time() + $this->resendDelay, $this->resendDelay);

        // افزایش تعداد تلاش‌ها
        $attemptKey = "otp_attempts:{$ip}:{$phone}";
        Cache::increment($attemptKey);
        if (Cache::get($attemptKey) === 1) {
            Cache::put($attemptKey . '_ttl', time() + $this->attemptWindow, $this->attemptWindow);
        }

        return [
            'success' => true,
            'message' => 'کد تایید با موفقیت ارسال شد.',
            'expires_at' => $otp->expires_at->timestamp,
            'can_resend_at' => time() + $this->resendDelay
        ];
    }

    protected function sendSms(string $phone, string $code): void
    {
        // ارسال SMS با پنل دلخواه
        // نمونه با Kavenegar
        try {
            // Http::post('https://api.kavenegar.com/v1/YOUR_API_KEY/verify/lookup.json', [
            //     'receptor' => $phone,
            //     'token' => $code,
            //     'template' => 'verify'
            // ]);

            Log::info("OTP Sent to {$phone}: {$code}");
        } catch (\Exception $e) {
            Log::error("Failed to send OTP: " . $e->getMessage());
        }
    }

    public function verifyOtp(string $phone, string $code): array
    {
        $otp = OtpCode::where('phone', $phone)
            ->where('code', $code)
            ->where('verified', false)
            ->latest()
            ->first();

        if (!$otp) {
            return [
                'success' => false,
                'message' => 'کد وارد شده نامعتبر است.'
            ];
        }

        if ($otp->isExpired()) {
            return [
                'success' => false,
                'message' => 'کد وارد شده منقضی شده است.'
            ];
        }

        $otp->update(['verified' => true]);

        // ایجاد یا پیدا کردن کاربر
        $user = User::firstOrCreate(
            ['mobile' => $phone],
            [
                'mobile_verified_at' => now(),
                'password' => bcrypt(str()->random(32))
            ]
        );

        if (!$user->phone_verified_at) {
            $user->update(['mobile_verified_at' => now()]);
        }

        // پاک کردن محدودیت‌ها
        Cache::forget("otp_resend:{$phone}");

        return [
            'success' => true,
            'user' => $user,
            'message' => 'ورود با موفقیت انجام شد.'
        ];
    }
}
