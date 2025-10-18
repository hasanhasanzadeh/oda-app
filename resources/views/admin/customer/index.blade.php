@extends('admin.layouts.master')

@section('content')
    <div class="bg-white my-6 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="block md:flex items-start justify-between p-6 border-b lg:flex-row lg:items-center dark:border-gray-700">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">کاربران اخیر</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">لیست آخرین کاربران ثبت شده در سیستم</p>
            </div>

            <form method="get" id="myForm" class="block md:flex items-center mt-4 gap-4 space-x-reverse lg:mt-0">
                @if(request()->has('search'))
                    <input type="hidden" name="search" value="{{request('search')}}">
                @endif
                @if(request()->has('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request()->has('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif
                @if(request()->has('per_page'))
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                @endif
                <a href="{{route('customers.create')}}"
                   class="block md:flex w-full my-4 items-center px-3 py-2 text-sm text-blue-600 bg-blue-100 rounded-lg dark:bg-blue-700 dark:text-blue-300">
                    <i class="px-2 fas fa-add"></i>
                    ایجاد
                </a>
                <div class="relative">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="text-gray-400 fas fa-search"></i>
                                </span>
                    <input type="text" id="searchInput" name="search" value="{{request('search')??''}}"
                           placeholder="جستجو در کاربران..."
                           class="w-full md:w-64 py-2 pr-10 text-sm text-gray-700 placeholder-gray-400 bg-gray-100 border-none rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div x-data="{ filterOpen: false }" class="relative">
                    <button type="button" @click="filterOpen = !filterOpen"
                            class="block md:flex my-4 items-center px-3 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg dark:bg-gray-700 dark:text-gray-300">
                        <i class="ml-2 fas fa-filter"></i>
                        فیلتر
                    </button>

                    <div x-show="filterOpen"
                         @click.away="filterOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute left-0 z-10 w-64 mt-2 origin-top-left bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="p-1">
                            <label for="role_type"
                                   class="block mb-1 text-xs text-gray-600 dark:text-gray-400">{{__('message.role_type')}}</label>
                            <select name="role_type" id="role_type"
                                    class="form-select px-3 py-1 text-xs text-gray-600 bg-gray-200 rounded-lg dark:bg-gray-700 dark:text-gray-300">
                                <option value="" @if(request('role_type')==null) selected @endif>انتخاب همه</option>
                                <option value="admin"
                                        @if(request('role_type')=='admin') selected @endif>{{__('message.admin')}}</option>
                                <option value="teacher"
                                        @if(request('role_type')=='teacher') selected @endif>{{__('message.teacher')}}</option>
                                <option value="student"
                                        @if(request('role_type')=='student') selected @endif>{{__('message.student')}}</option>
                                <option value="staff"
                                        @if(request('role_type')=='staff') selected @endif>{{__('message.staff')}}</option>
                                <option value="institute"
                                        @if(request('role_type')=='institute') selected @endif>{{__('message.institute')}}</option>
                            </select>
                        </div>
                        <div class="p-4">
                            <h3 class="mt-4 mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">بازه زمانی</h3>
                            <div class="space-y-2">
                                <div>
                                    <label for="fromDateInput" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">از تاریخ </label>
                                    <x-persian-datepicker
                                            name="from_date"
                                            id="fromDateInput"
                                            :value="request('from_date') ? \Carbon\Carbon::parse(request('from_date'))->format('Y-m-d'):''"
                                            placeholder="از تاریخ "
                                    />
                                </div>
                                <div>
                                    <label for="toDateInput" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">تا تاریخ </label>
                                    <x-persian-datepicker
                                            name="to_date"
                                            id="toDateInput"
                                            :value="request('to_date') ? \Carbon\Carbon::parse(request('to_date'))->format('Y-m-d'):''"
                                            placeholder="از تاریخ "
                                    />
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4 space-x-2 space-x-reverse">
                                <button type="reset" onclick="confirmClearParameters()"
                                        class="px-3 py-1 text-xs text-gray-600 bg-gray-200 rounded-lg dark:bg-gray-700 dark:text-gray-300">
                                    پاک کردن
                                </button>
                                <button type="submit" class="px-3 py-1 text-xs text-white bg-indigo-600 rounded-lg">
                                    اعمال فیلتر
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                <tr class="bg-gray-50 dark:bg-gray-900 text-right">
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                        <input type="checkbox"
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                    </th>
                    <x-sortable-column column="id" label="{{__('message.row')}}" :sort="$sort" :direction="$direction"/>
                    <x-sortable-column column="last_name" label="{{__('message.customer')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <x-sortable-column column="national_code" label="{{__('message.national_code')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <x-sortable-column column="created_at" label="{{__('message.created_at')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <x-sortable-column column="is_active" label="{{__('message.is_active')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <x-sortable-column column="role_type" label="{{__('message.role_type')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <x-sortable-column column="mobile_verified_at" label="{{__('message.mobile_verified_at')}}"
                                       :sort="$sort" :direction="$direction"/>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                        {{__('message.operation')}}
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                @foreach($customers as $index=>$customer)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 hover:cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="customer_{{$customer->id}}"
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="mr-2 font-medium text-gray-900 dark:text-white">{{ $customers->firstItem() + $index }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="{{$customer->avatar->address??asset('images/user/avatar-profile.png')}}"
                                     class="w-10 h-10 ml-3 rounded-full" alt="">
                                <div>
                                    <div class="text-md font-medium text-gray-900 dark:text-white">{{$customer->fullName}}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400"
                                         dir="ltr">{{$customer->mobile}}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{$customer->national_code}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{verta($customer->created_at)->format('d F Y')}}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($customer->created_at)->format('h:i A')}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($customer->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:bg-opacity-20 dark:text-blue-400">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-blue-500 rounded-full"></span>
                                <span class="px-2">{{__('message.active')}}</span>
                            </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-red-800 dark:bg-red-900 dark:bg-opacity-20 dark:text-red-400">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                <span class="px-2">{{__('message.unactive')}}</span>
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:bg-opacity-20 dark:text-green-400">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                    <span class="px-2">{{$customer->role_type_label}}</span>
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($customer->mobile_verified_at)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:bg-opacity-20 dark:text-green-400">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                <span class="px-2">موبایل تایید شده</span>
                            </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:bg-opacity-20 dark:text-red-400">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                <span class="px-2">موبایل تایید نشده</span>
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">

                            <div class="flex items-center space-x-3 space-x-reverse">
                                <a href="{{route('customers.show',$customer->id)}}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                   title="{{__('message.show')}}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.show', $customer->id) }}"
                                   class="text-indigo-400 hidden sm:block px-2" title="{{__('message.permissions')}}">
                                    <i class="fa-solid fa-user-check"></i>
                                </a>
                                <a href="{{route('customers.edit',$customer->id)}}"
                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                   title="{{__('message.edit')}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div>
                                    <form action="{{route('customers.destroy',$customer->id)}}" method="post"
                                          id="delete-form-{{ $customer->id }}">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button type="button" name="delete" onclick="confirmDelete({{ $customer->id }})"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                title="{{__('message.delete')}}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex flex-col md:flex-row items-center justify-between px-6 py-4 bg-white border-t dark:bg-gray-800 dark:border-gray-700">
            <!-- Pagination count text -->
            <div class="flex items-center justify-start w-full md:w-auto mb-4 md:mb-0 text-sm text-gray-600 dark:text-gray-400">
                <div>
                    نمایش {{ $customers->firstItem() }} تا {{ $customers->lastItem() }} از {{ $customers->total() }}
                    مورد
                </div>
                <div class="flex justify-center items-center p-3">
                    <form method="GET" action="{{ route('customers.index') }}"
                          class="flex flex-wrap justify-center items-center">
                        <!-- Preserve existing query parameters -->
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{request('search')}}">
                        @endif
                        @if(request()->has('from_date'))
                            <input type="hidden" name="from_date"
                                   value="{{request('from_date') ? \Carbon\Carbon::parse(request('from_date'))->format('Y-m-d'):''}}">
                        @endif
                        @if(request()->has('to_date'))
                            <input type="hidden" name="to_date"
                                   value="{{request('to_date') ? \Carbon\Carbon::parse(request('to_date'))->format('Y-m-d'):''}}">
                        @endif
                        @if(request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request()->has('direction'))
                            <input type="hidden" name="direction" value="{{ request('direction') }}">
                        @endif
                        @if(request()->has('role_type'))
                            <input type="hidden" name="role_type" value="{{ request('role_type') }}">
                        @endif
                        <label for="per-page" class="mr-2 text-sm md:text-base px-2">@lang('message.count')</label>
                        <select id="per-page" name="per_page"
                                class="appearance-none block w-16 md:w-24 bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-2 md:py-3 md:px-4 leading-tight focus:outline-none focus:bg-gray-200 focus:border-gray-500 dark:bg-gray-600 dark:text-gray-200"
                                onchange="this.form.submit()">
                            @foreach ($allowedPerPage as $value)
                                <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- Pagination links -->
            <div class="flex items-center space-x-1 space-x-reverse">
                <!-- Previous Page Link -->
                <a href="{{ $customers->appends(Request::except('page'))->previousPageUrl() }}"
                   class="{{ $customers->onFirstPage() ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100' }} px-3 py-2 rounded-md">
                    <span class="sr-only">قبلی</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>

                <!-- Compact Page Numbers (Always showing 4 pages max) -->
                @php
                    $currentPage = $customers->currentPage();
                    $lastPage = $customers->lastPage();

                    // Calculate which pages to show (at most 4)
                    $startPage = max($currentPage - 1, 1);
                    $endPage = min($startPage + 3, $lastPage);

                    // Adjust startPage if we're near the end
                    if ($endPage - $startPage < 3 && $startPage > 1) {
                        $startPage = max($endPage - 3, 1);
                    }
                @endphp

                        <!-- First Page Link if not in range -->
                @if ($startPage > 1)
                    <a href="{{ $customers->appends(Request::except('page'))->url(1) }}"
                       class="px-3 py-2 text-gray-600 bg-white hover:bg-gray-100 rounded-md">
                        1
                    </a>
                    @if ($startPage > 2)
                        <span class="px-2 py-2 text-gray-600">...</span>
                    @endif
                @endif

                <!-- Middle Pages -->
                @foreach (range($startPage, $endPage) as $page)
                    <a href="{{ $customers->appends(Request::except('page'))->url($page) }}"
                       class="{{ $page == $currentPage ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }} px-3 py-2 rounded-md">
                        {{ $page }}
                    </a>
                @endforeach

                <!-- Last Page Link if not in range -->
                @if ($endPage < $lastPage)
                    @if ($endPage < $lastPage - 1)
                        <span class="px-2 py-2 text-gray-600">...</span>
                    @endif
                    <a href="{{ $customers->appends(Request::except('page'))->url($lastPage) }}"
                       class="px-3 py-2 text-gray-600 bg-white hover:bg-gray-100 rounded-md">
                        {{ $lastPage }}
                    </a>
                @endif

                <!-- Next Page Link -->
                <a href="{{ $customers->appends(Request::except('page'))->nextPageUrl() }}"
                   class="{{ !$customers->hasMorePages() ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100' }} px-3 py-2 rounded-md">
                    <span class="sr-only">بعدی</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.delete_index')
