@extends('layouts.superadmin')

@section('title', 'Galerie publique — Super Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold tracking-widest text-optique-red uppercase mb-2">Site public</p>
            <h1 class="text-3xl font-serif text-optique-text">Galerie</h1>
            <p class="text-sm text-optique-gray mt-1">{{ $items->total() }} photo(s) · c'est ce que voient vos visiteurs.</p>
        </div>
        <a href="{{ route('superadmin.gallery.create') }}"
           class="inline-flex items-center justify-center px-5 py-3 text-sm font-medium text-white bg-optique-red rounded-xl hover:opacity-90 transition">
            + Ajouter une photo
        </a>
    </div>

    @include('superadmin._flash')

    @if ($items->count())
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-5">
            @foreach ($items as $item)
                <article class="bg-white border border-optique-border rounded-2xl overflow-hidden flex flex-col">
                    <div class="relative aspect-[4/3] bg-[#F5F1EF]">
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" loading="lazy" class="w-full h-full object-contain p-3">
                        @unless ($item->is_visible)
                            <span class="absolute top-2 left-2 text-[10px] px-2 py-1 rounded-full bg-gray-800/80 text-white">Masquée</span>
                        @endunless
                    </div>

                    <div class="p-3 sm:p-4 flex-1 flex flex-col gap-2">
                        <p class="font-medium text-sm text-optique-text truncate">{{ $item->name }}</p>

                        <div class="flex flex-wrap gap-1">
                            @forelse ($item->categories as $category)
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-50 text-optique-red">{{ $category->name }}</span>
                            @empty
                                <span class="text-[10px] text-gray-400">Sans catégorie</span>
                            @endforelse
                        </div>

                        <div class="mt-auto pt-2 flex items-center justify-between gap-2 text-xs">
                            <form method="POST" action="{{ route('superadmin.gallery.toggle-visibility', $item) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="{{ $item->is_visible ? 'text-green-700' : 'text-gray-500' }}">
                                    {{ $item->is_visible ? '● Visible' : '○ Masquée' }}
                                </button>
                            </form>

                            <a href="{{ route('superadmin.gallery.edit', $item) }}" class="font-medium text-optique-red hover:underline">Modifier</a>

                            <form method="POST" action="{{ route('superadmin.gallery.destroy', $item) }}"
                                  onsubmit="return confirm('Supprimer définitivement « {{ addslashes($item->name) }} » ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{ $items->links() }}
    @else
        <div class="bg-white border border-dashed border-optique-border rounded-2xl p-10 text-center text-optique-gray">
            La galerie est vide. Ajoutez votre première photo.
        </div>
    @endif
</div>
@endsection
