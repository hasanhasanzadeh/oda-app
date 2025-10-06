<!DOCTYPE html>
<html class="dark theme-dark" :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title??config('app.name')}}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        @font-face {
            font-family: 'Lahzeh';
            src: url({{asset('fonts/woff2/Lahzeh-Medium.woff2')}}) format('woff2');
        }
        * {
            font-family: 'Lahzeh', sans-serif;
        }
        .golden-border {
            border: 3px solid #FFD700;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
        }

        .golden-shadow {
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.15);
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.3);
            border-color: #FFD700;
        }

        .slide-enter {
            animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .slide-exit {
            animation: slideOutLeft 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutLeft {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(-30px);
            }
        }

        .floating {
            animation: floating 4s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-8px) rotate(1deg); }
            50% { transform: translateY(-12px) rotate(0deg); }
            75% { transform: translateY(-8px) rotate(-1deg); }
        }

        .pulse-gold {
            animation: pulseGold 3s ease-in-out infinite;
        }

        @keyframes pulseGold {
            0%, 100% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.05);
                opacity: 1;
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #FFD700, #FFA500, #FF8C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .left-panel {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF8C00 100%);
        }

        .geometric-pattern {
            background-image:
                    radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                    radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px, 80px 80px, 100px 100px;
        }
        .password-toggle-container {
            position: relative;
        }

        .eye-icon {
            transition: all 0.2s ease-in-out;
        }

        .eye-icon:hover {
            transform: scale(1.1);
        }

        .password-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
    @yield('style')
</head>
<body class="min-h-screen bg-white" dir="rtl">
@include('sweetalert::alert')
@include('layouts.loading')
<main>
    @yield('content')
</main>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
    <div class="bg-white golden-border rounded-3xl p-8 max-w-sm w-full text-center golden-shadow">
        <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">موفقیت آمیز!</h3>
        <p class="text-gray-600 mb-6" id="successMessage">عملیات با موفقیت انجام شد</p>
        <button id="closeModal" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-xl transition-colors duration-300">
            باشه
        </button>
    </div>
</div>
<script>
    const toggleLoginPassword = document.getElementById('toggleLoginPassword');
    const loginPassword = document.getElementById('loginPassword');
    toggleLoginPassword.addEventListener('click', () => {
        const type = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        loginPassword.setAttribute('type', type);
    });
</script>
@yield('script')
</body>
</html>