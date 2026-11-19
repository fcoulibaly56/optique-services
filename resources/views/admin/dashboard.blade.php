@extends('layouts.admin')
@section('title', 'Tableau de bord — Optique Services')
@section('content')
<div class="min-h-full bg-[#F9F8F6] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="mx-auto max-w-7xl space-y-6">
        <!-- En-tête -->
        <header class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#A33B36]">Espace équipe</p>
                <h1 class="mt-1 font-serif text-2xl font-bold text-gray-900 sm:text-3xl">Tableau de bord</h1>
                <p class="mt-1 text-sm text-gray-500">Un aperçu rapide de l’activité de la boutique.</p>
            </div>
            <p class="text-sm font-medium capitalize text-gray-500">{{ now()->locale('fr')->translatedFormat('l d F Y') }}</p>
        </header>

        <!-- Alerte de stock -->
        @if($lowStockProducts->count() > 0)
            <section class="overflow-hidden rounded-2xl border border-[#E8C9C6] bg-white shadow-sm" aria-labelledby="stock-alert-title">
                <div class="flex items-start gap-3 border-l-4 border-[#A33B36] bg-[#FCF5F4] p-4 sm:p-5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18.2A1.8 1.8 0 003.3 21h17.4a1.8 1.8 0 001.5-2.8L13.7 3.9a2 2 0 00-3.4 0z"></path></svg>
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 id="stock-alert-title" class="font-semibold text-gray-900">Stock à surveiller</h2>
                            <span class="rounded-full bg-[#A33B36]/10 px-2.5 py-1 text-xs font-semibold text-[#8F302C]">{{ $lowStockProducts->count() }} {{ $lowStockProducts->count() === 1 ? 'produit' : 'produits' }}</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">Certains produits ont atteint un niveau de stock bas.</p>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="hidden shrink-0 items-center gap-1 rounded-lg px-3 py-2 text-sm font-semibold text-[#A33B36] transition hover:bg-white sm:inline-flex">
                        Gérer le stock
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6l6 6-6 6"></path></svg>
                    </a>
                </div>
                <ul class="divide-y divide-gray-100 px-4 sm:px-5">
                    @foreach($lowStockProducts as $product)
                        <li class="flex items-center justify-between gap-4 py-3 text-sm">
                            <span class="min-w-0 truncate font-medium text-gray-800">{{ $product->name }}</span>
                            <span class="shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">{{ $product->stock }} restant(s)</span>
                        </li>
                    @endforeach
                </ul>
                <div class="border-t border-gray-100 p-4 sm:hidden">
                    <a href="{{ route('admin.products.index') }}" class="inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-xl bg-[#A33B36] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8F302C]">
                        Gérer le stock
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6l6 6-6 6"></path></svg>
                    </a>
                </div>
            </section>
        @endif

        <!-- Indicateurs clés -->
        <section aria-labelledby="stats-title">
            <div class="mb-3 flex items-end justify-between gap-3">
                <div>
                    <h2 id="stats-title" class="font-serif text-lg font-semibold text-gray-900">Activité en un coup d’œil</h2>
                    <p class="mt-0.5 text-xs text-gray-500">Les principaux chiffres de la boutique</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4">
                <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-5">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-gray-500">Commandes en cours</p>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 7h14l1 13H4L5 7zM9 9V6a3 3 0 016 0v3"></path></svg></span>
                    </div>
                    <p class="mt-4 text-3xl font-bold tracking-tight text-gray-900">{{ $stats['orders_active'] }}</p>
                    <p class="mt-1 text-xs text-gray-500">À traiter par l’équipe</p>
                </article>

                <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-5">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-gray-500">Prêtes à livrer</p>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"></path></svg></span>
                    </div>
                    <p class="mt-4 text-3xl font-bold tracking-tight text-gray-900">{{ $stats['orders_ready'] }}</p>
                    <p class="mt-1 text-xs text-gray-500">En attente de remise</p>
                </article>

                <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-5">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-gray-500">Rendez-vous aujourd’hui</p>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v4m8-4v4M4 9h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1z"></path></svg></span>
                    </div>
                    <p class="mt-4 text-3xl font-bold tracking-tight text-gray-900">{{ $stats['appointments_today'] }}</p>
                    <p class="mt-1 text-xs text-gray-500">À accueillir en boutique</p>
                </article>

                <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-5">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-gray-500">Clients</p>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m12-13a4 4 0 11-8 0 4 4 0 018 0zm2 5a4 4 0 014 4v2"></path></svg></span>
                    </div>
                    <p class="mt-4 text-3xl font-bold tracking-tight text-gray-900">{{ $stats['customers_total'] }}</p>
                    <p class="mt-1 text-xs text-gray-500">Dans le fichier client</p>
                </article>
            </div>
        </section>

        <!-- Commandes récentes -->
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm" aria-labelledby="recent-orders-title">
            <div class="flex flex-col gap-3 border-b border-gray-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 id="recent-orders-title" class="font-serif text-lg font-semibold text-gray-900">Dernières commandes</h2>
                    <p class="mt-0.5 text-xs text-gray-500">Les commandes récemment enregistrées</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="inline-flex min-h-10 items-center justify-center gap-2 self-start rounded-xl border border-gray-200 px-3 py-2 text-sm font-semibold text-[#A33B36] transition hover:border-[#D9B4B1] hover:bg-[#FCF5F4] sm:self-auto">
                    Voir toutes les commandes
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6l6 6-6 6"></path></svg>
                </a>
            </div>

            @if($recentOrders->count() > 0)
                <!-- Cartes mobiles -->
                <ul class="divide-y divide-gray-100 md:hidden">
                    @foreach($recentOrders as $order)
                        <li>
                            <a href="{{ route('admin.orders.show', $order) }}" class="block px-4 py-4 transition hover:bg-[#FCFAF9] focus:bg-[#FCFAF9] focus:outline-none">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-gray-900">{{ $order->reference }}</p>
                                        <p class="mt-1 truncate text-sm text-gray-600">{{ $order->customer?->last_name }} {{ $order->customer?->first_name }}</p>
                                    </div>
                                    <span class="shrink-0 rounded-lg bg-gray-50 px-2.5 py-1.5 text-xs font-medium text-gray-500">{{ $order->created_at->format('d/m/Y') }}</span>
                                </div>
                                <span class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-[#A33B36]">Consulter la commande <span aria-hidden="true">→</span></span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Tableau écrans moyens et grands -->
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Référence</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Date</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentOrders as $order)
                                <tr class="transition hover:bg-[#FCFAF9]">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">{{ $order->reference }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->customer?->last_name }} {{ $order->customer?->first_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex min-h-9 items-center rounded-lg px-3 text-sm font-semibold text-[#A33B36] transition hover:bg-[#A33B36]/10 focus:outline-none focus:ring-2 focus:ring-[#A33B36]">Voir le détail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 py-12 text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 7h14l1 13H4L5 7zM9 9V6a3 3 0 016 0v3"></path></svg>
                    </span>
                    <h3 class="mt-3 text-sm font-semibold text-gray-900">Aucune commande récente</h3>
                    <p class="mt-1 text-sm text-gray-500">Les nouvelles commandes apparaîtront ici.</p>
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
