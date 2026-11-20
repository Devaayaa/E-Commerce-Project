<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierLocation extends Model
{
    protected $fillable = ['courier_id', 'order_id', 'latitude', 'longitude'];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function courier() { return $this->belongsTo(Courier::class); }
    public function order() { return $this->belongsTo(Order::class); }
}
