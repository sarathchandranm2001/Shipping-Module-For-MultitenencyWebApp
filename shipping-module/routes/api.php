<?php 
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShippingController;

Route::get('/shipping-methods', [ShippingController::class, 'getShippingMethods']);
Route::post('/shipping/calculate', [ShippingController::class, 'calculateShipping']);
Route::get('/orders/{orderId}/tracking', [ShippingController::class, 'getTrackingDetails']);
