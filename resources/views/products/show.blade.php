@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">خانه</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('product.index') }}" class="text-gray-600 hover:text-blue-600">محصولات</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('product.index', ['category' => $product->category->slug]) }}" class="text-gray-600 hover:text-blue-600">
                {{ $product->category->name }}
            </a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <!-- Main Image with Zoom -->
                <div class="relative bg-white rounded-lg shadow-lg overflow-hidden group">
                    <div id="main-image-container" class="relative aspect-square overflow-hidden cursor-zoom-in">
                        <img id="main-image"
                             src="{{ asset($product->photo->address ?? 'images/placeholder.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-contain transition-transform duration-300">

                        <!-- Zoom Lens -->
                        <div id="zoom-lens" class="absolute w-32 h-32 border-2 border-blue-500 bg-blue-500/20 hidden pointer-events-none"></div>
                    </div>

                    <!-- Zoomed Image Display -->
                    <div id="zoom-result" class="absolute inset-0 bg-white hidden overflow-hidden z-10">
                        <img id="zoom-image"
                             src="{{ asset($product->photo->address ?? 'images/placeholder.jpg') }}"
                             alt="{{ $product->name }}"
                             class="absolute">
                    </div>

                    @if($product->discount > 0)
                        <div class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-full font-bold text-lg z-20">
                            {{ $product->discount }}% تخفیف
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Gallery -->
                <div class="flex gap-2 overflow-x-auto pb-2">
                    @foreach($product->images as $index => $image)
                        <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 cursor-pointer transition hover:border-blue-500 {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }}"
                             onclick="changeMainImage('{{ asset($image->image) }}', this)">
                            <img src="{{ asset($image->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                <!-- Rating -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b">
                    <div class="flex text-yellow-400 text-xl">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $product->averageRating ? '' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <span class="text-gray-600">({{ $product->comments->count() }} نظر)</span>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-600"><i class="fas fa-eye ml-1"></i> {{ $product->views }} بازدید</span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    @if($product->discount > 0)
                        <div class="flex items-center gap-4 mb-2">
                    <span class="text-2xl font-bold text-blue-600">
                        {{ number_format($product->original_price) }} تومان
                    </span>
                            <span class="text-xl text-gray-400 line-through">
                        {{ number_format($product->price) }} تومان
                    </span>
                        </div>
                        <div class="text-green-600 font-bold">
                            شما {{ number_format($product->price - $product->original_price) }} تومان صرفه‌جویی می‌کنید
                        </div>
                    @else
                        <div class="text-3xl font-bold text-blue-600">
                            {{ number_format($product->price) }} تومان
                        </div>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="mb-6 p-4 rounded-lg {{ $product->stock > 0 ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}">
                    @if($product->stock > 0)
                        <i class="fas fa-check-circle ml-2"></i>
                        موجود در انبار ({{ $product->stock }} عدد)
                    @else
                        <i class="fas fa-times-circle ml-2"></i>
                        ناموجود
                    @endif
                </div>

                <!-- Short Description -->
                @if($product->short_description)
                    <div class="mb-6 text-gray-700 leading-relaxed">
                        {{ $product->short_description }}
                    </div>
                @endif

                <!-- Actions -->
                <div class="space-y-3 mb-6">
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex gap-3">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-20 px-4 py-3 border border-gray-300 rounded-lg text-center">
                            <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                                <i class="fas fa-shopping-cart ml-2"></i>
                                افزودن به سبد خرید
                            </button>
                        </form>
                    @else
                        <button disabled
                                class="w-full bg-gray-300 text-gray-600 px-6 py-3 rounded-lg font-bold cursor-not-allowed">
                            ناموجود
                        </button>
                    @endif

                    @auth
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full border-2 border-red-500 text-red-500 px-6 py-3 rounded-lg font-bold hover:bg-red-500 hover:text-white transition">
                                <i class="fas fa-heart ml-2"></i>
                                {{ auth()->user()->favorites->contains($product->id) ? 'حذف از علاقه‌مندی‌ها' : 'افزودن به علاقه‌مندی‌ها' }}
                            </button>
                        </form>
                    @endauth
                </div>

                <!-- Features -->
                <div class="border-t pt-6 space-y-3 text-sm">
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-truck text-blue-600"></i>
                        ارسال رایگان برای خریدهای بالای 500,000 تومان
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-shield-alt text-green-600"></i>
                        گارانتی اصالت و سلامت فیزیکی کالا
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-undo text-purple-600"></i>
                        امکان بازگشت کالا تا 7 روز
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <div class="border-b">
                <nav class="flex">
                    <button class="tab-btn px-6 py-4 font-bold border-b-2 border-blue-600 text-blue-600" data-tab="description">
                        توضیحات
                    </button>
                    <button class="tab-btn px-6 py-4 font-bold text-gray-600 hover:text-blue-600 transition" data-tab="specifications">
                        مشخصات
                    </button>
                    <button class="tab-btn px-6 py-4 font-bold text-gray-600 hover:text-blue-600 transition" data-tab="comments">
                        نظرات ({{ $product->comments->count() }})
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <!-- Description Tab -->
                <div id="description-tab" class="tab-content">
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div id="specifications-tab" class="tab-content hidden">
                    @if($product->specifications)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(json_decode($product->specifications, true) as $key => $value)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <span class="font-bold text-gray-700">{{ $key }}</span>
                                    <span class="text-gray-600">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">مشخصات فنی برای این محصول ثبت نشده است.</p>
                    @endif
                </div>

                <!-- Comments Tab -->
                <div id="comments-tab" class="tab-content hidden">
                    <!-- Comment Form -->
                    @auth
                        <form action="{{ route('products.comment', $product) }}" method="POST" class="mb-8 p-6 bg-gray-50 rounded-lg">
                            @csrf
                            <h3 class="text-xl font-bold mb-4">نظر خود را ثبت کنید</h3>

                            <div class="mb-4">
                                <label class="block font-bold mb-2">امتیاز شما</label>
                                <div class="flex gap-2 text-3xl">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star cursor-pointer text-gray-300 hover:text-yellow-400 transition rating-star"
                                           data-rating="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating-input" value="5">
                            </div>

                            <div class="mb-4">
                                <label class="block font-bold mb-2">نظر شما</label>
                                <textarea name="comment" rows="4" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                                          placeholder="نظر خود را بنویسید..."></textarea>
                            </div>

                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                                ثبت نظر
                            </button>
                        </form>
                    @else
                        <div class="mb-8 p-6 bg-blue-50 rounded-lg text-center">
                            <p class="text-gray-700 mb-4">برای ثبت نظر ابتدا وارد حساب کاربری خود شوید</p>
                            <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                                ورود به حساب کاربری
                            </a>
                        </div>
                    @endauth

                    <!-- Comments List -->
                    <div class="space-y-6">
                        @forelse($product->comments->where('is_approved', true) as $comment)
                            <div class="border-b pb-6">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $comment->user->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $comment->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $comment->rating ? '' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700 leading-relaxed">{{ $comment->comment }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-600">
                                <i class="fas fa-comments text-4xl mb-4 text-gray-300"></i>
                                <p>هنوز نظری ثبت نشده است. اولین نفر باشید!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div>
                <h2 class="text-2xl font-bold mb-6">محصولات مرتبط</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                            <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                <img src="{{ asset($relatedProduct->photo->address ?? 'images/placeholder.jpg') }}"
                                     alt="{{ $relatedProduct->name }}"
                                     class="w-full aspect-square object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                            <div class="p-4">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}"
                                   class="font-bold hover:text-blue-600 transition line-clamp-2 mb-2">
                                    {{ $relatedProduct->name }}
                                </a>
                                <div class="text-blue-600 font-bold">
                                    {{ number_format($relatedProduct->price) }} تومان
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        // Tabs functionality
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tabId = btn.dataset.tab;

                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('border-blue-600', 'text-blue-600');
                    b.classList.add('text-gray-600');
                });
                btn.classList.add('border-blue-600', 'text-blue-600');
                btn.classList.remove('text-gray-600');

                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(tabId + '-tab').classList.remove('hidden');
            });
        });

        // Rating stars
        document.querySelectorAll('.rating-star').forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.dataset.rating;
                document.getElementById('rating-input').value = rating;

                document.querySelectorAll('.rating-star').forEach((s, index) => {
                    if (index < rating) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            });
        });

        // Image gallery
        function changeMainImage(src, element) {
            document.getElementById('main-image').src = src;
            document.getElementById('zoom-image').src = src;

            document.querySelectorAll('.flex-shrink-0').forEach(thumb => {
                thumb.classList.remove('border-blue-500');
                thumb.classList.add('border-gray-200');
            });
            element.classList.add('border-blue-500');
            element.classList.remove('border-gray-200');
        }

        // Zoom functionality
        const container = document.getElementById('main-image-container');
        const img = document.getElementById('main-image');
        const lens = document.getElementById('zoom-lens');
        const result = document.getElementById('zoom-result');
        const zoomImg = document.getElementById('zoom-image');

        container.addEventListener('mouseenter', () => {
            lens.classList.remove('hidden');
            result.classList.remove('hidden');
            container.classList.add('cursor-zoom-in');
        });

        container.addEventListener('mouseleave', () => {
            lens.classList.add('hidden');
            result.classList.add('hidden');
            container.classList.remove('cursor-zoom-in');
        });

        container.addEventListener('mousemove', (e) => {
            const rect = container.getBoundingClientRect();
            let x = e.clientX - rect.left;
            let y = e.clientY - rect.top;

            x = Math.max(lens.offsetWidth / 2, Math.min(x, rect.width - lens.offsetWidth / 2));
            y = Math.max(lens.offsetHeight / 2, Math.min(y, rect.height - lens.offsetHeight / 2));

            lens.style.left = (x - lens.offsetWidth / 2) + 'px';
            lens.style.top = (y - lens.offsetHeight / 2) + 'px';

            const cx = result.offsetWidth / lens.offsetWidth;
            const cy = result.offsetHeight / lens.offsetHeight;

            zoomImg.style.width = (img.width * cx) + 'px';
            zoomImg.style.height = (img.height * cy) + 'px';
            zoomImg.style.left = -(x * cx - result.offsetWidth / 2) + 'px';
            zoomImg.style.top = -(y * cy - result.offsetHeight / 2) + 'px';
        });
    </script>
@endsection
