<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/api', [ApiController::class, 'index'])->name('api.index');
Route::group(['middleware' => 'auth'], function () {
  Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::post('/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/delete/{id}', [CustomerController::class, 'delete'])->name('customers.delete');
  });
  Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
  });
  Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/update/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/delete/{id}', [OrderController::class, 'delete'])->name('orders.delete');
  });
});
