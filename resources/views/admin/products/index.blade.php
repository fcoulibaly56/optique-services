@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Produits & Alertes</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm">+ Nouveau Produit</a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $product->reference ?? 'Non renseignée' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ number_format($product->price, 0, ',', ' ') }} F</td>
                        <td class="px-6 py-4 text-sm">
                            @if($product->stock <= 0)
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full font-bold text-xs">Rupture</span>
                            @elseif($product->stock <= 5)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full font-bold text-xs">Faible ({{ $product->stock }})</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full font-bold text-xs">OK ({{ $product->stock }})</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun produit.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t">{{ $products->links() }}</div>
    </div>
</div>
@endsection
