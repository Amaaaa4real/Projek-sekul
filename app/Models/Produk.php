<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'stock',
        'is_popular',
        'category_id',
        'brand_id',
    ];

    /* =========================
     | AUTO SLUG
     ========================= */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /* =========================
     | RELATIONS
     ========================= */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProdukPhoto::class, 'produk_id');
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(ProdukSize::class, 'produk_id');
    }

    /* =========================
     | CASCADE DELETE PHOTOS
     ========================= */
    protected static function booted()
    {
        static::deleting(function ($produk) {
            if ($produk->isForceDeleting()) {
                $produk->photos()->forceDelete();
            } else {
                $produk->photos()->delete();
            }
        });
    }
}
