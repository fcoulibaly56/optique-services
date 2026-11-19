<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::query()
            ->publiclyVisible()
            ->where('is_available', true)
            ->with('category')
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::orderBy('position')->take(4)->get();

        return view('public.home', compact('featured', 'categories'));
    }
}
