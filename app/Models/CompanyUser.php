<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyUser extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyUserFactory> */
    use HasFactory;

    public $timestamps = false;
}
