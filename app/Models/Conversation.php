<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'subject',
        'is_read_by_admin',
        'last_reply_at',
    ];

    protected $casts = [
        'is_read_by_admin' => 'boolean',
        'last_reply_at' => 'datetime',
    ];

    /**
     * Percakapan ini dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Percakapan ini memiliki banyak pesan.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Percakapan ini mungkin terkait dengan satu produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}