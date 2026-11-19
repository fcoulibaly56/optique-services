<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['products', 'galleryItems'])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('superadmin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('superadmin.categories.create', [
            'category' => new Category(['type' => 'frame', 'position' => 0, 'show_in_admin' => true]),
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($this->payload($request));

        return redirect()->route('superadmin.categories.index')
            ->with('success', "La catégorie « {$category->name} » a été créée.");
    }

    public function edit(Category $category)
    {
        return view('superadmin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($this->payload($request));

        return redirect()->route('superadmin.categories.index')
            ->with('success', "La catégorie « {$category->name} » a été mise à jour.");
    }

    public function destroy(Category $category)
    {
        // withTrashed : un produit « supprimé » (SoftDeletes) occupe encore la ligne en base
        if ($category->products()->withTrashed()->exists()) {
            return back()->with('error', "« {$category->name} » est utilisée par des produits du stock : impossible de la supprimer.");
        }

        if ($category->galleryItems()->exists()) {
            return back()->with('error', "« {$category->name} » est utilisée par des photos de la galerie : retirez-la d'abord de ces photos.");
        }

        $category->delete();

        return redirect()->route('superadmin.categories.index')
            ->with('success', "La catégorie « {$category->name} » a été supprimée.");
    }

    private function payload(CategoryRequest $request): array
    {
        $data = $request->validated();

        $data['slug']          = Str::slug($data['name']);
        $data['position']      = $data['position'] ?? 0;
        $data['show_in_admin'] = $request->boolean('show_in_admin');

        return $data;
    }
}
