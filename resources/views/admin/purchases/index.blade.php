@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Stock & Achats</h1>
        <a href="{{ route('admin.purchases.create') }}" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm w-full sm:w-auto text-center hover:bg-opacity-90">+ Nouvel Achat</a>
    </div>

    <!-- Mobile -->
    <div class="md:hidden space-y-4">
        @forelse($purchases as $purchase)
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-gray-400">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-medium text-gray-900">{{ $purchase->reference }}</p>
                        <p class="text-sm text-gray-500">{{ $purchase->supplier_name }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $purchase->status == 'recu' ? 'bg-green-100 text-green-800' : ($purchase->status == 'annule' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($purchase->status) }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 mb-3">Date: {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</p>
                <div class="flex justify-between items-center border-t pt-3">
                    <span class="font-bold text-sm">{{ number_format($purchase->total_amount, 0, ',', ' ') }} FCFA</span>
                    <a href="{{ route('admin.purchases.show', $purchase) }}" class="text-[#A33B36] text-sm font-medium">Détails &rarr;</a>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-4">Aucun achat trouvé.</p>
        @endforelse
    </div>

    <!-- Desktop -->
    <div class="hidden md:block bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Réf.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Provenance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Articles</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($purchases as $purchase)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $purchase->reference }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $purchase->supplier_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $purchase->items->sum('quantity') }} unité(s)</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $purchase->status == 'recu' ? 'bg-green-100 text-green-800' : ($purchase->status == 'annule' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($purchase->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.purchases.show', $purchase) }}" class="text-[#A33B36] bg-red-50 px-3 py-1 rounded-md transition">Détails</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucun achat trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $purchases->links() }}
        </div>
    </div>
</div>
@endsection
