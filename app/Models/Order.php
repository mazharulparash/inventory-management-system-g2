<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'address', 'city', 'postal_code', 'country', 'email', 'phone', 'total_amount', 'status',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
