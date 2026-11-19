@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-2xl mx-auto">
    <a href="{{ route('admin.purchases.show', $purchase) }}" class="text-sm text-gray-500 mb-4 block">&larr; Retour</a>

    <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
        <h1 class="text-xl font-bold mb-4">Modifier l'Achat {{ $purchase->reference }}</h1>

        <div class="bg-yellow-50 text-yellow-800 p-3 rounded text-sm mb-6 border border-yellow-200">
            ⚠️ Attention : Changer le statut modifiera le stock des produits concernés.
        </div>

        <form action="{{ route('admin.purchases.update', $purchase) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm text-gray-600 mb-1">Date de réception</label>
                <input type="date" name="purchase_date" value="{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}" class="w-full rounded-md border-gray-300 text-sm">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Statut</label>
                <select name="status" class="w-full rounded-md border-gray-300 text-sm">
                    <option value="en_attente" {{ $purchase->status == 'en_attente' ? 'selected' : '' }}>En attente (Stock inchangé)</option>
                    <option value="recu" {{ $purchase->status == 'recu' ? 'selected' : '' }}>Reçu (Ajoute au stock)</option>
                    <option value="annule" {{ $purchase->status == 'annule' ? 'selected' : '' }}>Annulé (Retire du stock)</option>
                </select>
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded-md text-sm">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
@endsection
