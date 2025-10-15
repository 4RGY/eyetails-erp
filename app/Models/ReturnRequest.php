<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'order_item_id',
        'type',
        'reason',
        'status',
        'admin_notes',
        'attachment_path', // <-- TAMBAHKAN INI
    ];

    /**
     * Relasi ke Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke User (pelanggan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke OrderItem (produk yang diretur)
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
