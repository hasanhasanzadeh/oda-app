<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

public function __construct(private readonly UserService $userService)
{
}

    public function index()
    {
        $user = Auth::user();

        $totalOrders = $user->orders()->count();
        $deliveredOrders = $user->orders()->where('status', 'delivered')->count();
        $favoritesCount = $user->favorites()->count();
        $totalSpent = $user->orders()->where('payment_status', 'paid')->sum('total');

        $recentOrders = $user->orders()->latest()->take(5)->get();
        $favoriteProducts = $user->favorites()->with('primaryImage')->take(4)->get();

        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

        return view('user.dashboard', compact([
            'totalOrders',
            'deliveredOrders',
            'favoritesCount',
            'totalSpent',
            'recentOrders',
            'favoriteProducts',
            'setting'
            ])
        );
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->with('items')->latest()->paginate(10);
        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();
        return view('user.orders.index', compact(['orders','setting']));
    }

    public function showOrder(Order $order)
    {
        // Check if order belongs to user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

        $order->load('items.product.primaryImage');
        return view('user.orders.show', compact(['order','setting']));
    }

    public function favorites()
    {
        $products = Auth::user()->favorites()
            ->with(['photo', 'comments'])
            ->paginate(12);
        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

        return view('user.favorites', compact(['products','setting']));
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses()
            ->with(['photo', 'comments'])
            ->paginate(12);
        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

        return view('user.addresses.index', compact(['addresses','setting']));
    }

    public function toggleFavorite(Product $product)
    {
        $user = Auth::user();

        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
            $message = 'محصول از علاقه‌مندی‌ها حذف شد';
        } else {
            $user->favorites()->attach($product->id);
            $message = 'محصول به علاقه‌مندی‌ها اضافه شد';
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    public function profile()
    {
        $user = Auth::user();
        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();
        return view('user.profile', compact(['user','setting']));
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $user = $this->userService->update($user->id, $request->validated());
        return back()->with('success', 'اطلاعات با موفقیت بروزرسانی شد');
    }

    public function accountDelete(Request $request)
    {
        $user = Auth::user();
        Auth::guard('web')->logout();
//        $user = $this->userService->delete($user->id);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'اکانت شما با موفقیت حذف شد');
    }

    public function comments()
    {
        $comments = Auth::user()->comments()
            ->with('product')
            ->latest()
            ->paginate(10);
        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();
        return view('user.comments', compact(['comments','setting']));
    }
}
