<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'sku', 'image', 'category_id', 'quantity'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Reduce the stock quantity by the given amount.
     *
     * @param int $quantity
     * @return void
     */
    public function reduceStock($quantity)
    {
        $this->quantity -= $quantity;
        $this->save();
    }
}
