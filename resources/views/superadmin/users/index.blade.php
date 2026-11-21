@extends('layouts.superadmin')

@section('title', 'Équipe & Accès — Super Admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold tracking-widest text-optique-red uppercase mb-2">Administration</p>
            <h1 class="text-3xl font-serif text-optique-text">Équipe & Accès</h1>
            <p class="text-sm text-optique-gray mt-1">{{ $members->count() }} compte(s) · opticiens et administrateurs de la boutique.</p>
        </div>
        <a href="{{ route('superadmin.users.create') }}"
           class="inline-flex items-center justify-center px-5 py-3 text-sm font-medium text-white bg-optique-red rounded-xl hover:opacity-90 transition">
            + Nouveau compte
        </a>
    </div>

    @include('superadmin._flash')

    <div class="space-y-3">
        @forelse ($members as $member)
            <div class="bg-white border border-optique-border rounded-2xl p-4 flex flex-col md:flex-row md:items-center gap-4 {{ $member->is_active ? '' : 'opacity-60' }}">
                <div class="flex items-center gap-4 flex-1 min-w-0">
                    <div class="w-11 h-11 shrink-0 rounded-full bg-optique-red text-white grid place-items-center text-sm font-bold">
                        {{ strtoupper(mb_substr($member->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium text-optique-text truncate">{{ $member->name }}</p>
                        <p class="text-xs text-optique-gray truncate">
                            {{ $member->email }}@if ($member->phone) · {{ $member->phone }}@endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-xs px-2.5 py-1 rounded-full border
                        {{ $member->role === 'admin' ? 'bg-red-50 text-optique-red border-red-200' : 'bg-gray-50 text-optique-gray border-gray-200' }}">
                        {{ \App\Models\User::TEAM_ROLES[$member->role] ?? $member->role }}
                    </span>

                    <form method="POST" action="{{ route('superadmin.users.toggle-active', $member) }}"
                          @unless ($member->is_active) @else onsubmit="return confirm('Désactiver le compte de {{ addslashes($member->name) }} ? Il sera déconnecté.')" @endunless>
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="text-xs px-2.5 py-1 rounded-full border transition
                                {{ $member->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                            {{ $member->is_active ? '● Actif' : '○ Désactivé' }}
                        </button>
                    </form>

                    <a href="{{ route('superadmin.users.edit', $member) }}"
                       class="text-sm font-medium text-optique-red hover:underline">Modifier</a>

                    <form method="POST" action="{{ route('superadmin.users.destroy', $member) }}"
                          onsubmit="return confirm('Supprimer définitivement le compte de {{ addslashes($member->name) }} ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-gray-400 hover:text-red-600">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white border border-dashed border-optique-border rounded-2xl p-10 text-center text-optique-gray">
                Aucun compte d'équipe pour le moment.
            </div>
        @endforelse
    </div>
</div>
@endsection
