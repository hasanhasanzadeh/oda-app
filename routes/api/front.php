<?php

use App\Http\Controllers\Api\Front\ContentController;
use App\Http\Controllers\Api\Front\FaqController;
use App\Http\Controllers\Api\Front\PostController;
use App\Http\Controllers\Api\Front\ProductController;
use App\Http\Controllers\Api\Front\ServiceController;
use App\Http\Controllers\Api\Front\CityController;
use App\Http\Controllers\Api\Front\BlogController;
use App\Http\Controllers\Api\Front\CategoryController;
use App\Http\Controllers\Api\Front\SettingController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(callback: function ($route) {
        $route->get('setting', [SettingController::class,'showFirst']);
        $route->get('category', [CategoryController::class,'index']);
        $route->get('category/{slug}', [CategoryController::class,'show']);
        $route->get('blog', [BlogController::class,'index']);
        $route->get('blog/{slug}', [BlogController::class,'show']);
        $route->get('/city', [CityController::class, 'index']);
        $route->get('/city/{id}', [CityController::class, 'show']);

        $route->get('/content/{type}', [ContentController::class, 'show']);
        $route->get('/faq', [FaqController::class, 'index']);
        $route->get('/service', [ServiceController::class, 'index']);
        $route->get('/product', [ProductController::class, 'index']);
        $route->get('/post', [PostController::class, 'index']);
});

