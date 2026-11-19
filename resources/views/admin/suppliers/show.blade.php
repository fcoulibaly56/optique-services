@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-3xl mx-auto">
    <a href="{{ route('admin.suppliers.index') }}" class="text-sm text-gray-500 mb-4 block">&larr; Retour aux fournisseurs</a>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-serif font-bold text-gray-800">{{ $supplier->name }}</h1>
                <p class="text-gray-500 text-sm mt-1">{{ $supplier->contact_name }} - {{ $supplier->phone }}</p>
                <p class="text-gray-500 text-sm">{{ $supplier->address }}</p>
            </div>
            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="bg-blue-50 text-blue-600 px-3 py-1 rounded-md text-sm">Modifier</a>
        </div>
    </div>

    <h2 class="text-lg font-bold text-gray-800 mb-3">Historique des Achats</h2>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-gray-500">
                    <th class="p-4 font-medium">Réf.</th>
                    <th class="p-4 font-medium">Date</th>
                    <th class="p-4 font-medium">Montant</th>
                    <th class="p-4 font-medium">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($supplier->purchases as $purchase)
                <tr>
                    <td class="p-4 font-medium text-gray-900">{{ $purchase->reference }}</td>
                    <td class="p-4 text-gray-500">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</td>
                    <td class="p-4 font-medium">{{ number_format($purchase->total_amount, 0, ',', ' ') }} F</td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $purchase->status == 'recu' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-4 text-center text-gray-500">Aucun achat avec ce fournisseur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
