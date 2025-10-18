<?php
$cats = App\Models\Category::where('parent_id', 0)->where('is_active', true)
    ->orderBy('order')
    ->get();
?>
<div id="mobile-menu" class="hidden lg:hidden py-4">
    <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-white rounded">خانه</a>
    @foreach($cats as $category)
        <div>
            <a href="{{ route('product.index', ['category' => $category->slug]) }}"
               class="block px-4 py-2 hover:bg-white rounded">
                {{ $category->name }}
            </a>
            @if($category->children->count() > 0)
                <div class="pr-4">
                    @foreach($category->children as $child)
                        <a href="{{ route('products.index', ['category' => $child->slug]) }}"
                           class="block px-4 py-2 text-sm hover:bg-white rounded">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
    <a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-white rounded">درباره ما</a>
    <a href="{{ route('contact') }}" class="block px-4 py-2 hover:bg-white rounded">تماس با ما</a>
</div>



