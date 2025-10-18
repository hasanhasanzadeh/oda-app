<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get sliders
        $sliders = Slider::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get parent categories with products count
        $cats = Category::where('parent_id',0)
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('order')
            ->take(6)
            ->get();
        // Get featured products
        $featuredProducts = Product::with(['photo', 'comments'])
            ->where('is_featured', true)
            ->whereIn('status', ['active','soon'])
            ->inRandomOrder()
            ->take(8)
            ->get();

        // Get latest products
        $latestProducts = Product::with(['photo'])
            ->whereIn('status', ['active','soon'])
            ->latest()
            ->take(8)
            ->get();

        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();
        return view('home', compact(['sliders', 'cats', 'featuredProducts', 'latestProducts','setting']));
    }
}
