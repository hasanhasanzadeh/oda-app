@extends('layouts.app')

@section('title', 'تماس با ما')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-purple-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">تماس با ما</h1>
                    <p class="text-lg text-gray-600">ما همیشه برای پاسخگویی به شما آماده هستیم</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Contact Info Cards -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl mb-4">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-2">تلفن تماس</h3>
                            <p class="text-gray-600 mb-2">شنبه تا پنجشنبه، 9 صبح تا 6 عصر</p>
                            <a href="tel:02188888888" class="text-blue-600 font-bold text-lg hover:text-blue-700">
                                021-88888888
                            </a>
                        </div>

                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-2xl mb-4">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-2">ایمیل</h3>
                            <p class="text-gray-600 mb-2">پاسخگویی تا 24 ساعت</p>
                            <a href="mailto:info@shop.com" class="text-blue-600 font-bold hover:text-blue-700">
                                info@shop.com
                            </a>
                        </div>

                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-2xl mb-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-2">آدرس</h3>
                            <p class="text-gray-600 leading-relaxed">
                                تهران، خیابان ولیعصر، نرسیده به میدان ونک، پلاک 123، طبقه 4
                            </p>
                        </div>

                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                            <h3 class="font-bold text-lg mb-4">شبکه‌های اجتماعی</h3>
                            <div class="flex gap-3">
                                <a href="#" class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-lg flex items-center justify-center hover:scale-110 transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="w-12 h-12 bg-blue-500 text-white rounded-lg flex items-center justify-center hover:scale-110 transition">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a href="#" class="w-12 h-12 bg-green-500 text-white rounded-lg flex items-center justify-center hover:scale-110 transition">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" class="w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:scale-110 transition">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-lg p-8">
                            <h2 class="text-2xl font-bold mb-6">فرم تماس</h2>

                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                                    <i class="fas fa-check-circle ml-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block font-bold mb-2">نام و نام خانوادگی *</label>
                                        <input type="text" name="full_name" value="{{old('full_name')}}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition"
                                               placeholder="نام خود را وارد کنید">
                                    </div>
                                    <div>
                                        <label class="block font-bold mb-2">شماره تماس *</label>
                                        <input type="tel" name="mobile" value="{{old('mobile')}}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition"
                                               placeholder="09123456789">
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">ایمیل *</label>
                                    <input type="email" name="email" value="{{old('email')}}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition"
                                           placeholder="example@email.com">
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">موضوع *</label>
                                    <select name="subject" required
                                            class="w-full px-8 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                                        <option value="">انتخاب کنید</option>
                                        <option value="پشتیبانی فنی">پشتیبانی فنی</option>
                                        <option value="پیگیری سفارش">پیگیری سفارش</option>
                                        <option value="بازگشت کالا">بازگشت کالا</option>
                                        <option value="شکایات">شکایات</option>
                                        <option value="پیشنهادات">پیشنهادات</option>
                                        <option value="سایر">سایر</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">پیام شما *</label>
                                    <textarea name="message" rows="6" required
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition resize-none"
                                              placeholder="پیام خود را بنویسید..."></textarea>
                                </div>

                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                                    <i class="fas fa-paper-plane ml-2"></i>
                                    ارسال پیام
                                </button>
                            </form>
                        </div>

                        <!-- Map -->
                        <div class="bg-white rounded-lg shadow-lg p-4 mt-6">
                            <div class="w-full h-80 bg-gray-200 rounded-lg flex items-center justify-center">
                                <div class="text-center text-gray-600">
                                    <i class="fas fa-map-marked-alt text-4xl mb-2"></i>
                                    <p>نقشه موقعیت</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
