@extends('layouts.app')

@section('title', 'جزئیات سفارش')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-2xl font-bold mb-2">سفارش #{{ $order->order_number }}</h1>
                            <p class="text-gray-600">ثبت شده در {{ $order->created_at->format('Y/m/d H:i') }}</p>
                        </div>
                        <div class="flex gap-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'shipped' => 'bg-purple-100 text-purple-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'در انتظار پرداخت',
                                    'processing' => 'در حال پردازش',
                                    'shipped' => 'ارسال شده',
                                    'delivered' => 'تحویل داده شده',
                                    'cancelled' => 'لغو شده',
                                ];
                            @endphp
                            <span class="px-4 py-2 rounded-lg font-bold {{ $statusColors[$order->status] }}">
                            {{ $statusLabels[$order->status] }}
                        </span>
                            @if($order->payment_status == 'paid')
                                <span class="px-4 py-2 rounded-lg font-bold bg-green-100 text-green-800">
                            <i class="fas fa-check-circle ml-1"></i>
                            پرداخت شده
                        </span>
                            @endif
                        </div>
                    </div>

                    <!-- Order Progress -->
                    <div class="relative">
                        <div class="flex justify-between items-center">
                            @php
                                $steps = [
                                    'pending' => 'ثبت سفارش',
                                    'processing' => 'در حال پردازش',
                                    'shipped' => 'ارسال شده',
                                    'delivered' => 'تحویل داده شده'
                                ];
                                $currentStepIndex = array_search($order->status, array_keys($steps));
                            @endphp
                            @foreach($steps as $key => $label)
                                @php
                                    $stepIndex = array_search($key, array_keys($steps));
                                    $isCompleted = $stepIndex <= $currentStepIndex;
                                @endphp
                                <div class="flex flex-col items-center flex-1">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold mb-2 {{ $isCompleted ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                        @if($isCompleted)
                                            <i class="fas fa-check"></i>
                                        @else
                                            {{ $stepIndex + 1 }}
                                        @endif
                                    </div>
                                    <span class="text-xs text-center {{ $isCompleted ? 'text-blue-600 font-bold' : 'text-gray-600' }}">
                                {{ $label }}
                            </span>
                                </div>
                                @if(!$loop->last)
                                    <div class="flex-1 h-1 {{ $stepIndex < $currentStepIndex ? 'bg-blue-600' : 'bg-gray-200' }} -mx-2"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Order Items -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold mb-4">محصولات سفارش</h2>
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="flex gap-4 pb-4 border-b last:border-b-0">
                                        <img src="{{ asset($item->product->primaryImage->image ?? 'images/placeholder.jpg') }}"
                                             alt="{{ $item->product_name }}"
                                             class="w-20 h-20 object-cover rounded-lg">
                                        <div class="flex-1">
                                            <a href="{{ route('products.show', $item->product->slug) }}"
                                               class="font-bold hover:text-blue-600 transition">
                                                {{ $item->product_name }}
                                            </a>
                                            <div class="text-sm text-gray-600 mt-1">تعداد: {{ $item->quantity }}</div>
                                            <div class="text-sm text-gray-600">قیمت واحد: {{ number_format($item->price) }} تومان</div>
                                        </div>
                                        <div class="text-left">
                                            <div class="font-bold text-lg text-blue-600">
                                                {{ number_format($item->total) }} تومان
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                                آدرس تحویل
                            </h2>
                            <div class="space-y-2 text-gray-700">
                                <p><strong>نام:</strong> {{ $order->shipping_address['full_name'] }}</p>
                                <p><strong>تلفن:</strong> {{ $order->shipping_address['phone'] }}</p>
                                <p><strong>آدرس:</strong>
                                    {{ $order->shipping_address['province'] }}،
                                    {{ $order->shipping_address['city'] }}،
                                    {{ $order->shipping_address['address'] }}
                                </p>
                                <p><strong>کد پستی:</strong> {{ $order->shipping_address['postal_code'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h2 class="text-xl font-bold mb-4">خلاصه سفارش</h2>

                            <div class="space-y-3 mb-6 pb-6 border-b">
                                <div class="flex justify-between">
                                    <span class="text-gray-700">جمع محصولات:</span>
                                    <span class="font-bold">{{ number_format($order->subtotal) }} تومان</span>
                                </div>
                                @if($order->discount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>تخفیف:</span>
                                        <span class="font-bold">{{ number_format($order->discount) }} تومان</span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-700">هزینه ارسال:</span>
                                    <span class="font-bold">
                                    @if($order->shipping == 0)
                                            <span class="text-green-600">رایگان</span>
                                        @else
                                            {{ number_format($order->shipping) }} تومان
                                        @endif
                                </span>
                                </div>
                            </div>

                            <div class="flex justify-between text-lg font-bold mb-6">
                                <span>مبلغ کل:</span>
                                <span class="text-blue-600">{{ number_format($order->total) }} تومان</span>
                            </div>

                            @if($order->payment_status == 'paid')
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-center gap-2 text-green-800 mb-2">
                                        <i class="fas fa-check-circle"></i>
                                        <span class="font-bold">پرداخت موفق</span>
                                    </div>
                                    @if($order->transaction_id)
                                        <p class="text-sm text-gray-700">کد پیگیری: {{ $order->transaction_id }}</p>
                                    @endif
                                </div>
                            @elseif($order->payment_status == 'unpaid')
                                <a href="{{ route('checkout.process') }}"
                                   class="block w-full bg-green-600 text-white text-center px-6 py-3 rounded-lg font-bold hover:bg-green-700 transition mb-4">
                                    پرداخت سفارش
                                </a>
                            @endif

                            <a href="{{ route('user.orders') }}"
                               class="block w-full text-center border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-bold hover:bg-gray-50 transition">
                                بازگشت به لیست سفارشات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
