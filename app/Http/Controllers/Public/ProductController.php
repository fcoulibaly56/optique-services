<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Support\PublicGallery;

class ProductController extends Controller
{
    public function index()
    {
        $gallery = PublicGallery::get();

        return view('public.products.index', [
            'montures'       => $gallery['items'],
            'montureFilters' => $gallery['filters'],
            'filterLabelMap' => $gallery['labels'],
        ]);
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
