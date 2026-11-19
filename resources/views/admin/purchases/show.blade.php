@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-3xl mx-auto">
    <a href="{{ route('admin.purchases.index') }}" class="text-sm text-gray-500 mb-4 block">&larr; Retour</a>
    <div class="bg-white rounded-xl shadow p-6 border">
        <h1 class="text-xl font-bold mb-2">Entrée de Stock : {{ $purchase->reference }}</h1>
        <p class="text-sm text-gray-500 mb-4">Provenance : <strong>{{ $purchase->supplier_name }}</strong> | Date : {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</p>

        <table class="w-full text-sm mb-4">
            <thead><tr class="border-b text-left"><th class="py-2">Produit</th><th>Qté reçue</th></tr></thead>
            <tbody>
                @foreach($purchase->items as $item)
                <tr class="border-b">
                    <td class="py-2">{{ $item->product->name }}</td>
                    <td class="font-bold text-green-600">+ {{ $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-right text-sm text-gray-500">Le stock a été automatiquement mis à jour.</p>
    </div>
</div>
@endsection
