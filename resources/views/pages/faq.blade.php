@extends('layouts.app')

@section('title', 'سوالات متداول')

@section('content')
    <div class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-12">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-6">
                        <i class="fas fa-question"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">سوالات متداول</h1>
                    <p class="text-lg text-gray-600">پاسخ سوالات رایج شما در اینجا</p>
                </div>

                <!-- Search Box -->
                <div class="bg-white rounded-lg shadow-md p-4 mb-8">
                    <div class="relative">
                        <input type="text" id="faq-search" placeholder="جستجو در سوالات..."
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- FAQ Categories -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <button onclick="filterFAQ('all')"
                            class="faq-filter active bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition">
                        <i class="fas fa-list text-2xl text-blue-600 mb-2"></i>
                        <div class="font-bold text-sm">همه</div>
                    </button>
                    <button onclick="filterFAQ('order')"
                            class="faq-filter bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition">
                        <i class="fas fa-shopping-bag text-2xl text-green-600 mb-2"></i>
                        <div class="font-bold text-sm">سفارش</div>
                    </button>
                    <button onclick="filterFAQ('payment')"
                            class="faq-filter bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition">
                        <i class="fas fa-credit-card text-2xl text-purple-600 mb-2"></i>
                        <div class="font-bold text-sm">پرداخت</div>
                    </button>
                    <button onclick="filterFAQ('shipping')"
                            class="faq-filter bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition">
                        <i class="fas fa-truck text-2xl text-orange-600 mb-2"></i>
                        <div class="font-bold text-sm">ارسال</div>
                    </button>
                </div>

                <!-- FAQ Items -->
                <div class="space-y-4">
                    <!-- Order Questions -->
                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="order">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>چگونه می‌توانم سفارش خود را ثبت کنم؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p class="mb-4">برای ثبت سفارش، مراحل زیر را دنبال کنید:</p>
                            <ol class="list-decimal pr-6 space-y-2">
                                <li>محصول مورد نظر خود را انتخاب کنید</li>
                                <li>روی دکمه "افزودن به سبد خرید" کلیک کنید</li>
                                <li>به سبد خرید بروید و محصولات را بررسی کنید</li>
                                <li>روی "تکمیل خرید" کلیک کنید</li>
                                <li>اطلاعات تحویل گیرنده را وارد کنید</li>
                                <li>روش پرداخت را انتخاب کنید</li>
                                <li>سفارش خود را نهایی کنید</li>
                            </ol>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="order">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>چگونه سفارش خود را پیگیری کنم؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p>برای پیگیری سفارش خود، به بخش "پنل کاربری" وارد شده و در قسمت "سفارشات من" می‌توانید وضعیت سفارش خود را مشاهده کنید. همچنین می‌توانید با شماره سفارش خود تماس بگیرید یا از طریق ایمیل یا پیامک ارسالی، وضعیت سفارش را پیگیری کنید.</p>
                        </div>
                    </div>

                    <!-- Payment Questions -->
                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="payment">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>روش‌های پرداخت چیست؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p class="mb-3">روش‌های پرداخت در فروشگاه ما:</p>
                            <ul class="list-disc pr-6 space-y-2">
                                <li><strong>پرداخت آنلاین:</strong> از طریق درگاه امن زرین‌پال با تمام کارت‌های عضو شتاب</li>
                                <li><strong>پرداخت در محل:</strong> هنگام تحویل کالا (فقط برای شهر تهران)</li>
                                <li><strong>کارت به کارت:</strong> پس از هماهنگی با واحد فروش</li>
                            </ul>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="payment">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>آیا پرداخت آنلاین امن است؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p>بله، کاملاً امن است. ما از درگاه پرداخت معتبر زرین‌پال استفاده می‌کنیم که دارای گواهینامه‌های امنیتی بین‌المللی است. تمام اطلاعات کارت بانکی شما با پروتکل SSL رمزنگاری می‌شود و در هیچ بخشی از فرآیند، اطلاعات کارت شما ذخیره نمی‌شود.</p>
                        </div>
                    </div>

                    <!-- Shipping Questions -->
                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="shipping">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>زمان ارسال کالا چقدر است؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p class="mb-3">زمان ارسال بستگی به نوع ارسال انتخابی شما دارد:</p>
                            <ul class="list-disc pr-6 space-y-2">
                                <li><strong>ارسال عادی:</strong> 3 تا 5 روز کاری (رایگان برای خریدهای بالای 500 هزار تومان)</li>
                                <li><strong>ارسال فوری:</strong> 1 تا 2 روز کاری (با هزینه اضافی)</li>
                                <li><strong>ارسال ویژه تهران:</strong> حداکثر 24 ساعت (با هزینه اضافی)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="shipping">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>آیا ارسال رایگان دارید؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p>بله، برای سفارش‌های بالای 500,000 تومان، ارسال به صورت رایگان انجام می‌شود. برای سفارش‌های زیر این مبلغ، هزینه ارسال بر اساس وزن و مقصد محاسبه می‌شود.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="order">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>آیا می‌توانم سفارش خود را لغو کنم؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p>بله، تا زمانی که سفارش شما به مرحله ارسال نرسیده است، می‌توانید آن را لغو کنید. برای لغو سفارش، به پنل کاربری خود رفته و در بخش "سفارشات من"، گزینه "لغو سفارش" را انتخاب کنید. در صورت پرداخت آنلاین، مبلغ ظرف 72 ساعت به حساب شما بازگردانده می‌شود.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="order">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>شرایط بازگشت کالا چیست؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p class="mb-3">شما می‌توانید تا 7 روز پس از دریافت کالا، درخواست بازگشت کالا را داشته باشید. شرایط بازگشت:</p>
                            <ul class="list-disc pr-6 space-y-2">
                                <li>کالا باید در شرایط اولیه و با بسته‌بندی سالم باشد</li>
                                <li>برچسب و پلمپ کالا نباید پاره یا آسیب دیده باشد</li>
                                <li>کالا نباید استفاده شده باشد</li>
                                <li>فاکتور خرید همراه کالا باشد</li>
                            </ul>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-md overflow-hidden" data-category="payment">
                        <button class="faq-question w-full px-6 py-4 text-right font-bold text-lg flex items-center justify-between hover:bg-gray-50 transition">
                            <span>آیا امکان خرید اقساطی وجود دارد؟</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 text-gray-700 leading-relaxed">
                            <p>بله، برای خریدهای بالای 1 میلیون تومان، امکان پرداخت اقساطی وجود دارد. شما می‌توانید از کارت‌های اعتباری بانک‌های همکار استفاده کنید یا برای اطلاعات بیشتر با واحد فروش تماس بگیرید.</p>
                        </div>
                    </div>
                </div>

                <!-- Still have questions -->
                <div class="mt-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-xl p-8 text-center text-white">
                    <i class="fas fa-headset text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold mb-4">هنوز سوالی دارید؟</h3>
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
        // FAQ Toggle
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const item = question.closest('.faq-item');
                const answer = item.querySelector('.faq-answer');
                const icon = question.querySelector('i');

                answer.classList.toggle('hidden');
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            });
        });

        // FAQ Filter
        function filterFAQ(category) {
            const items = document.querySelectorAll('.faq-item');
            const filters = document.querySelectorAll('.faq-filter');

            filters.forEach(f => f.classList.remove('active'));
            event.target.closest('.faq-filter').classList.add('active');

            items.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // FAQ Search
        document.getElementById('faq-search').addEventListener('input', (e) => {
            const search = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.faq-item');

            items.forEach(item => {
                const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();

                if (question.includes(search) || answer.includes(search)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>

    <style>
        .faq-filter.active {
            border: 2px solid #3B82F6;
            background: linear-gradient(to br, #EFF6FF, #DBEAFE);
        }
    </style>
@endsection
