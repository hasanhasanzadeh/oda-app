@extends('layouts.app')

@section('title', 'علاقه‌مندی‌ها')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-6">
                @include('user.partials.sidebar')

                <div class="flex-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold">علاقه‌مندی‌های من</h2>
                                    <p class="text-gray-600 mt-1">{{ $products->total() }} محصول</p>
                                </div>
                            </div>
                        </div>

                        @if($products->count() > 0)
                            <div class="p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($products as $product)
                                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                            <div class="relative">
                                                <a href="{{ route('products.show', $product->slug) }}">
                                                    <img src="{{ asset($product->primaryImage->image ?? 'images/placeholder.jpg') }}"
                                                         alt="{{ $product->name }}"
                                                         class="w-full aspect-square object-cover">
                                                </a>

                                                @if($product->sale_price)
                                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                        {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% تخفیف
                                                    </div>
                                                @endif

                                                <form action="{{ route('user.favorites.toggle', $product) }}" method="POST" class="absolute top-2 left-2">
                                                    @csrf
                                                    <button type="submit"
                                                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-500 hover:bg-red-50 transition shadow-lg">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>

                                                @if($product->stock == 0)
                                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                                        <span class="bg-gray-900 text-white px-4 py-2 rounded-lg font-bold">ناموجود</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="p-4">
                                                <a href="{{ route('products.show', $product->slug) }}"
                                                   class="font-bold text-gray-900 hover:text-blue-600 transition line-clamp-2 mb-3 block">
                                                    {{ $product->name }}
                                                </a>

                                                <div class="flex items-center gap-2 mb-3">
                                                    <div class="flex text-yellow-400 text-sm">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $product->averageRating ? '' : 'text-gray-300' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="text-xs text-gray-600">({{ $product->comments->count() }})</span>
                                                </div>

                                                <div class="flex items-center justify-between mb-3">
                                                    <div>
                                                        @if($product->sale_price)
                                                            <div class="text-gray-400 line-through text-sm">
                                                                {{ number_format($product->price) }} تومان
                                                            </div>
                                                            <div class="text-blue-600 font-bold text-lg">
                                                                {{ number_format($product->sale_price) }} تومان
                                                            </div>
                                                        @else
                                                            <div class="text-blue-600 font-bold text-lg">
                                                                {{ number_format($product->price) }} تومان
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($product->stock > 0)
                                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit"
                                                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                                                            <i class="fas fa-shopping-cart ml-2"></i>
                                                            افزودن به سبد خرید
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled
                                                            class="w-full bg-gray-300 text-gray-600 py-3 rounded-lg font-bold cursor-not-allowed">
                                                        ناموجود
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if($products->hasPages())
                                    <div class="mt-8">
                                        {{ $products->links() }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <i class="fas fa-heart-broken text-gray-300 text-6xl mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-700 mb-2">هنوز محصولی به علاقه‌مندی‌ها اضافه نکرده‌اید</h3>
                                <p class="text-gray-600 mb-6">محصولات مورد علاقه خود را با کلیک روی آیکون قلب ذخیره کنید</p>
                                <a href="{{ route('products.index') }}"
                                   class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                                    مشاهده محصولات
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
