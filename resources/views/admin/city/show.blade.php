@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('cities.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.cities') }}
            </a>
        </div>

        <!-- Geographic Breadcrumb Navigation -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('countries.show', $city->province->country->id) }}"
                       class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 21v-4m0 0V5a2 2 0 012-2h6.5L21 11.5V19a2 2 0 01-2 2h-8a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ $city->province->country->country_name }}
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('provinces.show', $city->province->id) }}"
                           class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            {{ $city->province->name }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                        {{ $city->name }}
                    </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- City Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                        {{ $city->name }}
                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">#{{ $city->id }}</span>
                    </h2>
                    <div class="mt-2 sm:mt-0 flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ __('message.city') }}
                    </span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <dl>
                    <!-- ID -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.id') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $city->id }}
                        </dd>
                    </div>

                    <!-- Country -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.country') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm">
                            <a href="{{ route('countries.show', $city->province->country->id) }}"
                               class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <div class="flex items-center">
                                    @if($city->province->country->flag)
                                        <img src="{{$city->province->country->flag->address??asset('images/no-image.png')}}"
                                             class="w-12 h-8 ml-3 rounded shadow" alt="">
                                    @endif
                                    <div>
                                        <div class="text-md font-medium text-gray-900 dark:text-white">{{$city->province->country->country_persian_name}}</div>
                                    </div>
                                </div>
                            </a>
                        </dd>
                    </div>

                    <!-- Province -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.province') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm">
                            <a href="{{ route('provinces.show', $city->province->id) }}"
                               class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                {{ $city->province->name }}
                            </a>
                        </dd>
                    </div>

                    <!-- City Name -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.city') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $city->name }}
                        </dd>
                    </div>

                    <!-- Created At -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.created_at') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3">
                            <div class="text-sm text-gray-900 dark:text-white">
                                {{ verta($city->created_at)->format('d F Y') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ verta($city->created_at)->format('h:i A') }}
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex flex-wrap justify-end gap-3">
                <a href="{{ route('cities.edit', $city->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('message.edit') }}
                </a>

                <form action="{{ route('cities.destroy', $city->id) }}" method="POST" class="inline-block"
                      id="delete-form-{{ $city->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 transition ease-in-out duration-150"
                            onclick="confirmDelete({{$city->id}})">
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
