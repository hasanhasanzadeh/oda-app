<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SymbolController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisitController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['RoleType:admin','auth'])->group(function($route){

    $route->get('/dashboard', [AdminController::class,'index'])->name('admin.dashboard');
    $route->resource('/settings',SettingController::class);
    $route->resource('/customers',CustomerController::class);
    $route->resource('/blogs',BlogController::class);
    $route->resource('/symbols',SymbolController::class);
    $route->resource('/roles',RoleController::class);
    $route->resource('/questions',QuestionController::class);
    $route->resource('/permissions',PermissionController::class);
    $route->resource('/categories',CategoryController::class);
    $route->resource('/services',ServiceController::class);
    $route->resource('/countries',CountryController::class);
    $route->resource('/provinces',ProvinceController::class);
    $route->resource('/cities',CityController::class);
    $route->resource('/products',ProductController::class);
    $route->resource('/contents',ContentController::class);
    $route->resource('/posts',PostController::class);

    $route->get('/visits',[VisitController::class,'index'])->name('visits.index');
    $route->delete('/visits/{id}/delete',[VisitController::class,'destroy'])->name('visits.destroy');

    $route->delete('/visits/delete-all',[VisitController::class,'deleteAll'])->name('visits.deleteAll');

    $route->post('/upload-image',[PhotoController::class,'uploadImage'])->name('img.upload');
    $route->get('/',[AdminController::class,'index'])->name('admin.index');

    $route->get('/payments',[PaymentController::class,'index'])->name('payments.index');
    $route->get('/payments/{id}',[PaymentController::class,'show'])->name('payments.show');

    $route->get('/contacts',[ContactController::class,'index'])->name('contacts.index');
    $route->get('/contacts/{contact}',[ContactController::class,'show'])->name('contacts.show');
    $route->delete('/contacts/{contact}',[ContactController::class,'destroy'])->name('contacts.destroy');

    $route->get('/customer/search',[CustomerController::class,'search'])->name('customers.search');

    $route->get('/profile',[ProfileController::class,'show'])->name('profile.show');
    $route->get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
    $route->post('/profile/update',[ProfileController::class,'update'])->name('profile.update');

    $route->post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    $route->delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    $route->post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    $route->delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');

    $route->get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    $route->delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    $route->post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    $route->delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    $route->post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    $route->delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');

    $route->get('/category/search',[CategoryController::class,'search'])->name('category.search');

    $route->get('/user/search',[CustomerController::class,'search'])->name('user.search');
    $route->get('/city/search',[CityController::class,'search'])->name('city.search');
    $route->get('/country/search',[CountryController::class,'search'])->name('country.search');
    $route->get('/province/search',[ProvinceController::class,'search'])->name('province.search');
    $route->get('/setting/search',[SettingController::class,'search'])->name('setting.search');
    $route->get('/tags/search',[AdminController::class,'tagSearch'])->name('tag.search');
    $route->post('/make/slug',[AdminController::class,'makeSlug'])->name('make.slug');
    $route->get('/permission/search',[PermissionController::class,'search'])->name('permission.search');
});

