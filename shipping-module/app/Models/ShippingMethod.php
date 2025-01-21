<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'flat_rate', 'service_start', 'service_end', 'is_hyper_local'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

