@extends('admin.layouts.master')

@section('content')
    <div class="bg-white my-6 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-start justify-between p-6 border-b lg:flex-row lg:items-center dark:border-gray-700">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">ایجاد استان</h2>
            </div>
            <div>
                <a href="{{route('provinces.index')}}"
                   class="flex items-center px-3 py-2 text-sm text-blue-600 bg-blue-100 rounded-lg dark:bg-blue-700 dark:text-blue-300">
                    <i class="ml-2 fas fa-list"></i>
                    <span>
                        استان ها
                    </span>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="w-full">
                <div class="space-y-8 divide-y divide-gray-200 mt-10 gap-3">
                    <form method="POST" action="{{route('provinces.store')}}" class="w-full">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="m-4">
                                <div class="m-4">
                                    <x-search-select
                                            name="country_id"
                                            url="{{ route('country.search') }}"
                                            :multiple="false"
                                            label="کشور"
                                            placeholder="کشور را انتخاب کنید"
                                    />
                                </div>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm font-medium mb-1 dark:text-gray-200"
                                       for="country_persian_name">{{__('message.province')}}</label>
                                <input type="text" id="province_name" name="province_name"
                                       value="{{old('province_name')}}"
                                       class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                                       placeholder="{{__('message.province')}}">
                            </div>
                            <div class="m-4 p-4">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('message.store')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
