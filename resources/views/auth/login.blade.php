@extends('layouts.master')


@section('content')
    <div class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 left-panel relative overflow-hidden">
            <div class="absolute inset-0 geometric-pattern"></div>
            <div class="absolute top-20 left-20 w-32 h-32 bg-white bg-opacity-10 rounded-full floating" style="animation-delay: 0s;"></div>
            <div class="absolute bottom-32 right-16 w-24 h-24 bg-white bg-opacity-15 rounded-full floating" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-10 w-16 h-16 bg-white bg-opacity-20 rounded-full floating" style="animation-delay: 2s;"></div>

            <div class="relative z-10 flex flex-col justify-center items-center text-center px-12 text-white">
                <div class="mb-8 pulse-gold">
                    <img src="{{$setting->logo->address??asset('images/logo/logo.svg')}}" alt="{{$setting->title}}" class="h-24 bg-white bg-opacity-20 rounded-3xl flex items-center justify-center backdrop-blur-sm" />
                </div>

                <h1 class="text-5xl font-bold mb-6 leading-tight text-gray-700">
                    خوش آمدید به<br>
                    <span class="text-6xl">ورو به پنل کاربری</span>
                </h1>

                <p class="text-xl  text-gray-700 text-opacity-90 mb-8 leading-relaxed max-w-md">
                    پلتفرم پیشرفته ای که تجربه کاربری بی نظیری را برای شما فراهم می کند
                </p>

                <div class="space-y-4 w-full max-w-sm">
                    <div class="flex items-center text-right">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center ml-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700 text-opacity-90">امنیت بالا و رمزگذاری پیشرفته</span>
                    </div>
                    <div class="flex items-center text-right">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center ml-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700 text-opacity-90">رابط کاربری مدرن و کاربرپسند</span>
                    </div>
                    <div class="flex items-center text-right">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center ml-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700 text-opacity-90">پشتیبانی 24 ساعته</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <div class="text-center mb-8 lg:hidden">
                    <div class="inline-flex items-center justify-center w-16 h-16 golden-border rounded-2xl mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold gradient-text mb-2">خوش آمدید</h1>
                    <p class="text-gray-600">لطفا وارد حساب کاربری خود شوید</p>
                </div>

                <div class="bg-white golden-border rounded-3xl p-8 golden-shadow">
                    <div class="flex mb-8 p-1 bg-gray-100 rounded-2xl">
                        <a href="{{route('login')}}" class="flex-1 py-3 px-4 text-sm font-medium rounded-xl transition-all duration-300 bg-yellow-500 text-white shadow-md">
                            ورود
                        </a>
                    </div>
                    <form method="POST" action="{{route('login')}}" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="mobile">موبایل</label>
                            <div class="relative">
                                <input type="text" name="mobile" value="{{old('mobile')}}" id="mobile" class="w-full px-10 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none input-focus transition-all duration-300" placeholder="09121111111">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fa-solid fa-mobile fa-xl text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="loginPassword">کلمه عبور</label>
                            <div class="relative">
                                <input type="password" name="password" value="{{old('password')}}" id="loginPassword" class="w-full px-12 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none input-focus transition-all duration-300" placeholder="رمز عبور خود را وارد کنید">
                                <button type="button" id="toggleLoginPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="w-7 h-7 text-gray-400 text-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" class="w-4 h-4 text-yellow-600 bg-white border-2 border-gray-300 rounded focus:ring-yellow-500 focus:ring-2">
                                <span class="mr-2 text-gray-600 text-sm">مرا به خاطر بسپار</span>
                            </label>
                            <a href="#" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium transition-colors duration-300">فراموشی رمز عبور؟</a>
                        </div>

                        <button type="submit" id="loginBtn" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 golden-shadow">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                ورود به حساب کاربری
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
