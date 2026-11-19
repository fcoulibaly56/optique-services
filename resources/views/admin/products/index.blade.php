@extends('layouts.admin')
@section('title', 'Produits & alertes — Optique Services')
@section('content')
<div class="min-h-full bg-[#F9F8F6] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="mx-auto max-w-7xl space-y-6">
        <!-- En-tête -->
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#A33B36]">Gestion du catalogue</p>
                <h1 class="mt-1 font-serif text-2xl font-bold text-gray-900 sm:text-3xl">Produits &amp; alertes</h1>
                <p class="mt-1 text-sm text-gray-500">Consultez les références et surveillez les niveaux de stock.</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#A33B36] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#8F302C] focus:outline-none focus:ring-2 focus:ring-[#A33B36] focus:ring-offset-2 sm:w-auto">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"></path></svg>
                Nouveau produit
            </a>
        </header>

        <!-- Liste -->
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm" aria-label="Liste des produits">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-4 py-4 sm:px-6">
                <div>
                    <h2 class="font-serif text-lg font-semibold text-gray-900">Catalogue produits</h2>
                    <p class="mt-0.5 text-xs text-gray-500">{{ $products->total() }} {{ $products->total() === 1 ? 'référence' : 'références' }}</p>
                </div>
                <span class="hidden rounded-full bg-[#A33B36]/10 px-3 py-1 text-xs font-semibold text-[#8F302C] sm:inline-flex">Stock suivi</span>
            </div>

            @if($products->count() > 0)
                <!-- Cartes adaptées au mobile -->
                <ul class="divide-y divide-gray-100 md:hidden">
                    @foreach($products as $product)
                        @php
                            $stock = (int) $product->stock;
                            if ($stock <= 0) {
                                $stockLabel = 'Rupture';
                                $stockClass = 'bg-[#FCEDEC] text-[#8F302C] ring-[#EBC7C4]';
                            } elseif ($stock <= 5) {
                                $stockLabel = 'Stock faible · ' . $stock;
                                $stockClass = 'bg-amber-50 text-amber-800 ring-amber-200';
                            } else {
                                $stockLabel = 'En stock · ' . $stock;
                                $stockClass = 'bg-gray-50 text-gray-700 ring-gray-200';
                            }
                        @endphp
                        <li class="p-4 transition hover:bg-[#FCFAF9]">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400">{{ $product->reference ?? 'Référence non renseignée' }}</p>
                                    <h3 class="mt-1 break-words font-semibold text-gray-900">{{ $product->name }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $product->category?->name ?? 'Sans catégorie' }}</p>
                                </div>
                                <span class="inline-flex shrink-0 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $stockClass }}">{{ $stockLabel }}</span>
                            </div>
                            <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3">
                                <span class="text-xs font-medium text-gray-500">Prix</span>
                                <span class="font-semibold text-gray-900">{{ number_format((float) $product->price, 0, ',', ' ') }} <span class="text-xs font-medium text-gray-500">FCFA</span></span>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Tableau pour les écrans moyens et grands -->
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Référence</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nom du produit</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Catégorie</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Prix</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Stock</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($products as $product)
                                @php
                                    $stock = (int) $product->stock;
                                    if ($stock <= 0) {
                                        $stockLabel = 'Rupture';
                                        $stockClass = 'bg-[#FCEDEC] text-[#8F302C] ring-[#EBC7C4]';
                                    } elseif ($stock <= 5) {
                                        $stockLabel = 'Faible · ' . $stock;
                                        $stockClass = 'bg-amber-50 text-amber-800 ring-amber-200';
                                    } else {
                                        $stockLabel = 'En stock · ' . $stock;
                                        $stockClass = 'bg-gray-50 text-gray-700 ring-gray-200';
                                    }
                                @endphp
                                <tr class="transition hover:bg-[#FCFAF9]">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-800">{{ $product->reference ?? 'Non renseignée' }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category?->name ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium text-gray-800">{{ number_format((float) $product->price, 0, ',', ' ') }} FCFA</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $stockClass }}">{{ $stockLabel }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 py-12 text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </span>
                    <h3 class="mt-3 text-sm font-semibold text-gray-900">Aucun produit pour le moment</h3>
                    <p class="mt-1 text-sm text-gray-500">Ajoutez votre première référence au catalogue.</p>
                    <a href="{{ route('admin.products.create') }}" class="mt-4 inline-flex min-h-10 items-center justify-center rounded-xl bg-[#A33B36] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8F302C]">Créer un produit</a>
                </div>
            @endif

            @if(method_exists($products, 'links'))
                <div class="border-t border-gray-100 px-4 py-4 sm:px-6">
                    {{ $products->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
