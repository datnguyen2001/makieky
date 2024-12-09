<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\web\HomeController;
use \App\Http\Controllers\web\ProductController;
use \App\Http\Controllers\web\LoginController;
use \App\Http\Controllers\web\CartController;
use \App\Http\Controllers\web\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('dang-nhap', [LoginController::class, 'login'])->name('login');
Route::post('login/submit', [LoginController::class, 'loginSubmit'])->name('login.submit');
Route::get('dang-ky', [LoginController::class, 'register'])->name('register');
Route::post('registered', [LoginController::class, 'registered'])->name('registered');

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('chi-tiet/{slug}', [HomeController::class, 'detail'])->name('detail');
Route::get('danh-muc/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('thuong-hieu/{slug}', [HomeController::class, 'trademark'])->name('trademark');
Route::get('chi-tiet-san-pham/{slug}', [ProductController::class, 'detailProduct'])->name('detail-product');
Route::get('tim-kiem-san-pham', [ProductController::class, 'search'])->name('search');
Route::get('theo-doi-don-hang', [HomeController::class, 'orderTracking'])->name('order-tracking');
Route::get('lien-he', [HomeController::class, 'contact'])->name('contact');
Route::get('bai-viet/{slug}', [HomeController::class, 'post'])->name('post');

Route::get('cart-number', [CartController::class, 'cartNumber'])->name('cart-number');
Route::get('gio-hang', [CartController::class, 'getCart'])->name('get-cart');
Route::post('add-cart', [CartController::class, 'addCart'])->name('add-cart');
Route::get('cart-remove/{id}', [CartController::class, 'removeItem'])->name('cart-remove');
Route::get('cart-clear-all', [CartController::class, 'clearCart'])->name('cart-clear-all');
Route::post('cart-update/{id}', [CartController::class, 'updateCart'])->name('cart-update');


Route::middleware('auth')->group(function () {

    Route::get('mua-ngay', [HomeController::class, 'buyNow'])->name('buy-now');
    Route::get('thanh-toan', [HomeController::class, 'pay'])->name('pay');
    Route::post('tao-don', [HomeController::class, 'createOrderUser'])->name('create-order');
    Route::get('thanh-toan/thanh-cong',[HomeController::class,'successOrderVnPay']);
    Route::get('tai-khoan-cua-toi', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');

    Route::get('dia-chi', [ProfileController::class, 'address'])->name('address');
    Route::post('/add-address', [ProfileController::class, 'addAddress'])->name('add.address');
    Route::post('/update-address/{id}', [ProfileController::class, 'updateAddress'])->name('update.address');
    Route::get('/delete-address/{id}', [ProfileController::class, 'deleteAddress'])->name('address.delete');

    Route::get('lich-su-mua-hang', [ProfileController::class, 'orderHistory'])->name('order-history');
    Route::get('/order/details/{id}', [ProfileController::class, 'getOrderDetails']);

    Route::get('/api/districts/{province_id}', [ProfileController::class, 'getDistricts']);
    Route::get('/api/wards/{district_id}', [ProfileController::class, 'getWards']);



    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
