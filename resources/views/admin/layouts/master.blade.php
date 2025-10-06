<!DOCTYPE html>
<html class="dark theme-dark" :class="{ 'theme-dark': dark }"
      lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ in_array(app()->getLocale(), ['ar', 'fa', 'he', 'ur', 'ku']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title??config('app.name')}}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
    <script src="{{asset('/js/sweet-alert.min.js')}}"></script>
    <script src="{{asset('/js/alpine.min.js')}}" defer></script>
    <script src="{{asset('/js/select2.min.js')}}" defer></script>

    @yield('styles')
</head>
<body class="bg-gray-50 rtl-fix dark:bg-gray-700 font-lahzeh">
@include('sweetalert::alert')

@include('admin.layouts.loading')

<div x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        dropdowNotification: false,
        dropdownProfile: false,
        isDarkMode: false,
        showToast: false,
        toastMessage: '',
        toastType: 'success',

        showNotification(message, type = 'success') {
            this.toastMessage = message;
            this.toastType = type;
            this.showToast = true;
            setTimeout(() => this.showToast = false, 3000);
        },

        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
            if (this.isDarkMode) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            }
            localStorage.setItem('darkMode', this.isDarkMode);
            console.log('Dark mode toggled:', this.isDarkMode);
        },

        initDarkMode() {
            const savedMode = localStorage.getItem('darkMode') === 'true';
            this.isDarkMode = savedMode;
            if (this.isDarkMode) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            }
            console.log('Dark mode initialized:', this.isDarkMode);
        }
    }"
     x-init="initDarkMode()"
     class="transition-colors duration-200">

    @include('admin.layouts.header')

    @include('admin.layouts.navigation')

    <div class="min-h-screen transition-all duration-300"
         :class="{'lg:mr-64': sidebarOpen}">

        @include('admin.layouts.head')

        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/app.bundle.js')}}"></script>
<script src="{{asset('/js/buttons.js')}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loadingSpinner = document.getElementById('loading-spinner');

        function showLoadingSpinner() {
            loadingSpinner.classList.remove('hidden');
        }

        function hideLoadingSpinner() {
            loadingSpinner.classList.add('hidden');
        }

        showLoadingSpinner();
        setTimeout(hideLoadingSpinner, 2000);
    });

    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            darkIcon.classList.add('hidden');
            lightIcon.classList.remove('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            lightIcon.classList.add('hidden');
            darkIcon.classList.remove('hidden');
        }

        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');

            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });
    });

    function setupResponsiveSidebar() {
        const isDesktop = window.innerWidth >= 1024;
        const sidebarEl = document.querySelector('aside');
        const mainContent = document.querySelector('div.min-h-screen');

        if (isDesktop) {
            mainContent.classList.add('lg:mr-64');
            sidebarEl.classList.remove('translate-x-full');
            sidebarEl.classList.add('translate-x-0');
        } else {
            mainContent.classList.remove('lg:mr-64');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        setupResponsiveSidebar();
        window.addEventListener('resize', setupResponsiveSidebar);
    });

    function addSidebarOverlay() {
        const existingOverlay = document.getElementById('sidebar-overlay');
        if (existingOverlay) {
            existingOverlay.remove();
        }

        const overlay = document.createElement('div');
        overlay.id = 'sidebar-overlay';
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden';
        overlay.style.display = 'none';
        document.body.appendChild(overlay);

        overlay.addEventListener('click', function () {
            const sidebarOpen = document.querySelector('[x-data]').__x.$data.sidebarOpen;
            if (sidebarOpen) {
                document.querySelector('[x-data]').__x.$data.sidebarOpen = false;
                overlay.style.display = 'none';
            }
        });

        document.addEventListener('sidebar-opened', function () {
            if (window.innerWidth < 1024) {
                overlay.style.display = 'block';
            }
        });

        document.addEventListener('sidebar-closed', function () {
            overlay.style.display = 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        addSidebarOverlay();

        document.addEventListener('alpine:initialized', function () {
            const alpineData = document.querySelector('[x-data]').__x.$data;
            alpineData.$watch('sidebarOpen', function (value) {
                if (value) {
                    document.dispatchEvent(new Event('sidebar-opened'));
                } else {
                    document.dispatchEvent(new Event('sidebar-closed'));
                }
            });
        });
    });
</script>
<script>
    let currentOpenDropdown = null;

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('dropdown-toggle') || event.target.closest('.dropdown-toggle')) {
            const button = event.target.classList.contains('dropdown-toggle')
                ? event.target
                : event.target.closest('.dropdown-toggle');
            const dropdownId = button.getAttribute('data-dropdown-id');
            const dropdownMenu = document.getElementById(dropdownId);

            if (currentOpenDropdown && currentOpenDropdown !== dropdownMenu) {
                currentOpenDropdown.classList.remove('show');
            }

            dropdownMenu.classList.toggle('show');
            currentOpenDropdown = dropdownMenu.classList.contains('show') ? dropdownMenu : null;
            event.stopPropagation();
        }
        else if (!event.target.closest('.dropdown-menu')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
            currentOpenDropdown = null;
        }
    });

    function handleAction(action, itemId) {
        console.log(`${action} action on item ${itemId}`);
        alert(`${action} action on item ${itemId}`);

        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
        currentOpenDropdown = null;
    }
</script>

@stack('style')
@stack('script')

</body>
</html>

<?php
function route_exists($name) {
    try {
        return !empty(route($name, [], false));
    } catch (Exception $e) {
        return false;
    }
}
?>