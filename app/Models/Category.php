<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public const TYPES = [
        'frame'        => 'Monture',
        'sunglasses'   => 'Solaire',
        'lens'         => 'Verres',
        'contact_lens' => 'Lentilles',
    ];

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'position',
        'show_in_admin',
    ];

    protected $casts = [
        'show_in_admin' => 'bool',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function galleryItems()
    {
        return $this->belongsToMany(GalleryItem::class);
    }

    // Catégories proposées dans les selects de l'espace admin
    public function scopeForAdmin($query)
    {
        return $query->where('show_in_admin', true);
    }
}
