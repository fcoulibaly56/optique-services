@php
    $input = 'w-full rounded-xl border-optique-border text-sm focus:border-optique-red focus:ring-optique-red';
    $label = 'block text-sm font-medium text-optique-text mb-1';
@endphp

<form method="POST" action="{{ $action }}" class="bg-white border border-optique-border rounded-2xl p-5 md:p-8 space-y-6">
    @csrf
    @isset($method) @method($method) @endisset

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="{{ $label }}">Nom *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="{{ $input }}">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Type *</label>
            <select name="type" class="{{ $input }}">
                @foreach (\App\Models\Category::TYPES as $value => $text)
                    <option value="{{ $value }}" @selected(old('type', $category->type) === $value)>{{ $text }}</option>
                @endforeach
            </select>
            @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Position (ordre d'affichage)</label>
            <input type="number" min="0" name="position" value="{{ old('position', $category->position) }}" class="{{ $input }}">
            @error('position') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="{{ $label }}">Description</label>
            <textarea name="description" rows="3" class="{{ $input }}">{{ old('description', $category->description) }}</textarea>
            @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <label class="flex items-start gap-2 text-sm text-optique-text">
        <input type="hidden" name="show_in_admin" value="0">
        <input type="checkbox" name="show_in_admin" value="1" @checked(old('show_in_admin', $category->show_in_admin))
               class="mt-0.5 rounded border-gray-300 text-optique-red focus:ring-optique-red">
        <span>
            Afficher dans l'espace admin
            <span class="block text-xs text-optique-gray">Cochée : l'équipe peut la choisir pour classer le stock. Décochée : elle ne sert qu'aux filtres du site public.</span>
        </span>
    </label>

    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-4 border-t border-optique-border">
        <a href="{{ route('superadmin.categories.index') }}"
           class="px-5 py-3 text-sm text-center text-optique-gray bg-gray-50 rounded-xl hover:bg-gray-100">Annuler</a>
        <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-optique-red rounded-xl hover:opacity-90">Enregistrer</button>
    </div>
</form>
