@php
    $input = 'w-full rounded-xl border-optique-border text-sm focus:border-optique-red focus:ring-optique-red';
    $label = 'block text-sm font-medium text-optique-text mb-1';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data"
      class="bg-white border border-optique-border rounded-2xl p-5 md:p-8 space-y-6">
    @csrf
    @isset($method) @method($method) @endisset

    {{-- Image --}}
    <div x-data="{ preview: @js($product->image_url), removed: false }">
        <label class="{{ $label }}">Photo du produit</label>
        <div class="flex items-center gap-4">
            <div class="w-28 h-28 rounded-2xl bg-[#F9F8F6] border border-optique-border overflow-hidden flex items-center justify-center">
                <img x-show="preview && !removed" :src="preview" alt="Aperçu" class="w-full h-full object-cover">
                <span x-show="!preview || removed" class="text-xs text-gray-400 text-center px-2">Aucune image</span>
            </div>
            <div class="space-y-2">
                <input type="file" name="image" accept="image/png,image/jpeg,image/webp"
                       @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); removed = false }"
                       class="block text-sm text-optique-gray file:mr-3 file:rounded-lg file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-optique-red">
                <p class="text-xs text-optique-gray">JPG, PNG ou WebP — 2 Mo maximum.</p>
                @if ($product->image_path)
                    <label class="flex items-center gap-2 text-sm text-optique-gray">
                        <input type="checkbox" name="remove_image" value="1" x-model="removed" class="rounded border-gray-300 text-optique-red focus:ring-optique-red">
                        Supprimer l'image actuelle
                    </label>
                @endif
            </div>
        </div>
        @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="{{ $label }}">Nom *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="{{ $input }}">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Catégorie *</label>
            <select name="category_id" class="{{ $input }}">
                <option value="">— Choisir —</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Référence monture</label>
            <input type="text" name="reference" value="{{ old('reference', $product->reference) }}"
                   placeholder="ex : TR30_6003_S4-17_C2" class="{{ $input }}">
            @error('reference') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Marque</label>
            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="{{ $input }}">
            @error('brand') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Matière</label>
            <input type="text" name="material" value="{{ old('material', $product->material) }}" placeholder="Titane, acétate…" class="{{ $input }}">
            @error('material') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Taille</label>
            <input type="text" name="size" value="{{ old('size', $product->size) }}" placeholder="ex : 52-17-140" class="{{ $input }}">
            @error('size') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Stock</label>
            <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" class="{{ $input }}">
            @error('stock') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Prix : le champ s'affiche selon le mode --}}
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5"
             x-data="{ mode: '{{ old('price_mode', $product->price_mode) }}' }">
            <div>
                <label class="{{ $label }}">Affichage du prix *</label>
                <select name="price_mode" x-model="mode" class="{{ $input }}">
                    <option value="fixed">Prix fixe</option>
                    <option value="from">À partir de…</option>
                    <option value="on_request">Sur demande</option>
                </select>
                @error('price_mode') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div x-show="mode !== 'on_request'" x-cloak>
                <label class="{{ $label }}">Prix (FCFA) *</label>
                <input type="number" min="0" step="1" name="price" value="{{ old('price', $product->price !== null ? (int) $product->price : '') }}" class="{{ $input }}">
                @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="md:col-span-2">
            <label class="{{ $label }}">Description</label>
            <textarea name="description" rows="4" class="{{ $input }}">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Options --}}
    <div class="flex flex-col sm:flex-row gap-4 sm:gap-8 pt-2">
        <label class="flex items-center gap-2 text-sm text-optique-text">
            <input type="hidden" name="is_visible" value="0">
            <input type="checkbox" name="is_visible" value="1" @checked(old('is_visible', $product->is_visible))
                   class="rounded border-gray-300 text-optique-red focus:ring-optique-red">
            Visible dans le catalogue public
        </label>
        <label class="flex items-center gap-2 text-sm text-optique-text">
            <input type="hidden" name="is_available" value="0">
            <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $product->is_available))
                   class="rounded border-gray-300 text-optique-red focus:ring-optique-red">
            Disponible à la vente
        </label>
    </div>

    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-4 border-t border-optique-border">
        <a href="{{ route('superadmin.products.index') }}"
           class="px-5 py-3 text-sm text-center text-optique-gray bg-gray-50 rounded-xl hover:bg-gray-100">Annuler</a>
        <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-optique-red rounded-xl hover:opacity-90">
            Enregistrer
        </button>
    </div>
</form>
