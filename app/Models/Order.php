<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number', 'customer_id', 'seller_id', 'courier_id', 'total', 'shipping_address', 'shipping_latitude', 'shipping_longitude', 'status'];
    public function customer() { return $this->belongsTo(Customer::class); }
    public function seller() { return $this->belongsTo(Seller::class); }
    public function courier() { return $this->belongsTo(Courier::class); }
    public function locations() { return $this->hasMany(CourierLocation::class); }
}
