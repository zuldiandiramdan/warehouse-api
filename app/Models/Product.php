<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
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
        'company_id'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // filter for company_id
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

    public function transactionDetails()
    {
        return $this->hasMany(
            TransactionDetail::class,
            'product_id'
        );
    }
}
