<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = ['name', 'note', 'image_path', 'is_visible', 'position'];

    protected $casts = [
        'is_visible' => 'bool',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
