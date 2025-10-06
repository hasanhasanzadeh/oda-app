@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8 w-full">
            <div class="mb-12" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <div x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform -translate-y-6" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                        <div class="flex items-center space-x-6">
                            <!-- User Avatar -->
                            @if($customer->avatar)
                                <div class="relative group">
                                    <img class="w-20 h-20 rounded-2xl border-4 border-white dark:border-slate-600 shadow-2xl object-cover group-hover:scale-105 transition-transform duration-300"
                                         src="{{ $customer->avatar->address }}"
                                         alt="{{ $customer->getFullNameAttribute() }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                            @endif

                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-700 dark:from-white dark:via-slate-100 dark:to-slate-300 bg-clip-text text-transparent">
                                        ویرایش کاربر
                                    </h1>
                                    <div class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm font-medium">
                                        ID: {{ $customer->id }}
                                    </div>
                                </div>
                                <p class="text-xl text-slate-600 dark:text-slate-300">
                                    ویرایش اطلاعات برای
                                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $customer->getFullNameAttribute() }}</span>
                                </p>
                                <div class="flex items-center gap-4 mt-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 {{ $customer->is_active ? 'bg-emerald-500' : 'bg-red-500' }} rounded-full"></div>
                                        <span class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $customer->is_active ? 'فعال' : 'غیرفعال' }}
                                    </span>
                                    </div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400">
                                        آخرین بروزرسانی: {{ $customer->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3">
                            <a href="{{ route('customers.show', $customer->id) }}"
                               class="inline-flex items-center px-6 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                نمایش جزئیات
                            </a>
                            <a href="{{ route('customers.index') }}"
                               class="inline-flex items-center px-6 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                بازگشت به کاربران
                            </a>
                        </div>
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

            <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data" id="userEditForm" class="w-full mx-auto space-y-8" @submit="handleSubmit">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $customer->id }}">

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
                                        <p class="text-indigo-100">بروزرسانی اطلاعات پایه کاربری</p>
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
                                                   value="{{ old('first_name', $customer->first_name) }}"
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
                                                   value="{{ old('last_name', $customer->last_name) }}"
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
                                                    class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('gender') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                    required>
                                                <option value="">انتخاب جنسیت</option>
                                                <option value="male" {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>مرد</option>
                                                <option value="female" {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>زن</option>
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
                                        <input type="text"
                                               id="first_name_en"
                                               name="first_name_en"
                                               value="{{ old('first_name_en', $customer->first_name_en) }}"
                                               class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('first_name_en') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="First Name"
                                               required>
                                        @error('first_name_en')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Last Name English -->
                                    <div class="space-y-2">
                                        <label for="last_name_en" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">
                                            نام خانوادگی (انگلیسی) <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="last_name_en"
                                               name="last_name_en"
                                               value="{{ old('last_name_en', $customer->last_name_en) }}"
                                               class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('last_name_en') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="Last Name"
                                               required>
                                        @error('last_name_en')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Birthday -->
                                    <div class="space-y-2">
                                        <label for="birthday" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">تاریخ تولد</label>
                                        <x-persian-datepicker
                                                name="birthday"
                                                id="birthday"
                                                :value="$customer->birthday"
                                                placeholder="تاریخ تولد را انتخاب کنید"
                                        />
                                    </div>

                                    <!-- National Code -->
                                    <div class="space-y-2">
                                        <label for="national_code" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">کد ملی</label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="national_code"
                                                   name="national_code"
                                                   value="{{ old('national_code', $customer->national_code) }}"
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
                                                   value="{{ old('email', $customer->email) }}"
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
                                                        :selected="[
                                                        'id' => $customer->city?->id??'',
                                                        'title' => $customer->city?->name ?? 'انتخاب شهر',
                                                        'subtitle' => $customer->city?->name.'-'.$customer->city?->province->name.'-'.
                                                            $customer->city?->province->country->country_persian_name,
                                                        'avatar' => $customer->city?->province->country->flag->address ?? '/images/default-flag.png'
                                                    ]"
                                            />
                                        </div>
                                        @error('city_id')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Father Name -->
                                    <div class="space-y-2">
                                        <label for="father_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">نام پدر</label>
                                        <input type="text"
                                               id="father_name"
                                               name="father_name"
                                               value="{{ $customer->father_name ?? old('father_name') }}"
                                               class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('father_name') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="نام پدر را وارد کنید">
                                        @error('father_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- regin -->
                                    <div class="space-y-2">
                                        <label for="regin" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">منطقه</label>
                                        <input type="text"
                                               id="regin"
                                               name="regin"
                                               value="{{ $customer->regin ?? old('regin') }}"
                                               class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('regin') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="منطقه را وارد کنید">
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
                                            <p class="text-emerald-100">مدیریت شماره تلفن‌های تماس</p>
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
                                    @forelse($customer->phones as $index => $phone)
                                        <div class="phone-item bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 border border-slate-200 dark:border-slate-600 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]"
                                             data-phone-id="{{ $phone->id }}">
                                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                                <div class="md:col-span-3">
                                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">عنوان تلفن</label>
                                                    <input type="text"
                                                           name="phones[{{ $index }}][title]"
                                                           value="{{ old('phones.'.$index.'.title', $phone->title) }}"
                                                           class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-300"
                                                           placeholder="پدر یا مادر یا خودم">
                                                    <input type="hidden" name="phones[{{ $index }}][id]" value="{{ $phone->id }}">
                                                </div>
                                                <div class="md:col-span-4">
                                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">
                                                        شماره تلفن <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="text"
                                                           name="phones[{{ $index }}][number]"
                                                           value="{{ old('phones.'.$index.'.number', $phone->number) }}"
                                                           class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-300"
                                                           placeholder="09123456789"
                                                           required>
                                                </div>
                                                <div class="md:col-span-3">
                                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">تلفن پیش‌فرض</label>
                                                    <div class="flex items-center">
                                                        <input type="radio"
                                                               name="default_phone"
                                                               value="{{ $index }}"
                                                               class="phone-default w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500"
                                                                {{ $phone->is_default ? 'checked' : '' }}>
                                                        <label class="mr-3 text-sm text-slate-700 dark:text-slate-200 font-medium">پیش‌فرض</label>
                                                    </div>
                                                </div>
                                                <div class="md:col-span-2 flex justify-end">
                                                    <button type="button"
                                                            class="remove-phone p-3 text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-300 transform hover:scale-110">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                    <input type="hidden" name="phones[{{ $index }}][_delete]" value="0" class="delete-flag">
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="phone-item bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 border border-slate-200 dark:border-slate-600 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                                <div class="md:col-span-3">
                                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">عنوان تلفن</label>
                                                    <input type="text"
                                                           name="phones[0][title]"
                                                           value="{{ old('phones.0.title', 'اصلی') }}"
                                                           class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-300"
                                                           placeholder="پدر یا مادر یا خودم">
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
                                                        <label class="mr-3 text-sm text-slate-700 dark:text-slate-200 font-medium">پیش‌فرض</label>
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
                                    @endforelse
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
                                    @forelse($customer->addresses as $index => $address)
                                        <div class="address-item bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 border border-slate-200 dark:border-slate-600 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]"
                                             data-address-id="{{ $address->id }}">
                                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                                <div class="md:col-span-3">
                                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">عنوان آدرس</label>
                                                    <input type="text"
                                                           name="addresses[{{ $index }}][title]"
                                                           value="{{ old('addresses.'.$index.'.title', $address->title) }}"
                                                           class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300"
                                                           placeholder="اداره یا خانه یا محل کار">
                                                    <input type="hidden" name="addresses[{{ $index }}][id]" value="{{ $address->id }}">
                                                </div>
                                                <div class="md:col-span-7">
                                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">آدرس کامل</label>
                                                    <textarea name="addresses[{{ $index }}][content]"
                                                              rows="2"
                                                              class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 resize-none"
                                                              placeholder="آدرس کامل را وارد کنید">{{ old('addresses.'.$index.'.content', $address->content) }}</textarea>
                                                </div>
                                                <div class="md:col-span-2 flex justify-end">
                                                    <button type="button"
                                                            class="remove-address p-3 text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-300 transform hover:scale-110">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                    <input type="hidden" name="addresses[{{ $index }}][_delete]" value="0" class="delete-flag">
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="address-item bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 border border-slate-200 dark:border-slate-600 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                                <div class="md:col-span-3">
                                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">عنوان آدرس</label>
                                                    <input type="text"
                                                           name="addresses[0][title]"
                                                           value="{{ old('addresses.0.title', 'اصلی') }}"
                                                           class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300"
                                                           placeholder="اداره یا خانه یا محل کار">
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
                                    @endforelse
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
                                        <p class="text-orange-100">ویرایش نقش‌ها و اطلاعات سیستمی کاربر</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    <!-- Role Type -->
                                    <div class="space-y-2">
                                        <label for="role_type" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">نوع نقش</label>
                                        <select id="role_type"
                                                name="role_type"
                                                class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white focus:border-orange-500 dark:focus:border-orange-400 focus:ring-4 focus:ring-orange-500/20 transition-all duration-300 @error('role_type') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                            <option value="">انتخاب نقش</option>
                                            <option value="admin" {{ old('role_type', $customer->role_type) == 'admin' ? 'selected' : '' }}>مدیر</option>
                                            <option value="student" {{ old('role_type', $customer->role_type) == 'student' ? 'selected' : '' }}>دانش‌آموز</option>
                                            <option value="teacher" {{ old('role_type', $customer->role_type) == 'teacher' ? 'selected' : '' }}>معلم</option>
                                            <option value="staff" {{ old('role_type', $customer->role_type) == 'staff' ? 'selected' : '' }}>کارمند</option>
                                        </select>
                                        @error('role_type')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="space-y-2">
                                        <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">کلمه عبور جدید</label>
                                        <div class="relative" x-data="{ showPassword: false }">
                                            <input :type="showPassword ? 'text' : 'password'"
                                                   id="password"
                                                   name="password"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-4 focus:ring-orange-500/20 transition-all duration-300 @error('password') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="برای تغییر نکردن خالی بگذارید">
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
                                        <p class="text-xs text-slate-500 dark:text-slate-400">اگر می‌خواهید کلمه عبور تغییر نکند آن را خالی بگذارید</p>
                                        @error('password')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="space-y-2">
                                        <label for="is_active" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">وضعیت</label>
                                        <select id="is_active"
                                                name="is_active"
                                                class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white focus:border-orange-500 dark:focus:border-orange-400 focus:ring-4 focus:ring-orange-500/20 transition-all duration-300 @error('is_active') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                            <option value="1" {{ old('is_active', $customer->is_active) == '1' ? 'selected' : '' }}>فعال</option>
                                            <option value="0" {{ old('is_active', $customer->is_active) == '0' ? 'selected' : '' }}>غیرفعال</option>
                                        </select>
                                        @error('is_active')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="birthday" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">تاریخ خروج</label>
                                        <x-persian-datepicker
                                                name="leave_date"
                                                id="leave_date"
                                                :value="old('leave_date', $customer->leave_date ?? null )"
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
                                                          :existing-url="$customer->avatar->address??''"
                                                          :existing-type="$customer->avatar->type??''"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Record Information -->
                <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 1000)">
                    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-8 h-8 bg-slate-100 dark:bg-slate-700 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mr-3">اطلاعات ایجاد شده</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-2xl p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500 dark:text-slate-400 font-medium">ایجاد شده در:</span>
                                        <span class="text-slate-900 dark:text-slate-100 font-semibold">{{ $customer->created_at->format('Y/m/d H:i') }}</span>
                                    </div>
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-2xl p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500 dark:text-slate-400 font-medium">بروزرسانی شده در:</span>
                                        <span class="text-slate-900 dark:text-slate-100 font-semibold">{{ $customer->updated_at->format('Y/m/d H:i') }}</span>
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
                                انصراف
                            </a>

                            <div class="flex gap-4">
                                <button type="reset"
                                        class="px-8 py-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center">
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    بازنشانی تغییرات
                                </button>

                                <button type="submit"
                                        :disabled="isSubmitting"
                                        class="relative px-10 py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white rounded-2xl font-bold shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 opacity-0 hover:opacity-20 transition-opacity duration-300"></div>
                                    <div x-show="isSubmitting" class="animate-spin ml-2 h-5 w-5 border-2 border-white border-t-transparent rounded-full"></div>
                                    <svg x-show="!isSubmitting" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="relative z-10" x-text="isSubmitting ? 'در حال بروزرسانی...' : 'بروزرسانی کاربر'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection