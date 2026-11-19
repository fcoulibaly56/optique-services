@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-4xl mx-auto">
    <a href="{{ route('admin.insurances.index') }}" class="text-sm text-gray-500 mb-4 block">&larr; Retour aux assurances</a>
    <h1 class="text-2xl font-serif font-bold text-gray-800 mb-6">Commandes : {{ $insurance->name }}</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-gray-500">
                    <th class="p-4">Client</th>
                    <th class="p-4">Réf. Commande</th>
                    <th class="p-4">Net à payer</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4 text-right"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-medium">{{ $order->customer->last_name }} {{ $order->customer->first_name }}</td>
                        <td class="p-4">{{ $order->reference }}</td>
                        <td class="p-4">{{ number_format($order->net_to_pay, 0, ',', ' ') }} F</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $order->status == 'livre_paye' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-[#A33B36]">Détails</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-4 text-center text-gray-500">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
