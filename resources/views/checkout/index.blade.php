@extends('layouts.app')

@section('title', 'تکمیل خرید')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex items-center justify-center">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full font-bold">1</div>
                            <span class="mr-2 text-blue-600 font-bold">سبد خرید</span>
                        </div>
                        <div class="w-16 h-1 bg-blue-600 mx-2"></div>
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full font-bold">2</div>
                            <span class="mr-2 text-blue-600 font-bold">اطلاعات ارسال</span>
                        </div>
                        <div class="w-16 h-1 bg-gray-300 mx-2"></div>
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">3</div>
                            <span class="mr-2 text-gray-600">پرداخت</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Shipping Information -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Personal Info -->
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                                    <i class="fas fa-user text-blue-600"></i>
                                    اطلاعات شخصی
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-bold mb-2 text-sm">نام و نام خانوادگی *</label>
                                        <input type="text" name="full_name" value="{{ auth()->user()->name }}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block font-bold mb-2 text-sm">شماره تماس *</label>
                                        <input type="tel" name="phone" value="{{ auth()->user()->phone }}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                                               placeholder="09123456789">
                                    </div>
                                    <div>
                                        <label class="block font-bold mb-2 text-sm">ایمیل</label>
                                        <input type="email" name="email" value="{{ auth()->user()->email }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block font-bold mb-2 text-sm">کد ملی</label>
                                        <input type="text" name="national_code" value="{{ auth()->user()->national_code }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                                               placeholder="0123456789">
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    آدرس تحویل گیرنده
                                </h2>

                                @if(auth()->user()->addresses && auth()->user()->addresses->count() > 0)
                                    <div class="mb-6">
                                        <label class="block font-bold mb-3 text-sm">انتخاب از آدرس‌های ذخیره شده</label>
                                        <div class="space-y-3">
                                            @foreach(auth()->user()->addresses as $address)
                                                <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                                    <input type="radio" name="saved_address" value="{{ $address->id }}"
                                                           class="mt-1 w-5 h-5 text-blue-600">
                                                    <div class="flex-1">
                                                        <div class="font-bold mb-1">{{ $address->title }}</div>
                                                        <div class="text-sm text-gray-600">
                                                            {{ $address->province }} - {{ $address->city }} - {{ $address->address }}
                                                        </div>
                                                        <div class="text-sm text-gray-600">کد پستی: {{ $address->postal_code }}</div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="mt-4">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="saved_address" value="new" checked
                                                       class="w-5 h-5 text-blue-600">
                                                <span class="font-bold">آدرس جدید</span>
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-bold mb-2 text-sm">استان *</label>
                                        <select name="province" required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                                            <option value="">انتخاب استان</option>
                                            <option value="تهران">تهران</option>
                                            <option value="اصفهان">اصفهان</option>
                                            <option value="خراسان رضوی">خراسان رضوی</option>
                                            <option value="فارس">فارس</option>
                                            <!-- Add more provinces -->
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-bold mb-2 text-sm">شهر *</label>
                                        <input type="text" name="city" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block font-bold mb-2 text-sm">آدرس کامل *</label>
                                        <textarea name="address" rows="3" required
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                                                  placeholder="آدرس دقیق محل تحویل را وارد کنید..."></textarea>
                                    </div>
                                    <div>
                                        <label class="block font-bold mb-2 text-sm">کد پستی *</label>
                                        <input type="text" name="postal_code" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                                               placeholder="1234567890">
                                    </div>
                                    <div>
                                        <label class="block font-bold mb-2 text-sm">پلاک</label>
                                        <input type="text" name="plate"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" name="save_address" value="1"
                                               class="w-5 h-5 text-blue-600 rounded">
                                        <span class="text-sm">ذخیره این آدرس برای خریدهای بعدی</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Delivery Time -->
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                                    <i class="fas fa-clock text-blue-600"></i>
                                    زمان تحویل
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                        <input type="radio" name="delivery_time" value="normal" checked
                                               class="mt-1 w-5 h-5 text-blue-600">
                                        <div>
                                            <div class="font-bold mb-1">ارسال عادی</div>
                                            <div class="text-sm text-gray-600">3 تا 5 روز کاری</div>
                                            <div class="text-sm font-bold text-green-600 mt-2">رایگان</div>
                                        </div>
                                    </label>
                                    <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                        <input type="radio" name="delivery_time" value="express"
                                               class="mt-1 w-5 h-5 text-blue-600">
                                        <div>
                                            <div class="font-bold mb-1">ارسال فوری</div>
                                            <div class="text-sm text-gray-600">1 تا 2 روز کاری</div>
                                            <div class="text-sm font-bold text-blue-600 mt-2">50,000 تومان</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Order Notes -->
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                                    <i class="fas fa-comment text-blue-600"></i>
                                    توضیحات سفارش
                                </h2>
                                <textarea name="notes" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                                          placeholder="نکات خاصی درباره سفارش خود بنویسید (اختیاری)"></textarea>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                                <h2 class="text-xl font-bold mb-6">خلاصه سفارش</h2>

                                <!-- Cart Items -->
                                <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                                    @foreach(session('cart') as $item)
                                        <div class="flex gap-3 pb-4 border-b">
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                                 class="w-16 h-16 object-cover rounded-lg">
                                            <div class="flex-1">
                                                <h4 class="text-sm font-bold line-clamp-2 mb-1">{{ $item['name'] }}</h4>
                                                <div class="text-xs text-gray-600">تعداد: {{ $item['quantity'] }}</div>
                                                <div class="text-sm font-bold text-blue-600">
                                                    {{ number_format(($item['price']) * $item['quantity']) }} تومان
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pricing -->
                                <div class="space-y-3 mb-6 pb-6 border-b">
                                    <div class="flex justify-between text-sm">
                                        <span>جمع محصولات:</span>
                                        <span class="font-bold">{{ number_format($subtotal) }} تومان</span>
                                    </div>
                                    @if($discount > 0)
                                        <div class="flex justify-between text-sm text-green-600">
                                            <span>تخفیف:</span>
                                            <span class="font-bold">{{ number_format($discount) }} تومان</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between text-sm">
                                        <span>هزینه ارسال:</span>
                                        <span class="font-bold">
                                        @if($subtotal >= 500000)
                                                <span class="text-green-600">رایگان</span>
                                            @else
                                                {{ number_format($shipping) }} تومان
                                            @endif
                                    </span>
                                    </div>
                                </div>

                                <div class="flex justify-between text-lg font-bold mb-6">
                                    <span>مبلغ قابل پرداخت:</span>
                                    <span class="text-blue-600 text-2xl">{{ number_format($total) }} تومان</span>
                                </div>

                                <!-- Payment Method -->
                                <div class="mb-6">
                                    <h3 class="font-bold mb-3 text-sm">روش پرداخت</h3>
                                    <label class="flex items-center gap-3 p-4 border-2 border-blue-500 bg-blue-50 rounded-lg">
                                        <input type="radio" name="payment_method" value="zarinpal" checked
                                               class="w-5 h-5 text-blue-600">
                                        <div class="flex-1">
                                            <div class="font-bold">پرداخت اینترنتی</div>
                                            <div class="text-xs text-gray-600">پرداخت از طریق درگاه زرین‌پال</div>
                                        </div>
                                        <img src="/images/zarinpal.png" alt="ZarinPal" class="h-8">
                                    </label>
                                </div>

                                <!-- Terms -->
                                <div class="mb-6">
                                    <label class="flex items-start gap-2 text-sm">
                                        <input type="checkbox" name="terms" required
                                               class="mt-1 w-5 h-5 text-blue-600 rounded">
                                        <span class="text-gray-700">
                                        <a href="{{ route('rules') }}" target="_blank" class="text-blue-600 hover:underline">قوانین و مقررات</a>
                                        را مطالعه کرده و می‌پذیرم
                                    </span>
                                    </label>
                                </div>

                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                                    <i class="fas fa-credit-card ml-2"></i>
                                    پرداخت و ثبت نهایی سفارش
                                </button>

                                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-600">
                                    <i class="fas fa-lock"></i>
                                    <span>پرداخت امن با رمزنگاری SSL</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
