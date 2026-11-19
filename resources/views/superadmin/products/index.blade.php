@extends('layouts.superadmin')

@section('title', 'Catalogue — Super Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold tracking-widest text-optique-red uppercase mb-2">Catalogue</p>
            <h1 class="text-3xl font-serif text-optique-text">Produits</h1>
            <p class="text-sm text-optique-gray mt-1">{{ $products->total() }} produit(s)</p>
        </div>
        <a href="{{ route('superadmin.products.create') }}"
           class="inline-flex items-center justify-center px-5 py-3 text-sm font-medium text-white bg-optique-red rounded-xl hover:opacity-90 transition">
            + Nouveau produit
        </a>
    </div>

    @include('superadmin._flash')

    {{-- Filtres --}}
    <form method="GET" class="bg-white border border-optique-border rounded-2xl p-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom, marque ou référence…"
               class="md:col-span-2 rounded-xl border-optique-border text-sm focus:border-optique-red focus:ring-optique-red">
        <select name="category" class="rounded-xl border-optique-border text-sm focus:border-optique-red focus:ring-optique-red">
            <option value="">Toutes les catégories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <select name="visibility" class="flex-1 rounded-xl border-optique-border text-sm focus:border-optique-red focus:ring-optique-red">
                <option value="">Tous</option>
                <option value="visible" @selected(request('visibility') === 'visible')>Visibles</option>
                <option value="hidden" @selected(request('visibility') === 'hidden')>Masqués</option>
            </select>
            <button class="px-4 py-2 text-sm font-medium text-white bg-optique-text rounded-xl">Filtrer</button>
        </div>
    </form>

    {{-- Liste --}}
    <div class="space-y-3">
        @forelse ($products as $product)
            @php
                $fmt = fn ($v) => number_format((float) $v, 0, ',', ' ') . ' FCFA';
                $priceLabel = match ($product->price_mode) {
                    'on_request' => 'Sur demande',
                    'from'       => 'À partir de ' . $fmt($product->price),
                    default      => $fmt($product->price),
                };
            @endphp
            <div class="bg-white border border-optique-border rounded-2xl p-4 flex flex-col lg:flex-row lg:items-center gap-4">
                <div class="flex items-center gap-4 flex-1 min-w-0">
                    <div class="w-16 h-16 shrink-0 rounded-xl bg-[#F9F8F6] border border-optique-border overflow-hidden flex items-center justify-center">
                        @if ($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4-4a3 3 0 014 0l4 4m-2-2l1-1a3 3 0 014 0l2 2M4 6h16v12H4z"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium text-optique-text truncate">{{ $product->name }}</p>
                        <p class="text-xs text-optique-gray truncate">
                            {{ $product->reference ?? 'Sans référence' }} · {{ $product->category?->name }}
                        </p>
                        <p class="text-sm text-optique-text mt-1">{{ $priceLabel }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    {{-- Stock --}}
                    @if (is_null($product->stock))
                        <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">Stock —</span>
                    @elseif ($product->stock === 0)
                        <span class="text-xs px-2.5 py-1 rounded-full bg-red-50 text-red-700">Rupture</span>
                    @else
                        <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 text-optique-text">Stock : {{ $product->stock }}</span>
                    @endif

                    {{-- Visibilité (bascule) --}}
                    <form method="POST" action="{{ route('superadmin.products.toggle-visibility', $product) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="text-xs px-2.5 py-1 rounded-full border transition
                                {{ $product->is_visible ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                            {{ $product->is_visible ? '● Visible' : '○ Masqué' }}
                        </button>
                    </form>

                    <a href="{{ route('superadmin.products.edit', $product) }}"
                       class="text-sm font-medium text-optique-red hover:underline">Modifier</a>

                    <form method="POST" action="{{ route('superadmin.products.destroy', $product) }}"
                          onsubmit="return confirm('Supprimer « {{ addslashes($product->name) }} » ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-gray-400 hover:text-red-600">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white border border-dashed border-optique-border rounded-2xl p-10 text-center text-optique-gray">
                Aucun produit ne correspond à votre recherche.
            </div>
        @endforelse
    </div>

    {{ $products->links() }}
</div>
@endsection
