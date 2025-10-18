<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'shipping',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'notes',
        'shipping_address',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'subtotal' => 'integer',
        'discount' => 'integer',
        'tax' => 'integer',
        'shipping' => 'integer',
        'total' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
