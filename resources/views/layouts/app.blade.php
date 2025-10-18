<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'فروشگاه آنلاین')</title>

    @vite('resources/css/app.css')
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
                <a href="{{ route('cart.index') }}" class="relative hover:text-blue-600 transition">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    <span id="cart-count" class="absolute -top-2 -left-2 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ session('cart') ? count(session('cart')) : 0 }}
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
<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>

@stack('style')
@stack('script')

</body>
</html>
