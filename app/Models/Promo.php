<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'category',
        'code',
        'discount_type',
        'discount',
        'discount_amount',
        'min_purchase',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];
}
