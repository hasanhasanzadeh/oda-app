<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductAllRequest;
use App\Http\Requests\Product\ProductCreateFormRequest;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductDeleteRequest;
use App\Http\Requests\Product\ProductFindRequest;
use App\Http\Requests\Product\ProductUpdateFormRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Discount;
use App\Models\DiscountUsage;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function index(ProductAllRequest $request)
    {
        $title = __('message.products');
        $validated = $request->validated();
        $products = $this->productService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.product.index', [
            'title' => $title,
            'products' => $products,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(ProductCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.product.create', compact([ 'title']));
    }

    public function store(ProductCreateRequest $request)
    {
        $product = $this->productService->create($request->validated());
        if (!$product) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('products.index'));
    }


    public function show(ProductFindRequest $request,Product $product)
    {
        $title = __('message.show');

        return view('admin.product.show', compact([ 'title', 'product']));
    }


    public function edit(ProductUpdateFormRequest $request,Product $product)
    {
        $title = __('message.edit');
        $product->gallery = $product->gallery->map(function ($item) {
            return [
                'address' => $item->address,
                'type' => $item->type,
                'name' => basename($item->address),
                'url' => $item->address,
            ];
        });
        return view('admin.product.edit', compact(['title', 'product']));
    }


    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product = $this->productService->update($product->id,$request->validated());
        if (!$product) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('products.index'));
    }

    public function destroy(ProductDeleteRequest $request,Product $product)
    {
        $product = $this->productService->delete($product->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('products.index'));
    }

    public function search(Request $request)
    {
        $products = [];
        if ($request->has('q')) {
            $search = $request->q;
            $products = Product::select("id", "product_persian_name")
                ->where('product_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $products = collect($products);

        return response()->json($products);
    }

    public function purchase(Product $product)
    {
        $title = __('message.purchase_product');

        $availableDiscounts = Discount::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function ($query) use ($product) {
                $query->where('applicable_to', 'all')
                    ->orWhere('applicable_to', 'product')
                    ->orWhere(function ($q) use ($product) {
                        $q->where('applicable_to', 'specific_product')
                          ->where('product_id', $product->id);
                    });
            })
            ->get();

        return view('admin.product.purchase', compact('title', 'product', 'availableDiscounts'));
    }

    public function processPurchase(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
            'discount_codes' => 'nullable|array',
            'discount_codes.*' => 'string|max:50',
            'payment_method' => 'required|in:cash,card,bank_transfer,online,wallet',
            'delivery_address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $quantity = $validated['quantity'];
        $unitPrice = $product->price;
        $originalAmount = $unitPrice * $quantity;
        $discountCodes = $validated['discount_codes'] ?? [];

        $discountResult = $this->calculateDiscounts($discountCodes, 'product', $product->id, $originalAmount, $user->id);

        if (!$discountResult['success']) {
            toast($discountResult['message'], 'error');
            return back()->withInput();
        }

        $finalAmount = $discountResult['final_amount'];
        $appliedDiscounts = $discountResult['discounts'];

        if ($product->stock < $quantity) {
            toast(__('message.insufficient_stock'), 'error');
            return back()->withInput();
        }

        try {
            DB::beginTransaction();

            $purchase = ProductPurchase::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'original_amount' => $originalAmount,
                'discount_amount' => $discountResult['total_discount'],
                'final_amount' => $finalAmount,
                'payment_method' => $validated['payment_method'],
                'delivery_address' => $validated['delivery_address'],
                'status' => 'confirmed',
                'purchased_at' => now(),
                'notes' => $validated['notes'],
            ]);

            $product->decrement('stock', $quantity);

            foreach ($appliedDiscounts as $discount) {
                DiscountUsage::create([
                    'discount_id' => $discount['id'],
                    'user_id' => $user->id,
                    'item_type' => 'product',
                    'item_id' => $product->id,
                    'original_amount' => $originalAmount,
                    'discount_amount' => $discount['amount'],
                    'final_amount' => $finalAmount,
                    'purchase_id' => $purchase->id,
                ]);

                $discountModel = Discount::find($discount['id']);
                $discountModel->increment('usage_count');
            }

            DB::commit();

            toast(__('message.product_purchased_successfully'), 'success');
            return redirect()->route('admin.products.show', $product);

        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('message.purchase_failed'), 'error');
            return back()->withInput();
        }
    }

    public function bulkPurchase(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount_codes' => 'nullable|array',
            'discount_codes.*' => 'string|max:50',
            'payment_method' => 'required|in:cash,card,bank_transfer,online,wallet',
            'delivery_address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $items = $validated['items'];
        $discountCodes = $validated['discount_codes'] ?? [];

        $totalOriginalAmount = 0;
        $purchaseItems = [];

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            if ($product->stock < $item['quantity']) {
                toast(__('message.insufficient_stock_for_product', ['product' => $product->product_persian_name]), 'error');
                return back()->withInput();
            }

            $itemTotal = $product->price * $item['quantity'];
            $totalOriginalAmount += $itemTotal;

            $purchaseItems[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'item_total' => $itemTotal
            ];
        }

        $discountResult = $this->calculateBulkDiscounts($discountCodes, $purchaseItems, $totalOriginalAmount, $user->id);

        if (!$discountResult['success']) {
            toast($discountResult['message'], 'error');
            return back()->withInput();
        }

        $finalAmount = $discountResult['final_amount'];
        $appliedDiscounts = $discountResult['discounts'];

        try {
            DB::beginTransaction();

            $bulkPurchaseId = 'BP-' . time() . '-' . $user->id;

            foreach ($purchaseItems as $item) {
                $purchase = ProductPurchase::create([
                    'user_id' => $user->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'original_amount' => $item['item_total'],
                    'discount_amount' => 0, // Will be distributed proportionally
                    'final_amount' => 0, // Will be calculated proportionally
                    'payment_method' => $validated['payment_method'],
                    'delivery_address' => $validated['delivery_address'],
                    'status' => 'confirmed',
                    'purchased_at' => now(),
                    'notes' => $validated['notes'],
                    'bulk_purchase_id' => $bulkPurchaseId,
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }

            $totalDiscountDistributed = 0;
            $purchases = ProductPurchase::where('bulk_purchase_id', $bulkPurchaseId)->get();

            foreach ($purchases as $purchase) {
                $proportion = $purchase->original_amount / $totalOriginalAmount;
                $purchaseDiscount = $discountResult['total_discount'] * $proportion;
                $purchaseFinalAmount = $purchase->original_amount - $purchaseDiscount;

                $purchase->update([
                    'discount_amount' => $purchaseDiscount,
                    'final_amount' => $purchaseFinalAmount
                ]);

                $totalDiscountDistributed += $purchaseDiscount;
            }

            foreach ($appliedDiscounts as $discount) {
                foreach ($purchases as $purchase) {
                    DiscountUsage::create([
                        'discount_id' => $discount['id'],
                        'user_id' => $user->id,
                        'item_type' => 'product',
                        'item_id' => $purchase->product_id,
                        'original_amount' => $purchase->original_amount,
                        'discount_amount' => ($discount['amount'] * $purchase->original_amount) / $totalOriginalAmount,
                        'final_amount' => $purchase->final_amount,
                        'purchase_id' => $purchase->id,
                        'bulk_purchase_id' => $bulkPurchaseId,
                    ]);
                }

                $discountModel = Discount::find($discount['id']);
                $discountModel->increment('usage_count');
            }

            DB::commit();

            toast(__('message.bulk_purchase_successful', ['count' => count($items)]), 'success');
            return redirect()->route('admin.products.index');

        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('message.purchase_failed'), 'error');
            return back()->withInput();
        }
    }

    public function applyDiscount(Request $request, Product $product)
    {
        $validated = $request->validate([
            'discount_codes' => 'required|array|min:1',
            'discount_codes.*' => 'string|max:50',
            'quantity' => 'required|integer|min:1',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $userId = $validated['user_id'] ?? Auth::id();
        $amount = $product->price * $validated['quantity'];

        $result = $this->calculateDiscounts(
            $validated['discount_codes'],
            'product',
            $product->id,
            $amount,
            $userId
        );

        return response()->json($result);
    }

    private function calculateDiscounts($codes, $itemType, $itemId, $originalAmount, $userId = null)
    {
        if (empty($codes)) {
            return [
                'success' => true,
                'original_amount' => $originalAmount,
                'total_discount' => 0,
                'final_amount' => $originalAmount,
                'discounts' => [],
                'savings_percentage' => 0
            ];
        }

        $discounts = Discount::whereIn('code', $codes)
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->orderBy('discount_value', 'desc')
            ->get();

        $user = $userId ? User::find($userId) : null;
        $applicableDiscounts = [];
        $totalDiscount = 0;
        $currentAmount = $originalAmount;
        $hasNonStackable = false;

        foreach ($discounts as $discount) {
            if ($hasNonStackable) {
                break;
            }

            if ($user && !empty($discount->user_roles) && !in_array($user->role, $discount->user_roles)) {
                continue;
            }

            if (!$discount->isApplicableTo($itemType, $itemId)) {
                continue;
            }

            if ($discount->usage_limit && $discount->usage_count >= $discount->usage_limit) {
                continue;
            }

            if ($user && $discount->usage_limit_per_user) {
                $userUsageCount = $discount->usages()->where('user_id', $user->id)->count();
                if ($userUsageCount >= $discount->usage_limit_per_user) {
                    continue;
                }
            }

            if ($discount->minimum_amount && $currentAmount < $discount->minimum_amount) {
                continue;
            }

            $discountAmount = $discount->calculateDiscount($currentAmount);

            if ($discount->maximum_discount && $discountAmount > $discount->maximum_discount) {
                $discountAmount = $discount->maximum_discount;
            }

            $applicableDiscounts[] = [
                'id' => $discount->id,
                'name' => $discount->name,
                'code' => $discount->code,
                'type' => $discount->discount_type,
                'value' => $discount->discount_value,
                'amount' => $discountAmount,
                'stackable' => $discount->stackable
            ];

            $totalDiscount += $discountAmount;

            if ($discount->stackable) {
                $currentAmount -= $discountAmount;
            } else {
                $hasNonStackable = true;
            }
        }

        return [
            'success' => true,
            'original_amount' => $originalAmount,
            'total_discount' => $totalDiscount,
            'final_amount' => max(0, $originalAmount - $totalDiscount),
            'discounts' => $applicableDiscounts,
        ];
    }

    private function calculateBulkDiscounts($codes, $items, $totalAmount, $userId = null)
    {
        if (empty($codes)) {
            return [
                'success' => true,
                'original_amount' => $totalAmount,
                'total_discount' => 0,
                'final_amount' => $totalAmount,
                'discounts' => [],
                'savings_percentage' => 0
            ];
        }

        $discounts = Discount::whereIn('code', $codes)
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function ($query) {
                $query->where('applicable_to', 'all')
                    ->orWhere('applicable_to', 'product');
            })
            ->orderBy('discount_value', 'desc')
            ->get();

        $user = $userId ? User::find($userId) : null;
        $applicableDiscounts = [];
        $totalDiscount = 0;
        $currentAmount = $totalAmount;
        $hasNonStackable = false;

        foreach ($discounts as $discount) {
            if ($hasNonStackable) {
                break;
            }

            if ($user && !empty($discount->user_roles) && !in_array($user->role, $discount->user_roles)) {
                continue;
            }

            if ($discount->usage_limit && $discount->usage_count >= $discount->usage_limit) {
                continue;
            }

            if ($user && $discount->usage_limit_per_user) {
                $userUsageCount = $discount->usages()->where('user_id', $user->id)->count();
                if ($userUsageCount >= $discount->usage_limit_per_user) {
                    continue;
                }
            }

            if ($discount->minimum_amount && $currentAmount < $discount->minimum_amount) {
                continue;
            }

            $discountAmount = $discount->calculateDiscount($currentAmount);

            if ($discount->maximum_discount && $discountAmount > $discount->maximum_discount) {
                $discountAmount = $discount->maximum_discount;
            }

            $applicableDiscounts[] = [
                'id' => $discount->id,
                'name' => $discount->name,
                'code' => $discount->code,
                'type' => $discount->discount_type,
                'value' => $discount->discount_value,
                'amount' => $discountAmount,
                'stackable' => $discount->stackable
            ];

            $totalDiscount += $discountAmount;

            if ($discount->stackable) {
                $currentAmount -= $discountAmount;
            } else {
                $hasNonStackable = true;
            }
        }

        return [
            'success' => true,
            'original_amount' => $totalAmount,
            'total_discount' => $totalDiscount,
            'final_amount' => max(0, $totalAmount - $totalDiscount),
            'discounts' => $applicableDiscounts,
        ];
    }

    public function purchaseHistory(Request $request)
    {
        $title = __('message.product_purchase_history');

        $query = ProductPurchase::with(['user', 'product']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('product', function ($q) use ($search) {
                $q->where('product_persian_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('purchased_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('purchased_at', '<=', $request->date_to . ' 23:59:59');
        }

        $purchases = $query->orderBy('purchased_at', 'desc')->paginate(20);

        $products = Product::where('is_active', true)->orderBy('product_persian_name')->get();

        $statistics = [
            'total_purchases' => ProductPurchase::count(),
            'total_revenue' => ProductPurchase::sum('final_amount'),
            'total_discounts' => ProductPurchase::sum('discount_amount'),
            'average_discount' => ProductPurchase::where('discount_amount', '>', 0)->avg('discount_amount'),
        ];

        return view('admin.product.purchase-history', compact(
            'title', 'purchases', 'products', 'statistics'
        ));
    }

    public function discountReport(Request $request)
    {
        $title = __('message.product_discount_report');

        $query = DiscountUsage::with(['discount', 'user'])
            ->where('item_type', 'product');

        if ($request->filled('product_id')) {
            $query->where('item_id', $request->product_id);
        }

        if ($request->filled('discount_code')) {
            $query->whereHas('discount', function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->discount_code . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $usages = $query->orderBy('created_at', 'desc')->paginate(20);

        $products = Product::where('is_active', true)->orderBy('product_persian_name')->get();

        $statistics = [
            'total_discount_usage' => DiscountUsage::where('item_type', 'product')->count(),
            'total_discount_amount' => DiscountUsage::where('item_type', 'product')->sum('discount_amount'),
            'average_discount' => DiscountUsage::where('item_type', 'product')->avg('discount_amount'),
            'unique_users' => DiscountUsage::where('item_type', 'product')->distinct('user_id')->count(),
        ];

        return view('admin.product.discount-report', compact(
            'title', 'usages', 'products', 'statistics'
        ));
    }
}
