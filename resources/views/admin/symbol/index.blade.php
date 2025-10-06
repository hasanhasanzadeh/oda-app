@extends('admin.layouts.master')

@section('content')
    <div class="bg-white my-6 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="block md:flex items-start justify-between p-6 border-b lg:flex-row lg:items-center dark:border-gray-700">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">نمادهای اخیر</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">لیست آخرین نمادهای ثبت شده در سیستم</p>
            </div>
            <div>
                <a href="{{route('symbols.create')}}"
                   class="block md:flex w-full my-4 items-center px-3 py-2 text-sm text-blue-600 bg-blue-100 rounded-lg dark:bg-blue-700 dark:text-blue-300">
                    <i class="ml-2 fas fa-add"></i>
                    ایجاد
                </a>
            </div>
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
                    <x-sortable-column column="title" label="{{__('message.title')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <x-sortable-column column="setting" label="{{__('message.setting')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <x-sortable-column column="status" label="{{__('message.status')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <x-sortable-column column="created_at" label="{{__('message.created_at')}}" :sort="$sort"
                                       :direction="$direction"/>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                        {{__('message.operation')}}
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                @foreach($symbols as $index=>$symbol)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 hover:cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="country_{{$symbol->id}}"
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="mr-2 font-medium text-gray-900 dark:text-white">{{ $symbols->firstItem() + $index }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($symbol->photo)
                                    <img src="{{$symbol->photo->address??asset('images/no-image.png')}}"
                                         class="w-20 h-20 ml-3 rounded shadow" alt="">
                                @endif
                                <div>
                                    <div class="text-md font-medium text-gray-900 dark:text-white">{{$symbol->title}}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($symbol->setting->logo)
                                    <img src="{{$symbol->setting->logo->address??asset('images/no-image.png')}}"
                                         class="w-20 h-20 ml-3 rounded shadow" alt="">
                                @endif
                                <div>
                                    <div class="text-md font-medium text-gray-900 dark:text-white">{{$symbol->title}}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($symbol->status)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:bg-opacity-20 dark:text-blue-400">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-blue-500 rounded-full"></span>
                                <span class="px-2">{{__('message.active')}}</span>
                            </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:bg-opacity-20 dark:text-yellow-400">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-yellow-500 rounded-full"></span>
                                <span class="px-2">{{__('message.unactive')}}</span>
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{verta($symbol->created_at)->format('d F Y')}}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($symbol->created_at)->format('h:i A')}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">

                            <div class="flex items-center space-x-3 space-x-reverse">
                                <a href="{{route('symbols.show',$symbol->id)}}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                   title="{{__('message.show')}}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{route('symbols.edit',$symbol->id)}}"
                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                   title="{{__('message.edit')}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div>
                                    <form action="{{route('symbols.destroy',$symbol->id)}}" method="post"
                                          id="delete-form-{{ $symbol->id }}">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button type="button" name="delete" onclick="confirmDelete({{ $symbol->id }})"
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
                    نمایش {{ $symbols->firstItem() }} تا {{ $symbols->lastItem() }} از {{ $symbols->total() }} مورد
                </div>
                <div class="flex justify-center items-center p-3">
                    <form method="GET" action="{{ route('symbols.index') }}"
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
                <a href="{{ $symbols->appends(Request::except('page'))->previousPageUrl() }}"
                   class="{{ $symbols->onFirstPage() ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100' }} px-3 py-2 rounded-md">
                    <span class="sr-only">قبلی</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>

                <!-- Compact Page Numbers (Always showing 4 pages max) -->
                @php
                    $currentPage = $symbols->currentPage();
                    $lastPage = $symbols->lastPage();

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
                    <a href="{{ $symbols->appends(Request::except('page'))->url(1) }}"
                       class="px-3 py-2 text-gray-600 bg-white hover:bg-gray-100 rounded-md">
                        1
                    </a>
                    @if ($startPage > 2)
                        <span class="px-2 py-2 text-gray-600">...</span>
                    @endif
                @endif

                <!-- Middle Pages -->
                @foreach (range($startPage, $endPage) as $page)
                    <a href="{{ $symbols->appends(Request::except('page'))->url($page) }}"
                       class="{{ $page == $currentPage ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }} px-3 py-2 rounded-md">
                        {{ $page }}
                    </a>
                @endforeach

                <!-- Last Page Link if not in range -->
                @if ($endPage < $lastPage)
                    @if ($endPage < $lastPage - 1)
                        <span class="px-2 py-2 text-gray-600">...</span>
                    @endif
                    <a href="{{ $symbols->appends(Request::except('page'))->url($lastPage) }}"
                       class="px-3 py-2 text-gray-600 bg-white hover:bg-gray-100 rounded-md">
                        {{ $lastPage }}
                    </a>
                @endif

                <!-- Next Page Link -->
                <a href="{{ $symbols->appends(Request::except('page'))->nextPageUrl() }}"
                   class="{{ !$symbols->hasMorePages() ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100' }} px-3 py-2 rounded-md">
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
