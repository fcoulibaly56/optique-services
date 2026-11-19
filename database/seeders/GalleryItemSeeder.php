<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\GalleryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GalleryItemSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Catégories : on crée seulement celles qui n'existent pas (par slug)
        $categories = [
            ['Homme',     'homme',     'frame',      true],
            ['Femme',     'femme',     'frame',      true],
            ['Solaire',   'solaire',   'sunglasses', true],
            ['Enfant',    'enfant',    'frame',      false],
            ['Unisexe',   'unisexe',   'frame',      false],
            ['Percée',    'percee',    'frame',      false],
            ['Tendance',  'tendance',  'frame',      false],
            ['Classique', 'classique', 'frame',      false],
            ['Sport',     'sport',     'frame',      false],
            ['Moderne',   'moderne',   'frame',      false],
            ['Vintage',   'vintage',   'frame',      false],
        ];

        foreach ($categories as $i => [$name, $slug, $type, $inAdmin]) {
            Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'type' => $type, 'position' => $i, 'show_in_admin' => $inAdmin]
            );
        }

        // 2) Import des montures de config/montures.php
        $renamed = ['vue' => 'percee']; // l'ancien tag « vue » devient « percée »

        foreach (config('montures.items', []) as $i => $item) {
            $file   = basename($item['image'] ?? '');
            $source = public_path('images/montures/' . $file);

            if ($file === '' || ! is_file($source)) {
                $this->command?->warn("Image introuvable, ignorée : {$file}");
                continue;
            }

            // On copie la photo dans le stockage géré par le SuperAdmin
            $target = 'gallery/' . $file;
            Storage::disk('public')->put($target, file_get_contents($source));

            $galleryItem = GalleryItem::firstOrCreate(
                ['image_path' => $target],
                [
                    'name'       => $item['name'] ?? 'Monture',
                    'note'       => $item['note'] ?? null,
                    'is_visible' => true,
                    'position'   => $i,
                ]
            );

            $keys  = array_merge($item['audiences'] ?? [], $item['types'] ?? [], $item['styles'] ?? []);
            $slugs = array_map(fn ($key) => $renamed[$key] ?? $key, $keys);

            $galleryItem->categories()->syncWithoutDetaching(
                Category::whereIn('slug', $slugs)->pluck('id')
            );
        }
    }
}
