<?php

namespace App\Models;

use App\Support\Geo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

    /** Kecepatan rata-rata kurir (km/jam) untuk estimasi tiba. */
    public const AVG_SPEED_KMH = 25;

    protected $fillable = [
        'order_number', 'customer_id', 'seller_id', 'courier_id', 'total',
        'payment_method', 'recipient_name', 'recipient_phone',
        'shipping_address', 'shipping_latitude', 'shipping_longitude', 'status',
    ];

    protected $casts = [
        'total' => 'float',
        'shipping_latitude' => 'float',
        'shipping_longitude' => 'float',
    ];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function seller() { return $this->belongsTo(Seller::class); }
    public function courier() { return $this->belongsTo(Courier::class); }
    public function locations() { return $this->hasMany(CourierLocation::class); }
    public function items() { return $this->hasMany(OrderItem::class); }

    public static function generateNumber(): string
    {
        do {
            $number = 'ORD-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
        } while (static::where('order_number', $number)->exists());

        return $number;
    }

    /** Order yang boleh dilihat oleh user tertentu, sesuai role-nya. */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return match ($user->role) {
            User::ROLE_ADMIN => $query,
            User::ROLE_SELLER => $query->whereHas('seller', fn ($q) => $q->where('user_id', $user->id)),
            User::ROLE_COURIER => $query->whereHas('courier', fn ($q) => $q->where('user_id', $user->id)),
            default => $query->whereHas('customer', fn ($q) => $q->where('user_id', $user->id)),
        };
    }

    public function isVisibleTo(User $user): bool
    {
        return static::query()->whereKey($this->id)->visibleTo($user)->exists();
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_CONFIRMED => 'Dikonfirmasi',
            self::STATUS_SHIPPED => 'Sedang Dikirim',
            self::STATUS_DELIVERED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function progressPercent(): int
    {
        return match ($this->status) {
            self::STATUS_PENDING => 10,
            self::STATUS_CONFIRMED => 35,
            self::STATUS_SHIPPED => 70,
            self::STATUS_DELIVERED => 100,
            default => 0,
        };
    }

    /** Estimasi menit tiba berdasarkan posisi kurir saat ini ke alamat tujuan. */
    public function etaMinutes(): ?int
    {
        if ($this->status !== self::STATUS_SHIPPED || ! $this->courier) {
            return null;
        }

        $km = Geo::distanceKm(
            $this->courier->current_latitude,
            $this->courier->current_longitude,
            $this->shipping_latitude,
            $this->shipping_longitude
        );

        return $km === null ? null : max(1, (int) ceil($km / self::AVG_SPEED_KMH * 60));
    }

    /** Batalkan pesanan dan kembalikan stok produk. Return false bila status tidak memungkinkan. */
    public function cancelAndRestock(): bool
    {
        if (! in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED], true)) {
            return false;
        }

        DB::transaction(function () {
            foreach ($this->items()->get() as $item) {
                if ($item->product_id) {
                    Product::whereKey($item->product_id)->increment('stock', $item->quantity);
                }
            }
            $this->update(['status' => self::STATUS_CANCELLED]);
        });

        return true;
    }
}
