@extends('layouts.admin')

@section('title', 'Gestion des Rendez-vous')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 bg-[#F9F8F6] min-h-screen">

    <!-- En-tête & Compteurs -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Gestion des Rendez-vous</h1>

        <div class="flex gap-3 text-sm">
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <span class="text-gray-500 block text-xs uppercase">Aujourd'hui</span>
                <span class="font-bold text-[#A33B36]">{{ $counters['today'] }}</span>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <span class="text-gray-500 block text-xs uppercase">En attente</span>
                <span class="font-bold text-yellow-600">{{ $counters['pending'] }}</span>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <span class="text-gray-500 block text-xs uppercase">Confirmés</span>
                <span class="font-bold text-green-600">{{ $counters['confirmed'] }}</span>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('admin.appointments.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Client, téléphone, réf..."
                class="rounded-md border-gray-300 shadow-sm focus:border-[#A33B36] focus:ring-[#A33B36] text-sm">

            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-[#A33B36] focus:ring-[#A33B36] text-sm">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="confirme" {{ request('status') == 'confirme' ? 'selected' : '' }}>Confirmé</option>
                <option value="termine" {{ request('status') == 'termine' ? 'selected' : '' }}>Terminé</option>
                <option value="annule" {{ request('status') == 'annule' ? 'selected' : '' }}>Annulé</option>
                <option value="deplace" {{ request('status') == 'deplace' ? 'selected' : '' }}>Déplacé</option>
            </select>

            <input type="date" name="date" value="{{ request('date') }}"
                class="rounded-md border-gray-300 shadow-sm focus:border-[#A33B36] focus:ring-[#A33B36] text-sm">

            <button type="submit" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm hover:bg-opacity-90 transition">
                Filtrer
            </button>
        </form>
    </div>

    <!-- Vue Mobile (Cartes) -->
    <div class="md:hidden space-y-4">
        @forelse($appointments as $appointment)
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[#A33B36]">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-xs font-semibold text-gray-500">{{ $appointment->reference }}</span>
                        <p class="font-medium text-gray-900 mt-1">
                            {{ $appointment->customer ? $appointment->customer->last_name . ' ' . $appointment->customer->first_name : $appointment->guest_name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $appointment->customer ? $appointment->customer->phone : $appointment->guest_phone }}
                        </p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($appointment->status == 'confirme') bg-green-100 text-green-800
                        @elseif($appointment->status == 'termine') bg-blue-100 text-blue-800
                        @elseif($appointment->status == 'annule') bg-red-100 text-red-800
                        @elseif($appointment->status == 'deplace') bg-purple-100 text-purple-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $appointment->status_label }}
                    </span>
                </div>
                <div class="mt-3 text-sm text-gray-600">
                    <p><strong>Motif :</strong> {{ $appointment->motive_label }}</p>
                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($appointment->requested_at)->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="mt-4 flex justify-between items-center border-t pt-3">
                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-[#A33B36] text-sm font-medium hover:underline">Voir détails &rarr;</a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">Aucun rendez-vous trouvé.</p>
        @endforelse
    </div>

    <!-- Vue Desktop (Tableau) -->
    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Réf.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Heure</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $appointment->reference }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $appointment->customer ? $appointment->customer->last_name . ' ' . $appointment->customer->first_name : $appointment->guest_name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $appointment->customer ? $appointment->customer->phone : $appointment->guest_phone }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $appointment->motive_label }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($appointment->requested_at)->format('d/m/Y à H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($appointment->status == 'confirme') bg-green-100 text-green-800
                                @elseif($appointment->status == 'termine') bg-blue-100 text-blue-800
                                @elseif($appointment->status == 'annule') bg-red-100 text-red-800
                                @elseif($appointment->status == 'deplace') bg-purple-100 text-purple-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $appointment->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-[#A33B36] hover:text-red-900 bg-red-50 px-3 py-1 rounded-md transition">Détails</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucun rendez-vous trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $appointments->links() }}
        </div>
    </div>

</div>
@endsection
