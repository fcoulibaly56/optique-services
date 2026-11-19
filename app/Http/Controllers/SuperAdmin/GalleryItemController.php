<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\GalleryItemRequest;
use App\Models\Category;
use App\Models\GalleryItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    public function index()
    {
        $items = GalleryItem::with('categories')
            ->orderBy('position')
            ->orderBy('id')
            ->paginate(24);

        return view('superadmin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('superadmin.gallery.create', [
            'galleryItem' => new GalleryItem([
                'is_visible' => true,
                'position'   => (GalleryItem::max('position') ?? -1) + 1,
            ]),
            'categories' => $this->categories(),
        ]);
    }

    public function store(GalleryItemRequest $request)
    {
        $data = $this->payload($request);
        $data['image_path'] = $request->file('image')->store('gallery', 'public');

        try {
            $item = DB::transaction(function () use ($data, $request) {
                $item = GalleryItem::create($data);
                $item->categories()->sync($request->input('categories', []));

                return $item;
            });
        } catch (\Throwable $e) {
            // Pas de fichier orphelin si l'enregistrement échoue
            Storage::disk('public')->delete($data['image_path']);
            throw $e;
        }

        return redirect()->route('superadmin.gallery.index')
            ->with('success', "La photo « {$item->name} » a été ajoutée à la galerie.");
    }

    public function edit(GalleryItem $galleryItem)
    {
        return view('superadmin.gallery.edit', [
            'galleryItem' => $galleryItem->load('categories'),
            'categories'  => $this->categories(),
        ]);
    }

    public function update(GalleryItemRequest $request, GalleryItem $galleryItem)
    {
        $data     = $this->payload($request);
        $oldImage = $galleryItem->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        DB::transaction(function () use ($galleryItem, $data, $request) {
            $galleryItem->update($data);
            $galleryItem->categories()->sync($request->input('categories', []));
        });

        // L'ancienne photo est supprimée seulement après la réussite
        if (isset($data['image_path']) && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('superadmin.gallery.index')
            ->with('success', "La photo « {$galleryItem->name} » a été mise à jour.");
    }

    public function toggleVisibility(GalleryItem $galleryItem)
    {
        $galleryItem->update(['is_visible' => ! $galleryItem->is_visible]);

        return back()->with('success', $galleryItem->is_visible
            ? "« {$galleryItem->name} » est maintenant visible sur le site."
            : "« {$galleryItem->name} » est maintenant masquée.");
    }

    public function destroy(GalleryItem $galleryItem)
    {
        $name = $galleryItem->name;
        $path = $galleryItem->image_path;

        $galleryItem->delete(); // le pivot est nettoyé par la base (cascade)
        Storage::disk('public')->delete($path);

        return redirect()->route('superadmin.gallery.index')
            ->with('success', "La photo « {$name} » a été supprimée.");
    }

    // ---------- Helpers ----------

    private function categories()
    {
        return Category::orderBy('position')->orderBy('name')->get();
    }

    private function payload(GalleryItemRequest $request): array
    {
        $data = $request->safe()->only(['name', 'note', 'position']);

        $data['is_visible'] = $request->boolean('is_visible');
        $data['position']   = $data['position'] ?? ((GalleryItem::max('position') ?? -1) + 1);

        return $data;
    }
}
