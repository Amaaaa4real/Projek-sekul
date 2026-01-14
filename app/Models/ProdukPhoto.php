<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukPhoto extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'photo',
        'produk_id',
    ];
}
