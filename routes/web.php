<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\CkeditorUploadController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\User\DashboardController;

require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/admin.php';
require __DIR__ . '/web/test.php';

Route::post('/ckeditor-upload', [CkeditorUploadController::class, 'upload'])->name('ckeditor.upload')->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{product}/comment', [ProductController::class, 'comment'])
    ->middleware('auth')
    ->name('products.comment');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{productId}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('applyDiscount');
});

Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
});

Route::get('/payment/verify/{order}', [CheckoutController::class, 'verify'])->name('payment.verify');

Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/addresses', [DashboardController::class, 'addresses'])->name('addresses');

    Route::delete('/account/delete', [DashboardController::class, 'accountDelete'])->name('account.delete');

    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [DashboardController::class, 'showOrder'])->name('orders.show');

    Route::get('/favorites', [DashboardController::class, 'favorites'])->name('favorites');
    Route::post('/favorites/toggle/{product}', [DashboardController::class, 'toggleFavorite'])->name('favorites.toggle');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('/change-password', [DashboardController::class, 'changePassword'])->name('password.change');

    Route::get('/comments', [DashboardController::class, 'comments'])->name('comments');
});

Route::get('/about', [ContentController::class,'about'])->name('about');
Route::get('/contact', [ContentController::class,'contact'])->name('contact');
Route::get('/faq', [ContentController::class,'faq'])->name('faq');
Route::get('/privacy', [ContentController::class,'privacy'])->name('privacy');
Route::get('/rules', [ContentController::class,'rules'])->name('rules');

Route::post('/contact', function(\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string',
        'subject' => 'required|string',
        'message' => 'required|string|max:1000',
    ]);
    // Send email or save to database
    // Mail::to('info@shop.com')->send(new ContactMail($request->all()));

    return back()->with('success', 'پیام شما با موفقیت ارسال شد. به زودی با شما تماس می‌گیریم.');
})->name('contact.submit');
