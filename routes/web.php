<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Shop\ContactController;

Route::get('/', [ShopController::class, 'home'])->name('shop.home');
Route::get('/catalogo', [ShopController::class, 'catalog'])->name('shop.catalog');
Route::get('/catalogo/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/ocasion/{slug}', [ShopController::class, 'ocasion'])->name('shop.ocasion');
Route::get('/ocasion/{slug}', [ShopController::class, 'ocasion'])->name('shop.ocasion');
Route::get('/contacto', [ContactController::class, 'show'])->name('shop.contact');
Route::post('/contacto', [ContactController::class, 'send'])->middleware('throttle:3,10')->name('shop.contact.send');
Route::get('/nosotras', [ShopController::class, 'nosotras'])->name('shop.nosotras');
Route::get('/producto/{slug}', [ShopController::class, 'product'])->name('shop.product');

Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/actualizar', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/eliminar/{varianteId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/carrito', [CartController::class, 'show'])->name('cart.show');

Route::get('/pedir', [ShopOrderController::class, 'checkout'])->name('order.checkout');
Route::post('/pedir', [ShopOrderController::class, 'store'])->name('order.store');
Route::get('/pedido/{numero}', [ShopOrderController::class, 'confirmation'])->name('order.confirmation');
Route::get('/pedir/whatsapp', [ShopOrderController::class, 'whatsapp'])->name('order.whatsapp');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout',[AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
        Route::resource('products', ProductController::class);
        Route::patch('products/{product}/toggle', [ProductController::class, 
'toggle'])->name('products.toggle');
        Route::patch('products/{product}/featured', [ProductController::class, 
'toggleFeatured'])->name('products.featured');
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('orders', OrderController::class)->only(['index','show','update']);
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::resource('customers', CustomerController::class)->only(['index','show','destroy']);
        Route::patch('customers/{customer}/toggle', [CustomerController::class, 
'toggle'])->name('customers.toggle');
        Route::resource('coupons', CouponController::class)->except(['show']);
        Route::patch('coupons/{coupon}/toggle', [CouponController::class, 'toggle'])->name('coupons.toggle');
        Route::get('account',            [AccountController::class, 'edit'])->name('account.edit');
        Route::patch('account',          [AccountController::class, 'update'])->name('account.update');
        Route::patch('account/password', [AccountController::class, 
'updatePassword'])->name('account.password');
    });
});
