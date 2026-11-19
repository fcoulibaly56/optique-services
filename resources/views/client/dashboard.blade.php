@extends('layouts.client')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 mt-2">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Bonjour, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-gray-500">Bienvenue sur votre espace personnel.</p>
    </div>

    <!-- Commande en cours -->
    <h2 class="text-sm uppercase font-bold text-gray-500 mb-2">Suivi de commande</h2>
    @if($activeOrder)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6 border-l-4 border-[#A33B36]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-bold text-gray-900">Commande {{ $activeOrder->reference }}</p>
                    <p class="text-xs text-gray-500">{{ $activeOrder->created_at->format('d/m/Y') }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full {{ $activeOrder->status == 'en_cours' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $activeOrder->status == 'en_cours' ? 'En cours' : 'Prête' }}
                </span>
            </div>
            <div class="mt-4 flex justify-between items-center border-t pt-3">
                <p class="text-sm font-bold text-red-600">Reste : {{ number_format($activeOrder->remaining_amount, 0, ',', ' ') }} F</p>
                <a href="{{ route('client.orders.show', $activeOrder) }}" class="text-sm text-[#A33B36] font-medium">Suivre &rarr;</a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6 text-center text-gray-500 text-sm">
            Aucune commande en cours.
        </div>
    @endif

    <!-- Rendez-vous -->
    <h2 class="text-sm uppercase font-bold text-gray-500 mb-2">Prochain rendez-vous</h2>
    @if($nextAppointment)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
            <p class="font-bold text-gray-900">{{ ucfirst(str_replace('_', ' ', $nextAppointment->motive)) }}</p>
            <p class="text-sm text-gray-600 mt-1">
                📅 {{ \Carbon\Carbon::parse($nextAppointment->requested_at)->format('d/m/Y à H:i') }}
            </p>
            <div class="mt-3">
                <span class="px-2 py-1 text-xs rounded-full {{ $nextAppointment->status == 'confirme' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $nextAppointment->status == 'confirme' ? 'Confirmé' : 'En attente de validation' }}
                </span>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6 text-center text-gray-500 text-sm">
            Aucun rendez-vous prévu.
            <a href="{{ route('client.appointments.index') }}" class="text-[#A33B36] block mt-2">Prendre un rendez-vous</a>
        </div>
    @endif
</div>
@endsection
