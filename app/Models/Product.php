<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'reference',           // <--- AJOUTÉ ICI
        'reference_normalisee',
        'slug',
        'description',
        'image_path',
        'brand',
        'material',
        'size',
        'price',
        'price_mode',
        'stock',
        'is_visible',
        'is_available',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_visible'   => 'bool',
        'is_available' => 'bool',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function scopePubliclyVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public static function normaliser(string $ref): string
    {
        return preg_replace('/[^A-Z0-9]/', '', strtoupper($ref));
    }

 // Ajoute cet accesseur
public function getImageUrlAttribute(): ?string
{
    return $this->image_path ? asset('storage/' . $this->image_path) : null;
}

// Corrige le hook booted() (voir l'explication plus bas)
protected static function booted()
{
    static::saving(function ($product) {
        $product->reference_normalisee = $product->reference
            ? self::normaliser($product->reference)
            : null;
    });
}
}
