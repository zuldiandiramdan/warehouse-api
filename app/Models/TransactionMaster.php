<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMaster extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionMasterFactory> */
    use HasFactory;
    protected $fillable = ['transaction_date', 'transaction_type_id'];

    public function details()
    {
        return $this->hasMany(
            TransactionDetail::class,
            'transaction_master_id'
        );
    }

    public function transactionType()
    {
        return $this->belongsTo(
            TransactionType::class,
            'transaction_type_id'
        );
    }
}
