@extends('layouts.public')

@section('title', 'Mon rendez-vous — Optique Services')

@section('content')
<section class="relative isolate overflow-hidden bg-[#fbf8f6] min-h-[60vh]">
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-16">
        <a href="{{ route('appointment.track') }}" class="mb-6 inline-flex items-center gap-2 text-xs font-semibold text-optique-gray transition hover:text-optique-red"><span aria-hidden="true">←</span> Nouvelle recherche</a>

        @php
            $statusColors = [
                'en_attente' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
                'confirme'   => 'bg-green-50 border-green-200 text-green-800',
                'deplace'    => 'bg-purple-50 border-purple-200 text-purple-800',
                'termine'    => 'bg-gray-50 border-gray-200 text-gray-800',
                'annule'     => 'bg-red-50 border-red-200 text-red-800',
            ];
            $colorClass = $statusColors[$appointment->status] ?? 'bg-gray-50 border-gray-200 text-gray-800';
        @endphp

        <div class="bg-white rounded-2xl border border-optique-border shadow-md overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-100">
                <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Rendez-vous trouvé</p>
                <h1 class="mt-2 font-serif text-2xl sm:text-3xl text-optique-text">{{ $appointment->reference }}</h1>
            </div>

            <!-- Statut en grand -->
            <div class="p-6 sm:p-8">
                <div class="rounded-xl border-2 {{ $colorClass }} p-5 text-center">
                    <p class="text-xs uppercase font-bold tracking-wider mb-1">Statut actuel</p>
                    <p class="text-2xl font-bold">{{ $appointment->status_label }}</p>
                </div>

                @if($appointment->status === 'deplace' && $appointment->proposed_at)
                    <div class="mt-4 rounded-xl bg-purple-50 border border-purple-200 p-4 text-sm text-purple-800">
                        <strong>📅 Nouvelle date proposée par l'équipe :</strong><br>
                        {{ $appointment->proposed_at->translatedFormat('l d F Y à H:i') }}
                    </div>
                @endif

                <!-- Détails -->
                <dl class="mt-6 space-y-3 text-sm">
                    <div class="flex justify-between border-b pb-2">
                        <dt class="text-gray-500">Motif</dt>
                        <dd class="font-semibold">{{ $appointment->motive_label }}</dd>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <dt class="text-gray-500">Date demandée</dt>
                        <dd class="font-semibold">{{ $appointment->requested_at->translatedFormat('l d F Y à H:i') }}</dd>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <dt class="text-gray-500">Client</dt>
                        <dd class="font-semibold">{{ $appointment->customer?->first_name ?? $appointment->guest_name }}</dd>
                    </div>
                </dl>

                @if($appointment->comment)
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg text-sm italic text-gray-700">
                        💬 "{{ $appointment->comment }}"
                    </div>
                @endif

                <!-- Actions -->
                <div class="mt-6 space-y-2">
                    <a href="tel:{{ config('shop.phones.0.tel') }}"
                       class="block w-full text-center bg-gray-100 text-gray-800 py-3 rounded-xl font-semibold hover:bg-gray-200 transition text-sm">
                        📞 Appeler le magasin
                    </a>
                    <a href="https://wa.me/{{ config('shop.whatsapp') }}?text={{ rawurlencode('Bonjour, je souhaite des informations sur mon RDV ' . $appointment->reference) }}"
                       target="_blank"
                       class="block w-full text-center bg-green-500 text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition text-sm">
                        💬 Contacter par WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
