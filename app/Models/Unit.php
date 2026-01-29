<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'unit_name',
        'is_big_unit',
        'smallest_unit_id',
        'smallest_amount'
    ];
    
}
