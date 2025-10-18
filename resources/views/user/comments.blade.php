@extends('layouts.app')

@section('title', 'نظرات من')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-6">
                @include('user.partials.sidebar')

                <div class="flex-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b">
                            <h2 class="text-2xl font-bold">نظرات من</h2>
                            <p class="text-gray-600 mt-1">{{ $comments->total() }} نظر</p>
                        </div>

                        @if($comments->count() > 0)
                            <div class="divide-y divide-gray-200">
                                @foreach($comments as $comment)
                                    <div class="p-6 hover:bg-gray-50 transition">
                                        <div class="flex flex-col md:flex-row gap-4">
                                            <!-- Product Image -->
                                            <a href="{{ route('products.show', $comment->product->slug) }}"
                                               class="flex-shrink-0">
                                                <img src="{{ asset($comment->product->photo->address ?? 'images/placeholder.jpg') }}"
                                                     alt="{{ $comment->product->name }}"
                                                     class="w-full md:w-32 h-32 object-cover rounded-lg">
                                            </a>

                                            <!-- Comment Details -->
                                            <div class="flex-1">
                                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-2 mb-3">
                                                    <div>
                                                        <a href="{{ route('products.show', $comment->product->slug) }}"
                                                           class="font-bold text-lg hover:text-blue-600 transition">
                                                            {{ $comment->product->name }}
                                                        </a>
                                                        <div class="text-sm text-gray-600 mt-1">
                                                            {{ $comment->created_at->format('Y/m/d H:i') }}
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-3">
                                                        <!-- Rating -->
                                                        <div class="flex text-yellow-400">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star {{ $i <= $comment->rating ? '' : 'text-gray-300' }}"></i>
                                                            @endfor
                                                        </div>

                                                        <!-- Status Badge -->
                                                        @if($comment->is_approved)
                                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                                <i class="fas fa-check-circle ml-1"></i>
                                                تایید شده
                                            </span>
                                                        @else
                                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">
                                                <i class="fas fa-clock ml-1"></i>
                                                در انتظار تایید
                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Comment Text -->
                                                <div class="bg-gray-50 rounded-lg p-4">
                                                    <p class="text-gray-700 leading-relaxed">{{ $comment->comment }}</p>
                                                </div>

                                                <!-- Actions -->
                                                <div class="flex items-center gap-4 mt-4">
                                                    <a href="{{ route('products.show', $comment->product->slug) }}"
                                                       class="text-blue-600 hover:text-blue-700 text-sm font-bold">
                                                        <i class="fas fa-eye ml-1"></i>
                                                        مشاهده محصول
                                                    </a>

                                                    @if(!$comment->is_approved)
                                                        <form action="{{ route('user.comments.delete', $comment) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    onclick="return confirm('آیا از حذف این نظر مطمئن هستید؟')"
                                                                    class="text-red-600 hover:text-red-700 text-sm font-bold">
                                                                <i class="fas fa-trash ml-1"></i>
                                                                حذف نظر
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($comments->hasPages())
                                <div class="p-6 border-t">
                                    {{ $comments->links() }}
                                </div>
                            @endif
                        @else
                            <div class="p-12 text-center">
                                <i class="fas fa-comments text-gray-300 text-6xl mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-700 mb-2">هنوز نظری ثبت نکرده‌اید</h3>
                                <p class="text-gray-600 mb-6">با ثبت نظر در مورد محصولات، به دیگران در انتخاب بهتر کمک کنید</p>
                                <a href="{{ route('product.index') }}"
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
