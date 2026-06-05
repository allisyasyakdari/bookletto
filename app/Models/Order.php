<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'province',
        'city',
        'district',
        'subtotal',
        'discount_amount',
        'promo_code',
        'shipping_cost',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'qris_reference',
        'placed_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'        => 'decimal:2',
            'shipping_cost'   => 'decimal:2',
            'total'           => 'decimal:2',
            'discount_amount' => 'integer',
            'placed_at'       => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
