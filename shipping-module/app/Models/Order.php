<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'shipping_method_id', 'tracking_id', 'shipping_cost'];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function trackingDetails()
    {
        return $this->hasMany(TrackingDetail::class);
    }
}
