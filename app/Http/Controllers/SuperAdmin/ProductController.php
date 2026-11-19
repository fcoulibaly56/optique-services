<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));

        $products = Product::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $norm = Product::normaliser($search);
                $query->where(function ($q) use ($search, $norm) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%")
                      ->orWhere('reference', 'like', "%{$search}%");
                    if ($norm !== '') {
                        $q->orWhere('reference_normalisee', 'like', "%{$norm}%");
                    }
                });
            })
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->category))
            ->when($request->visibility === 'visible', fn ($q) => $q->where('is_visible', true))
            ->when($request->visibility === 'hidden', fn ($q) => $q->where('is_visible', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('superadmin.products.index', [
            'products'   => $products,
            'categories' => $this->categories(),
        ]);
    }

    public function create()
    {
        return view('superadmin.products.create', [
            'product'    => new Product(['price_mode' => 'fixed', 'is_visible' => true, 'is_available' => true]),
            'categories' => $this->categories(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $data = $this->payload($request);
        $data['slug'] = $this->makeSlug($data['name']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        return redirect()->route('superadmin.products.index')
            ->with('success', "Le produit « {$product->name} » a été créé.");
    }

    public function edit(Product $product)
    {
        return view('superadmin.products.edit', [
            'product'    => $product,
            'categories' => $this->categories(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $this->payload($request);
        $oldImage = $product->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image')) {
            $data['image_path'] = null;
        }

        $product->update($data);

        // On supprime l'ancien fichier seulement APRÈS la réussite de l'update
        if ($oldImage && array_key_exists('image_path', $data) && $data['image_path'] !== $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('superadmin.products.index')
            ->with('success', "Le produit « {$product->name} » a été mis à jour.");
    }

    public function toggleVisibility(Product $product)
    {
        $product->update(['is_visible' => ! $product->is_visible]);

        return back()->with('success', $product->is_visible
            ? "« {$product->name} » est maintenant visible au public."
            : "« {$product->name} » est maintenant masqué.");
    }

    public function destroy(Product $product)
    {
        $product->delete(); // SoftDeletes : le produit reste en base (et son image aussi)

        return redirect()->route('superadmin.products.index')
            ->with('success', "Le produit « {$product->name} » a été supprimé.");
    }

    // ---------- Helpers privés ----------

    private function categories()
    {
        return Category::orderBy('position')->orderBy('name')->get();
    }

    private function payload(ProductRequest $request): array
    {
        $data = $request->safe()->except(['image', 'remove_image']);

        $data['is_visible']   = $request->boolean('is_visible');
        $data['is_available'] = $request->boolean('is_available');

        if ($data['price_mode'] === 'on_request') {
            $data['price'] = null;
        }

        return $data;
    }

    private function makeSlug(string $name): string
    {
        do {
            $slug = Str::slug($name) . '-' . Str::lower(Str::random(4));
        } while (Product::withTrashed()->where('slug', $slug)->exists());

        return $slug;
    }
}
