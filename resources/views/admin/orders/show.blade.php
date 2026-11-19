@extends('layouts.admin')

@section('title', 'Fiche Commande ' . $order->reference)

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 bg-[#F9F8F6] min-h-screen">
    <div class="max-w-4xl mx-auto">

        <!-- En-tête & Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-[#A33B36] text-sm flex items-center gap-1 mb-2">
                    &larr; Retour aux commandes
                </a>
                <h1 class="text-2xl font-serif font-bold text-gray-800">Fiche N° {{ $order->reference }}</h1>
            </div>

            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.orders.edit', $order) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm text-center flex-1 sm:flex-none hover:bg-blue-700">Modifier</a>
                <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm flex-1 sm:flex-none hover:bg-gray-900">🖨️ Imprimer</button>
            </div>
        </div>

        <!-- Le Document -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-6 sm:p-8">

            <!-- En-tête Fiche -->
            <div class="flex justify-between items-start border-b pb-4 mb-6">
                <div>
                    <h2 class="text-lg font-serif font-bold text-[#A33B36]">Optique Services</h2>
                    <p class="text-xs text-gray-500">ACI 2000, Bamako, Mali</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold">Date : {{ $order->created_at->format('d/m/Y') }}</p>
                    <p class="text-xs text-gray-500">Créé par : {{ $order->creator->name ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Infos Client -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-sm">
                <div class="space-y-2">
                    <p><span class="text-gray-500 w-32 inline-block">Nom :</span> <strong>{{ $order->customer->last_name }}</strong></p>
                    <p><span class="text-gray-500 w-32 inline-block">Prénom :</span> <strong>{{ $order->customer->first_name }}</strong></p>
                    <p><span class="text-gray-500 w-32 inline-block">Contact :</span> <strong>{{ $order->customer->phone }}</strong></p>
                </div>
                <div class="space-y-2">
                    <p><span class="text-gray-500 w-32 inline-block">Profession :</span> {{ $order->customer->profession ?? '-' }}</p>
                    <p><span class="text-gray-500 w-32 inline-block">Adresse :</span> {{ $order->customer->address ?? '-' }}</p>
                    <p><span class="text-gray-500 w-32 inline-block">Assurance (P.E.C) :</span> <strong>{{ $order->insurance->name ?? 'Aucune' }}</strong></p>
                </div>
            </div>

            <!-- Ordonnance -->
            <div class="mb-8">
                <h3 class="font-bold text-gray-700 border-b pb-2 mb-2">Ordonnance</h3>
                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <p><span class="text-gray-500">Date :</span> {{ $order->prescription->prescription_date ?? '-' }}</p>
                    <p><span class="text-gray-500">Médecin :</span> {{ $order->prescription->doctor_name ?? '-' }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border p-2 text-left w-16"></th>
                                <th class="border p-2">SPH</th>
                                <th class="border p-2">CYL</th>
                                <th class="border p-2">AXE</th>
                                <th class="border p-2">ADD</th>
                                <th class="border p-2">E.P</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2 font-bold bg-gray-50">OD</td>
                                <td class="border p-2 text-center">{{ $order->prescription->od_sph ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ $order->prescription->od_cyl ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ $order->prescription->od_axis ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ $order->prescription->od_add ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ $order->prescription->od_ep ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border p-2 font-bold bg-gray-50">OG</td>
                                <td class="border p-2 text-center">{{ $order->prescription->og_sph ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ $order->prescription->og_cyl ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ $order->prescription->og_axis ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ $order->prescription->og_add ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ $order->prescription->og_ep ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                                    <div class="mt-2 text-sm">
                    <span class="text-gray-500">Type de Verres :</span> <strong>{{ $order->prescription->lens_type ?? '-' }}</strong>
                </div>
                </div>
            </div>

            <!-- Facturation -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t pt-6">
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-500">Réf. Monture :</span> {{ $order->frame_reference ?? '-' }}</p>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between border-b pb-1">
                        <span class="text-gray-500">Prix Monture :</span>
                        <span class="font-medium">{{ number_format($order->frame_price, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between border-b pb-1">
                        <span class="text-gray-500">Prix Verre :</span>
                        <span class="font-medium">{{ number_format($order->lens_price, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between border-b pb-1">
                        <span class="text-gray-500">Total :</span>
                        <span class="font-medium">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between border-b pb-1">
                        <span class="text-gray-500">Remise :</span>
                        <span class="font-medium">-{{ number_format($order->discount, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between text-base font-bold text-[#A33B36] pt-2">
                        <span>Net à payer :</span>
                        <span>{{ number_format($order->net_to_pay, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Paiements & Statut -->
            <div class="mt-6 pt-4 border-t border-dashed flex flex-col sm:flex-row justify-between items-start sm:items-end text-sm gap-4">
                <div class="space-y-1">
                    <p><span class="text-gray-500 font-medium">Acompte :</span> {{ number_format($order->deposit_amount, 0, ',', ' ') }} FCFA</p>
                    <p class="text-red-600 font-bold"><span class="text-gray-500 font-medium">Reste à payer :</span> {{ number_format($order->remaining_amount, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="text-right w-full sm:w-auto">
                    <p class="text-gray-500 mb-1">Date de Livraison :</p>
                    <p class="font-bold text-lg">{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') : 'À définir' }}</p>
                </div>
            </div>
        </div>
        <!-- Formulaire de mise à jour du statut -->
        <div class="mt-6 bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="font-bold text-gray-800 mb-3">Mettre à jour le statut de la commande</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf @method('PATCH')
                <select name="status" class="rounded-md border-gray-300 text-sm w-full sm:w-64 focus:border-[#A33B36] focus:ring-[#A33B36]">
                    <option value="en_cours" {{ $order->status == 'en_cours' ? 'selected' : '' }}>⏳ En cours de traitement</option>
                    <option value="livraison_en_cours" {{ $order->status == 'livraison_en_cours' ? 'selected' : '' }}>📦 Prête à livrer</option>
                    <option value="livre_paye" {{ $order->status == 'livre_paye' ? 'selected' : '' }}>✅ Livrée & Payée</option>
                    <option value="annulee" {{ $order->status == 'annulee' ? 'selected' : '' }}>❌ Annulée</option>
                </select>
                <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded-md text-sm hover:bg-opacity-90">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
@endsection
