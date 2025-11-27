<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // PERBAIKAN DI SINI
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'phone',
        'shipping_address',
        'order_status',
        'payment_method',
        'payment_proof',
        'subtotal',
        'shipping_cost',
        'shipping_method',
        'total_amount',
        'points_used',
        'tracking_number',
        'promo_code',
        'promo_discount',
    ];

    // Status default untuk order baru (optional, tetapi baik untuk konsistensi)
    protected $attributes = [
        'order_status' => 'Pending',
    ];

    /**
     * Relasi ke Order Items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
