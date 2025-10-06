@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen">

        <div class="container mx-auto px-4 py-8 w-full">
            <!-- Header Section -->
            <div class="mb-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <div x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform -translate-y-6" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 overflow-hidden">
                        <!-- Cover Background -->
                        <div class="relative h-48 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                            <div class="absolute inset-0 bg-black/10"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>

                            <!-- Floating Elements -->
                            <div class="absolute top-6 left-6 w-20 h-20 bg-white/10 rounded-full blur-xl animate-pulse"></div>
                            <div class="absolute bottom-8 right-8 w-16 h-16 bg-white/10 rounded-full blur-xl animate-pulse" style="animation-delay: 1s"></div>
                        </div>

                        <div class="relative px-8 pb-8">
                            <!-- Profile Avatar -->
                            <div class="absolute -top-40 left-8">
                                <div class="relative group">
                                    <div class="w-40 h-40 rounded-3xl bg-white dark:bg-slate-800 p-2 shadow-2xl transform group-hover:scale-105 transition-all duration-300">
                                        @if($customer->avatar)
                                            <img src="{{ $customer->avatar->address }}"
                                                 class="w-full h-full rounded-2xl object-cover"
                                                 alt="{{ $customer->first_name }} {{ $customer->last_name }}">
                                        @else
                                            <div class="w-full h-full rounded-2xl bg-gradient-to-br from-indigo-400 via-purple-500 to-pink-500 flex items-center justify-center text-white text-4xl font-bold shadow-inner">
                                                {{ strtoupper(substr($customer->first_name_en ?? $customer->first_name, 0, 1) . substr($customer->last_name_en ?? $customer->last_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Status Indicator -->
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full border-4 border-white dark:border-slate-800 shadow-lg {{ $customer->is_active ? 'bg-emerald-500' : 'bg-red-500' }}">
                                        <div class="w-full h-full rounded-full {{ $customer->is_active ? 'bg-emerald-400' : 'bg-red-400' }} animate-pulse"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end pt-6 gap-4">
                                <button class="group px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/20 dark:border-slate-600/50 text-slate-700 dark:text-slate-200 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 ml-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                    </svg>
                                    اشتراک‌گذاری
                                </button>

                                <a href="{{ route('customers.edit', $customer) }}"
                                   class="group px-6 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white rounded-2xl font-semibold shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center">
                                    <svg class="w-5 h-5 ml-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="relative z-10">ویرایش پروفایل</span>
                                </a>
                            </div>

                            <!-- User Info -->
                            <div class="mt-8 mr-48">
                                <div class="flex items-center gap-4 mb-4">
                                    <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-700 dark:from-white dark:via-slate-100 dark:to-slate-300 bg-clip-text text-transparent">
                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                    </h1>

                                    <!-- Status Badge -->
                                    @if($customer->is_active)
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700/50 shadow-lg">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full ml-2 animate-pulse"></div>
                                        فعال
                                    </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-700/50 shadow-lg">
                                        <div class="w-2 h-2 bg-red-500 rounded-full ml-2"></div>
                                        غیرفعال
                                    </span>
                                    @endif
                                </div>

                                @if($customer->first_name_en && $customer->last_name_en)
                                    <p class="text-xl text-slate-600 dark:text-slate-300 mb-3 font-medium">{{ $customer->first_name_en }} {{ $customer->last_name_en }}</p>
                                @endif

                                <div class="flex items-center gap-6 text-slate-600 dark:text-slate-300">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-medium">{{ $customer->email }}</span>
                                    </div>

                                    @if($customer->email_verified_at)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700/50">
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        تایید شده
                                    </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-700/50">
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        تایید نشده
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Personal Information -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Information Card -->
                    <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)">
                        <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 p-8 group-hover:scale-[1.02]">
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center ml-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    اطلاعات شخصی
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">نام</label>
                                        <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $customer->first_name }}</p>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">نام خانوادگی</label>
                                        <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $customer->last_name }}</p>
                                    </div>

                                    @if($customer->first_name_en)
                                        <div class="space-y-2">
                                            <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">نام (انگلیسی)</label>
                                            <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $customer->first_name_en }}</p>
                                        </div>
                                    @endif

                                    @if($customer->last_name_en)
                                        <div class="space-y-2">
                                            <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">نام خانوادگی (انگلیسی)</label>
                                            <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $customer->last_name_en }}</p>
                                        </div>
                                    @endif

                                    @if($customer->father_name)
                                        <div class="space-y-2">
                                            <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">نام پدر</label>
                                            <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $customer->father_name }}</p>
                                        </div>
                                    @endif

                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">جنسیت</label>
                                        <p class="text-lg font-semibold text-slate-900 dark:text-white capitalize">{{ $customer->gender_label }}</p>
                                    </div>

                                    @if($customer->birthday)
                                        <div class="space-y-2">
                                            <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">تاریخ تولد</label>
                                            <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ App\Helpers\DateHelper::toJalali($customer->birthday) }}</p>
                                            <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($customer->birthday)->format('M d, Y') }}</p>
                                        </div>
                                    @endif

                                    @if($customer->national_code)
                                        <div class="space-y-2">
                                            <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">کد ملی</label>
                                            <p class="text-lg font-mono font-semibold text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-700 px-3 py-2 rounded-lg inline-block">{{ $customer->national_code }}</p>
                                        </div>
                                    @endif

                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">نقش</label>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                                        @switch($customer->role_type)
                                            @case('admin')
                                                bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-700/50
                                                @break
                                            @case('manager')
                                                bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700/50
                                                @break
                                            @case('customer')
                                                bg-slate-100 dark:bg-slate-700/50 text-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-600/50
                                                @break
                                            @default
                                                bg-slate-100 dark:bg-slate-700/50 text-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-600/50
                                        @endswitch
                                    ">
                                        {{ $customer->role_type_label }}
                                    </span>
                                    </div>

                                    @if($customer->city)
                                        <div class="space-y-2">
                                            <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">شهر</label>
                                            <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $customer->city->province->country->country_persian_name .'-'.$customer->city->province->name.'-'. $customer->city->name }}</p>
                                        </div>
                                    @endif

                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">منطقه</label>
                                        <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $customer->regin ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)">
                        <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 p-8 group-hover:scale-[1.02]">
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center ml-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    اطلاعات تماس
                                </h3>

                                <div class="space-y-6">
                                    <!-- Email -->
                                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 rounded-2xl p-6 border border-slate-200/50 dark:border-slate-600/50">
                                        <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3 block">آدرس ایمیل</label>
                                        <div class="flex items-center gap-4">
                                            <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $customer->email }}</p>
                                            @if($customer->email_verified_at)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700/50">
                                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                تایید شده
                                            </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-700/50">
                                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                                تایید نشده
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Phone Numbers -->
                                    @if($customer->phones && $customer->phones->count() > 0)
                                        @foreach($customer->phones as $phone)
                                            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 rounded-2xl p-6 border border-slate-200/50 dark:border-slate-600/50">
                                                <div class="flex items-center justify-between mb-3">
                                                    <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                                        شماره {{ $phone->title ?? 'تلفن' }}
                                                    </label>
                                                    @if($phone->is_default)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700/50">
                                                    پیش‌فرض
                                                </span>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-4">
                                                    <p class="text-lg font-mono font-semibold text-slate-900 dark:text-white">{{ $phone->number }}</p>
                                                    <a href="tel:{{ $phone->number }}"
                                                       class="group p-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-all duration-300 transform hover:scale-110">
                                                        <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 rounded-2xl p-6 border border-slate-200/50 dark:border-slate-600/50">
                                            <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3 block">شماره تلفن</label>
                                            <p class="text-slate-400 dark:text-slate-500 italic">شماره تلفنی ارائه نشده است</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 700)">
                        <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 p-8 group-hover:scale-[1.02]">
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center ml-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    اطلاعات آدرس
                                </h3>

                                @if($customer->addresses && $customer->addresses->count() > 0)
                                    <div class="space-y-6">
                                        @foreach($customer->addresses as $address)
                                            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 rounded-2xl p-6 border border-slate-200/50 dark:border-slate-600/50 relative overflow-hidden">
                                                <!-- Decorative element -->
                                                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full blur-xl"></div>

                                                <div class="relative z-10">
                                                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                                                        <div class="w-3 h-3 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full ml-2"></div>
                                                        {{ $address->title ?? 'آدرس' }}
                                                    </h4>

                                                    @if($address->content)
                                                        <div class="space-y-2">
                                                            <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">آدرس</label>
                                                            <div class="text-slate-900 dark:text-white whitespace-pre-line leading-relaxed">{{ $address->content }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-600/50 rounded-2xl p-6 border border-slate-200/50 dark:border-slate-600/50">
                                        <p class="text-slate-400 dark:text-slate-500 italic text-center">آدرسی ارائه نشده است</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Account Status -->
                    <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 400)">
                        <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 p-8 group-hover:scale-[1.02]">
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">وضعیت حساب</h3>

                                <div class="space-y-6">
                                    <!-- Status -->
                                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl">
                                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">وضعیت</span>
                                        @if($customer->is_active)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300">
                                            فعال
                                        </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                            غیرفعال
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Email Verification -->
                                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl">
                                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">تایید ایمیل</span>
                                        @if($customer->email_verified_at)
                                            <span class="text-emerald-600 dark:text-emerald-400 text-sm font-semibold">بله</span>
                                        @else
                                            <span class="text-red-600 dark:text-red-400 text-sm font-semibold">خیر</span>
                                        @endif
                                    </div>

                                    <!-- Join Date -->
                                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl">
                                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">عضویت از</span>
                                        <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $customer->created_at->format('M Y') }}</span>
                                    </div>

                                    <!-- Leave Date -->
                                    @if($customer->leave_date)
                                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl">
                                            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">تاریخ خروج</span>
                                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($customer->leave_date)->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 600)">
                        <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 p-8 group-hover:scale-[1.02]">
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">اقدامات سریع</h3>

                                <div class="space-y-4">
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="w-full group flex items-center justify-center px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                        <svg class="w-5 h-5 ml-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        ویرایش مشتری
                                    </a>

                                    @if(!$customer->email_verified_at)
                                        <button class="w-full group flex items-center justify-center px-6 py-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                            <svg class="w-5 h-5 ml-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            ارسال تایید
                                        </button>
                                    @endif

                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="w-full" id="delete-form-{{ $customer->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                @click="confirmDelete({{ $customer->id }})"
                                                class="w-full group flex items-center justify-center px-6 py-4 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 border-2 border-red-200 dark:border-red-700/50 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                            <svg class="w-5 h-5 ml-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            {{ __('message.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="group" x-data="{ show: false }" x-init="setTimeout(() => show = true, 800)">
                        <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-2xl hover:shadow-3xl transition-all duration-500 p-8 group-hover:scale-[1.02]">
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">جدول زمانی</h3>

                                <div class="space-y-6">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full shadow-lg animate-pulse"></div>
                                            <div class="w-0.5 h-8 bg-blue-200 dark:bg-blue-800 mx-auto mt-2"></div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-slate-900 dark:text-white">حساب ایجاد شد</p>
                                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $customer->created_at->format('M d, Y - H:i') }}</p>
                                        </div>
                                    </div>

                                    @if($customer->email_verified_at)
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="w-3 h-3 bg-emerald-500 rounded-full shadow-lg"></div>
                                                <div class="w-0.5 h-8 bg-emerald-200 dark:bg-emerald-800 mx-auto mt-2"></div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-slate-900 dark:text-white">ایمیل تایید شد</p>
                                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($customer->email_verified_at)->format('M d, Y - H:i') }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-3 h-3 bg-slate-400 rounded-full shadow-lg"></div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-slate-900 dark:text-white">آخرین بروزرسانی</p>
                                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $customer->updated_at->format('M d, Y - H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.delete')