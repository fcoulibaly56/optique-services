<?php

namespace App\Support;

use App\Models\GalleryItem;

class PublicGallery
{
    /**
     * Données de la galerie publique, dans le format attendu par les vues
     * (même structure que l'ancien config/montures.php).
     */
    public static function get(): array
    {
        $galleryItems = GalleryItem::visible()
            ->with('categories')
            ->orderBy('position')
            ->orderBy('id')
            ->get();

        $items = $galleryItems->map(fn (GalleryItem $item) => [
            'name'      => $item->name,
            'image'     => basename($item->image_path),
            'url'       => $item->image_url,
            'note'      => $item->note,
            'audiences' => $item->categories->pluck('slug')->all(),
            'types'     => [],
            'styles'    => [],
        ])->all();

        // Seules les catégories qui ont au moins une photo visible deviennent des filtres
        $usedCategories = $galleryItems
            ->flatMap(fn (GalleryItem $item) => $item->categories)
            ->unique('id')
            ->sortBy([['position', 'asc'], ['name', 'asc']])
            ->values();

        $filters = [['key' => 'all', 'label' => 'Toutes']];
        foreach ($usedCategories as $category) {
            $filters[] = ['key' => $category->slug, 'label' => $category->name];
        }

        return [
            'items'   => $items,
            'filters' => $filters,
            'labels'  => array_column($filters, 'label', 'key'),
        ];
    }
}
