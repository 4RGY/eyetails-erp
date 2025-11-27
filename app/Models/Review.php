<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'content',
        'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Definisikan relasi ke OrderItem
     * Ini dicocokkan dengan $review->orderItem di view 'show.blade.php'
     */
    public function orderItem()
    {
        // Mencari OrderItem yang punya order_id DAN product_id yang sama dengan review ini
        return $this->hasOne(OrderItem::class, 'order_id', 'order_id')
            ->where('product_id', $this->product_id);
    }

    /**
     * Definisikan relasi ke Order
     * Ini akan memperbaiki error 'reviews.order' JIKA kamu tetap ingin memakainya
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
