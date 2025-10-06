<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts.favicon')
    <title>{{ config('app.name', 'آکادمی آنلاین') }} @yield('title')</title>
    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/all.min.css')}}">

    <script src="{{asset('js/tailwindcss.min.js')}}"></script>
    <script src="{{asset('/js/alpine.min.js')}}"></script>
    <script src="{{asset('/js/init-alpine.js')}}"></script>
    <script src="{{asset('/js/sweet-alert.min.js')}}"></script>
    <style>
        @font-face {
            font-family: 'Lahzeh';
            src: url({{asset('fonts/woff2/Lahzeh-Medium.woff2')}}) format('woff2');
        }
        * {
            font-family: 'Lahzeh', sans-serif;
        }

        .menu-gradient {
            background: linear-gradient(135deg, #ca950c 0%, #bd9309 50%, #b89008 100%);
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.4), 0 1px 8px rgba(0, 0, 0, 0.2);
        }

        .dropdown-bg {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-scale:hover {
            transform: translateY(-2px);
        }

        .cart-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .search-expand {
            transition: all 0.4s ease;
        }

        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.2s ease-out;
        }

        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .mobile-menu-slide {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu-slide.active {
            transform: translateX(0);
        }

        .logo-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .8;
            }
        }
    </style>
    @stack('styles')

</head>
<body class="bg-gray-50 min-h-screen antialiased font-lahzeh">
@include('sweetalert::alert')
@include('admin.layouts.loading')
<!-- Navigation -->
@include('layouts.front.nav')

<main class="p-8">
    @yield('content')
</main>

@include('layouts.front.footer')

<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/app.bundle.js')}}"></script>
<script src="{{asset('/js/buttons.js')}}"></script>
<script src="{{asset('/js/select2.min.js')}}"></script>

<script>
    // Mobile Menu Toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const mobileMenuClose = document.getElementById('mobileMenuClose');

    function openMobileMenu() {
        mobileMenu.classList.add('active');
        mobileMenuOverlay.classList.remove('opacity-0', 'invisible');
        document.body.classList.add('overflow-hidden');
    }

    function closeMobileMenu() {
        mobileMenu.classList.remove('active');
        mobileMenuOverlay.classList.add('opacity-0', 'invisible');
        document.body.classList.remove('overflow-hidden');
    }

    mobileMenuToggle.addEventListener('click', openMobileMenu);
    mobileMenuClose.addEventListener('click', closeMobileMenu);
    mobileMenuOverlay.addEventListener('click', closeMobileMenu);

    // Mobile Dropdown Functionality
    document.querySelectorAll('.mobile-dropdown-trigger').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const content = this.parentNode.querySelector('.mobile-dropdown-content');
            const icon = this.querySelector('i');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });

    // Search Toggle
    const searchToggle = document.getElementById('searchToggle');
    const searchBox = document.getElementById('searchBox');

    searchToggle.addEventListener('click', function() {
        if (searchBox.classList.contains('opacity-0')) {
            searchBox.classList.remove('opacity-0', 'invisible');
            searchBox.querySelector('input').focus();
        } else {
            searchBox.classList.add('opacity-0', 'invisible');
        }
    });

    const switchLangToggle = document.getElementById('switchLangToggle');
    const switchLang = document.getElementById('switchLang');

    switchLangToggle.addEventListener('click', function() {
        if (switchLang.classList.contains('opacity-0')) {
            switchLang.classList.remove('opacity-0', 'invisible');
        } else {
            switchLang.classList.add('opacity-0', 'invisible');
        }
    });

    // Close search when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchToggle.contains(e.target) && !searchBox.contains(e.target)) {
            searchBox.classList.add('opacity-0', 'invisible');
        }
        if (!switchLangToggle.contains(e.target) && !switchLang.contains(e.target)) {
            switchLang.classList.add('opacity-0', 'invisible');
        }
    });

    // Close mobile menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            closeMobileMenu();
        }
    });

    // Add scroll effect to navigation
    let lastScrollTop = 0;
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const nav = document.querySelector('nav');

        if (scrollTop > lastScrollTop && scrollTop > 100) {
            nav.style.transform = 'translateY(-100%)';
        } else {
            nav.style.transform = 'translateY(0)';
        }
        lastScrollTop = scrollTop;
    });

    // Add entrance animations
    window.addEventListener('load', function() {
        const elements = document.querySelectorAll('.hover-scale');
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'all 0.6s ease';

                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });
    });
</script>
@stack('scripts')
</body>
</html>