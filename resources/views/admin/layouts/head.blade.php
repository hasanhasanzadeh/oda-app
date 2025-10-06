<header class="sticky top-0 z-40 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center justify-between h-16 px-6">
        <div class="flex items-center space-x-4 space-x-reverse">
            <button @click="sidebarOpen = !sidebarOpen; console.log('Sidebar toggled:', sidebarOpen)" class="text-gray-600 dark:text-gray-300 focus:outline-none lg:hidden">
                <i class="text-xl fas" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
            </button>
            <div >
                <h3 class="text-sm text-gray-700 dark:text-gray-200">
                    {{auth()->user()->fullName}}
                </h3>
                <h3 class="text-xs text-gray-600 dark:text-gray-300">
                    {{auth()->user()->mobile}}
                </h3>
            </div>
        </div>

        <div class="flex items-center space-x-4 space-x-reverse">
            <button id="theme-toggle" type="button" class="text-gray-600 dark:text-gray-300">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
            </button>

            <div x-data="{ notificationOpen: false }" class="relative">
                <button @click="notificationOpen = !notificationOpen" class="relative text-gray-600 dark:text-gray-300">
                    <i class="text-xl fas fa-bell"></i>
                    <span class="absolute -top-2 left-3 flex items-center justify-center w-4 h-4 text-xs text-white bg-red-500 rounded-full">{{\App\Helpers\DashboardPanel::dashboard()['sumCount']}}</span>
                </button>

                <div x-show="notificationOpen"
                     @click.away="notificationOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute left-0 mt-3 overflow-hidden origin-top-left bg-white rounded-lg shadow-lg w-80 dark:bg-gray-800 rtl-fix"
                     style="z-index: 999;">
                    <div class="py-2">
                        <div class="px-4 py-3 border-b dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">اعلان‌ها</h3>
                                <a href="{{route('admin.dashboard')}}" class="text-xs text-blue-600 dark:text-blue-400">خلاصه ای از اعلانات روزانه</a>
                            </div>
                        </div>
                        <a href="{{route('customers.index')}}" class="block px-4 py-3 transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 border-b dark:border-gray-700">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <div class="flex-shrink-0 ml-3">
                                        <div class="flex items-center justify-center w-10 h-10 text-white bg-indigo-500 rounded-full">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900 dark:text-white">
                                            <span class="font-semibold">کاربر جدید</span> ثبت‌نام کرد
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-900 dark:text-white">{{\App\Helpers\DashboardPanel::dashboard()['userToday']}}</span>
                                </div>
                            </div>
                        </a>
                        <a href="{{route('payments.index')}}" class="block px-4 py-3 transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 border-b dark:border-gray-700">
                            <div class="flex justify-between">
                               <div class="flex">
                                   <div class="flex-shrink-0 ml-3">
                                       <div class="flex items-center justify-center w-10 h-10 text-white bg-green-500 rounded-full">
                                           <i class="fas fa-shopping-cart"></i>
                                       </div>
                                   </div>
                                   <div>
                                       <p class="text-sm text-gray-900 dark:text-white">
                                           <span class="font-semibold">سفارش جدید</span> ثبت شد
                                       </p>
                                   </div>
                               </div>
                                <div>
                                    <span class="text-sm text-gray-900 dark:text-white">{{\App\Helpers\DashboardPanel::dashboard()['paymentToday']}}</span>
                                </div>
                            </div>
                        </a>
                        <a href="{{route('contacts.index')}}" class="block px-4 py-3 transition-colors hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="flex justify-between">
                                <div class="flex ">
                                    <div class="flex-shrink-0 ml-3">
                                        <div class="flex items-center justify-center w-10 h-10 text-white bg-red-500 rounded-full">
                                            <i class="fas fa-contact-book"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900 dark:text-white">
                                            <span class="font-semibold">ارتباط با ما</span>ثبت اطلاعات جدید
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-900 dark:text-white">{{\App\Helpers\DashboardPanel::dashboard()['contactToday']}}</span>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- منو پروفایل -->
            <div x-data="{ profileOpen: false }" class="relative">
                <button @click="profileOpen = !profileOpen" class="relative">
                    <img src="{{auth()->user()->avatar->address??asset('images/user/avatar-profile.png')}}" class="w-8 h-8 rounded-full border-2 border-indigo-500" alt="تصویر پروفایل">
                </button>

                <div x-show="profileOpen"
                     @click.away="profileOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute left-0 mt-3 overflow-hidden origin-top-left bg-white rounded-lg shadow-lg w-48 dark:bg-gray-800 rtl-fix"
                     style="z-index: 999;">
                    <div class="py-1">
                        <a href="{{route('profile.edit')}}" class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            <i class="ml-2 fas fa-user"></i>
                            پروفایل من
                        </a>
                        <div class="border-t dark:border-gray-700"></div>
                        <a href="{{route('logout')}}" class="block px-4 py-2 text-sm text-red-600 transition-colors hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700">
                            <i class="ml-2 fas fa-sign-out-alt"></i>
                            خروج
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
