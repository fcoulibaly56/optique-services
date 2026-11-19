@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 bg-[#F9F8F6] min-h-screen">
    <h1 class="text-2xl font-serif font-bold text-gray-800 mb-6">Tableau de bord</h1>

    <!-- ALERTES STOCK -->
    @if($lowStockProducts->count() > 0)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <h3 class="text-red-800 font-bold mb-2 flex items-center">
                ⚠️ Alertes de Stock ({{ $lowStockProducts->count() }})
            </h3>
            <ul class="text-sm text-red-700 space-y-1">
                @foreach($lowStockProducts as $product)
                    <li>• <strong>{{ $product->name }}</strong> : {{ $product->stock }} restant(s)</li>
                @endforeach
            </ul>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-red-600 font-medium underline mt-2 block">Gérer le stock &rarr;</a>
        </div>
    @endif

    <!-- STATISTIQUES -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs uppercase font-semibold">Commandes en cours</p>
            <p class="text-3xl font-bold text-[#A33B36] mt-2">{{ $stats['orders_active'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs uppercase font-semibold">Prêtes à livrer</p>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $stats['orders_ready'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs uppercase font-semibold">RDV Aujourd'hui</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['appointments_today'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs uppercase font-semibold">Total Clients</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['customers_total'] }}</p>
        </div>
    </div>

    <!-- COMMANDES RÉCENTES -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="font-bold text-gray-800">Dernières commandes</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#A33B36] hover:underline">Voir tout</a>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <tbody class="divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $order->reference }}</td>
                        <td class="px-6 py-3 text-sm text-gray-500">{{ $order->customer->last_name }} {{ $order->customer->first_name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-[#A33B36] text-sm font-medium">Voir</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune commande récente.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
