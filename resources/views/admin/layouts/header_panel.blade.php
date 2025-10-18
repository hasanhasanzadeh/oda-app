@php
    $setting = App\Models\Setting::with(['logo','favicon'])->first();
@endphp
<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pr-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <a href="{{url('/')}}" class="flex mr-2 md:ml-24">
                    <img src="{{$setting->logo->address??asset('/images/logo/logo-icon.svg')}}" class="h-8 w-8 object-cover mr-3 rounded-full" alt="FlowBite Logo">
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
                        <span class="px-2">
                            {{$setting->title}}
                        </span>
                    </span>
                </a>
                <form method="GET" class="hidden lg:block lg:pl-3.5">
                    <input type="hidden" name="from_date" value="{{request('from_date')}}">
                    <input type="hidden" name="to_date" value="{{request('to_date')}}">
                    <label for="topbar-search" class="sr-only">جستجو</label>
                    <div class="relative mt-1 lg:w-96">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" value="{{request('search')}}" name="search" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="جستجو">
                    </div>
                </form>
            </div>
            <div class="flex items-center">
                <div class="hidden ml-3 -mb-1 sm:block">
                    <span></span>
                </div>

                <button id="toggleSidebarMobileSearch" type="button" class="p-2 px-3 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">جستجو</span>

                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                </button>

                <div id="tooltip-toggle" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1764px, 63px);" data-popper-placement="bottom">
                    Toggle dark mode
                    <div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(69px);"></div>
                </div>
                <button type="button" data-dropdown-toggle="notification-dropdown" class="p-2 px-3 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                    <span class="sr-only">View notifications</span>

                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                </button>

                <div class="z-50  hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700" id="notification-dropdown" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1756px, 977px);" data-popper-placement="bottom">
                    <div class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        اعلانات
                    </div>
                    <div>
                        <a href="{{route('customers.index')}}" class="flex px-2 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                            <div class="w-full pl-3 flex px-2 items-center justify-content-center text-center">
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                    <span class="font-medium text-gray-700 dark:text-gray-100 text-xl">{{\App\Helpers\DashboardPanel::dashboard()['userToday']}}</span>
                                </div>
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                    <span class="font-semibold text-gray-600 dark:text-gray-100 px-3">
                                      کاربران ثبت نام شده امروز
                                    </span>
                                </div>
                            </div>
                        </a>
                        <a href="{{route('contacts.index')}}" class="flex px-2 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                            <div class="w-full pl-3 flex px-2 items-center justify-content-center text-center">
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                    <span class="font-medium text-gray-700 dark:text-gray-100 text-xl">{{\App\Helpers\DashboardPanel::dashboard()['contactToday']}}</span>
                                </div>
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                    <span class="font-semibold text-gray-600 dark:text-gray-100 px-3">
                                      نظرات ثبت شده امروز
                                    </span>
                                </div>
                            </div>
                        </a>
                        <a href="{{route('counselings.index')}}" class="flex px-2 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                            <div class="w-full pl-3 flex px-2 items-center justify-content-center text-center">
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                    <span class="font-medium text-gray-700 dark:text-gray-100 text-xl">{{\App\Helpers\DashboardPanel::dashboard()['counselingToday']}}</span>
                                </div>
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                    <span class="font-semibold text-gray-600 dark:text-gray-100 px-3">
                                      درخواست مشاوره های ثبت شده امروز
                                    </span>
                                </div>
                            </div>
                        </a>
                        <a href="{{route('counselings.index')}}" class="flex px-2 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                            <div class="w-full pl-3 flex px-2 items-center justify-content-center text-center">
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                    <span class="font-medium text-gray-700 dark:text-gray-100 text-xl">{{\App\Helpers\DashboardPanel::dashboard()['commentsToday']}}</span>
                                </div>
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                    <span class="font-semibold text-gray-600 dark:text-gray-100 px-3">
                                      نظرات ثبت شده امروز
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="flex items-center mr-3">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-300 rounded-full" id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-10 h-10 rounded-full" src="{{auth()->user()->avatar->address??asset('/images/user/avatar-profile.png')}}" alt="user photo">
                        </button>
                    </div>

                    <div class="z-50 hidden my-4 max-w-sm text-base w-[200px] list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-2" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1884px, 973px);" data-popper-placement="bottom">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm font-medium text-center text-gray-900 truncate dark:text-gray-300" role="none">
                                {{auth()->user()->mobile}}
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="{{route('admin.dashboard')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                    <i class="fa-solid fa-chart-pie"></i>
                                    <span class="px-2">داشبورد</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('profile.show')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                    <i class="fa fa-user"></i>
                                    <span class="px-2">پروفایل</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.logout')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                    <i class="fa fa-sign-out"></i>
                                    <span class="px-2">خروج</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
