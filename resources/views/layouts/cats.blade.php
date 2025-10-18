<?php
$cats = App\Models\Category::where('parent_id', 0)->where('is_active', true)
    ->orderBy('order')
    ->get();
?>
@foreach($cats as $category)
    <div class="relative group">
        <a href="{{ route('product.index', ['category' => $category->slug]) }}"
           class="px-4 py-3 hover:bg-white hover:text-blue-600 transition rounded-t-lg flex items-center gap-2">
            {{ $category->name }}
            @if($category->children->count() > 0)
                <i class="fas fa-chevron-down text-xs"></i>
            @endif
        </a>
        @if($category->children->count() > 0)
            <div class="absolute right-0 top-full hidden group-hover:block bg-white shadow-lg rounded-b-lg min-w-[200px] py-2 z-50">
                @foreach($category->children as $child)
                    <a href="{{ route('products.index', ['category' => $child->slug]) }}"
                       class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition">
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endforeach
