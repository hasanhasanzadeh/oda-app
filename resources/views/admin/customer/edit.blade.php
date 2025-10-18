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
                                            نام  <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="first_name"
                                                   name="first_name"
                                                   value="{{ old('first_name', $customer->first_name) }}"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('first_name') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="نام "
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
                                            نام خانوادگی  <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="last_name"
                                                   name="last_name"
                                                   value="{{ old('last_name', $customer->last_name) }}"
                                                   class="w-full px-4 py-4 bg-slate-50 dark:bg-slate-700/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('last_name') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                   placeholder="نام خانوادگی "
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
                                    <x-file-previewer name="avatar"
                                                      label="عکس "
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
