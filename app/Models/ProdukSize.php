<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'size',
        'produk_id',
    ];
}
