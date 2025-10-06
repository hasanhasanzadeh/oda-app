@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('countries.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.countries') }}
            </a>
        </div>

        <!-- Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                    {{ $country->country_name }} ({{ $country->country_code }})
                </h2>
            </div>

            <div class="px-6 py-4">
                <dl>
                    <!-- ID -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.id') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $country->id }}
                        </dd>
                    </div>

                    <!-- Country Name -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.country_name') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $country->country_name }}
                        </dd>
                    </div>

                    <!-- Persian Name -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.country_persian_name') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            <div class="flex items-center">
                                @if($country->flag)
                                    <img src="{{$country->flag->address??asset('images/no-image.png')}}"
                                         class="w-12 h-8 ml-3 rounded shadow" alt="">
                                @endif
                                <div>
                                    <div class="text-md font-medium text-gray-900 dark:text-white">{{$country->country_persian_name}}</div>
                                </div>
                            </div>
                        </dd>
                    </div>

                    <!-- Country Code -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.country_code') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded dark:bg-blue-900 dark:text-blue-200">
                            {{ $country->country_code }}
                        </span>
                        </dd>
                    </div>

                    <!-- Created At -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.created_at') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            <div class="text-sm text-gray-900 dark:text-white">{{verta($country->created_at)->format('d F Y')}}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($country->created_at)->format('h:i A')}}</div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 flex justify-end space-x-3 rtl:space-x-reverse">
                <a href="{{ route('countries.edit', $country->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('message.edit') }}
                </a>

                <form action="{{ route('countries.destroy', $country->id) }}" method="POST" class="inline-block"
                      id="delete-form-{{ $country->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 transition ease-in-out duration-150"
                            onclick="confirmDelete({{$country->id}})">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('message.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.delete')
