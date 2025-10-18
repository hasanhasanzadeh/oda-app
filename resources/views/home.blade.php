@extends('layouts.app')

@section('title', 'خانه - فروشگاه آنلاین')

@section('content')
    <!-- Hero Slider -->
    <div class="relative overflow-hidden bg-gray-900">
        <div id="slider" class="relative h-[400px] md:h-[500px] lg:h-[600px]">
            @foreach($sliders as $index => $slider)
                <div class="slider-item absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                     style="background-image: url('{{ asset($slider->photo->address) }}'); background-size: cover; background-position: center;">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent">
                        <div class="container mx-auto px-4 h-full flex items-center">
                            <div class="max-w-2xl text-white">
                                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 animate-fade-in">
                                    {{ $slider->title }}
                                </h2>
                                <p class="text-lg md:text-xl mb-8 animate-fade-in-delay">
                                    {{ $slider->description }}
                                </p>
                                @if($slider->link)
                                    <a href="{{ $slider->link }}"
                                       class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-full font-bold hover:scale-105 transform transition shadow-lg">
                                        مشاهده بیشتر
                                        <i class="fas fa-arrow-left mr-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Slider Controls -->
            <button id="prev-slide" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition z-10">
                <i class="fas fa-chevron-right"></i>
            </button>
            <button id="next-slide" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition z-10">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Slider Dots -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                @foreach($sliders as $index => $slider)
                    <button class="slider-dot w-3 h-3 rounded-full transition {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}"
                            data-index="{{ $index }}"></button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center gap-4 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg">ارسال سریع</h3>
                    <p class="text-sm text-gray-600">ارسال به سراسر کشور</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center gap-4 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-2xl">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg">ضمانت اصالت</h3>
                    <p class="text-sm text-gray-600">کالای اصل و معتبر</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center gap-4 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-2xl">
                    <i class="fas fa-headset"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg">پشتیبانی 24/7</h3>
                    <p class="text-sm text-gray-600">پاسخگویی سریع</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center gap-4 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center text-red-600 text-2xl">
                    <i class="fas fa-undo"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg">7 روز ضمانت</h3>
                    <p class="text-sm text-gray-600">بازگشت کالا</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Carousel -->
    <div class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">محصولات ویژه</h2>
                <p class="text-gray-600 mt-2">جدیدترین و پرفروش‌ترین محصولات</p>
            </div>
            <a href="{{ route('product.index', ['featured' => 1]) }}"
               class="text-blue-600 hover:text-blue-700 font-bold flex items-center gap-2">
                مشاهده همه
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <div class="relative">
            <div id="featured-carousel" class="overflow-hidden">
                <div class="flex transition-transform duration-500 gap-4" id="carousel-track">
                    @foreach($featuredProducts as $product)
                        <div class="flex-shrink-0 w-full sm:w-1/2 lg:w-1/4 px-2">
                            <div class="bg-white rounded-lg shadow-md overflow-hidden group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                                <div class="relative overflow-hidden aspect-square">
                                    <img src="{{ asset($product->photo->address ?? 'images/placeholder.jpg') }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @if($product->discount > 0)
                                        <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                            {{ $product->discount }}% تخفیف
                                        </div>
                                    @endif
                                    @auth
                                        <button onclick="toggleFavorite({{ $product->id }})"
                                                class="absolute top-2 left-2 w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition opacity-0 group-hover:opacity-100">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    @endauth
                                </div>
                                <div class="p-4">
                                    <a href="{{ route('products.show', $product->slug) }}"
                                       class="font-bold text-gray-900 hover:text-blue-600 transition line-clamp-2 mb-2">
                                        {{ $product->name }}
                                    </a>
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $product->averageRating ? '' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-600">({{ $product->comments->count() }})</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if($product->discount > 0)
                                                <div class="text-gray-400 line-through text-sm">
                                                    {{ number_format($product->price) }} تومان
                                                </div>
                                                <div class="text-blue-600 font-bold text-lg">
                                                    {{ number_format($product->original_price) }} تومان
                                                </div>
                                            @else
                                                <div class="text-blue-600 font-bold text-lg">
                                                    {{ number_format($product->price) }} تومان
                                                </div>
                                            @endif
                                        </div>
                                        <button onclick="addToCart({{ $product->id }})"
                                                class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button id="carousel-prev" class="absolute right-0 top-1/2 -translate-y-1/2 -translate-x-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-blue-600 hover:shadow-xl transition z-10">
                <i class="fas fa-chevron-right"></i>
            </button>
            <button id="carousel-next" class="absolute left-0 top-1/2 -translate-y-1/2 translate-x-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-blue-600 hover:shadow-xl transition z-10">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
    </div>

    <!-- Categories -->
    <div class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">دسته‌بندی محصولات</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($cats as $category)
                    <a href="{{ route('product.index', ['category' => $category->slug]) }}"
                       class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                        @if($category->photo)
                            <img src="{{ asset($category->photo->address) }}" alt="{{ $category->name }}"
                                 class="w-20 h-20 mx-auto mb-4 object-contain group-hover:scale-110 transition-transform">
                        @else
                            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center text-3xl text-blue-600">
                                <i class="fas fa-box"></i>
                            </div>
                        @endif
                        <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition">
                            {{ $category->name }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Latest Products -->
    <div class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold text-center mb-8">جدیدترین محصولات</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ asset($product->photo->address ?? 'images/placeholder.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full aspect-square object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-4">
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="font-bold hover:text-blue-600 transition line-clamp-2">
                            {{ $product->name }}
                        </a>
                        <div class="mt-2 text-blue-600 font-bold">
                            {{ number_format( $product->price) }} تومان
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Slider functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-item');
        const dots = document.querySelectorAll('.slider-dot');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('opacity-100', i === index);
                slide.classList.toggle('opacity-0', i !== index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-white', i === index);
                dot.classList.toggle('bg-white/50', i !== index);
            });
        }

        document.getElementById('next-slide')?.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        });

        document.getElementById('prev-slide')?.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Auto slide
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 5000);

        // Carousel functionality
        let carouselPosition = 0;
        const track = document.getElementById('carousel-track');
        const prevBtn = document.getElementById('carousel-prev');
        const nextBtn = document.getElementById('carousel-next');

        nextBtn?.addEventListener('click', () => {
            const itemWidth = track.children[0].offsetWidth;
            const maxScroll = -(track.scrollWidth - track.parentElement.offsetWidth);
            carouselPosition = Math.max(carouselPosition - itemWidth, maxScroll);
            track.style.transform = `translateX(${carouselPosition}px)`;
        });

        prevBtn?.addEventListener('click', () => {
            const itemWidth = track.children[0].offsetWidth;
            carouselPosition = Math.min(carouselPosition + itemWidth, 0);
            track.style.transform = `translateX(${carouselPosition}px)`;
        });

        // Add to cart
        function addToCart(productId) {
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('cart-count').textContent = data.cartCount;
                        alert('محصول به سبد خرید اضافه شد');
                    }
                });
        }

        // Toggle favorite
        function toggleFavorite(productId) {
            fetch(`/favorites/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                    }
                });
        }
    </script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }

        .animate-fade-in-delay {
            animation: fade-in 1s ease-out 0.3s both;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
