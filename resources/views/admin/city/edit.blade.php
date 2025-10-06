@extends('admin.layouts.master')
@section('content')
    <div class="bg-white my-6 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-start justify-between p-6 border-b lg:flex-row lg:items-center dark:border-gray-700">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">ایجاد شهر</h2>
            </div>
            <div>
                <a href="{{route('cities.index')}}"
                   class="flex items-center px-3 py-2 text-sm text-blue-600 bg-blue-100 rounded-lg dark:bg-blue-700 dark:text-blue-300">
                    <i class="ml-2 fas fa-list"></i>
                    <span>
                        شهر ها
                    </span>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="w-full">
                <div class="space-y-8 divide-y divide-gray-200 mt-10 gap-3">
                    <form method="POST" action="{{route('cities.update',$city->id)}}" class="w-full">
                        @csrf
                        {{method_field('PATCH')}}
                        <input type="hidden" name="id" value="{{$city->id}}">
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="m-4">
                                <x-search-select
                                        name="province_id"
                                        url="{{ route('province.search') }}"
                                        :multiple="false"
                                        label="استان"
                                        :selected="[
                                            'id' => $city->province_id,
                                            'title' => $city->province->name,
                                            'subtitle' => $city->province->country->country_name,
                                            'avatar' => $city->province->country->flag->address ?? '/images/default-flag.png'
                                        ]"
                                        placeholder="استان را انتخاب کنید"
                                />
                            </div>
                            <div class="m-4">
                                <label class="block text-sm font-medium mb-1 dark:text-gray-200"
                                       for="country_persian_name">{{__('message.city')}}</label>
                                <input type="text" id="city_name" name="city_name" value="{{$city->name}}"
                                       class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                                       placeholder="{{__('message.city')}}">
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
