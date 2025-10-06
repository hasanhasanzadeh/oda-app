@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8 w-full">
            <div class="text-center mb-12" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <div x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform -translate-y-6" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="inline-flex items-center justify-center w-20 h-20 mb-6 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-3xl shadow-2xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-700 dark:from-white dark:via-slate-100 dark:to-slate-300 bg-clip-text text-transparent mb-4">
                        ایجاد کاربر جدید
                    </h1>
                    <p class="text-xl text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                        تکمیل اطلاعات کاربر با دقت و جزئیات کامل
                    </p>
                </div>
            </div>

            <div class="mb-12 max-w-2xl mx-auto">
                <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400 mb-3">
                    <span class="font-medium">شروع</span>
                    <span x-text="`${formProgress}% تکمیل شده`" class="font-medium"></span>
                    <span class="font-medium">تکمیل</span>
                </div>
                <div class="relative w-full h-3 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full transform origin-left scale-x-0 transition-transform duration-1000 ease-out"
                         :style="`transform: scaleX(${formProgress / 100})`">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 rounded-full opacity-50 blur-sm transform origin-left scale-x-0 transition-transform duration-1000 ease-out"
                         :style="`transform: scaleX(${formProgress / 100})`">
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-8 max-w-4xl mx-auto" x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 rounded-2xl p-6 backdrop-blur-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 dark:bg-red-800/50 rounded-full flex items-center justify-center">
                                    <svg class="h-5 w-5 text-red-600 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mr-4">
                                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">لطفاً خطاهای زیر را برطرف کنید:</h3>
                                <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-300">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button @click="show = false" class="mr-auto">
                                <svg class="w-5 h-5 text-red-400 hover:text-red-600 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-8 max-w-4xl mx-auto" x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-2xl p-6 backdrop-blur-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-800/50 rounded-full flex items-center justify-center">
                                    <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mr-4">
                                <p class="text-lg font-medium text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="mr-auto">
                                <svg class="w-5 h-5 text-emerald-400 hover:text-emerald-600 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" id="userEditForm" class="w-full mx-auto space-y-8" @submit="handleSubmit">
                @csrf

                <!-- Personal Information Section -->
                <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)">
                    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 overflow-hidden group-hover:scale-[1.02]">
                            <!-- Header -->
                            <div class="relative px-8 py-6 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                                <div class="absolute inset-0 bg-black/10"></div>
                                <div class="relative flex items-center">
                                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div class="mr-6">
                                        <h2 class="text-2xl font-bold text-white mb-1">اطلاعات شخصی</h2>
                                        <p class="text-indigo-100">جزئیات هویتی و شناسایی کاربر</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    <!-- First Name Persian -->
                                    <div class="space-y-2">
                                        <label for="first_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">
                                            نام (فارسی) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="first_name"
                                                   name="first_name"
                                                   value="{{ old('first_name') }}"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('first_name') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="نام (فارسی)"
                                                   required>
                                            <div class="absolute left-4 top-4">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('first_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Last Name Persian -->
                                    <div class="space-y-2">
                                        <label for="last_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">
                                            نام خانوادگی (فارسی) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="last_name"
                                                   name="last_name"
                                                   value="{{ old('last_name') }}"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('last_name') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="نام خانوادگی (فارسی)"
                                                   required>
                                        </div>
                                        @error('last_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="space-y-2">
                                        <label for="gender" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">
                                            جنسیت <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select id="gender"
                                                    name="gender"
                                                    @change="updateProgress()"
                                                    class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('gender') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                    required>
                                                <option value="">انتخاب جنسیت</option>
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>مرد</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>زن</option>
                                            </select>
                                            <div class="absolute left-4 top-4 pointer-events-none">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('gender')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- First Name English -->
                                    <div class="space-y-2">
                                        <label for="first_name_en" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">
                                            نام (انگلیسی) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="first_name_en"
                                                   name="first_name_en"
                                                   value="{{ old('first_name_en') }}"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('first_name_en') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="First Name"
                                                   required>
                                        </div>
                                        @error('first_name_en')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Last Name English -->
                                    <div class="space-y-2">
                                        <label for="last_name_en" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">
                                            نام خانوادگی (انگلیسی) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="last_name_en"
                                                   name="last_name_en"
                                                   value="{{ old('last_name_en') }}"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('last_name_en') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="Last Name"
                                                   required>
                                        </div>
                                        @error('last_name_en')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="birthday" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">تاریخ تولد</label>
                                        <x-persian-datepicker
                                                name="birthday"
                                                id="birthday"
                                                :value="old('birthday')"
                                                placeholder="تاریخ تولد را انتخاب کنید"
                                        />
                                        @error('birthday')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- National Code -->
                                    <div class="space-y-2">
                                        <label for="national_code" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">کد ملی</label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="national_code"
                                                   name="national_code"
                                                   value="{{ old('national_code') }}"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('national_code') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="کد ملی را وارد کنید">
                                            <div class="absolute left-4 top-4">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('national_code')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">آدرس ایمیل</label>
                                        <div class="relative">
                                            <input type="email"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('email') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="user@example.com">
                                            <div class="absolute left-4 top-4">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('email')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- City -->
                                    <div class="space-y-2">
                                        <div class="m-4">
                                            <x-search-select
                                                    name="city_id"
                                                    url="{{ route('city.search') }}"
                                                    :multiple="false"
                                                    label="شهر"
                                                    placeholder="شهر را انتخاب کنید"
                                            />
                                        </div>
                                        @error('city_id')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Father Name -->
                                    <div class="space-y-2">
                                        <label for="father_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">نام پدر</label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="father_name"
                                                   name="father_name"
                                                   value="{{ old('father_name') }}"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('father_name') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="نام پدر را وارد کنید">
                                        </div>
                                        @error('father_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- regin -->
                                    <div class="space-y-2">
                                        <label for="regin" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">منطقه</label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="regin"
                                                   name="regin"
                                                   value="{{ old('regin') }}"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('regin') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="منطقه را وارد کنید">
                                        </div>
                                        @error('regin')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phone Numbers Section -->
                <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 400)">
                    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 overflow-hidden group-hover:scale-[1.02]">
                            <!-- Header -->
                            <div class="relative px-8 py-6 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500">
                                <div class="absolute inset-0 bg-black/10"></div>
                                <div class="relative flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <div class="mr-6">
                                            <h2 class="text-2xl font-bold text-white mb-1">شماره تلفن‌ها</h2>
                                            <p class="text-emerald-100">مدیریت اطلاعات تماس</p>
                                        </div>
                                    </div>
                                    <button type="button"
                                            @click="addPhone()"
                                            class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center">
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        افزودن تلفن
                                    </button>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8">
                                <div id="phoneContainer" class="space-y-6">
                                    <div class="phone-item bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 border border-slate-200 dark:border-slate-600 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                            <div class="md:col-span-3">
                                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">عنوان تلفن</label>
                                                <input type="text"
                                                       name="phones[0][title]"
                                                       value="{{ old('phones.0.title', 'اصلی') }}"
                                                       class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-300"
                                                       placeholder="مثال: اصلی، کاری">
                                            </div>
                                            <div class="md:col-span-4">
                                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">
                                                    شماره تلفن <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text"
                                                       name="phones[0][number]"
                                                       value="{{ old('phones.0.number') }}"
                                                       class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-300"
                                                       placeholder="09123456789"
                                                       required>
                                            </div>
                                            <div class="md:col-span-3">
                                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">تلفن پیش‌فرض</label>
                                                <div class="flex items-center">
                                                    <input type="radio"
                                                           name="default_phone"
                                                           value="0"
                                                           class="phone-default w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500"
                                                           checked>
                                                    <label class="mr-3 text-sm text-slate-700 dark:text-slate-200 font-medium">تنظیم به عنوان پیش‌فرض</label>
                                                </div>
                                            </div>
                                            <div class="md:col-span-2 flex justify-end">
                                                <button type="button"
                                                        class="remove-phone p-3 text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-300 transform hover:scale-110"
                                                        style="display: none;">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Addresses Section -->
                <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 600)">
                    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 overflow-hidden group-hover:scale-[1.02]">
                            <!-- Header -->
                            <div class="relative px-8 py-6 bg-gradient-to-r from-purple-500 via-pink-500 to-rose-500">
                                <div class="absolute inset-0 bg-black/10"></div>
                                <div class="relative flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div class="mr-6">
                                            <h2 class="text-2xl font-bold text-white mb-1">آدرس‌ها</h2>
                                            <p class="text-purple-100">مدیریت آدرس‌های فیزیکی</p>
                                        </div>
                                    </div>
                                    <button type="button"
                                            @click="addAddress()"
                                            class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center">
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        افزودن آدرس
                                    </button>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8">
                                <div id="addressContainer" class="space-y-6">
                                    <div class="address-item bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 border border-slate-200 dark:border-slate-600 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                            <div class="md:col-span-3">
                                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">عنوان آدرس</label>
                                                <input type="text"
                                                       name="addresses[0][title]"
                                                       value="{{ old('addresses.0.title', 'اصلی') }}"
                                                       class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300"
                                                       placeholder="مثال: منزل، دفتر">
                                            </div>
                                            <div class="md:col-span-7">
                                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">آدرس کامل</label>
                                                <textarea name="addresses[0][content]"
                                                          rows="2"
                                                          class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 resize-none"
                                                          placeholder="آدرس کامل را وارد کنید">{{ old('addresses.0.content') }}</textarea>
                                            </div>
                                            <div class="md:col-span-2 flex justify-end">
                                                <button type="button"
                                                        class="remove-address p-3 text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-300 transform hover:scale-110"
                                                        style="display: none;">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Information Section -->
                <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 800)">
                    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 overflow-hidden group-hover:scale-[1.02]">
                            <!-- Header -->
                            <div class="relative px-8 py-6 bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500">
                                <div class="absolute inset-0 bg-black/10"></div>
                                <div class="relative flex items-center">
                                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div class="mr-6">
                                        <h2 class="text-2xl font-bold text-white mb-1">اطلاعات سیستم</h2>
                                        <p class="text-orange-100">تنظیمات حساب و دسترسی‌ها</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    <!-- Role Type -->
                                    <div class="space-y-2">
                                        <label for="role_type" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">نوع نقش</label>
                                        <div class="relative">
                                            <select id="role_type"
                                                    name="role_type"
                                                    @change="updateProgress()"
                                                    class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white focus:border-orange-500 dark:focus:border-orange-400 focus:ring-4 focus:ring-orange-500/20 transition-all duration-300 @error('role_type') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                                <option value="">انتخاب نقش</option>
                                                <option value="admin" {{ old('role_type') == 'admin' ? 'selected' : '' }}>مدیر کل</option>
                                                <option value="student" {{ old('role_type') == 'student' ? 'selected' : '' }}>دانشجو</option>
                                                <option value="teacher" {{ old('role_type') == 'teacher' ? 'selected' : '' }}>مدرس</option>
                                                <option value="staff" {{ old('role_type') == 'staff' ? 'selected' : '' }}>کارمند</option>
                                            </select>
                                        </div>
                                        @error('role_type')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="space-y-2">
                                        <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">رمز عبور جدید</label>
                                        <div class="relative" x-data="{ showPassword: false }">
                                            <input :type="showPassword ? 'text' : 'password'"
                                                   id="password"
                                                   name="password"
                                                   @input="updateProgress()"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-4 focus:ring-orange-500/20 transition-all duration-300 @error('password') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="برای حفظ رمز فعلی خالی بگذارید">
                                            <button type="button" @click="showPassword = !showPassword" class="absolute left-4 top-4">
                                                <svg x-show="!showPassword" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <svg x-show="showPassword" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">برای حفظ رمز عبور فعلی خالی بگذارید</p>
                                        @error('password')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="space-y-2">
                                        <label for="is_active" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">وضعیت</label>
                                        <div class="relative">
                                            <select id="is_active"
                                                    name="is_active"
                                                    @change="updateProgress()"
                                                    class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white focus:border-orange-500 dark:focus:border-orange-400 focus:ring-4 focus:ring-orange-500/20 transition-all duration-300 @error('is_active') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>فعال</option>
                                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>غیرفعال</option>
                                            </select>
                                        </div>
                                        @error('is_active')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="birthday" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">تاریخ خروج</label>
                                        <x-persian-datepicker
                                                name="leave_date"
                                                id="leave_date"
                                                :value="old('leave_date')"
                                                placeholder="تاریخ خروج را انتخاب کنید"
                                        />
                                        <p class="text-xs text-slate-500 dark:text-slate-400">در صورت عدم فعالیت کاربر تنظیم کنید</p>
                                        @error('leave_date')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Profile Image -->
                                    <div class="flex justify-between justify-items-center">
                                        <x-file-previewer name="avatar"
                                                          label="عکس پروفایل "
                                                          :multiple="false"
                                                          lang="fa"
                                                          accept="image/*"
                                                          :maxSize="config('file-upload.max_file_upload')"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="group">
                    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl p-8 flex flex-col sm:flex-row justify-between items-center gap-6 group-hover:scale-[1.02] transition-all duration-500">
                            <a href="{{ route('customers.index') }}"
                               class="inline-flex items-center px-8 py-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                بازگشت به لیست
                            </a>

                            <div class="flex gap-4">
                                <button type="button"
                                        @click="resetForm()"
                                        class="px-8 py-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center">
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    بازنشانی
                                </button>

                                <button type="submit"
                                        :disabled="isSubmitting"
                                        class="relative px-10 py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white rounded-2xl font-bold shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 opacity-0 hover:opacity-20 transition-opacity duration-300"></div>
                                    <div x-show="isSubmitting" class="animate-spin ml-2 h-5 w-5 border-2 border-white border-t-transparent rounded-full"></div>
                                    <svg x-show="!isSubmitting" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="relative z-10" x-text="isSubmitting ? 'در حال ایجاد...' : 'ایجاد کاربر'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection