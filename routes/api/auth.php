<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthController as AuthV1;

Route::prefix('v1')->group(function ($route) {
    $route->post('/login', [AuthV1::class, 'login']);
    $route->post('/activate', [AuthV1::class, 'activate']);
});
