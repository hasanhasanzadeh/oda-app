<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $price = $item['price'];
            $subtotal += $price * $item['quantity'];
        }

        $discount = session('discount', 0);
        $shipping = $subtotal >= 500000 ? 0 : 50000;
        $total = $subtotal - $discount + $shipping;
        $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

        return view('checkout.index', compact(['subtotal', 'discount', 'shipping', 'total','setting']));
    }

    public function process(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:zarinpal',
            'terms' => 'accepted',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $price = $item['price'];
            $subtotal += $price * $item['quantity'];
        }

        $discount = session('discount', 0);
        $shipping = $subtotal >= 500000 ? 0 : 50000;
        $total = $subtotal - $discount + $shipping;

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => Auth::id(),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => $request->payment_method,
            'shipping_address' => [
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'province' => $request->province,
                'city' => $request->city,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
            ],
            'notes' => $request->notes,
        ]);

        // Create order items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        // Redirect to payment gateway
        return $this->payWithZarinpal($order);
    }

    protected function payWithZarinpal(Order $order)
    {
        // ZarinPal Configuration
        $merchantId = env('ZARINPAL_MERCHANT_ID');
        $amount = $order->total; // Amount in Tomans
        $description = "پرداخت سفارش #{$order->order_number}";
        $email = Auth::user()->email;
        $mobile = $order->shipping_address['phone'];
        $callbackUrl = route('payment.verify', ['order' => $order->id]);

        try {
            $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentRequest([
                'MerchantID' => $merchantId,
                'Amount' => $amount,
                'Description' => $description,
                'Email' => $email,
                'Mobile' => $mobile,
                'CallbackURL' => $callbackUrl,
            ]);

            if ($result->Status == 100) {
                // Redirect to payment gateway
                return redirect('https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
            } else {
                $order->update(['payment_status' => 'failed']);
                return redirect()->route('cart.index')->with('error', 'خطا در اتصال به درگاه پرداخت');
            }
        } catch (\Exception $e) {
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('cart.index')->with('error', 'خطا در اتصال به درگاه پرداخت');
        }
    }

    public function verify(Request $request, Order $order)
    {
        $authority = $request->get('Authority');
        $status = $request->get('Status');

        if ($status != 'OK') {
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('user.orders.show', $order)->with('error', 'پرداخت ناموفق بود');
        }

        $merchantId = env('ZARINPAL_MERCHANT_ID');
        $amount = $order->total;

        try {
            $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification([
                'MerchantID' => $merchantId,
                'Authority' => $authority,
                'Amount' => $amount,
            ]);

            if ($result->Status == 100) {
                // Payment successful
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'transaction_id' => $result->RefID,
                ]);

                // Clear cart
                session()->forget('cart');
                session()->forget('discount');

                return redirect()->route('user.orders.show', $order)->with('success', 'پرداخت با موفقیت انجام شد');
            } else {
                $order->update(['payment_status' => 'failed']);
                return redirect()->route('user.orders.show', $order)->with('error', 'تراکنش ناموفق بود');
            }
        } catch (\Exception $e) {
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('user.orders.show', $order)->with('error', 'خطا در تایید تراکنش');
        }
    }
}
