@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-2xl mx-auto">
    <h1 class="text-2xl font-serif mb-4">Nouveau Produit</h1>
    <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf
        <div>
            <label class="block text-sm mb-1">Nom du produit *</label>
            <input type="text" name="name" required class="w-full border rounded p-2 text-sm" placeholder="Ex: Monture Titanium Noire">
        </div>
        <div>
            <label class="block text-sm mb-1">Référence (ex: TR30_6003...)</label>
            <input type="text" name="reference" placeholder="Scanner ou taper la référence..." class="w-full border rounded p-2 text-sm">
        </div>
        <div>
            <label class="block text-sm mb-1">Catégorie *</label>
            <select name="category_id" required class="w-full border rounded p-2 text-sm">
                <option value="">Choisir...</option>
                @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Marque</label>
                <input type="text" name="brand" class="w-full border rounded p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm mb-1">Prix de vente (FCFA) *</label>
                <input type="number" name="price" required class="w-full border rounded p-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm mb-1">Stock initial *</label>
            <input type="number" name="stock" value="0" required class="w-full border rounded p-2 text-sm">
        </div>
        <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded-md">Enregistrer</button>
    </form>
</div>
@endsection
