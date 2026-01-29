<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_selling_price',
        'product_buying_price',
        'unit_id',
        'product_stock',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(
            TransactionDetail::class,
            'product_id'
        );
    }
}
