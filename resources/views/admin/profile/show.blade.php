@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('admin.dashboard') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.dashboard') }}
            </a>
        </div>

        <!-- Customer Profile Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <!-- Profile Header -->
            <div class="p-6 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row">
                    <div class="flex-shrink-0 mx-auto sm:mx-0 mb-4 sm:mb-0 sm:mr-4">
                        @if($user->avatar)
                            <img
                                    src="{{ $user->avatar->address }}"
                                    alt="{{ $user->fullNameWithGender }}"
                                    class="h-24 w-24 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-md"
                            >
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-4 border-white dark:border-gray-700 shadow-md">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col items-center sm:items-start">
                        <div class="text-center sm:text-left">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $user->fullNameWithGender }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                ID: {{ $user->id }}
                            </p>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2 justify-center sm:justify-start">
                        <span class="text-xs font-semibold inline-block py-1 px-2 rounded text-blue-600 bg-blue-100 uppercase dark:bg-blue-900 dark:text-blue-200">
                            {{ $user->role_type }}
                        </span>

                            @if($user->is_active)
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-emerald-600 bg-emerald-100 dark:bg-emerald-900 dark:text-emerald-200">
                                {{ __('message.active') }}
                            </span>
                            @else
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-red-600 bg-red-100 dark:bg-red-900 dark:text-red-200">
                                {{ __('message.inactive') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    {{ __('message.contact_information') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Mobile Number -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 px-2">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('message.mobile') }}
                            </p>
                            <a href="tel:{{$user->mobile}}" target="_blank"
                               class="text-sm text-gray-500 dark:text-gray-400" dir="ltr">
                                {{ $user->mobile ?: '-' }}
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 px-2">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('message.email') }}
                            </p>
                            <a href="mailto:{{$user->email}}" target="_blank"
                               class="text-sm text-gray-500 dark:text-gray-400" dir="ltr">
                                {{ $user->email ?: '-' }}
                            </a>
                        </div>
                    </div>

                    <!-- National Code -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 px-2">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('message.national_code') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400" dir="ltr">
                                {{ $user->national_code ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 px-2">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('message.birthday') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ verta($user->birthday)->format('Y-m-d') }}
                            </p>
                        </div>
                    </div>

                    <!-- Registered Date -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 px-2">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('message.created_at') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ verta($user->created_at) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end space-x-3 rtl:space-x-reverse">
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('message.edit') }}
                </a>
            </div>
        </div>
    </div>
@endsection

