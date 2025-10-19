@extends('layouts.app')

@section('title', 'محصولات')

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Filters -->
                <aside class="lg:w-64 space-y-4">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold">فیلترها</h2>
                            @if(request()->hasAny(['category', 'min_price', 'max_price', 'brand', 'sort']))
                                <a href="{{ route('product.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                                    پاک کردن همه
                                </a>
                            @endif
                        </div>

                        <form method="GET" action="{{ route('product.index') }}" id="filter-form">
                            <!-- Search in current results -->
                            <div class="mb-6">
                                <label class="block font-bold mb-2 text-sm">جستجو</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="جستجو در محصولات..."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none text-sm">
                            </div>

                            <!-- Categories -->
                            <div class="mb-6">
                                <h3 class="font-bold mb-3 text-sm">دسته‌بندی</h3>
                                <div class="space-y-2 max-h-64 overflow-y-auto">
                                    @foreach($categories as $category)
                                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded transition">
                                            <input type="radio" name="category" value="{{ $category->slug }}"
                                                   {{ request('category') == $category->slug ? 'checked' : '' }}
                                                   onchange="document.getElementById('filter-form').submit()"
                                                   class="w-4 h-4 text-blue-600">
                                            <span class="text-sm">{{ $category->name }}</span>
                                            <span class="text-xs text-gray-500 mr-auto">({{ $category->products_count }})</span>
                                        </label>
                                        @if($category->children->count() > 0)
                                            @foreach($category->children as $child)
                                                <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 pr-6 rounded transition">
                                                    <input type="radio" name="category" value="{{ $child->slug }}"
                                                           {{ request('category') == $child->slug ? 'checked' : '' }}
                                                           onchange="document.getElementById('filter-form').submit()"
                                                           class="w-4 h-4 text-blue-600">
                                                    <span class="text-sm">{{ $child->name }}</span>
                                                    <span class="text-xs text-gray-500 mr-auto">({{ $child->products_count }})</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-6">
                                <h3 class="font-bold mb-3 text-sm">محدوده قیمت (تومان)</h3>
                                <div class="space-y-3">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}"
                                           placeholder="از قیمت"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none text-sm">
                                    <input type="number" name="max_price" value="{{ request('max_price') }}"
                                           placeholder="تا قیمت"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none text-sm">
                                </div>
                            </div>

                            <!-- Brands -->
                            @if($brands->count() > 0)
                                <div class="mb-6">
                                    <h3 class="font-bold mb-3 text-sm">برند</h3>
                                    <div class="space-y-2 max-h-48 overflow-y-auto">
                                        @foreach($brands as $brand)
                                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded transition">
                                                <input type="checkbox" name="brand[]" value="{{ $brand->brand }}"
                                                       {{ in_array($brand->brand, request('brand', [])) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-blue-600 rounded">
                                                <span class="text-sm">{{ $brand->brand }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Stock Status -->
                            <div class="mb-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="in_stock" value="1"
                                           {{ request('in_stock') ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 rounded">
                                    <span class="text-sm font-bold">فقط کالاهای موجود</span>
                                </label>
                            </div>

                            <!-- Featured Products -->
                            <div class="mb-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="featured" value="1"
                                           {{ request('featured') ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 rounded">
                                    <span class="text-sm font-bold">محصولات ویژه</span>
                                </label>
                            </div>

                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                                <i class="fas fa-filter ml-2"></i>
                                اعمال فیلترها
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="flex-1">
                    <!-- Toolbar -->
                    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="text-gray-700">
                                <span class="font-bold">{{ $products->total() }}</span> محصول یافت شد
                            </div>

                            <div class="flex items-center gap-4">
                                <label class="text-sm text-gray-700">مرتب‌سازی:</label>
                                <select name="sort" onchange="window.location.href=this.value"
                                        class="px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none text-sm">
                                    <option value="{{ route('product.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}"
                                        {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>
                                        جدیدترین
                                    </option>
                                    <option value="{{ route('product.index', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}"
                                        {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                        محبوب‌ترین
                                    </option>
                                    <option value="{{ route('product.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}"
                                        {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                        ارزان‌ترین
                                    </option>
                                    <option value="{{ route('product.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}"
                                        {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                        گران‌ترین
                                    </option>
                                </select>

                                <div class="flex gap-2">
                                    <button onclick="toggleView('grid')" id="grid-view-btn"
                                            class="w-10 h-10 flex items-center justify-center border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                        <i class="fas fa-th"></i>
                                    </button>
                                    <button onclick="toggleView('list')" id="list-view-btn"
                                            class="w-10 h-10 flex items-center justify-center border-2 border-gray-300 text-gray-600 rounded-lg hover:bg-gray-600 hover:text-white transition">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        @if(request()->hasAny(['category', 'min_price', 'max_price', 'brand', 'search', 'in_stock', 'featured']))
                            <div class="mt-4 pt-4 border-t flex flex-wrap gap-2">
                                <span class="text-sm text-gray-600">فیلترهای فعال:</span>

                                @if(request('category'))
                                    <a href="{{ route('product.index', request()->except('category')) }}"
                                       class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm hover:bg-blue-200 transition">
                                        {{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif

                                @if(request('search'))
                                    <a href="{{ route('product.index', request()->except('search')) }}"
                                       class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm hover:bg-blue-200 transition">
                                        جستجو: {{ request('search') }}
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif

                                @if(request('min_price') || request('max_price'))
                                    <a href="{{ route('product.index', request()->except(['min_price', 'max_price'])) }}"
                                       class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm hover:bg-blue-200 transition">
                                        قیمت: {{ number_format(request('min_price')) }} - {{ number_format(request('max_price')) }}
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Products -->
                    <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                                <div class="relative overflow-hidden aspect-square">
                                    <a href="{{ route('product.show', $product->slug) }}">
                                        <img src="{{ asset($product->photo->address ?? 'images/placeholder.jpg') }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </a>

                                    @if($product->disocunt > 0)
                                        <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                            {{ $product->discount }}%
                                        </div>
                                    @endif

                                    @if($product->stock == 0)
                                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                            <span class="bg-gray-900 text-white px-4 py-2 rounded-lg font-bold">ناموجود</span>
                                        </div>
                                    @endif

                                    @auth
                                        <form action="{{ route('user.favorites.toggle', $product) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="absolute top-2 left-2 w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition opacity-0 group-hover:opacity-100 shadow-lg">
                                                <i class="fas fa-heart {{ auth()->user()->favorites->contains($product->id) ? 'text-red-500' : '' }}"></i>
                                            </button>
                                        </form>
                                    @endauth
                                </div>

                                <div class="p-4">
                                    <a href="{{ route('product.show', $product->slug) }}"
                                       class="font-bold text-gray-900 hover:text-blue-600 transition line-clamp-2 mb-2 block">
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

                                        @if($product->stock > 0)
                                            <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                        class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700 transition shadow-lg">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-2xl font-bold text-gray-700 mb-2">محصولی یافت نشد</h3>
                                <p class="text-gray-600 mb-6">متاسفانه محصولی با این فیلترها پیدا نشد</p>
                                <a href="{{ route('product.index') }}"
                                   class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                                    مشاهده همه محصولات
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleView(view) {
            const container = document.getElementById('products-container');
            const gridBtn = document.getElementById('grid-view-btn');
            const listBtn = document.getElementById('list-view-btn');

            if (view === 'grid') {
                container.classList.remove('grid-cols-1');
                container.classList.add('grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3');
                gridBtn.classList.add('border-blue-600', 'text-blue-600');
                gridBtn.classList.remove('border-gray-300', 'text-gray-600');
                listBtn.classList.add('border-gray-300', 'text-gray-600');
                listBtn.classList.remove('border-blue-600', 'text-blue-600');
            } else {
                container.classList.remove('sm:grid-cols-2', 'lg:grid-cols-3');
                container.classList.add('grid-cols-1');
                listBtn.classList.add('border-blue-600', 'text-blue-600');
                listBtn.classList.remove('border-gray-300', 'text-gray-600');
                gridBtn.classList.add('border-gray-300', 'text-gray-600');
                gridBtn.classList.remove('border-blue-600', 'text-blue-600');

                document.querySelectorAll('.product-card').forEach(card => {
                    card.classList.add('flex', 'flex-row');
                    card.querySelector('.relative').classList.add('w-48');
                    card.querySelector('.relative').classList.remove('aspect-square');
                });
            }
        }
    </script>
@endsection
