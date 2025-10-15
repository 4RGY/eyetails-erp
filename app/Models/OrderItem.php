<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'size',
        'price',
        'quantity'
    ];

    /**
     * Relasi ke Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Product (jika produk masih ada)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Setiap item pesanan bisa memiliki satu permintaan pengembalian.
     */
    public function returnRequest()
    {
        return $this->hasOne(ReturnRequest::class);
    }
}
