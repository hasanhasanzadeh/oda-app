<?php

use App\Http\Controllers\Api\CkeditorUploadController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/admin.php';
require __DIR__ . '/web/test.php';

Route::post('/ckeditor-upload', [CkeditorUploadController::class, 'upload'])->name('ckeditor.upload')->middleware('auth');

Route::get('/',function(){
    return view('welcome');
})->name('home');
