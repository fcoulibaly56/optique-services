<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('position')->get();

        $products = Product::query()
            ->publiclyVisible()
            ->with('category')
            ->when($request->category, fn ($q, $slug) =>
                $q->whereHas('category', fn ($c) => $c->where('slug', $slug))
            )
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('public.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_visible, 404);

        $related = Product::query()
            ->publiclyVisible()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->take(4)
            ->get();

        return view('public.products.show', compact('product', 'related'));
    }
}
