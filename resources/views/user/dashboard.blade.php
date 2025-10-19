@extends('layouts.app')

@section('title', 'پنل کاربری')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar -->
                <aside class="lg:w-64">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <div class="text-center mb-6 pb-6 border-b">
                            @if(auth()->user()->avatar)
                                <img src="{{auth()->user()->avatar->address}}" alt="{{ auth()->user()->full_name }}" class="w-24 h-24 bg-gradient-to-br object-contain rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3 shadow-md">
                            @else
                                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3">
                                    {{ substr(auth()->user()->full_name, 0, 1) }}
                                </div>
                            @endif
                            <h3 class="font-bold text-lg">{{ auth()->user()->full_name }}</h3>
                            <p class="text-sm text-gray-600">{{ auth()->user()->mobile }}</p>
                        </div>

                        <nav class="space-y-1">
                            <a href="{{ route('user.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                                <i class="fas fa-th-large w-5"></i>
                                <span>داشبورد</span>
                            </a>
                            @if(auth()->user()->roles)
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                    <i class="fas fa-dashboard w-5"></i>
                                    <span>پنل مدیریت</span>
                                </a>
                            @endif
                            <a href="{{ route('user.orders') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.orders*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                                <i class="fas fa-shopping-bag w-5"></i>
                                <span>سفارش‌ها</span>
                            </a>
                            <a href="{{ route('user.favorites') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.favorites') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                                <i class="fas fa-heart w-5"></i>
                                <span>علاقه‌مندی‌ها</span>
                            </a>
                            <a href="{{ route('user.profile') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.profile') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                                <i class="fas fa-user w-5"></i>
                                <span>اطلاعات کاربری</span>
                            </a>
                            <a href="{{ route('user.addresses') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.addresses*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                                <i class="fas fa-map-marker-alt w-5"></i>
                                <span>آدرس‌ها</span>
                            </a>
                            <a href="{{ route('user.comments') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.comments') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                                <i class="fas fa-comment w-5"></i>
                                <span>نظرات من</span>
                            </a>
                            <form action="{{route('user.logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>خروج</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 mb-2">کل سفارشات</p>
                                    <h3 class="text-3xl font-bold">{{ $totalOrders }}</h3>
                                </div>
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-shopping-bag text-3xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 mb-2">سفارشات تحویل شده</p>
                                    <h3 class="text-3xl font-bold">{{ $deliveredOrders }}</h3>
                                </div>
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-3xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 mb-2">علاقه‌مندی‌ها</p>
                                    <h3 class="text-3xl font-bold">{{ $favoritesCount }}</h3>
                                </div>
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-heart text-3xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-lg shadow-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-orange-100 mb-2">کل خریدها</p>
                                    <h3 class="text-2xl font-bold">{{ number_format($totalSpent) }}</h3>
                                    <p class="text-orange-100 text-sm">تومان</p>
                                </div>
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-coins text-3xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-6 border-b flex items-center justify-between">
                            <h2 class="text-xl font-bold">آخرین سفارشات</h2>
                            <a href="{{ route('user.orders') }}" class="text-blue-600 hover:text-blue-700 text-sm font-bold">
                                مشاهده همه
                                <i class="fas fa-arrow-left mr-1"></i>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700">شماره سفارش</th>
                                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700">تاریخ</th>
                                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700">مبلغ</th>
                                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700">وضعیت</th>
                                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700">عملیات</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @forelse($recentOrders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-bold text-blue-600">
                                            #{{ $order->order_number }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $order->created_at->format('Y/m/d') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                            {{ number_format($order->total) }} تومان
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
                                                    'pending' => 'در انتظار پرداخت',
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
                                            <a href="{{ route('user.orders.show', $order) }}"
                                               class="text-blue-600 hover:text-blue-700 text-sm font-bold">
                                                جزئیات
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-600">
                                            <i class="fas fa-shopping-bag text-4xl mb-3 text-gray-300"></i>
                                            <p>هنوز سفارشی ثبت نکرده‌اید</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Favorite Products -->
                    @if($favoriteProducts->count() > 0)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 border-b flex items-center justify-between">
                                <h2 class="text-xl font-bold">علاقه‌مندی‌های من</h2>
                                <a href="{{ route('user.favorites') }}" class="text-blue-600 hover:text-blue-700 text-sm font-bold">
                                    مشاهده همه
                                    <i class="fas fa-arrow-left mr-1"></i>
                                </a>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    @foreach($favoriteProducts->take(4) as $product)
                                        <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                            <a href="{{ route('product.show', $product->slug) }}">
                                                <img src="{{ asset($product->photo->address ?? 'images/placeholder.jpg') }}"
                                                     alt="{{ $product->name }}"
                                                     class="w-full aspect-square object-cover">
                                            </a>
                                            <div class="p-3">
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                   class="font-bold text-sm hover:text-blue-600 transition line-clamp-2 mb-2">
                                                    {{ $product->name }}
                                                </a>
                                                <div class="text-blue-600 font-bold">
                                                    {{ number_format( $product->price) }} تومان
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
