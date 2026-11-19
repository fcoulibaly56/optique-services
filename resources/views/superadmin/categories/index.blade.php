@extends('layouts.superadmin')

@section('title', 'Catégories — Super Admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold tracking-widest text-optique-red uppercase mb-2">Catalogue</p>
            <h1 class="text-3xl font-serif text-optique-text">Catégories</h1>
            <p class="text-sm text-optique-gray mt-1">Elles servent de filtres sur le site public, et certaines aussi de choix dans l'espace admin.</p>
        </div>
        <a href="{{ route('superadmin.categories.create') }}"
           class="inline-flex items-center justify-center px-5 py-3 text-sm font-medium text-white bg-optique-red rounded-xl hover:opacity-90 transition">
            + Nouvelle catégorie
        </a>
    </div>

    @include('superadmin._flash')

    <div class="space-y-3">
        @forelse ($categories as $category)
            <div class="bg-white border border-optique-border rounded-2xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-optique-text">{{ $category->name }}</p>
                    <p class="text-xs text-optique-gray">
                        {{ \App\Models\Category::TYPES[$category->type] ?? $category->type }}
                        · {{ $category->products_count }} produit(s) en stock
                        · {{ $category->gallery_items_count }} photo(s)
                    </p>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-xs px-2.5 py-1 rounded-full border
                        {{ $category->show_in_admin ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                        {{ $category->show_in_admin ? 'Dans l\'espace admin' : 'Public seulement' }}
                    </span>

                    <a href="{{ route('superadmin.categories.edit', $category) }}"
                       class="text-sm font-medium text-optique-red hover:underline">Modifier</a>

                    <form method="POST" action="{{ route('superadmin.categories.destroy', $category) }}"
                          onsubmit="return confirm('Supprimer « {{ addslashes($category->name) }} » ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-gray-400 hover:text-red-600">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white border border-dashed border-optique-border rounded-2xl p-10 text-center text-optique-gray">
                Aucune catégorie pour le moment.
            </div>
        @endforelse
    </div>
</div>
@endsection
