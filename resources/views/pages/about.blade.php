@extends('layouts.app')

@section('title', 'درباره ما')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 to-purple-600 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">درباره فروشگاه ما</h1>
            <p class="text-xl max-w-3xl mx-auto leading-relaxed">
                ما با افتخار بیش از 10 سال است که در خدمت مشتریان عزیز هستیم و بهترین محصولات را با قیمت مناسب ارائه می‌دهیم
            </p>
        </div>
    </div>

    <!-- Stats -->
    <div class="container mx-auto px-4 -mt-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">10+</div>
                <div class="text-gray-700">سال تجربه</div>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                <div class="text-4xl font-bold text-green-600 mb-2">50K+</div>
                <div class="text-gray-700">مشتری راضی</div>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                <div class="text-4xl font-bold text-purple-600 mb-2">5000+</div>
                <div class="text-gray-700">محصول متنوع</div>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                <div class="text-4xl font-bold text-orange-600 mb-2">24/7</div>
                <div class="text-gray-700">پشتیبانی</div>
            </div>
        </div>
    </div>

    <!-- Story Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">داستان ما</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto"></div>
            </div>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-6">
                <p>
                    فروشگاه ما در سال 2014 با هدف ارائه محصولات باکیفیت و خدمات عالی به مشتریان آغاز به کار کرد. از همان ابتدا، تمرکز ما بر رضایت مشتریان و ایجاد تجربه خرید لذت‌بخش بوده است.
                </p>
                <p>
                    در طول این سال‌ها، ما توانسته‌ایم با جلب اعتماد بیش از 50,000 مشتری، به یکی از فروشگاه‌های معتبر آنلاین در ایران تبدیل شویم. تنوع محصولات، قیمت‌های مناسب، و خدمات پس از فروش ما، ویژگی‌هایی هستند که ما را از رقبا متمایز می‌کند.
                </p>
                <p>
                    تیم ما متشکل از متخصصان مجرب و متعهد است که همواره در تلاش هستند تا بهترین تجربه خرید را برای شما فراهم کنند. ما معتقدیم که موفقیت ما در موفقیت مشتریانمان نهفته است.
                </p>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">ارزش‌های ما</h2>
                <p class="text-lg text-gray-600">اصولی که ما بر اساس آنها فعالیت می‌کنیم</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-3xl mx-auto mb-4">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">رضایت مشتری</h3>
                    <p class="text-gray-600 leading-relaxed">
                        رضایت و اعتماد شما مهم‌ترین اولویت ماست. ما همواره در تلاش هستیم تا بهترین خدمات را ارائه دهیم
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-3xl mx-auto mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">کیفیت محصولات</h3>
                    <p class="text-gray-600 leading-relaxed">
                        تمام محصولات ما اصل و اورجینال هستند و از کیفیت بالایی برخوردارند. ما به کیفیت محصولاتمان افتخار می‌کنیم
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-3xl mx-auto mb-4">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">صداقت و شفافیت</h3>
                    <p class="text-gray-600 leading-relaxed">
                        ما در تمام مراحل خرید با شما صادق و شفاف هستیم. از قیمت‌گذاری تا تحویل، همه چیز شفاف است
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">تیم ما</h2>
            <p class="text-lg text-gray-600">افراد پشت پرده موفقیت ما</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                    م.ا
                </div>
                <h3 class="text-xl font-bold mb-2">محمد احمدی</h3>
                <p class="text-gray-600 mb-3">مدیر عامل</p>
                <div class="flex justify-center gap-3">
                    <a href="#" class="text-blue-600 hover:text-blue-700"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-purple-600 hover:text-purple-700"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-green-500 to-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                    س.ر
                </div>
                <h3 class="text-xl font-bold mb-2">سارا رضایی</h3>
                <p class="text-gray-600 mb-3">مدیر بازاریابی</p>
                <div class="flex justify-center gap-3">
                    <a href="#" class="text-blue-600 hover:text-blue-700"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-purple-600 hover:text-purple-700"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-orange-500 to-red-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                    ع.م
                </div>
                <h3 class="text-xl font-bold mb-2">علی محمدی</h3>
                <p class="text-gray-600 mb-3">مدیر فنی</p>
                <div class="flex justify-center gap-3">
                    <a href="#" class="text-blue-600 hover:text-blue-700"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-purple-600 hover:text-purple-700"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-pink-500 to-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                    ن.ک
                </div>
                <h3 class="text-xl font-bold mb-2">نرگس کریمی</h3>
                <p class="text-gray-600 mb-3">مدیر پشتیبانی</p>
                <div class="flex justify-center gap-3">
                    <a href="#" class="text-blue-600 hover:text-blue-700"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-purple-600 hover:text-purple-700"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 py-16">
        <div class="container mx-auto px-4 text-center text-white">
            <h2 class="text-4xl font-bold mb-6">آماده خرید هستید؟</h2>
            <p class="text-xl mb-8">بیش از 5000 محصول متنوع در انتظار شماست</p>
            <a href="{{ route('products.index') }}"
               class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:scale-105 transform transition shadow-lg">
                <i class="fas fa-shopping-bag ml-2"></i>
                شروع خرید
            </a>
        </div>
    </div>
@endsection
