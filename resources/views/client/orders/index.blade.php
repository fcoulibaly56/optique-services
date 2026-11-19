@extends('layouts.client')
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-serif font-bold text-gray-800 mb-6">Mes Commandes</h1>

    <div class="space-y-4">
        @forelse($orders as $order)
            <a href="{{ route('client.orders.show', $order) }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:border-[#A33B36] transition">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-bold text-gray-900">{{ $order->reference }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($order->status == 'livre_paye') bg-green-100 text-green-800
                        @elseif($order->status == 'annulee') bg-red-100 text-red-800
                        @elseif($order->status == 'livraison_en_cours') bg-blue-100 text-blue-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
                <div class="flex justify-between items-center border-t pt-3 mt-2 text-sm">
                    <span class="text-gray-500">Total : {{ number_format($order->net_to_pay, 0, ',', ' ') }} F</span>
                    <span class="text-[#A33B36] font-medium">Détails &rarr;</span>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center text-gray-500">
                Vous n'avez aucune commande pour le moment.
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</div>
@endsection
