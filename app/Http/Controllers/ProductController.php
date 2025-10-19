<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['photo', 'comments', 'category'])
            ->whereIn('status', ['active', 'soon']);

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $categoryIds = [$category->id];
                // Include child categories
                $categoryIds = array_merge($categoryIds, $category->children->pluck('id')->toArray());
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Brand filter
        if ($request->has('brand') && is_array($request->brand)) {
            $query->whereIn('brand', $request->brand);
        }

        // Stock filter
        if ($request->has('in_stock') && $request->in_stock) {
            $query->where('stock', '>', 0);
        }

        // Featured filter
        if ($request->has('featured') && $request->featured) {
            $query->where('is_featured', true);
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);

        // Get all categories for filter
        $cats = Category::withCount('products')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get brands
        $brands = Product::select('brand')
            ->whereNotNull('brand')
            ->groupBy('brand')
            ->get();

        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

        return view('products.index', compact(['products', 'cats', 'brands','setting']));
    }

    public function show($slug)
    {
        $product = Product::with(['photo','gallery', 'category', 'comments.user'])
            ->where('slug', $slug)
            ->whereIn('status', ['active', 'soon'])
            ->firstOrFail();

        // Increment views
        $product->increment('views');

        // Get related products
        $relatedProducts = Product::with(['photo'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->whereIn('status', ['active', 'soon'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

        return view('products.show', compact(['product', 'relatedProducts','setting']));
    }

    public function comment(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از تایید نمایش داده می‌شود.');
    }
}
