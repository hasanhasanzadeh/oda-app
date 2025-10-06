<nav class="container mx-auto sticky top-0 z-50">
    <div class="w-full items-center  mx-auto px-4">
        <div class="flex justify-between h-16 lg:h-20">
            <!-- Logo -->
            <div class="flex items-center space-x-2 space-x-reverse">
                <div class="logo-pulse bg-white/20 p-2 rounded-xl">
                    <a href="{{url('/')}}">
                        <img src="{{$setting->logo->address ?? asset('/images/logo/logo.svg')}}" alt="" class="h-16">
                    </a>
                </div>
                <h1 class="font-bold text-xl text-[#FFB22C]">
                    <a href="{{url('/')}}">
                        {{$setting->title??'اکادمی زبان آزادی'}}
                    </a>
                </h1>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-2 space-x-reverse">

                <!-- Language Categories Dropdown -->
                <div class="relative group">
                    <button class="hover:text-[#FFB22C] transition-colors duration-300 flex items-center space-x-2 space-x-reverse hover-scale p-2 rounded-lg">
                        <span class="font-medium">دسته‌بندی زبان</span>
                        <i class="fas fa-chevron-down text-sm transform group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    <div class="absolute top-full right-0 mt-2 w-64 dropdown-bg rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 dropdown-enter">
                        <div class="p-4 space-y-2">
                            <a href="#" class="block text-gray-700 hover:text-[#FFB22C] hover:bg-amber-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale">
                                <i class="fas fa-flag-usa ml-3 text-[#FFB22C]"></i>انگلیسی
                            </a>
                            <a href="#" class="block text-gray-700 hover:text-[#FFB22C] hover:bg-amber-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale">
                                <i class="fas fa-flag ml-3 text-[#FFB22C]"></i>آلمانی
                            </a>
                            <a href="#" class="block text-gray-700 hover:text-[#FFB22C] hover:bg-amber-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale">
                                <i class="fas fa-flag ml-3 text-[#FFB22C]"></i>فرانسوی
                            </a>
                            <a href="#" class="block text-gray-700 hover:text-[#FFB22C] hover:bg-amber-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale">
                                <i class="fas fa-flag ml-3 text-[#FFB22C]"></i>اسپانیایی
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Level Assessment Dropdown -->
                <div class="relative group">
                    <button class="hover:text-[#FFB22C] transition-colors duration-300 flex items-center space-x-2 space-x-reverse hover-scale p-2 rounded-lg">
                        <span class="font-medium">سطح‌بندی زبان</span>
                        <i class="fas fa-chevron-down text-sm transform group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    <div class="absolute top-full right-0 mt-2 w-80 dropdown-bg rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 dropdown-enter">
                        <div class="p-4 space-y-2">
                            <a href="#" class="block text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale">
                                <i class="fas fa-play-circle ml-3 text-blue-600"></i>تست تعیین سطح
                            </a>
                            <a href="#" class="block text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale">
                                <i class="fas fa-chart-line ml-3 text-blue-600"></i>مسیر یادگیری
                            </a>
                            <a href="#" class="block text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale">
                                <i class="fas fa-trophy ml-3 text-blue-600"></i>سطوح مختلف
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Certificate Inquiry -->
                <a href="#" class="hover:text-[#FFB22C] transition-colors duration-300 hover-scale p-2 rounded-lg flex items-center space-x-2 space-x-reverse font-medium">
                    <i class="fas fa-certificate"></i>
                    <span>استعلام گواهی</span>
                </a>

                <!-- Shop -->
                <a href="#" class="hover:text-[#FFB22C] transition-colors duration-300 hover-scale py-2 px-4 rounded-lg flex items-center space-x-2 space-x-reverse font-medium">
                    <i class="fas fa-store"></i>
                    <span>فروشگاه</span>
                </a>

                <!-- Login/Register -->
                <div class="flex items-center space-x-2 space-x-reverse border-r border-white/20 pr-6">
                    <a href="{{route('login')}}" class="bg-[#FFB22C] border-2 text-gray-800 hover:text-white transition-colors duration-300 hover-scale p-2 rounded-lg font-medium">
                        <i class="fa fa-user"></i>
                        <span>
                            ثبت نام / ورود
                        </span>
                    </a>
                </div>
            </div>

            <!-- Search & Cart & Mobile Menu -->
            <div class="flex items-center space-x-2 space-x-reverse">

                <!-- Search -->
                <div class="relative hidden lg:flex">
                    <button id="searchToggle" class="bg-white border-2 border-gray-800 hover:bg-[#FFB22C] transition-colors duration-300 py-1 px-2 rounded-lg">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                    <div id="searchBox" class="absolute top-full left-0 mt-2 w-80 dropdown-bg rounded-xl shadow-2xl opacity-0 invisible transition-all duration-300 search-expand">
                        <div class="p-4">
                            <div class="relative">
                                <input type="text" placeholder="جستجو در دوره‌ها..." class="w-full bg-gray-100 text-gray-800 placeholder-gray-500 border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <div class="mt-3 space-y-2">
                                <div class="text-gray-600 text-sm">جستجوهای پیشنهادی:</div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full cursor-pointer hover:bg-blue-200 transition-colors">انگلیسی</span>
                                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full cursor-pointer hover:bg-blue-200 transition-colors">آیلتس</span>
                                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full cursor-pointer hover:bg-blue-200 transition-colors">تافل</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cart -->
                <div class="relative hidden lg:flex">
                    <button class="bg-white border-2 border-gray-800 hover:bg-[#FFB22C] duration-300 py-1 px-2 rounded-lg">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="absolute -top-1 -left-1 bg-[#FFB22C] text-xs rounded-full w-5 h-5 flex items-center justify-center ">3</span>
                    </button>
                </div>
                <div class="relative">
                    <button id="switchLangToggle" class="bg-white border-2 border-gray-800 hover:bg-[#FFB22C] transition-colors duration-300 py-1 px-2 rounded-lg">
                        فا
                    </button>
                    <div id="switchLang" class="absolute top-full left-0 mt-2 w-60 dropdown-bg rounded-xl shadow-2xl opacity-0 invisible transition-all duration-300 search-expand">
                        <div class="p-4">
                            <ul class="p-2">
                                <li class="p-2"><a class="text-gray-700 hover:text-[#FFB22C] hover:bg-amber-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale" href="#">زبان فارسی</a></li>
                                <li class="p-2"><a class="text-gray-700 hover:text-[#FFB22C] hover:bg-amber-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale" href="#">زبان انگلیسی</a></li>
                                <li class="p-2"><a class="text-gray-700 hover:text-[#FFB22C] hover:bg-amber-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale" href="#">زبان عربی</a></li>
                                <li class="p-2"><a class="text-gray-700 hover:text-[#FFB22C] hover:bg-amber-50 px-4 py-3 rounded-lg transition-all duration-200 hover-scale" href="#">زبان کردی</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuToggle" class="lg:hidden hover:text-[#FFB22C] transition-colors duration-300 p-2 rounded-lg">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="lg:hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-40 opacity-0 invisible transition-all duration-300"></div>

<!-- Mobile Menu -->
<div id="mobileMenu" class="lg:hidden fixed top-0 right-0 h-full w-80 max-w-[90vw] bg-white text-gray-800 shadow-2xl z-50 mobile-menu-slide">
    <div class="p-6">
        <!-- Mobile Header -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-3 space-x-reverse">
                <div class="bg-white/20 p-2 rounded-xl">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <h2 class="font-bold text-lg">اکادمی زبان آزادی</h2>
            </div>
            <button id="mobileMenuClose" class="hover:text-red-300 transition-colors duration-300 p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu Items -->
        <div class="space-y-4">

            <!-- Language Categories -->
            <div class="mobile-dropdown">
                <button class="mobile-dropdown-trigger w-full text-right font-medium py-3 px-4 rounded-lg transition-all duration-200 flex justify-between items-center">
                    <span> دسته بندی زبان</span>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-300"></i>
                </button>
                <div class="mobile-dropdown-content hidden mt-2 mr-4 space-y-2">
                    <a href="#" class="block 80 hover:py-2 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-flag-usa ml-3"></i>انگلیسی
                    </a>
                    <a href="#" class="block 80 hover:py-2 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-flag ml-3"></i>آلمانی
                    </a>
                    <a href="#" class="block 80 hover:py-2 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-flag ml-3"></i>فرانسوی
                    </a>
                    <a href="#" class="block 80 hover:py-2 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-flag ml-3"></i>اسپانیایی
                    </a>
                </div>
            </div>

            <!-- Level Assessment -->
            <div class="mobile-dropdown">
                <button class="mobile-dropdown-trigger w-full text-right font-medium py-3 px-4 rounded-lg transition-all duration-200 flex justify-between items-center">
                    <span>سطح‌بندی زبان</span>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-300"></i>
                </button>
                <div class="mobile-dropdown-content hidden mt-2 mr-4 space-y-2">
                    <a href="#" class="block 80 hover:py-2 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-play-circle ml-3"></i>تست تعیین سطح
                    </a>
                    <a href="#" class="block 80 hover:py-2 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-chart-line ml-3"></i>مسیر یادگیری
                    </a>
                    <a href="#" class="block 80 hover:py-2 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-trophy ml-3"></i>سطوح مختلف
                    </a>
                </div>
            </div>

            <!-- Certificate Inquiry -->
            <a href="#" class="block font-medium py-3 px-4 rounded-lg transition-all duration-200">
                <i class="fas fa-certificate ml-3"></i>استعلام گواهی
            </a>

            <!-- Shop -->
            <a href="#" class="block font-medium py-3 px-4 rounded-lg transition-all duration-200">
                <i class="fas fa-store ml-3"></i>فروشگاه
            </a>
            <div>
                <hr>
            </div>
            <!-- Mobile Search -->
            <div class="pt-4 border-t border-white/20">
                <div class="relative">
                    <input type="text" placeholder="جستجو در دوره‌ها..." class="w-full bg-gray-100 text-gray-800 placeholder-gray-500 border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <!-- Login/Register -->
            <div class="pt-4 border-t border-white/20 space-y-3">
                <a href="#" class="block text-center bg-[#FFB22C] border-2 text-gray-800 hover:text-white transition-colors duration-300 hover-scale py-2 px-6 rounded-lg font-medium shadow-lg">
                    <i class="fa fa-user"></i>
                    <span>
                            ثبت نام / ورود
                    </span>
                </a>
            </div>

            <!-- Mobile Cart -->
            <div class="pt-4 border-t border-white/20 space-y-3">
                <a href="#" class="block text-center bg-[#FFB22C] text-center border-2 text-gray-800 hover:text-white transition-colors duration-300 hover-scale py-2 px-6 rounded-lg font-medium shadow-lg">
                    <i class="fas fa-shopping-cart"></i>
                    <span>سبد خرید</span>
                </a>
            </div>
        </div>
    </div>
</div>