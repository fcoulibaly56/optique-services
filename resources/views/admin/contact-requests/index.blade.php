@extends('layouts.admin')

@section('title', 'Demandes de contact — Espace Équipe')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl md:text-3xl font-serif text-optique-text">Demandes de contact</h1>
        <p class="text-sm text-optique-gray mt-1">Messages envoyés depuis la page Contact du site public.</p>
    </div>

    {{-- Onglets + recherche --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div class="flex gap-2 text-sm">
            @foreach (['new' => 'Nouveaux (' . $counts['new'] . ')', 'done' => 'Traités (' . $counts['done'] . ')', 'all' => 'Tous'] as $key => $label)
                <a href="{{ route('admin.contact-requests.index', ['filter' => $key, 'q' => request('q')]) }}"
                   class="px-4 py-2 rounded-full border transition
                   {{ $filter === $key ? 'bg-optique-red text-white border-optique-red' : 'bg-white text-gray-600 border-optique-border hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form method="GET" class="flex gap-2">
            <input type="hidden" name="filter" value="{{ $filter }}">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom, téléphone, message…"
                   class="rounded-xl border-optique-border text-sm focus:border-optique-red focus:ring-optique-red">
            <button class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-xl">Chercher</button>
        </form>
    </div>

    {{-- Liste --}}
    <div class="space-y-3">
        @forelse ($messages as $message)
            @php
                $digits = preg_replace('/\D+/', '', $message->phone);
                if (strlen($digits) === 8) { $digits = '223' . $digits; }
                $whatsapp = 'https://wa.me/' . $digits . '?text=' . rawurlencode('Bonjour ' . $message->name . ', c\'est Optique Services. Nous avons bien reçu votre message.');
            @endphp
            <article class="bg-white border border-optique-border rounded-2xl p-4 md:p-5 {{ $message->processed ? 'opacity-70' : '' }}">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="font-medium text-optique-text">{{ $message->name }}</p>
                        <p class="text-xs text-optique-gray">
                            {{ $message->created_at?->format('d/m/Y \à H:i') }}
                            · {{ $message->phone }}@if ($message->email) · {{ $message->email }}@endif
                        </p>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-full border
                        {{ $message->processed ? 'bg-gray-50 text-gray-500 border-gray-200' : 'bg-red-50 text-optique-red border-red-200' }}">
                        {{ $message->processed ? 'Traité' : 'Nouveau' }}
                    </span>
                </div>

                <p class="mt-3 text-sm text-optique-text whitespace-pre-line">{{ $message->message }}</p>

                <div class="mt-4 pt-3 border-t border-optique-border flex flex-wrap items-center gap-2 text-sm">
                    <a href="tel:{{ $digits }}" class="px-3 py-1.5 rounded-lg bg-gray-50 text-gray-700 hover:bg-gray-100">Appeler</a>
                    <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer"
                       class="px-3 py-1.5 rounded-lg bg-green-50 text-green-700 hover:bg-green-100">WhatsApp</a>
                    @if ($message->email)
                        <a href="mailto:{{ $message->email }}" class="px-3 py-1.5 rounded-lg bg-gray-50 text-gray-700 hover:bg-gray-100">E-mail</a>
                    @endif

                    <form method="POST" action="{{ route('admin.contact-requests.toggle-processed', $message) }}" class="ml-auto">
                        @csrf @method('PATCH')
                        <button type="submit" class="px-3 py-1.5 rounded-lg border border-optique-border text-optique-red hover:bg-red-50">
                            {{ $message->processed ? 'Remettre en nouveau' : 'Marquer comme traité' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.contact-requests.destroy', $message) }}"
                          onsubmit="return confirm('Supprimer ce message ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-2 py-1.5 text-gray-400 hover:text-red-600">Supprimer</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="bg-white border border-dashed border-optique-border rounded-2xl p-10 text-center text-optique-gray">
                Aucun message{{ $filter === 'new' ? ' à traiter' : '' }}. 🎉
            </div>
        @endforelse
    </div>

    {{ $messages->links() }}
</div>
@endsection
