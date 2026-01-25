<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionDetailFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['transaction_master_id', 'product_id', 'qty', 'price'];

    public function transactionMaster()
    {
        return $this->belongsTo(
            TransactionMaster::class,
            'transaction_master_id'
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }
}
