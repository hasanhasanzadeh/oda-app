<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'فروشگاه آنلاین')</title>

    <!-- PWA Meta Tags -->
    <meta name="application-name" content="فروشگاه آنلاین">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="فروشگاه آنلاین">
    <meta name="description" content="فروشگاه آنلاین حرفه‌ای با قابلیت‌های PWA پیشرفته">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="msapplication-config" content="/browserconfig.xml">
    <meta name="msapplication-TileColor" content="#3b82f6">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="theme-color" content="#3b82f6">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/images/logo/logo-152x152.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/logo/logo-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/logo/logo-180x180.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/images/logo/logo-167x167.png">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/images/logo/logo-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/logo/logo-16x16.png">
    <link rel="shortcut icon" href="/favicon.ico">

    <!-- Microsoft Tiles -->
    <meta name="msapplication-TileImage" content="/images/logo/logo-144x144.png">
    <meta name="msapplication-square70x70logo" content="/images/logo/logo-70x70.png">
    <meta name="msapplication-square150x150logo" content="/images/logo/logo-150x150.png">
    <meta name="msapplication-wide310x150logo" content="/images/logo/logo-310x150.png">
    <meta name="msapplication-square310x310logo" content="/images/logo/logo-310x310.png">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'فروشگاه آنلاین')">
    <meta property="og:description" content="فروشگاه آنلاین حرفه‌ای با قابلیت‌های PWA پیشرفته">
    <meta property="og:image" content="/images/logo/logo-512x512.png">
    <meta property="og:locale" content="fa_IR">
    <meta property="og:site_name" content="فروشگاه آنلاین">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'فروشگاه آنلاین')">
    <meta property="twitter:description" content="فروشگاه آنلاین حرفه‌ای با قابلیت‌های PWA پیشرفته">
    <meta property="twitter:image" content="/images/logo/logo-512x512.png">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

    @vite(['resources/css/app.css', 'resources/css/pwa.css'])
    @vite('resources/js/app.js')

    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
    <script src="{{asset('/js/sweet-alert.min.js')}}"></script>
    <script src="{{asset('/js/alpine.min.js')}}" defer></script>
    <script src="{{asset('/js/select2.min.js')}}" defer></script>
    @yield('styles')
</head>
<body class="bg-gray-50 text-gray-900">
@include('sweetalert::alert')

@include('admin.layouts.loading')
<!-- Header -->
<header class="bg-white shadow-md sticky top-0 z-50">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="container mx-auto px-4 py-2">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center gap-4">
                    <a href="tel:{{$setting->tel}}" class="hover:text-blue-200 transition">
                        <i class="fas fa-phone ml-1"></i> {{$setting->tel}}
                    </a>
                    <a href="mailto:{{$setting->email}}" class="hover:text-blue-200 transition">
                        <i class="fas fa-envelope ml-1"></i> {{$setting->email}}
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="hover:text-blue-200 transition">
                            <i class="fas fa-user ml-1"></i> پنل کاربری
                        </a>
                        <a href="{{route('user.logout')}}" class="hover:text-blue-200 transition">
                            <i class="fas fa-sign-out-alt ml-1"></i>
                            <span>خروج</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-blue-200 transition">
                            <i class="fas fa-sign-in-alt ml-1"></i>
                            <span>ورود | ثبت نام</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between gap-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold text-blue-600">
                <i class="fas fa-shopping-bag"></i>
                <span>فروشگاه ما</span>
            </a>

            <!-- Search Bar -->
            <form action="{{ route('products.index') }}" method="GET" class="flex-1 max-w-2xl hidden md:block">
                <div class="relative">
                    <input type="text" name="search" placeholder="جستجوی محصولات..."
                           value="{{ request('search') }}"
                           class="w-full px-4 py-3 pr-12 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:outline-none transition">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                </div>
            </form>

            <!-- Cart & Actions -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('user.favorites') }}" class="relative hover:text-blue-600 transition">
                        <i class="fas fa-heart text-2xl"></i>
                        <span class="absolute -top-2 -left-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ auth()->user()->favorites()->count() }}
                        </span>
                    </a>
                @endauth
                    @php
                        $sum = 0;
                    @endphp
                    @foreach(session('cart') as $pr)
                        @php $sum+=$pr['quantity'] @endphp
                    @endforeach
                <a href="{{ route('cart.index') }}" class="relative hover:text-blue-600 transition">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    <span id="cart-count" class="absolute -top-2 -left-2 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $sum }}
                    </span>
                </a>
                <button id="mobile-menu-btn" class="lg:hidden text-2xl hover:text-blue-600 transition">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Search -->
        <form action="{{ route('products.index') }}" method="GET" class="mt-4 md:hidden">
            <input type="text" name="search" placeholder="جستجو..."
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none">
        </form>
    </div>

    <!-- Navigation -->
    <nav class="bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4">
            <div id="main-menu" class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-4 py-3 hover:bg-white hover:text-blue-600 transition rounded-t-lg">
                    <i class="fas fa-home ml-1"></i> خانه
                </a>
                @include('layouts.cats')
                <a href="{{ route('about') }}" class="px-4 py-3 hover:bg-white hover:text-blue-600 transition rounded-t-lg">
                    درباره ما
                </a>
                <a href="{{ route('contact') }}" class="px-4 py-3 hover:bg-white hover:text-blue-600 transition rounded-t-lg">
                    تماس با ما
                </a>
            </div>

            <!-- Mobile Menu -->
            @include('layouts.cat_mobile')
        </div>
    </nav>
</header>

<!-- Main Content -->
<main class="min-h-screen">
    @yield('content')
</main>

<!-- PWA Components -->
@include('components.pwa.install-prompt')

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">درباره ما</h3>
                <p class="text-sm leading-relaxed mb-4">
                    فروشگاه آنلاین ما با ارائه محصولات باکیفیت و خدمات عالی در خدمت شماست.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-telegram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">دسترسی سریع</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">درباره ما</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">تماس با ما</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition">سوالات متداول</a></li>
                    <li><a href="{{ route('rules') }}" class="hover:text-white transition">قوانین و مقررات</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-white transition">حریم خصوصی</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">خدمات مشتریان</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">پیگیری سفارش</a></li>
                    <li><a href="#" class="hover:text-white transition">شیوه های ارسال</a></li>
                    <li><a href="#" class="hover:text-white transition">رویه بازگشت کالا</a></li>
                    <li><a href="#" class="hover:text-white transition">شیوه های پرداخت</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">تماس با ما</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-map-marker-alt mt-1"></i>
                        <span>{{$setting->address}}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-phone"></i>
                        <span>{{$setting->tel}}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-envelope"></i>
                        <span>{{$setting->email}}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-clock"></i>
                        <span>{{$setting->support_text}}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Certifications -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-wrap justify-center items-center gap-8">
                @if($setting->symbols)
                    @foreach($setting->symbols as $symbol)
                    <img src="{{$symbol->photo->address}}" alt="{{$symbol->title}}" title="{{$symbol->description}}" class="h-16">
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
            <p>{{$setting->copy_right}}</p>
        </div>
    </div>
</footer>
{!! $setting->script_text !!}
<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/app.bundle.js')}}"></script>
<script src="{{asset('/js/buttons.js')}}"></script>

<!-- PWA JavaScript -->
<script>
    // PWA Installation and Service Worker Management
    class PWAManager {
        constructor() {
            this.deferredPrompt = null;
            this.isInstalled = false;
            this.swRegistration = null;
            this.init();
        }

        async init() {
            // Check if already installed
            this.isInstalled = window.matchMedia('(display-mode: standalone)').matches || 
                              window.navigator.standalone === true;

            // Register service worker
            await this.registerServiceWorker();

            // Setup install prompt
            this.setupInstallPrompt();

            // Setup update notifications
            this.setupUpdateNotifications();

            // Setup offline detection
            this.setupOfflineDetection();
        }

        async registerServiceWorker() {
            if ('serviceWorker' in navigator) {
                try {
                    this.swRegistration = await navigator.serviceWorker.register('/sw.js', {
                        scope: '/'
                    });

                    console.log('Service Worker registered successfully:', this.swRegistration);

                    // Handle updates
                    this.swRegistration.addEventListener('updatefound', () => {
                        const newWorker = this.swRegistration.installing;
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                this.showUpdateNotification();
                            }
                        });
                    });

                } catch (error) {
                    console.error('Service Worker registration failed:', error);
                }
            }
        }

        setupInstallPrompt() {
            // Listen for beforeinstallprompt event
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                this.deferredPrompt = e;
                this.showInstallButton();
            });

            // Listen for appinstalled event
            window.addEventListener('appinstalled', () => {
                this.isInstalled = true;
                this.hideInstallButton();
                this.showInstallSuccessMessage();
            });
        }

        setupUpdateNotifications() {
            // Listen for service worker updates
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                window.location.reload();
            });
        }

        setupOfflineDetection() {
            // Update online/offline status
            const updateOnlineStatus = () => {
                const statusElement = document.getElementById('connection-status');
                if (statusElement) {
                    if (navigator.onLine) {
                        statusElement.textContent = 'آنلاین';
                        statusElement.className = 'text-green-600';
                    } else {
                        statusElement.textContent = 'آفلاین';
                        statusElement.className = 'text-red-600';
                    }
                }
            };

            window.addEventListener('online', updateOnlineStatus);
            window.addEventListener('offline', updateOnlineStatus);
            updateOnlineStatus();
        }

        showInstallButton() {
            if (this.isInstalled) return;

            // Create install button
            const installButton = document.createElement('button');
            installButton.id = 'pwa-install-btn';
            installButton.className = 'fixed bottom-4 left-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 transition z-50';
            installButton.innerHTML = '<i class="fas fa-download ml-2"></i>نصب اپلیکیشن';
            installButton.addEventListener('click', () => this.installApp());

            document.body.appendChild(installButton);
        }

        hideInstallButton() {
            const installButton = document.getElementById('pwa-install-btn');
            if (installButton) {
                installButton.remove();
            }
        }

        async installApp() {
            if (this.deferredPrompt) {
                this.deferredPrompt.prompt();
                const { outcome } = await this.deferredPrompt.userChoice;
                
                if (outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                } else {
                    console.log('User dismissed the install prompt');
                }
                
                this.deferredPrompt = null;
                this.hideInstallButton();
            }
        }

        showUpdateNotification() {
            // Create update notification
            const updateNotification = document.createElement('div');
            updateNotification.id = 'pwa-update-notification';
            updateNotification.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-sm';
            updateNotification.innerHTML = `
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-bold">به‌روزرسانی موجود است!</p>
                        <p class="text-sm">نسخه جدید اپلیکیشن آماده است.</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200 ml-2">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mt-2 flex gap-2">
                    <button onclick="window.location.reload()" class="bg-white text-green-600 px-3 py-1 rounded text-sm font-bold">
                        به‌روزرسانی
                    </button>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200 text-sm">
                        بعداً
                    </button>
                </div>
            `;

            document.body.appendChild(updateNotification);

            // Auto remove after 10 seconds
            setTimeout(() => {
                if (updateNotification.parentNode) {
                    updateNotification.remove();
                }
            }, 10000);
        }

        showInstallSuccessMessage() {
            // Show success message
            const successMessage = document.createElement('div');
            successMessage.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMessage.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle ml-2"></i>
                    <span>اپلیکیشن با موفقیت نصب شد!</span>
                </div>
            `;

            document.body.appendChild(successMessage);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (successMessage.parentNode) {
                    successMessage.remove();
                }
            }, 3000);
        }

        // Request notification permission
        async requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                const permission = await Notification.requestPermission();
                return permission === 'granted';
            }
            return Notification.permission === 'granted';
        }

        // Show notification
        async showNotification(title, options = {}) {
            if (await this.requestNotificationPermission()) {
                if (this.swRegistration) {
                    this.swRegistration.showNotification(title, {
                        body: options.body || 'اعلان جدید از فروشگاه آنلاین',
                        icon: '/images/logo/logo-192x192.png',
                        badge: '/images/logo/logo-72x72.png',
                        vibrate: [100, 50, 100],
                        ...options
                    });
                }
            }
        }
    }

    // Initialize PWA Manager
    const pwaManager = new PWAManager();

    // Mobile menu toggle
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Connection status indicator
    document.addEventListener('DOMContentLoaded', function() {
        // Add connection status to header
        const header = document.querySelector('header .container');
        if (header) {
            const statusDiv = document.createElement('div');
            statusDiv.className = 'text-xs text-center mt-2';
            statusDiv.innerHTML = '<span id="connection-status" class="text-green-600">آنلاین</span>';
            header.appendChild(statusDiv);
        }
    });
</script>

@stack('style')
@stack('script')

</body>
</html>
