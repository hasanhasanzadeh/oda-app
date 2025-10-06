<!DOCTYPE html>
<html class="dark theme-dark" :class="{ 'theme-dark': dark }" x-data="data()" lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('layouts.favicon')

    <title>{{$title??config('app.name')}}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
    <script src="{{asset('/js/alpine.min.js')}}"></script>
    <script src="{{asset('/js/init-alpine.js')}}"></script>
    <script src="{{asset('/js/sweet-alert.min.js')}}"></script>
    @yield('style')

</head>
<body class="font-dana bg-gray-50 dark:bg-gray-800" dir="rtl">
@include('sweetalert::alert')

@include("admin.layouts.loading_panel")
<!-- ===== Preloader End ===== -->

@include('admin.layouts.header_panel')

<div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

    @include('admin.layouts.sidebar')

    <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>

    <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:mr-64 dark:bg-gray-800">
        <main>
            @yield('content')
        </main>
    </div>

</div>

<!-- Dark Mode Toggle Button -->
<div class="fixed bottom-4 left-4">
    <button id="theme-toggle" type="button" class="bg-blue-500 text-white p-3 rounded-full shadow-lg">
        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                  fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>
    </button>
</div>

<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/app.bundle.js')}}"></script>
<script src="{{asset('/js/buttons.js')}}"></script>
<script src="{{asset('/js/select2.min.js')}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loadingSpinner = document.getElementById('loading-spinner');

        // Function to show the loading spinner
        function showLoadingSpinner() {
            loadingSpinner.classList.remove('hidden');
        }

        // Function to hide the loading spinner
        function hideLoadingSpinner() {
            loadingSpinner.classList.add('hidden');
        }

        // Example usage: Show spinner on page load and hide after 2 seconds
        showLoadingSpinner();
        setTimeout(hideLoadingSpinner, 2000);
    });
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        // Show the correct initial icon
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
            window.location.reload();
        });
    });

    function selectPhoto() {
        $('#select_photo').empty();
        var id = $('input[name="photo_radio"]:checked').val();
        $.ajax({
            type: 'get',
            url: '/panel/photo/show/' + id,
            success: function (res) {
                $('#select_photo').append(`<img class="img-select shadow" src="${res}"  alt="" />`)
            }, error: function () {
                alert('Error');
            }
        });
        $('#photo_id').val(id);
        $("#multiSelectPhoto").addClass('hidden');
    }

    function selectImag() {
        $('#select_image').empty();
        var array = $.map($('input[name="photo_check"]:checked'), function (c) {
            $.ajax({
                type: 'get',
                url: '/panel/photo/show/' + c.value,
                success: function (res) {
                    $('#select_image').append(`<img class="img-select shadow" src="${res}"  alt="" />`)
                }, error: function () {
                    alert('Error');
                }
            });
            return c.value;
        });
        $('#gallery').val(array);
        $("#sampleSelect").addClass('hidden');
    }

    function loadImag() {
        window.location.reload();
    }
</script>
@yield('script')
</body>
</html>
