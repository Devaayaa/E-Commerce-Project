<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = ['user_id', 'phone', 'vehicle_type', 'vehicle_plate', 'status', 'current_latitude', 'current_longitude', 'last_location_update'];
    public function user() { return $this->belongsTo(User::class); }
    public function locations() { return $this->hasMany(CourierLocation::class); }
}
