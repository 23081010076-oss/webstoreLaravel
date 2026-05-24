<?php

use App\Http\Controllers\ProductController;
use App\Livewire\Cart;
use App\Livewire\ProductCatalog;
use App\Livewire\Homepage;
use App\Livewire\ProductDetail;
use App\Livewire\Checkout;
use App\Livewire\Page;
use App\Livewire\OrderConfirmed;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class)->name('home');
Route::get('/product', ProductCatalog::class)->name('product-catalog');
Route::get('/product/{product:slug}', ProductDetail::class)->name('product');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/order-confirmed', OrderConfirmed::class)->name('order-confirmed');
Route::get('/page', Page::class)->name('page');
