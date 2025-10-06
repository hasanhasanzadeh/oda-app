<aside id="sidebar" class="fixed top-0 right-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width" aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-gray-100 border-r border-gray-200 dark:bg-gray-700 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 divide-y divide-gray-200 bg-gray-100 dark:bg-gray-700 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">
                    <li>
                        <form action="#" method="GET" class="lg:hidden">
                            <label for="mobile-search" class="sr-only">جستجو</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" value="{{request('search')}}" name="search" id="mobile-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="جستجو">
                            </div>
                        </form>
                    </li>
                    <li>
                        <a href="{{route('admin.dashboard')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-chart-pie"></i>
                            <span class="mr-3" >
                                {{__('message.dashboard')}}
                            </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('customers.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-users"></i>
                            <span class="px-2">
                                    {{__('message.customers')}}
                                    </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('roles.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-user-shield"></i>
                            <span class="px-2">
                                    {{__('message.roles')}}
                                    </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('permissions.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-user-lock"></i>
                            <span class="px-2">
                                    {{__('message.permissions')}}
                                    </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                                <a href="{{route('pages.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                                    <i class="fa-solid fa-file-circle-plus"></i>
                                    <span class="px-2">
                                    {{__('message.pages')}}
                                    </span>
                                </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('services.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-server"></i>
                            <span class="px-2">
                                    {{__('message.services')}}
                            </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('companies.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-city"></i>
                            <span class="px-2">
                                    {{__('message.companies')}}
                            </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                                <a class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200" href="{{route('categories.index')}}">
                                    <i class="fa-solid fa-cube"></i>
                                    <span class="mr-2 pr-2">{{__('message.categories')}}</span>
                                </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                                <a href="{{route('questions.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                                    <i class="fa-solid fa-question-circle"></i>
                                    <span class="px-2">
                                    {{__('message.questions')}}
                                    </span>
                                </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('blogs.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-blog"></i>
                            <span class="mr-3" >
                                {{__('message.blogs')}}
                            </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('symbols.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-peace"></i>
                            <span class="mr-3" >
                                 {{__('message.symbols')}}
                            </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('settings.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-cogs"></i>
                            <span class="mr-3" >
                                {{__('message.settings')}}
                            </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('visits.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-eye"></i>
                            <span class="mr-3" >
                                 {{__('message.visits')}}
                            </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('contacts.index')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-contact-card"></i>
                            <span class="mr-3" >
                                 {{__('message.contacts')}}
                            </span>
                        </a>
                    </li>
                    <li class="dark:hover:bg-gray-800 hover:bg-gray-300">
                        <a href="{{route('logout')}}" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group dark:text-gray-200">
                            <i class="fa-solid fa-sign-out"></i>
                            <span class="mr-3" >
                                {{__('message.logout')}}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
