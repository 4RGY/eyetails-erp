<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'max_discount',
        'start_date',
        'end_date',
        'usage_limit',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi untuk melacak user mana saja yang sudah mengklaim/menggunakan promo ini.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'promotion_user')->withTimestamps();
    }
}
