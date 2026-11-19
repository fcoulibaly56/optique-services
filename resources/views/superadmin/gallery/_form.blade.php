@php
    $input = 'w-full rounded-xl border-optique-border text-sm focus:border-optique-red focus:ring-optique-red';
    $label = 'block text-sm font-medium text-optique-text mb-1';
    $selected = array_map('intval', old('categories', $galleryItem->exists ? $galleryItem->categories->pluck('id')->all() : []));
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data"
      class="bg-white border border-optique-border rounded-2xl p-5 md:p-8 space-y-6">
    @csrf
    @isset($method) @method($method) @endisset

    {{-- Photo --}}
    <div x-data="{ preview: @js($galleryItem->image_path ? $galleryItem->image_url : null) }">
        <label class="{{ $label }}">Photo {{ $galleryItem->exists ? '' : '*' }}</label>
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="w-full sm:w-48 aspect-[4/3] rounded-2xl bg-[#F5F1EF] border border-optique-border overflow-hidden flex items-center justify-center">
                <img x-show="preview" :src="preview" alt="Aperçu" class="w-full h-full object-contain p-2">
                <span x-show="!preview" class="text-xs text-gray-400">Aucune photo</span>
            </div>
            <div class="space-y-2">
                <input type="file" name="image" accept="image/png,image/jpeg,image/webp"
                       @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f) }"
                       class="block text-sm text-optique-gray file:mr-3 file:rounded-lg file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-optique-red">
                <p class="text-xs text-optique-gray">JPG, PNG ou WebP — 5 Mo maximum.
                    @if ($galleryItem->exists) Laissez vide pour garder la photo actuelle. @endif
                </p>
            </div>
        </div>
        @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="{{ $label }}">Nom *</label>
            <input type="text" name="name" value="{{ old('name', $galleryItem->name) }}" class="{{ $input }}">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Position (ordre d'affichage)</label>
            <input type="number" min="0" name="position" value="{{ old('position', $galleryItem->position) }}" class="{{ $input }}">
            @error('position') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="{{ $label }}">Description courte</label>
            <input type="text" name="note" value="{{ old('note', $galleryItem->note) }}"
                   placeholder="ex : Confort au quotidien." class="{{ $input }}">
            @error('note') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Catégories --}}
    <div>
        <label class="{{ $label }}">Catégories (filtres du site)</label>
        <div class="flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <label class="cursor-pointer">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="peer sr-only"
                           @checked(in_array($category->id, $selected, true))>
                    <span class="inline-block px-3.5 py-2 text-sm rounded-full border border-optique-border bg-white text-optique-gray transition
                                 peer-checked:bg-optique-red peer-checked:border-optique-red peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-optique-red">
                        {{ $category->name }}
                    </span>
                </label>
            @endforeach
        </div>
        @error('categories.*') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm text-optique-text">
        <input type="hidden" name="is_visible" value="0">
        <input type="checkbox" name="is_visible" value="1" @checked(old('is_visible', $galleryItem->is_visible))
               class="rounded border-gray-300 text-optique-red focus:ring-optique-red">
        Visible sur le site public
    </label>

    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-4 border-t border-optique-border">
        <a href="{{ route('superadmin.gallery.index') }}"
           class="px-5 py-3 text-sm text-center text-optique-gray bg-gray-50 rounded-xl hover:bg-gray-100">Annuler</a>
        <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-optique-red rounded-xl hover:opacity-90">Enregistrer</button>
    </div>
</form>
