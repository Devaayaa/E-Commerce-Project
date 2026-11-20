<?php

namespace App\Models;

use App\Support\Geo;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = ['user_id', 'phone', 'vehicle_type', 'vehicle_plate', 'status', 'current_latitude', 'current_longitude', 'last_location_update'];

    protected $casts = [
        'current_latitude' => 'float',
        'current_longitude' => 'float',
        'last_location_update' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function locations() { return $this->hasMany(CourierLocation::class); }
    public function orders() { return $this->hasMany(Order::class); }

    /**
     * Pilih kurir terbaik untuk pesanan baru:
     * hanya kurir berstatus "available", prioritas yang antreannya paling sedikit,
     * lalu yang paling dekat dengan titik pengambilan (toko).
     */
    public static function findBestFor(?float $lat, ?float $lng): ?self
    {
        return static::query()
            ->where('status', 'available')
            ->withCount(['orders as active_orders_count' => fn ($q) => $q->whereIn('status', ['confirmed', 'shipped'])])
            ->get()
            ->sortBy([
                ['active_orders_count', 'asc'],
                fn ($a, $b) => (Geo::distanceKm($lat, $lng, $a->current_latitude, $a->current_longitude) ?? PHP_INT_MAX)
                    <=> (Geo::distanceKm($lat, $lng, $b->current_latitude, $b->current_longitude) ?? PHP_INT_MAX),
            ])
            ->first();
    }
}
