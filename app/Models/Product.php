<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Pastikan fillable diatur untuk mass assignment (saat Admin input)
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sku'
    ];

    /**
     * Dapatkan kunci route untuk model.
     * Menggunakan 'slug' daripada 'id' untuk URL yang ramah SEO.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getPrimaryImageAttribute()
    {
        // Mengambil path gambar pertama, atau null jika tidak ada gambar.
        return $this->images->first()->path ?? null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        // Ambil hanya review yang sudah disetujui
        return $this->hasMany(Review::class)->where('is_approved', true);
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function totalStock()
    {
        return $this->variants->sum('quantity');
    }
}