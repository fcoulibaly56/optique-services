@extends('layouts.client')
@section('content')
<div class="max-w-2xl mx-auto" x-data="{ showForm: false }">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Mes Rendez-vous</h1>
        <button @click="showForm = !showForm" class="bg-[#A33B36] text-white px-3 py-1.5 rounded-md text-sm">
            + Demander
        </button>
    </div>

    <!-- Formulaire de demande -->
    <div x-show="showForm" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6" style="display: none;" x-transition>
        <h2 class="font-bold text-gray-800 mb-4">Nouvelle demande</h2>
        <form action="{{ route('client.appointments.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm text-gray-600 mb-1">Motif</label>
                <select name="motive" required class="w-full rounded-md border-gray-300 text-sm">
                    <option value="eye_exam">Examen de la vue</option>
                    <option value="frame_try_on">Essayage de monture</option>
                    <option value="pick_up">Retrait de commande</option>
                    <option value="other">Autre</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Date et heure souhaitées</label>
                <input type="datetime-local" name="requested_at" required class="w-full rounded-md border-gray-300 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Commentaire (optionnel)</label>
                <textarea name="comment" rows="2" class="w-full rounded-md border-gray-300 text-sm"></textarea>
            </div>
            <button type="submit" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm w-full">Envoyer la demande</button>
        </form>
    </div>

    <!-- Liste des RDV -->
    <div class="space-y-4">
        @forelse($appointments as $app)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex justify-between items-start mb-2">
                    <p class="font-bold text-gray-900">
                        {{ $app->motive_label }}
                    </p>
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($app->status == 'confirme') bg-green-100 text-green-800
                        @elseif($app->status == 'annule') bg-red-100 text-red-800
                        @elseif($app->status == 'termine') bg-gray-100 text-gray-800
                        @elseif($app->status == 'deplace') bg-purple-100 text-purple-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $app->status_label }}
                    </span>
                </div>
                <p class="text-sm text-gray-600">
                    📅 Date demandée : <strong>{{ \Carbon\Carbon::parse($app->requested_at)->format('d/m/Y à H:i') }}</strong>
                </p>
                @if($app->status == 'deplace' && $app->proposed_at)
                    <p class="text-sm text-purple-600 mt-1">L'équipe propose : {{ \Carbon\Carbon::parse($app->proposed_at)->format('d/m/Y à H:i') }}</p>
                @endif
                @if($app->comment)
                    <p class="text-xs text-gray-500 mt-2 italic">"{{ $app->comment }}"</p>
                @endif
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">Aucun rendez-vous pour le moment.</div>
        @endforelse
    </div>
</div>
@endsection
