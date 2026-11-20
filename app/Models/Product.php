<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const CATEGORIES = ['fashion', 'electronics', 'beauty', 'home', 'gaming'];

    protected $fillable = [
        'seller_id', 'name', 'description', 'category', 'emoji',
        'price', 'original_price', 'discount', 'stock', 'sold', 'image',
    ];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'discount' => 'integer',
        'stock' => 'integer',
        'sold' => 'integer',
    ];

    public function seller() { return $this->belongsTo(Seller::class); }
}
