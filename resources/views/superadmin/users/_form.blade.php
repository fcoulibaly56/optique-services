@php
    $input = 'w-full rounded-xl border-optique-border text-sm focus:border-optique-red focus:ring-optique-red';
    $label = 'block text-sm font-medium text-optique-text mb-1';
    $btn   = 'shrink-0 px-3 py-2 text-xs font-medium rounded-xl border border-optique-border text-optique-gray hover:bg-gray-50';
@endphp

<form method="POST" action="{{ $action }}" autocomplete="off"
      class="bg-white border border-optique-border rounded-2xl p-5 md:p-8 space-y-6">
    @csrf
    @isset($method) @method($method) @endisset

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="{{ $label }}">Nom complet *</label>
            <input type="text" name="name" value="{{ old('name', $member->name) }}" class="{{ $input }}">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">E-mail * <span class="font-normal text-optique-gray">(sert à se connecter)</span></label>
            <input type="email" name="email" value="{{ old('email', $member->email) }}" class="{{ $input }}">
            @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $label }}">Téléphone</label>
            <input type="tel" name="phone" value="{{ old('phone', $member->phone) }}" placeholder="ex : 65 81 05 01" class="{{ $input }}">
            @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="{{ $label }}">Rôle *</label>
            <select name="role" class="{{ $input }}">
                @foreach (\App\Models\User::TEAM_ROLES as $value => $text)
                    <option value="{{ $value }}" @selected(old('role', $member->role) === $value)>{{ $text }}</option>
                @endforeach
            </select>
            @error('role') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Mot de passe --}}
        <div class="md:col-span-2"
             x-data="{
                show: false,
                pwd: '',
                generate() {
                    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
                    const bytes = new Uint32Array(12);
                    crypto.getRandomValues(bytes);
                    this.pwd = Array.from(bytes, n => chars[n % chars.length]).join('');
                    this.show = true;
                },
                copy() { navigator.clipboard && navigator.clipboard.writeText(this.pwd); }
             }">
            <label class="{{ $label }}">
                Mot de passe {{ $member->exists ? '(laisser vide pour ne pas le changer)' : '*' }}
            </label>
            <div class="flex gap-2">
                <input :type="show ? 'text' : 'password'" name="password" x-model="pwd" autocomplete="new-password" class="{{ $input }}">
                <button type="button" @click="show = !show" class="{{ $btn }}" x-text="show ? 'Masquer' : 'Afficher'"></button>
                <button type="button" @click="generate()" class="{{ $btn }}">Générer</button>
                <button type="button" @click="copy()" x-show="pwd" x-cloak class="{{ $btn }}">Copier</button>
            </div>
            <p class="text-xs text-optique-gray mt-1">8 caractères minimum. Notez-le ou copiez-le avant d'enregistrer : il ne sera plus affichable ensuite.</p>
            @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    @if ($member->exists)
        <label class="flex items-center gap-2 text-sm text-optique-text">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $member->is_active))
                   class="rounded border-gray-300 text-optique-red focus:ring-optique-red">
            Compte actif (peut se connecter)
        </label>
    @endif

    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-4 border-t border-optique-border">
        <a href="{{ route('superadmin.users.index') }}"
           class="px-5 py-3 text-sm text-center text-optique-gray bg-gray-50 rounded-xl hover:bg-gray-100">Annuler</a>
        <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-optique-red rounded-xl hover:opacity-90">Enregistrer</button>
    </div>
</form>
