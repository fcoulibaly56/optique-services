@extends('layouts.admin')

@section('title', 'Dossier Client')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 bg-[#F9F8F6] min-h-screen">
    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-gray-500 hover:text-[#A33B36] text-sm mb-2 block">&larr; Retour aux clients</a>
        <h1 class="text-2xl font-serif font-bold text-gray-800">{{ $customer->last_name }} {{ $customer->first_name }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Infos Client -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 h-fit">
            <h2 class="font-bold text-gray-800 border-b pb-2 mb-4">Informations</h2>
            <div class="space-y-3 text-sm">
                <p><span class="text-gray-500 block">Téléphone</span> <strong>{{ $customer->phone }}</strong></p>
                <p><span class="text-gray-500 block">Email</span>
                    {{ ($customer->email && !str_ends_with($customer->email, '@optique.local')) ? $customer->email : '-' }}
                </p>
                <p><span class="text-gray-500 block">Adresse</span> {{ $customer->address ?? '-' }}</p>
                <p><span class="text-gray-500 block">Profession</span> {{ $customer->profession ?? '-' }}</p>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <!-- Historique Commandes -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="font-bold text-gray-800 border-b pb-2 mb-4">Historique des Commandes</h2>
                @forelse($customer->orders as $order)
                    <div class="flex justify-between items-center py-3 border-b last:border-0 text-sm">
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->reference }}</p>
                            <p class="text-gray-500 text-xs">{{ $order->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</p>
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-[#A33B36] text-xs hover:underline">Voir</a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Aucune commande.</p>
                @endforelse
            </div>

            <!-- Historique Rendez-vous -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="font-bold text-gray-800 border-b pb-2 mb-4">Historique des Rendez-vous</h2>
                @forelse($customer->appointments as $appointment)
                    <div class="flex justify-between items-center py-3 border-b last:border-0 text-sm">
                        <div>
                            <p class="font-medium text-gray-900">{{ $appointment->motive_label }}</p>
                            <p class="text-gray-500 text-xs">{{ $appointment->requested_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($appointment->status == 'confirme') bg-green-100 text-green-800
                                @elseif($appointment->status == 'termine') bg-blue-100 text-blue-800
                                @elseif($appointment->status == 'annule') bg-red-100 text-red-800
                                @elseif($appointment->status == 'deplace') bg-purple-100 text-purple-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $appointment->status_label }}
                            </span>
                            <br>
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-[#A33B36] text-xs hover:underline mt-1 inline-block">Voir</a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Aucun rendez-vous.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
