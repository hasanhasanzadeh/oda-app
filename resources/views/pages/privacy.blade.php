@extends('layouts.app')

@section('title', 'حریم خصوصی و قوانین')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Tabs -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="flex border-b">
                        <button class="policy-tab flex-1 px-6 py-4 font-bold text-center border-b-2 border-blue-600 text-blue-600"
                                data-tab="privacy">
                            <i class="fas fa-shield-alt ml-2"></i>
                            حریم خصوصی
                        </button>
                        <button class="policy-tab flex-1 px-6 py-4 font-bold text-center text-gray-600 hover:text-blue-600 transition"
                                data-tab="terms">
                            <i class="fas fa-file-contract ml-2"></i>
                            قوانین و مقررات
                        </button>
                        <button class="policy-tab flex-1 px-6 py-4 font-bold text-center text-gray-600 hover:text-blue-600 transition"
                                data-tab="return">
                            <i class="fas fa-undo ml-2"></i>
                            رویه بازگشت کالا
                        </button>
                    </div>
                </div>

                <!-- Privacy Tab -->
                <div id="privacy-tab" class="policy-content bg-white rounded-lg shadow-md p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">سیاست حریم خصوصی</h1>
                    <p class="text-sm text-gray-600 mb-8">آخرین بروزرسانی: دی 1403</p>

                    <div class="prose prose-lg max-w-none space-y-8">
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. مقدمه</h2>
                            <p class="text-gray-700 leading-relaxed">
                                فروشگاه ما متعهد به حفظ حریم خصوصی و امنیت اطلاعات شخصی کاربران است. این سند نحوه جمع‌آوری، استفاده و محافظت از اطلاعات شما را توضیح می‌دهد.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. اطلاعات جمع‌آوری شده</h2>
                            <p class="text-gray-700 leading-relaxed mb-3">ما انواع زیر از اطلاعات را جمع‌آوری می‌کنیم:</p>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li><strong>اطلاعات شخصی:</strong> نام، ایمیل، شماره تماس، آدرس</li>
                                <li><strong>اطلاعات پرداخت:</strong> اطلاعات کارت بانکی (از طریق درگاه امن)</li>
                                <li><strong>اطلاعات فنی:</strong> IP، مرورگر، سیستم عامل</li>
                                <li><strong>تاریخچه خرید:</strong> سفارشات، علاقه‌مندی‌ها، نظرات</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. نحوه استفاده از اطلاعات</h2>
                            <p class="text-gray-700 leading-relaxed mb-3">ما از اطلاعات شما برای موارد زیر استفاده می‌کنیم:</p>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>پردازش و ارسال سفارشات</li>
                                <li>ارائه خدمات پشتیبانی</li>
                                <li>بهبود تجربه کاربری</li>
                                <li>ارسال اطلاعات محصولات جدید و پیشنهادات ویژه</li>
                                <li>تحلیل و بهینه‌سازی عملکرد سایت</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. امنیت اطلاعات</h2>
                            <p class="text-gray-700 leading-relaxed">
                                ما از تکنولوژی‌های پیشرفته برای محافظت از اطلاعات شما استفاده می‌کنیم، از جمله رمزنگاری SSL، سرورهای امن، و سیستم‌های ضد هک. هیچگاه اطلاعات کارت بانکی شما در سرورهای ما ذخیره نمی‌شود.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. اشتراک‌گذاری اطلاعات</h2>
                            <p class="text-gray-700 leading-relaxed">
                                ما هرگز اطلاعات شخصی شما را بدون اجازه شما به شخص ثالث نمی‌فروشیم یا اجاره نمی‌دهیم. تنها در موارد زیر ممکن است اطلاعات شما با دیگران به اشتراک گذاشته شود:
                            </p>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700 mt-3">
                                <li>شرکت‌های حمل و نقل برای ارسال سفارش</li>
                                <li>درگاه‌های پرداخت برای پردازش تراکنش‌ها</li>
                                <li>در صورت الزام قانونی</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. کوکی‌ها</h2>
                            <p class="text-gray-700 leading-relaxed">
                                ما از کوکی‌ها برای بهبود تجربه کاربری و تحلیل رفتار کاربران استفاده می‌کنیم. شما می‌توانید کوکی‌ها را در مرورگر خود غیرفعال کنید، اما ممکن است برخی از ویژگی‌های سایت کار نکنند.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">7. حقوق کاربران</h2>
                            <p class="text-gray-700 leading-relaxed mb-3">شما حق دارید:</p>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>به اطلاعات شخصی خود دسترسی داشته باشید</li>
                                <li>اطلاعات نادرست را تصحیح کنید</li>
                                <li>درخواست حذف اطلاعات کنید</li>
                                <li>از دریافت ایمیل‌های تبلیغاتی انصراف دهید</li>
                            </ul>
                        </section>
                    </div>
                </div>

                <!-- Terms Tab -->
                <div id="terms-tab" class="policy-content hidden bg-white rounded-lg shadow-md p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">قوانین و مقررات</h1>
                    <p class="text-sm text-gray-600 mb-8">آخرین بروزرسانی: دی 1403</p>

                    <div class="prose prose-lg max-w-none space-y-8">
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. پذیرش قوانین</h2>
                            <p class="text-gray-700 leading-relaxed">
                                با استفاده از این وب‌سایت، شما قوانین و مقررات را می‌پذیرید. اگر با این قوانین موافق نیستید، لطفاً از سایت استفاده نکنید.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. ثبت نام و حساب کاربری</h2>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>اطلاعات ثبت نامی باید دقیق و معتبر باشد</li>
                                <li>مسئولیت حفظ امنیت رمز عبور با کاربر است</li>
                                <li>استفاده از حساب کاربری دیگران ممنوع است</li>
                                <li>هر فرد فقط یک حساب کاربری می‌تواند داشته باشد</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. قیمت‌ها و پرداخت</h2>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>تمام قیمت‌ها به تومان و شامل مالیات است</li>
                                <li>قیمت‌ها ممکن است بدون اطلاع قبلی تغییر کنند</li>
                                <li>پرداخت از طریق درگاه‌های معتبر انجام می‌شود</li>
                                <li>در صورت ناموجود بودن، مبلغ بازگردانده می‌شود</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. ارسال و تحویل</h2>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>زمان ارسال تخمینی است و تضمین نمی‌شود</li>
                                <li>کالا باید توسط خود خریدار یا فرد مورد اعتماد تحویل گرفته شود</li>
                                <li>بررسی کالا هنگام تحویل الزامی است</li>
                                <li>در صورت عدم تحویل، مسئولیت با خریدار است</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. گارانتی و ضمانت</h2>
                            <p class="text-gray-700 leading-relaxed">
                                تمام محصولات دارای گارانتی معتبر هستند. شرایط گارانتی برای هر محصول متفاوت است و در صفحه محصول قید شده است. گارانتی شامل عیوب ساخت می‌شود و خسارات ناشی از سوء استفاده را شامل نمی‌شود.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. مالکیت معنوی</h2>
                            <p class="text-gray-700 leading-relaxed">
                                تمام محتوا، لوگو، طراحی و کدهای این سایت متعلق به فروشگاه ماست و هرگونه کپی‌برداری یا استفاده غیرمجاز پیگرد قانونی دارد.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">7. محدودیت مسئولیت</h2>
                            <p class="text-gray-700 leading-relaxed">
                                ما تا حد امکان دقت اطلاعات را حفظ می‌کنیم، اما مسئولیت خسارات ناشی از اطلاعات نادرست، قطع سرویس، یا مشکلات فنی را نمی‌پذیریم.
                            </p>
                        </section>
                    </div>
                </div>

                <!-- Return Policy Tab -->
                <div id="return-tab" class="policy-content hidden bg-white rounded-lg shadow-md p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">رویه بازگشت و تعویض کالا</h1>

                    <div class="prose prose-lg max-w-none space-y-8">
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. شرایط کلی بازگشت کالا</h2>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>مهلت بازگشت: 7 روز کاری از تاریخ تحویل</li>
                                <li>کالا باید در شرایط اولیه و با بسته‌بندی سالم باشد</li>
                                <li>برچسب و پلمپ اصلی کالا نباید پاره شده باشد</li>
                                <li>کالا نباید استفاده شده باشد</li>
                                <li>فاکتور خرید باید همراه کالا باشد</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. کالاهای غیرقابل بازگشت</h2>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>کالاهای بهداشتی و قابل مصرف</li>
                                <li>نرم‌افزارهای باز شده</li>
                                <li>کالاهای سفارشی و شخصی‌سازی شده</li>
                                <li>کالاهای در حراج یا تخفیف ویژه</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. فرآیند بازگشت کالا</h2>
                            <div class="space-y-4">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">مرحله 1: ثبت درخواست</h4>
                                    <p class="text-gray-700">در پنل کاربری، بخش سفارشات، درخواست بازگشت کالا را ثبت کنید</p>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">مرحله 2: بررسی درخواست</h4>
                                    <p class="text-gray-700">تیم ما درخواست شما را ظرف 24 ساعت بررسی می‌کند</p>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">مرحله 3: ارسال کالا</h4>
                                    <p class="text-gray-700">پس از تایید، کالا را به آدرس اعلام شده ارسال کنید</p>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">مرحله 4: بازگشت وجه</h4>
                                    <p class="text-gray-700">پس از دریافت و بررسی کالا، مبلغ ظرف 3-5 روز کاری بازگردانده می‌شود</p>
                                </div>
                            </div>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. هزینه بازگشت</h2>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>در صورت مغایرت یا معیوب بودن: هزینه ارسال با فروشگاه</li>
                                <li>در صورت انصراف خریدار: هزینه ارسال با خریدار</li>
                                <li>تعویض کالا: رایگان</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. تعویض کالا</h2>
                            <p class="text-gray-700 leading-relaxed mb-3">
                                اگر کالای دریافتی معیوب است یا با سفارش شما مطابقت ندارد، می‌توانید آن را تعویض کنید:
                            </p>
                            <ul class="list-disc pr-6 space-y-2 text-gray-700">
                                <li>تعویض فقط یک بار امکان‌پذیر است</li>
                                <li>کالای جدید باید موجود باشد</li>
                                <li>در صورت تفاوت قیمت، باید تسویه شود</li>
                                <li>زمان تعویض: 5-7 روز کاری</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. گارانتی کالاهای معیوب</h2>
                            <p class="text-gray-700 leading-relaxed">
                                اگر کالا در دوره گارانتی دچار مشکل شد، به مرکز گارانتی مربوطه مراجعه کنید. اطلاعات تماس در کارت گارانتی موجود است. ما نیز در این فرآیند همراه شما خواهیم بود.
                            </p>
                        </section>
                    </div>
                </div>

                <!-- Contact CTA -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-xl p-8 text-center text-white mt-8">
                    <i class="fas fa-headset text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold mb-4">سوالی دارید؟</h3>
                    <p class="mb-6">تیم پشتیبانی ما آماده پاسخگویی به شماست</p>
                    <a href="{{ route('contact') }}"
                       class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                        تماس با ما
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.policy-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const tabName = tab.dataset.tab;

                document.querySelectorAll('.policy-tab').forEach(t => {
                    t.classList.remove('border-blue-600', 'text-blue-600');
                    t.classList.add('text-gray-600');
                });
                tab.classList.add('border-blue-600', 'text-blue-600');
                tab.classList.remove('text-gray-600');

                document.querySelectorAll('.policy-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(tabName + '-tab').classList.remove('hidden');
            });
        });
    </script>
@endsection
