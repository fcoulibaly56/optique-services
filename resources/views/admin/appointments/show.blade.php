@extends('layouts.admin')

@section('title', 'Détails du Rendez-vous')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 bg-[#F9F8F6] min-h-screen">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('admin.appointments.index') }}" class="text-gray-500 hover:text-[#A33B36] text-sm flex items-center gap-1 mb-4">
            &larr; Retour aux rendez-vous
        </a>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-6 sm:p-8">
            <!-- En-tête -->
            <div class="flex justify-between items-start border-b pb-4 mb-6">
                <div>
                    <h1 class="text-xl font-serif font-bold text-gray-800">Rendez-vous {{ $appointment->reference }}</h1>
                    <p class="text-sm text-gray-500">Créé le {{ $appointment->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm rounded-full
                    @if($appointment->status == 'confirme') bg-green-100 text-green-800
                    @elseif($appointment->status == 'termine') bg-blue-100 text-blue-800
                    @elseif($appointment->status == 'annule') bg-red-100 text-red-800
                    @elseif($appointment->status == 'deplace') bg-purple-100 text-purple-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ $appointment->status_label }}
                </span>
            </div>

            <!-- Infos Client -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-sm">
                <div class="space-y-2">
                    <h2 class="font-bold text-gray-700 border-b pb-1 mb-2">Client</h2>
                    <p><span class="text-gray-500 inline-block w-24">Nom :</span> <strong>{{ $appointment->customer?->last_name ?? $appointment->guest_name ?? '-' }}</strong></p>
                    <p><span class="text-gray-500 inline-block w-24">Prénom :</span> <strong>{{ $appointment->customer?->first_name ?? '-' }}</strong></p>
                    <p><span class="text-gray-500 inline-block w-24">Téléphone :</span> <strong>{{ $appointment->customer?->phone ?? $appointment->guest_phone ?? '-' }}</strong></p>
                    <p><span class="text-gray-500 inline-block w-24">Email :</span>
                        {{ ($appointment->customer?->email && !str_ends_with($appointment->customer->email, '@optique.local')) ? $appointment->customer->email : ($appointment->guest_email ?? '-') }}
                    </p>
                </div>
                <div class="space-y-2">
                    <h2 class="font-bold text-gray-700 border-b pb-1 mb-2">Rendez-vous</h2>
                    <p><span class="text-gray-500 inline-block w-24">Motif :</span> <strong>{{ $appointment->motive_label }}</strong></p>
                    <p><span class="text-gray-500 inline-block w-24">Date :</span> <strong>{{ $appointment->requested_at->format('d/m/Y à H:i') }}</strong></p>
                    <p><span class="text-gray-500 inline-block w-24">Durée :</span> {{ $appointment->duration_minutes }} min</p>
                    <p><span class="text-gray-500 inline-block w-24">Statut :</span> <strong>{{ $appointment->status_label }}</strong></p>
                </div>
            </div>

            <!-- Date proposée si décalé -->
            @if($appointment->status === 'deplace' && $appointment->proposed_at)
                <div class="bg-purple-50 border-l-4 border-purple-500 p-4 mb-6 rounded text-sm text-purple-800">
                    <strong>Nouvelle date proposée :</strong> {{ $appointment->proposed_at->format('d/m/Y à H:i') }}
                </div>
            @endif

            <!-- Commentaire -->
            @if($appointment->comment)
                <div class="mb-6 p-4 bg-gray-50 rounded-lg text-sm text-gray-700 italic">
                    "{{ $appointment->comment }}"
                </div>
            @endif

            <!-- Formulaire de mise à jour du statut -->
            @if($appointment->status !== 'termine')
                <div class="border-t pt-6">
                    <h3 class="font-bold text-gray-700 mb-3">Mettre à jour le statut</h3>
                    <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-start sm:items-end">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-xs text-gray-500">Statut</label>
                            <select name="status" class="rounded-md border-gray-300 text-sm w-full sm:w-48">
                                <option value="en_attente" {{ $appointment->status == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="confirme" {{ $appointment->status == 'confirme' ? 'selected' : '' }}>Confirmer</option>
                                <option value="deplace" {{ $appointment->status == 'deplace' ? 'selected' : '' }}>Décaler / Proposer une date</option>
                                <option value="termine" {{ $appointment->status == 'termine' ? 'selected' : '' }}>Terminé</option>
                                <option value="annule" {{ $appointment->status == 'annule' ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Nouvelle date (si décalé)</label>
                            <input type="datetime-local" name="proposed_at" value="{{ $appointment->proposed_at ? \Carbon\Carbon::parse($appointment->proposed_at)->format('Y-m-d\TH:i') : '' }}" class="rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500">Commentaire pour le client</label>
                            <input type="text" name="comment" value="{{ old('comment', $appointment->comment) }}" placeholder="Ex: Médecin indisponible..." class="w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <button type="submit" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm">Mettre à jour</button>
                    </form>
                </div>
            @else
                <div class="bg-gray-100 text-gray-600 p-3 rounded text-sm text-center">
                    Ce rendez-vous est terminé et ne peut plus être modifié.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
