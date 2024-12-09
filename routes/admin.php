<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\admin\LoginController;
use \App\Http\Controllers\admin\DashboardController;
use \App\Http\Controllers\admin\BannersController;
use \App\Http\Controllers\admin\IntroduceController;
use \App\Http\Controllers\admin\PromoteController;
use \App\Http\Controllers\admin\CategoryController;
use \App\Http\Controllers\admin\TrademarkController;
use \App\Http\Controllers\admin\ProductController;
use \App\Http\Controllers\admin\FooterController;
use \App\Http\Controllers\admin\OrderController;


Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/dologin', [LoginController::class, 'doLogin'])->name('doLogin');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('check-admin-auth')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('index');

    Route::prefix('order')->name('order.')->group(function (){
        Route::get('index/{status}', [OrderController::class,'getDataOrder'])->name('index');
        Route::get('detail/{id}', [OrderController::class,'orderDetail'])->name('detail');
        Route::get('status/{order_id}/{status_id}', [OrderController::class,'statusOrder'])->name('status');
    });

    Route::prefix('banner')->name('banner.')->group(function () {
        Route::get('/', [BannersController::class, 'index'])->name('index');
        Route::get('create', [BannersController::class, 'create'])->name('create');
        Route::post('store', [BannersController::class, 'store'])->name('store');
        Route::get('delete/{id}', [BannersController::class, 'delete']);
        Route::get('edit/{id}', [BannersController::class, 'edit']);
        Route::post('update/{id}', [BannersController::class, 'update']);
    });

    Route::prefix('introduce')->name('introduce.')->group(function () {
        Route::get('', [IntroduceController::class, 'index'])->name('index');
        Route::get('create', [IntroduceController::class, 'create'])->name('create');
        Route::post('store', [IntroduceController::class, 'store'])->name('store');
        Route::get('delete/{id}', [IntroduceController::class, 'delete']);
        Route::get('edit/{id}', [IntroduceController::class, 'edit']);
        Route::post('update/{id}', [IntroduceController::class, 'update']);
    });

    Route::prefix('promote')->name('promote.')->group(function () {
        Route::get('', [PromoteController::class, 'index'])->name('index');
        Route::get('create', [PromoteController::class, 'create'])->name('create');
        Route::post('store', [PromoteController::class, 'store'])->name('store');
        Route::get('delete/{id}', [PromoteController::class, 'delete']);
        Route::get('edit/{id}', [PromoteController::class, 'edit']);
        Route::post('update/{id}', [PromoteController::class, 'update']);
    });

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('delete/{id}', [CategoryController::class, 'delete']);
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
    });

    Route::prefix('trademark')->name('trademark.')->group(function () {
        Route::get('', [TrademarkController::class, 'index'])->name('index');
        Route::get('create', [TrademarkController::class, 'create'])->name('create');
        Route::post('store', [TrademarkController::class, 'store'])->name('store');
        Route::get('delete/{id}', [TrademarkController::class, 'delete']);
        Route::get('edit/{id}', [TrademarkController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [TrademarkController::class, 'update'])->name('update');
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('delete/{id}', [ProductController::class, 'delete']);
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('delete-img', [ProductController::class, 'deleteImg']);
    });

    Route::prefix('footer')->name('footer.')->group(function () {
        Route::get('/', [FooterController::class, 'index'])->name('index');
        Route::get('create', [FooterController::class, 'create'])->name('create');
        Route::post('store', [FooterController::class, 'store'])->name('store');
        Route::get('delete/{id}', [FooterController::class, 'delete']);
        Route::get('edit/{id}', [FooterController::class, 'edit']);
        Route::post('update/{id}', [FooterController::class, 'update']);
    });

});

Route::post('ckeditor/upload', [DashboardController::class, 'upload'])->name('ckeditor.image-upload');
