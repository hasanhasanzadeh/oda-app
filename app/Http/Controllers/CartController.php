<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        $subtotal = 0;
        foreach ($cart as $item) {
            $price = $item['sale_price'] ?? $item['price'];
            $subtotal += $price * $item['quantity'];
        }

        $discount = 0;
        $shipping = $subtotal >= 500000 ? 0 : 50000;
        $total = $subtotal - $discount + $shipping;

        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

        return view('cart.index', compact(['subtotal', 'discount', 'shipping', 'total','setting']));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $quantity = $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return back()->with('error', 'موجودی کافی نیست');
        }

        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'buy_price' => $product->buy_price,
                'quantity' => $quantity,
                'image' => $product->photo->address ?? 'images/placeholder.jpg',
            ];
        }

        session(['cart' => $cart]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cartCount' => count($cart),
                'message' => 'محصول به سبد خرید اضافه شد'
            ]);
        }

        return back()->with('success', 'محصول به سبد خرید اضافه شد');
    }

    public function update(Request $request, $productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $quantity = $request->input('quantity', 1);

            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }

            session(['cart' => $cart]);

            return response()->json([
                'success' => true,
                'cartCount' => count($cart)
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function remove($productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);

            return response()->json([
                'success' => true,
                'cartCount' => count($cart),
                'message' => 'محصول از سبد خرید حذف شد'
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'سبد خرید خالی شد');
    }

    public function applyDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        // Check discount code logic here
        $code = $request->code;

        // Example: If code is valid
        // session(['discount' => 50000]);
        // return back()->with('success', 'کد تخفیف اعمال شد');

        return back()->with('error', 'کد تخفیف نامعتبر است');
    }
}
