<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FeedbackController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

# Auth

Route::prefix('auth')->name('auth.')->group(function(){
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

# Product
Route::prefix('product')->name('product.')->group(function(){
    Route::get('list', [ProductController::class, 'list'])->name('list');
});

# Wishlist
Route::prefix('wishlist')->name('wishlist.')->group(function(){
    Route::get('list', [WishlistController::class, 'index'])->name('index');
    Route::post('save', [WishlistController::class, 'save'])->name('save');
    Route::get('delete/{id}', [WishlistController::class, 'delete'])->name('delete');
});

# Cart
Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('list', [CartController::class, 'index'])->name('index');
    Route::post('save', [CartController::class, 'save'])->name('save');
    Route::get('delete', [CartController::class, 'delete'])->name('delete');
});
# Coupon
Route::prefix('coupon')->name('coupon.')->group(function(){
    Route::post('apply', [CartController::class, 'couponCheck'])->name('save');
    Route::post('delete', [CartController::class, 'couponRemove'])->name('delete');
});
# Order
Route::prefix('order')->name('order.')->group(function(){
    Route::post('place', [OrderController::class, 'place'])->name('place');
    Route::post('payment-verify', [OrderController::class, 'verify'])->name('verify');
    Route::get('list', [OrderController::class, 'list'])->name('list');
    Route::get('details/{id}', [OrderController::class, 'details'])->name('details');
});

# Address
Route::prefix('address')->name('address.')->group(function(){
    Route::get('list', [UserController::class, 'index'])->name('index');
    Route::post('save', [UserController::class, 'save'])->name('save');
    Route::get('delete/{id}', [UserController::class, 'delete'])->name('delete');
    Route::post('edit', [UserController::class, 'edit'])->name('edit');
     Route::get('view/{id}', [UserController::class, 'view'])->name('view');
});

# Coupon
Route::prefix('feedback')->name('feedback.')->group(function(){
    Route::post('save', [FeedbackController::class, 'save'])->name('save');
    
});
