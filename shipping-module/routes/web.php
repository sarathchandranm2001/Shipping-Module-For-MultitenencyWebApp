<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\OrderController;

Route::resource('shipping', ShippingController::class);

Route::get('/orders/{order}/tracking', [OrderController::class, 'showTracking'])->name('orders.tracking');
