<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShippingDetail extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
