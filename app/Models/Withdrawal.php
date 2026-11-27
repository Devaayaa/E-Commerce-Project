<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'courier_id', 'amount', 'bank_name', 'account_number', 'account_name', 'status',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function courier() { return $this->belongsTo(Courier::class); }
}
