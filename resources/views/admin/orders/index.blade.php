@extends('layouts.admin')
@section('title', 'Commandes')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Gestion des Commandes</h1>
        <a href="{{ route('admin.orders.create') }}" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm hover:bg-opacity-90">+ Nouvelle Commande</a>
    </div>

    <!-- Les 3 Classeurs Digitaux (Onglets) -->
    <div class="flex border-b border-gray-200 mb-6 overflow-x-auto bg-white rounded-t-lg shadow-sm">
        <a href="{{ route('admin.orders.index', ['status' => 'en_cours']) }}" class="px-4 py-3 text-sm font-medium whitespace-nowrap {{ request('status') == 'en_cours' || !request('status') ? 'border-b-2 border-[#A33B36] text-[#A33B36] bg-red-50' : 'text-gray-500 hover:text-gray-700' }}">
            ⏳ En cours de traitement ({{ $counters['en_cours'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'livraison_en_cours']) }}" class="px-4 py-3 text-sm font-medium whitespace-nowrap {{ request('status') == 'livraison_en_cours' ? 'border-b-2 border-[#A33B36] text-[#A33B36] bg-red-50' : 'text-gray-500 hover:text-gray-700' }}">
            📦 Prêtes à livrer ({{ $counters['livraison'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'livre_paye']) }}" class="px-4 py-3 text-sm font-medium whitespace-nowrap {{ request('status') == 'livre_paye' ? 'border-b-2 border-[#A33B36] text-[#A33B36] bg-red-50' : 'text-gray-500 hover:text-gray-700' }}">
            ✅ Livrées & Payées ({{ $counters['livre'] }})
        </a>
    </div>

        <!-- Barre de recherche -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col lg:flex-row gap-3 items-center">
            <input type="hidden" name="status" value="{{ request('status', 'en_cours') }}">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Client, téléphone, réf..."
                class="rounded-md border-gray-300 text-sm w-full lg:w-1/3 focus:ring-[#A33B36] focus:border-[#A33B36]">

            <div class="flex items-center gap-2 w-full lg:w-auto">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-md border-gray-300 text-sm">
                <span class="text-gray-400 text-sm">au</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-md border-gray-300 text-sm">
            </div>

            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm w-full lg:w-auto hover:bg-gray-700">Filtrer</button>

            @if(request()->anyFilled(['search', 'date_from', 'date_to']))
                <a href="{{ route('admin.orders.index', ['status' => request('status')]) }}" class="text-sm text-gray-500 hover:text-red-500 whitespace-nowrap">Réinitialiser</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase">Réf.</th>
                    <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase">Client</th>
                    <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase">Montant</th>
                    <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase">Reste</th>
                    <th class="px-6 py-3 text-right text-xs text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium">{{ $order->reference }}</td>
                        <td class="px-6 py-4 text-sm">{{ $order->customer->last_name }} {{ $order->customer->first_name }}</td>
                        <td class="px-6 py-4 text-sm">{{ number_format($order->total_amount, 0, ',', ' ') }} F</td>
                        <td class="px-6 py-4 text-sm text-red-600 font-bold">{{ number_format($order->remaining_amount, 0, ',', ' ') }} F</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-[#A33B36] bg-red-50 px-3 py-1 rounded-md text-sm">Détails</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune commande dans ce classeur.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
