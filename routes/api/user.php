<?php

use App\Http\Controllers\Api\Front\ContactController;
use App\Http\Controllers\Api\User\AuthController as AuthV1;
use App\Http\Controllers\Api\User\LikeController;
use App\Http\Controllers\Api\User\NotificationController;
use App\Http\Controllers\Api\User\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function ($route) {
        $route->post('/logout', [AuthV1::class, 'logout']);
        $route->get('/profile', [AuthV1::class, 'getProfile']);
        $route->post('/profile/update', [AuthV1::class, 'updateProfile']);

        $route->post('/profile/avatar', [AuthV1::class, 'updateAvatar']);

        $route->post('/contact-us', [ContactController::class, 'store']);

        $route->delete('/notification/{id}', [NotificationController::class, 'show']);

        $route->post('/like/{id}', [LikeController::class, 'like']);
        $route->get('/likes', [LikeController::class, 'index']);

        $route->get('/payment-all', [\App\Http\Controllers\Api\User\PaymentController::class, 'all']);
        $route->get('/payment-all/{id}', [\App\Http\Controllers\Api\User\PaymentController::class, 'show']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/v1/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');
});

Route::get('/v1/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
