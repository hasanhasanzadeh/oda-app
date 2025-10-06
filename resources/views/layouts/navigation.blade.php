<aside
    class="fixed inset-y-0 right-0 z-50 w-64 overflow-y-auto transition-all duration-300 transform bg-white dark:bg-gray-900 border-l dark:border-gray-700"
    :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'"
>

    <!-- دکمه بستن منوی کناری در موبایل -->
    <button
        @click="sidebarOpen = false"
        class="absolute top-3 left-3 text-gray-600 dark:text-gray-300 focus:outline-none lg:hidden close-btn">
        <i class="text-lg fas fa-times"></i>
    </button>

    <!-- لوگو و نام سیستم -->
    <div class="flex items-center justify-center h-20 border-b dark:border-gray-700">
        <div class="flex items-center space-x-3 space-x-reverse">
            <div class="p-2 bg-indigo-600 rounded-lg">
                <img src="{{App\Models\Setting::with(['logo','favicon'])->first()->logo->address??asset('images/logo/logo.svg')}}" class="h-10 w-10 rounded shadow-lg" alt="">
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">{{App\Models\Setting::first()->value('title')}}</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">پنل مدیریت</p>
            </div>
        </div>
    </div>

    <!-- منو اصلی -->
    <nav class="px-4 py-6">
        <div class="space-y-1">
            @can('dashboard-show')
            <a href="{{route('admin.dashboard')}}" class="flex items-center px-4 py-3 text-sm text-white rounded-lg bg-gradient-to-l from-indigo-600 to-indigo-700">
                <i class="ml-3 text-lg fas fa-tachometer-alt"></i>
                <span>داشبورد</span>
            </a>
            @endcan
            @can('customer-all')
            <a href="{{route('customers.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fas fa-user"></i>
                <span>کاربران</span>
            </a>
            @endcan

            @can('role-all')
            <a href="{{route('roles.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-user-shield"></i>
                <span>سطوح دسترسی</span>
            </a>
            @endcan
            @can('country-all')
            <a href="{{route('countries.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-earth-asia"></i>
                <span>کشور ها</span>
            </a>
            @endcan
            @can('province-all')
            <a href="{{route('provinces.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-mountain-city"></i>
                <span>استان ها</span>
            </a>
            @endcan
            @can('city-all')
            <a href="{{route('cities.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-city"></i>
                <span>شهر ها</span>
            </a>
            @endcan
            @can('category-all')
            <a href="{{route('categories.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-atom"></i>
                <span>دسته ها</span>
            </a>
            @endcan
            @can('blog-all')
            <a href="{{route('blogs.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-blog"></i>
                <span>بلاگ</span>
            </a>
            @endcan
            @can('page-all')
            <a href="{{route('pages.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-file-circle-plus"></i>
                <span>صفحات</span>
            </a>
            @endcan
            @can('service-all')
                    <a href="{{route('services.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-server"></i>
                        <span>خدمات</span>
                    </a>
            @endcan
            @can('comment-all')
            <a href="{{route('comments.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-comments"></i>
                <span>نظرات</span>
            </a>
            @endcan
            @can('ticket-all')
            <a href="{{route('tickets.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-ticket"></i>
                <span>تیکیت ها</span>
            </a>
            @endcan
            @can('setting-all')
            <a href="{{route('settings.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-gear"></i>
                <span>تنظیمات</span>
            </a>
            @endcan
            @can('symbol-all')
            <a href="{{route('symbols.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-bacon"></i>
                <span>نماد ها</span>
            </a>
            @endcan
            @can('contact-all')
            <a href="{{route('contacts.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-id-card"></i>
                <span>ارتباط با ما</span>
            </a>
            @endcan
            @can('visit-all')
            <a href="{{route('visits.index')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-street-view"></i>
                <span>بازدید از ما</span>
            </a>
            @endcan
            <a href="{{route('logout')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fa-solid fa-sign-out"></i>
                <span>خروج</span>
            </a>
        </div>

{{--        <h2 class="pt-8 pb-4 text-xs font-semibold text-gray-500 dark:text-gray-400">ناحیه ها</h2>--}}
{{--        <div class="space-y-1">--}}
{{--            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">--}}
{{--                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fas fa-cog"></i>--}}
{{--                <span>تنظیمات</span>--}}
{{--            </a>--}}
{{--            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">--}}
{{--                <i class="ml-3 text-lg text-gray-500 dark:text-gray-400 fas fa-bell"></i>--}}
{{--                <span>اعلان‌ها</span>--}}
{{--            </a>--}}
{{--        </div>--}}
    </nav>

</aside>
