<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ورود / ثبت نام</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4 font-[Lahzeh]">
@include('sweetalert::alert')
@include('layouts.loading')

<div class="w-full max-w-md">
    <!-- Logo & Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl shadow-lg mb-4">
            <a href="{{url('/')}}">
                @if($setting->logo)
                    <img src="{{$setting->logo->address}}" alt="{{$setting->title}}" class="h-8 w-8 object-contain"/>
                @else
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                @endif
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">خوش آمدید</h1>
        <p class="text-gray-600">برای ورود یا ثبت نام شماره موبایل خود را وارد کنید</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 backdrop-blur-sm bg-opacity-90">

        <!-- Phone Step -->
        <div id="phone-step">
            <form id="phone-form" class="space-y-6">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        شماره موبایل
                    </label>
                    <div class="relative">
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="09123456789"
                            maxlength="11"
                            class="w-full px-4 py-3.5 pr-12 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-left"
                            autofocus
                        >
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p id="phone-error" class="text-red-500 text-sm mt-2 hidden"></p>
                </div>

                <button
                    type="submit"
                    id="send-otp-btn"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                >
                        <span class="flex items-center justify-center gap-2">
                            <span id="send-btn-text">دریافت کد تایید</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                </button>
            </form>
        </div>

        <!-- OTP Step -->
        <div id="otp-step" class="hidden">
            <button
                id="back-btn"
                class="flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-6 transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>بازگشت</span>
            </button>

            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">کد تایید را وارد کنید</h2>
                <p class="text-gray-600 text-sm">
                    کد 6 رقمی به شماره
                    <span id="phone-display" class="font-semibold text-indigo-600"></span>
                    ارسال شد
                </p>
            </div>

            <form id="otp-form" class="space-y-6">
                <!-- OTP Inputs -->
                <div class="flex gap-2 justify-center" dir="ltr">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" data-index="0">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" data-index="1">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" data-index="2">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" data-index="3">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" data-index="4">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-bold border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" data-index="5">
                </div>
                <p id="otp-error" class="text-red-500 text-sm text-center hidden"></p>

                <!-- Timer & Resend -->
                <div class="text-center">
                    <div id="timer-container" class="text-sm text-gray-600">
                        <span>ارسال مجدد کد تا </span>
                        <span id="timer" class="font-bold text-indigo-600">01:00</span>
                        <span> دیگر</span>
                    </div>
                    <button
                        type="button"
                        id="resend-btn"
                        class="text-indigo-600 hover:text-indigo-700 font-semibold text-lg py-3 mt-2 hidden transition-colors"
                    >
                        ارسال مجدد کد تایید
                    </button>
                </div>

                <button
                    type="submit"
                    id="verify-btn"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                >
                        <span class="flex items-center justify-center gap-2">
                            <span id="verify-btn-text">تایید و ورود</span>
                            <svg class="w-5 h-5 hidden" id="verify-spinner" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                </button>
            </form>
        </div>

    </div>

    <!-- Footer -->
    <div class="text-center mt-6 text-sm text-gray-600">
        <p>با ورود و یا ثبت نام، <a href="{{url('/rules')}}" class="text-indigo-600 hover:text-indigo-700">شرایط و قوانین</a> را می‌پذیرید</p>
    </div>
</div>

<script>
    // CSRF Token Setup
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Elements
    const phoneStep = document.getElementById('phone-step');
    const otpStep = document.getElementById('otp-step');
    const phoneForm = document.getElementById('phone-form');
    const otpForm = document.getElementById('otp-form');
    const phoneInput = document.getElementById('phone');
    const phoneError = document.getElementById('phone-error');
    const otpError = document.getElementById('otp-error');
    const sendBtn = document.getElementById('send-otp-btn');
    const verifyBtn = document.getElementById('verify-btn');
    const backBtn = document.getElementById('back-btn');
    const resendBtn = document.getElementById('resend-btn');
    const phoneDisplay = document.getElementById('phone-display');
    const timerElement = document.getElementById('timer');
    const timerContainer = document.getElementById('timer-container');
    const otpInputs = document.querySelectorAll('.otp-input');

    let currentPhone = '';
    let timerInterval = null;

    // Phone Input Format
    phoneInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });

    // Send OTP
    phoneForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const phone = phoneInput.value.trim();
        if (!phone.match(/^09[0-9]{9}$/)) {
            showError(phoneError, 'لطفاً شماره موبایل معتبر وارد کنید');
            return;
        }

        await sendOtp(phone);
    });

    async function sendOtp(phone) {
        setButtonLoading(sendBtn, true);
        hideError(phoneError);

        try {
            const response = await fetch('{{ route("otp.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ phone })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                currentPhone = phone;
                phoneDisplay.textContent = phone;
                switchToOtpStep();
                startTimer(data.can_resend_at);
                otpInputs[0].focus();
            } else {
                showError(phoneError, data.message || 'خطا در ارسال کد');
            }
        } catch (error) {
            showError(phoneError, 'خطا در ارتباط با سرور');
        } finally {
            setButtonLoading(sendBtn, false);
        }
    }

    // OTP Input Handling
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');

            if (e.target.value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            // Auto submit when all filled
            if (index === otpInputs.length - 1 && e.target.value) {
                const code = Array.from(otpInputs).map(inp => inp.value).join('');
                if (code.length === 6) {
                    verifyOtp(code);
                }
            }
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');

            for (let i = 0; i < Math.min(pastedData.length, otpInputs.length); i++) {
                otpInputs[i].value = pastedData[i];
            }

            if (pastedData.length === 6) {
                verifyOtp(pastedData);
            }
        });
    });

    // Verify OTP
    otpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const code = Array.from(otpInputs).map(inp => inp.value).join('');

        if (code.length !== 6) {
            showError(otpError, 'لطفاً کد 6 رقمی را وارد کنید');
            return;
        }

        verifyOtp(code);
    });

    async function verifyOtp(code) {
        setButtonLoading(verifyBtn, true);
        hideError(otpError);

        try {
            const response = await fetch('{{ route("otp.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    phone: currentPhone,
                    code: code,
                    remember: true
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                window.location.href = data.redirect;
            } else {
                showError(otpError, data.message || 'کد وارد شده نامعتبر است');
                otpInputs.forEach(inp => inp.value = '');
                otpInputs[0].focus();
            }
        } catch (error) {
            showError(otpError, 'خطا در ارتباط با سرور');
        } finally {
            setButtonLoading(verifyBtn, false);
        }
    }

    // Resend OTP
    resendBtn.addEventListener('click', async function() {
        await sendOtp(currentPhone);
        otpInputs.forEach(inp => inp.value = '');
        otpInputs[0].focus();
    });

    // Back Button
    backBtn.addEventListener('click', function() {
        switchToPhoneStep();
    });

    // Timer Functions
    function startTimer(canResendAt) {
        clearInterval(timerInterval);

        const updateTimer = () => {
            const now = Math.floor(Date.now() / 1000);
            const remaining = canResendAt - now;

            if (remaining <= 0) {
                clearInterval(timerInterval);
                showResendButton();
                return;
            }

            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;
            timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        };

        updateTimer();
        timerInterval = setInterval(updateTimer, 1000);
    }

    function showResendButton() {
        timerContainer.classList.add('hidden');
        resendBtn.classList.remove('hidden');
    }

    // UI Helper Functions
    function switchToOtpStep() {
        phoneStep.classList.add('hidden');
        otpStep.classList.remove('hidden');
    }

    function switchToPhoneStep() {
        otpStep.classList.add('hidden');
        phoneStep.classList.remove('hidden');
        otpInputs.forEach(inp => inp.value = '');
        hideError(otpError);
        clearInterval(timerInterval);
        timerContainer.classList.remove('hidden');
        resendBtn.classList.add('hidden');
    }

    function showError(element, message) {
        element.textContent = message;
        element.classList.remove('hidden');
    }

    function hideError(element) {
        element.classList.add('hidden');
    }

    function setButtonLoading(button, loading) {
        const btnText = button.querySelector('span > span:first-child');
        const spinner = button.querySelector('#verify-spinner') || button.querySelector('svg');

        button.disabled = loading;

        if (loading) {
            btnText.textContent = 'در حال پردازش...';
            if (spinner) spinner.classList.remove('hidden');
        } else {
            btnText.textContent = button.id === 'send-otp-btn' ? 'دریافت کد تایید' : 'تایید و ورود';
            if (spinner) spinner.classList.add('hidden');
        }
    }
</script>
</body>
</html>
