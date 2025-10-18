@extends('layouts.app')

@section('title', 'سفارشات من')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar - Same as dashboard -->
                @include('user.partials.sidebar')

                <!-- Orders List -->
                <div class="flex-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b">
                            <h2 class="text-2xl font-bold">سفارشات من</h2>
                        </div>

                        @if($orders->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">شماره سفارش</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">تاریخ</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">تعداد کالا</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">مبلغ</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">وضعیت</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">پرداخت</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-blue-600">#{{ $order->order_number }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                {{ $order->created_at->format('Y/m/d H:i') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                {{ $order->items->sum('quantity') }} کالا
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-gray-900">{{ number_format($order->total) }} تومان</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'processing' => 'bg-blue-100 text-blue-800',
                                                        'shipped' => 'bg-purple-100 text-purple-800',
                                                        'delivered' => 'bg-green-100 text-green-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'در انتظار',
                                                        'processing' => 'در حال پردازش',
                                                        'shipped' => 'ارسال شده',
                                                        'delivered' => 'تحویل داده شده',
                                                        'cancelled' => 'لغو شده',
                                                    ];
                                                @endphp
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$order->status] }}">
                                            {{ $statusLabels[$order->status] }}
                                        </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $paymentColors = [
                                                        'unpaid' => 'bg-red-100 text-red-800',
                                                        'paid' => 'bg-green-100 text-green-800',
                                                        'failed' => 'bg-gray-100 text-gray-800',
                                                        'refunded' => 'bg-purple-100 text-purple-800',
                                                    ];
                                                    $paymentLabels = [
                                                        'unpaid' => 'پرداخت نشده',
                                                        'paid' => 'پرداخت شده',
                                                        'failed' => 'ناموفق',
                                                        'refunded' => 'بازگشت داده شده',
                                                    ];
                                                @endphp
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $paymentColors[$order->payment_status] }}">
                                            {{ $paymentLabels[$order->payment_status] }}
                                        </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('user.orders.show', $order) }}"
                                                   class="text-blue-600 hover:text-blue-700 font-bold">
                                                    جزئیات
                                                    <i class="fas fa-arrow-left mr-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($orders->hasPages())
                                <div class="p-6 border-t">
                                    {{ $orders->links() }}
                                </div>
                            @endif
                        @else
                            <div class="p-12 text-center">
                                <i class="fas fa-shopping-bag text-gray-300 text-6xl mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-700 mb-2">هنوز سفارشی ندارید</h3>
                                <p class="text-gray-600 mb-6">اولین خرید خود را انجام دهید</p>
                                <a href="{{ route('products.index') }}"
                                   class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                                    شروع خرید
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
