<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create() {
$categories = Category::forAdmin()->orderBy('position')->orderBy('name')->get();
    return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create([
            'name' => $data['name'],
            'reference' => $data['reference'] ?? null,
            'slug' => Str::slug($data['name']) . '-' . Str::random(4),
            'category_id' => $data['category_id'],
            'brand' => $data['brand'] ?? null,
            'price' => $data['price'],
            'price_mode' => 'fixed',
            'stock' => $data['stock'],
            'is_visible' => false,
            'is_available' => true,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    // On renvoie bien la ref et le nom
                    'name' => $product->name . ($product->reference ? ' (' . $product->reference . ')' : ''),
                    'reference' => $product->reference
                ]
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit créé.');
    }

    public function searchApi(Request $request) {
        $search = $request->input('q');
        if (empty($search)) return response()->json([]);

        // On normalise ce que l'utilisateur tape (ex: "TR30" -> "TR30")
        $normalized = preg_replace('/[^A-Z0-9]/', '', strtoupper($search));

        $products = Product::where('stock', '>', 0)
            ->where(function($query) use ($normalized, $search) {
                // On cherche dans la référence normalisée OU dans le nom
                $query->where('reference_normalisee', 'like', "%{$normalized}%")
                      ->orWhere('name', 'like', "%{$search}%");
            })
            ->limit(8)
            ->get(['id', 'name', 'reference', 'price', 'stock']);

        return response()->json($products);
    }
}
