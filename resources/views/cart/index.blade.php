@extends('layouts.app')

@section('title', 'سبد خرید')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8">سبد خرید</h1>

            @if(session('cart') && count(session('cart')) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach(session('cart') as $id => $item)
                            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                     class="w-full md:w-32 h-32 object-cover rounded-lg">

                                <div class="flex-1">
                                    <a href="{{ route('products.show', $item['slug']) }}"
                                       class="text-lg font-bold text-gray-900 hover:text-blue-600 transition mb-2 block">
                                        {{ $item['name'] }}
                                    </a>

                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-4">
                                        <div class="flex items-center gap-3">
                                            <label class="text-sm text-gray-600">تعداد:</label>
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button onclick="updateQuantity({{ $id }}, -1)"
                                                        class="px-3 py-2 hover:bg-gray-100 transition">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" value="{{ $item['quantity'] }}"
                                                       id="quantity-{{ $id }}"
                                                       class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none"
                                                       readonly>
                                                <button onclick="updateQuantity({{ $id }}, 1)"
                                                        class="px-3 py-2 hover:bg-gray-100 transition">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <div class="text-left">
                                                @if(isset($item['sale_price']))
                                                    <div class="text-sm text-gray-400 line-through">
                                                        {{ number_format($item['price']) }} تومان
                                                    </div>
                                                    <div class="text-lg font-bold text-blue-600">
                                                        {{ number_format($item['sale_price'] * $item['quantity']) }} تومان
                                                    </div>
                                                @else
                                                    <div class="text-lg font-bold text-blue-600">
                                                        {{ number_format($item['price'] * $item['quantity']) }} تومان
                                                    </div>
                                                @endif
                                            </div>

                                            <button onclick="removeFromCart({{ $id }})"
                                                    class="text-red-500 hover:text-red-700 transition">
                                                <i class="fas fa-trash text-xl"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h2 class="text-xl font-bold mb-6">خلاصه سفارش</h2>

                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-700">
                                    <span>جمع کل محصولات:</span>
                                    <span class="font-bold">{{ number_format($subtotal) }} تومان</span>
                                </div>

                                @if($discount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>تخفیف:</span>
                                        <span class="font-bold">{{ number_format($discount) }} تومان</span>
                                    </div>
                                @endif

                                <div class="flex justify-between text-gray-700">
                                    <span>هزینه ارسال:</span>
                                    <span class="font-bold">
                                @if($subtotal >= 500000)
                                            <span class="text-green-600">رایگان</span>
                                        @else
                                            {{ number_format($shipping) }} تومان
                                        @endif
                            </span>
                                </div>

                                @if($subtotal < 500000)
                                    <div class="text-sm text-blue-600 bg-blue-50 p-3 rounded-lg">
                                        <i class="fas fa-info-circle ml-1"></i>
                                        با خرید {{ number_format(500000 - $subtotal) }} تومان دیگر، ارسال رایگان است!
                                    </div>
                                @endif

                                <div class="border-t pt-4 flex justify-between text-lg font-bold">
                                    <span>مبلغ قابل پرداخت:</span>
                                    <span class="text-blue-600 text-2xl">{{ number_format($total) }} تومان</span>
                                </div>
                            </div>

                            <!-- Discount Code -->
                            <form action="{{ route('cart.applyDiscount') }}" method="POST" class="mb-6">
                                @csrf
                                <label class="block font-bold mb-2 text-sm">کد تخفیف</label>
                                <div class="flex gap-2">
                                    <input type="text" name="code" placeholder="کد تخفیف خود را وارد کنید"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                                    <button type="submit"
                                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-300 transition">
                                        اعمال
                                    </button>
                                </div>
                            </form>

                            @auth
                                <a href="{{ route('checkout.index') }}"
                                   class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center px-6 py-4 rounded-lg font-bold hover:scale-105 transform transition shadow-lg mb-3">
                                    <i class="fas fa-lock ml-2"></i>
                                    ادامه فرآیند خرید
                                </a>
                            @else
                                <a href="{{ route('login', ['redirect' => route('checkout.index')]) }}"
                                   class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center px-6 py-4 rounded-lg font-bold hover:scale-105 transform transition shadow-lg mb-3">
                                    <i class="fas fa-sign-in-alt ml-2"></i>
                                    ورود و ادامه خرید
                                </a>
                            @endauth

                            <a href="{{ route('products.index') }}"
                               class="block w-full text-center border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-bold hover:bg-gray-50 transition">
                                <i class="fas fa-shopping-bag ml-2"></i>
                                بازگشت به فروشگاه
                            </a>

                            <!-- Trust Badges -->
                            <div class="mt-6 pt-6 border-t space-y-3">
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <i class="fas fa-shield-alt text-green-600"></i>
                                    <span>پرداخت امن</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <i class="fas fa-truck text-blue-600"></i>
                                    <span>ارسال سریع</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <i class="fas fa-undo text-purple-600"></i>
                                    <span>7 روز ضمانت بازگشت</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-6"></i>
                    <h2 class="text-2xl font-bold text-gray-700 mb-4">سبد خرید شما خالی است</h2>
                    <p class="text-gray-600 mb-8">برای افزودن محصول به سبد خرید، به صفحه محصولات بروید</p>
                    <a href="{{ route('products.index') }}"
                       class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                        <i class="fas fa-shopping-bag ml-2"></i>
                        مشاهده محصولات
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function updateQuantity(productId, change) {
            const input = document.getElementById(`quantity-${productId}`);
            let quantity = parseInt(input.value) + change;

            if (quantity < 1) return;

            fetch(`/cart/update/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: quantity })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        function removeFromCart(productId) {
            if (!confirm('آیا از حذف این محصول مطمئن هستید؟')) return;

            fetch(`/cart/remove/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }
    </script>
@endsection
