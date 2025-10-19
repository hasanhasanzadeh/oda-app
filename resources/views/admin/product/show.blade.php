@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-6 w-full">

        <div class="text-center mb-4 mt-3">
            <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-3 animate-pulse">
                جزئیات محصول
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">مشاهده اطلاعات کامل و دقیق محصول</p>
        </div>
        <div class="flex justify-end">
            <a href="{{route('products.index')}}" class=" items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                @lang('message.products')
            </a>
        </div>
        <div class="gradient-border mb-2">
            <div class="gradient-border-content p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- Product Image Section -->
                    <div class="space-y-4">
                        <div class="relative group overflow-hidden rounded-2xl shadow-2xl">
                            <img src="{{ $product->photo->address?? asset('images/default-image.png') }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-96 object-cover transform group-hover:scale-110 transition-transform duration-500">

                            <!-- Image Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-4 right-4 left-4">
                                    <p class="text-white text-sm font-medium">کلیک برای بزرگنمایی</p>
                                </div>
                            </div>

                            <!-- Status Badge on Image -->
                            @if($product->status === 'active')
                                <div class="absolute top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-full font-bold shadow-lg badge-pulse">
                                    موجود
                                </div>
                            @elseif($product->status === 'inactive')
                                <div class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-full font-bold shadow-lg">
                                    ناموجود
                                </div>
                            @else
                                <div class="absolute top-4 right-4 bg-yellow-500 text-white px-4 py-2 rounded-full font-bold shadow-lg">
                                    به زودی
                                </div>
                            @endif
                        </div>

                        @if(isset($product->gallery))
                            <div class="grid grid-cols-3">
                                @foreach($product->gallery as $photo)
                                <div class="w-20 h-20 flex justify-between rounded-md overflow-hidden border-2 border-blue-500 cursor-pointer hover:scale-105 transition-transform">
                                        <img src="{{ $photo->address?? asset('images/default-image.png') }}" alt="thumb" class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <!-- Product Info Section -->
                    <div class="space-y-6">

                        <!-- Title -->
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $product->name }}
                            </h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                شناسه: <span class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $product->sku }}</span>
                            </p>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $product->name_en }}
                            </h2>
                        </div>
                        <!-- Category Badge -->
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            <span class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                دسته‌بندی:
                            </span>
                            <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-4 py-1 rounded-full font-medium">
                                {{ $product->category->name ?? 'نامشخص' }}
                            </span>
                        </div>

                        <!-- Description -->
                        @if($product->description)
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    توضیحات محصول
                                </h3>
                                <div class="text-gray-700 dark:text-gray-100 leading-relaxed text-justify">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        @endif

                        <!-- Price Section -->
                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl p-6 border-2 border-blue-200 dark:border-blue-800">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Sale Price -->
                                <div class="text-center">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">قیمت اصلی</p>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 flex items-center justify-center gap-2">
                                        {{ number_format($product->original_price) }}
                                        <span class="text-sm">تومان</span>
                                    </p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">تخفیف</p>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 flex items-center justify-center gap-2">
                                        {{ $product->discount }}
                                        <span class="text-sm">درصد</span>
                                    </p>
                                </div>
                                <!-- Buy Price -->
                                <div class="text-center">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">قیمت خرید</p>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 flex items-center justify-center gap-2">
                                        {{ number_format($product->buy_price) }}
                                        <span class="text-sm">تومان</span>
                                    </p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">قیمت فروش</p>
                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 flex items-center justify-center gap-2">
                                        {{ number_format($product->price) }}
                                        <span class="text-lg">تومان</span>
                                    </p>
                                </div>

                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-xl p-5 border-2 border-orange-200 dark:border-orange-800">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="bg-orange-500 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">موجودی انبار</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                            {{ number_format($product->quantity) }} عدد
                                        </p>
                                    </div>
                                </div>

                                <!-- Stock Status Indicator -->
                                @if($product->quantity > 50)
                                    <div class="text-green-500 font-bold">موجودی کافی</div>
                                @elseif($product->quantity > 0)
                                    <div class="text-yellow-500 font-bold">موجودی کم</div>
                                @else
                                    <div class="text-red-500 font-bold">ناموجود</div>
                                @endif
                            </div>
                        </div>


                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                ویرایش
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block"
                                  id="delete-form-{{ $product->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl"
                                        onclick="confirmDelete({{$product->id}})">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    {{ __('message.delete') }}
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Card 1: Created Date -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-full">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">تاریخ ایجاد</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $product->created_at ? $product->created_at->format('Y/m/d') : 'نامشخص' }}
                            <br>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="text-sm text-gray-900 dark:text-white">{{verta($product->created_at)->format('d F Y')}}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{verta($product->created_at)->format('h:i A')}}</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-full">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">آخرین بروزرسانی</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $product->updated_at ? $product->updated_at->format('Y/m/d') : 'نامشخص' }}
                            <br>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="text-sm text-gray-900 dark:text-white">{{verta($product->updated_at)->format('d F Y')}}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{verta($product->updated_at)->format('h:i A')}}</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>


            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-pink-100 dark:bg-pink-900 p-4 rounded-full">
                        <svg class="w-8 h-8 text-pink-600 dark:text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <div class="block p-1 m-1">
                            <h5 class="text-sm text-gray-500 dark:text-gray-400">شناسه محصول</h5>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white" dir="ltr">#{{$product->id}}</h4>
                        </div>
                        <div class="block p-1 m-1">
                            <h5 class="text-sm text-gray-500 dark:text-gray-400">کد محصول</h5>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white" dir="ltr">#{{$product->sku}}</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

@include('admin.partials.delete')
