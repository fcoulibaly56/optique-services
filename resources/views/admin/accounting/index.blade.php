@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Comptabilité</h1>

        <!-- Filtre de dates -->
        <form method="GET" class="flex gap-2 items-center bg-white p-2 rounded-lg border border-gray-200">
            <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-md border-gray-300 text-sm">
            <span class="text-gray-400">au</span>
            <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-md border-gray-300 text-sm">
            <button type="submit" class="bg-gray-800 text-white px-3 py-2 rounded-md text-sm">Filtrer</button>
        </form>
    </div>

    <!-- Résumé -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-green-50 p-6 rounded-xl border border-green-200">
            <p class="text-green-700 text-sm uppercase font-semibold">Chiffre d'Affaires (Sur la période)</p>
            <p class="text-4xl font-bold text-green-700 mt-2">{{ number_format($totalRevenue, 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <p class="text-gray-500 text-sm uppercase font-semibold">Commandes Livrées & Payées</p>
            <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalOrders }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Détail des assurances -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h2 class="font-bold text-gray-800 mb-3 border-b pb-2">À percevoir des assurances</h2>
            @forelse($insuranceTotals as $total)
                <div class="flex justify-between py-2 border-b last:border-0 text-sm">
                    <span>{{ $total['name'] }} ({{ $total['count'] }} cmd)</span>
                    <span class="font-bold">{{ number_format($total['total'], 0, ',', ' ') }} F</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Aucune commande avec assurance sur cette période.</p>
            @endforelse
        </div>

        <!-- Dernières commandes payées -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 overflow-hidden">
            <h2 class="font-bold text-gray-800 mb-3 border-b pb-2">Dernières commandes payées</h2>
            <table class="w-full text-sm">
                <tbody>
                    @forelse($paidOrders->take(5) as $order)
                        <tr class="border-b">
                            <td class="py-2">{{ $order->customer->last_name }}</td>
                            <td class="py-2 font-medium">{{ number_format($order->net_to_pay, 0, ',', ' ') }} F</td>
                        </tr>
                    @empty
                        <tr><td class="py-2 text-gray-500">Aucune commande.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
