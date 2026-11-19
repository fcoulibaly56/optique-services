@extends('layouts.client')
@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('client.orders.index') }}" class="text-sm text-gray-500 mb-4 block">&larr; Retour</a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h1 class="text-xl font-bold text-gray-900 mb-1">Commande {{ $order->reference }}</h1>
        <p class="text-sm text-gray-500 mb-4">Passée le {{ $order->created_at->format('d/m/Y') }}</p>

        <!-- Statut Actuel -->
        <div class="bg-gray-50 p-4 rounded-lg text-center mb-6 border border-gray-200">
            <p class="text-xs uppercase text-gray-500 font-bold mb-1">Statut actuel</p>
            <p class="text-lg font-bold
                @if($order->status == 'livre_paye') text-green-600
                @elseif($order->status == 'annulee') text-red-600
                @else text-[#A33B36] @endif">
                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </p>
            <a href="{{ route('client.messages.index', ['subject' => 'Question sur la commande ' . $order->reference]) }}"
   class="mt-4 block w-full text-center bg-gray-100 text-[#A33B36] font-medium py-2 rounded-lg hover:bg-gray-200 transition text-sm">
    💬 Contacter l'équipe à propos de cette commande
</a>
        </div>

        <!-- Détails Facturation -->
        <h2 class="font-bold text-gray-800 border-b pb-2 mb-3">Détails</h2>
        <div class="space-y-2 text-sm mb-6">
            <div class="flex justify-between"><span>Monture :</span> <span class="font-medium">{{ $order->frame_reference ?? 'P.E.C' }}</span></div>
            <div class="flex justify-between"><span>Prix Monture :</span> <span class="font-medium">{{ number_format($order->frame_price, 0, ',', ' ') }} F</span></div>
            <div class="flex justify-between"><span>Prix Verre :</span> <span class="font-medium">{{ number_format($order->lens_price, 0, ',', ' ') }} F</span></div>
            <div class="flex justify-between border-t pt-2 font-bold text-[#A33B36]"><span>Net à payer :</span> <span>{{ number_format($order->net_to_pay, 0, ',', ' ') }} F</span></div>
            <div class="flex justify-between text-red-600"><span>Reste à payer :</span> <span>{{ number_format($order->remaining_amount, 0, ',', ' ') }} F</span></div>
        </div>

        <!-- Ordonnance (lecture seule) -->
        @if($order->prescription)
        <h2 class="font-bold text-gray-800 border-b pb-2 mb-3">Ordonnance</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-xs border-collapse border border-gray-300 text-center">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border p-1"></th>
                        <th class="border p-1">SPH</th>
                        <th class="border p-1">CYL</th>
                        <th class="border p-1">AXE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-1 font-bold bg-gray-50">OD</td>
                        <td class="border p-1">{{ $order->prescription->od_sph ?? '-' }}</td>
                        <td class="border p-1">{{ $order->prescription->od_cyl ?? '-' }}</td>
                        <td class="border p-1">{{ $order->prescription->od_axis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 font-bold bg-gray-50">OG</td>
                        <td class="border p-1">{{ $order->prescription->og_sph ?? '-' }}</td>
                        <td class="border p-1">{{ $order->prescription->og_cyl ?? '-' }}</td>
                        <td class="border p-1">{{ $order->prescription->og_axis ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-xs text-gray-500 mt-2">Type de verres : <strong>{{ $order->prescription->lens_type ?? '-' }}</strong></p>
        </div>
        @endif
    </div>
</div>
@endsection
