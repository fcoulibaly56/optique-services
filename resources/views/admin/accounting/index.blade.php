@extends('layouts.admin')
@section('title', 'Comptabilité')
@section('content')
<div class="min-h-screen bg-[#F9F8F6] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="mx-auto w-full max-w-6xl space-y-6">

        <!-- En-tête et filtre de période -->
        <header class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#A33B36]">Espace équipe</p>
                <h1 class="mt-1 font-serif text-2xl font-bold leading-tight text-gray-900 sm:text-3xl">Comptabilité</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">Suivez les encaissements et les montants à percevoir sur la période choisie.</p>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="grid w-full grid-cols-1 gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:grid-cols-[1fr_auto_1fr_auto] sm:items-end lg:w-auto lg:min-w-[600px]">
                <div>
                    <label for="accounting-start-date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Du</label>
                    <input id="accounting-start-date" type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm text-gray-700 focus:border-[#A33B36] focus:ring-[#A33B36]">
                </div>
                <span class="hidden pb-3 text-sm text-gray-400 sm:block">au</span>
                <div>
                    <label for="accounting-end-date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Jusqu’au</label>
                    <input id="accounting-end-date" type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm text-gray-700 focus:border-[#A33B36] focus:ring-[#A33B36]">
                </div>
                <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 sm:col-span-4 lg:col-span-1">Afficher</button>
            </form>
        </header>

        <!-- Indicateurs clés -->
        <section class="grid grid-cols-1 gap-4 md:grid-cols-2" aria-label="Résumé comptable">
            <article class="relative overflow-hidden rounded-2xl border border-[#E8D2D0] bg-white p-5 shadow-sm sm:p-6">
                <div class="absolute inset-y-0 left-0 w-1.5 bg-[#A33B36]"></div>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Chiffre d’affaires</p>
                        <p class="mt-1 text-xs text-gray-400">Sur la période sélectionnée</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 15h4"></path>
                        </svg>
                    </span>
                </div>
                <p class="mt-5 break-words text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ number_format($totalRevenue, 0, ',', ' ') }} <span class="text-lg font-semibold text-gray-500">FCFA</span></p>
            </article>

            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Commandes livrées et payées</p>
                        <p class="mt-1 text-xs text-gray-400">Sur la période sélectionnée</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-600" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 7h14l1 13H4L5 7z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 9V6a3 3 0 016 0v3"></path>
                        </svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ number_format($totalOrders, 0, ',', ' ') }}</p>
            </article>
        </section>

        <!-- Détails financiers -->
        <div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-2">
            <!-- Montants à percevoir des assurances -->
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="font-serif text-lg font-semibold text-gray-900">À percevoir des assurances</h2>
                        <p class="mt-1 text-xs text-gray-500">Détail par organisme sur la période choisie</p>
                    </div>
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l8 4v5c0 5-3.4 8-8 9-4.6-1-8-4-8-9V7l8-4z"></path>
                        </svg>
                    </span>
                </div>

                <div class="divide-y divide-gray-100 px-5 sm:px-6">
                    @forelse($insuranceTotals as $total)
                        <div class="flex flex-col gap-2 py-4 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                            <div class="min-w-0">
                                <p class="break-words text-sm font-semibold text-gray-800">{{ $total['name'] }}</p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $total['count'] }} {{ $total['count'] == 1 ? 'commande' : 'commandes' }}
                                </p>
                            </div>
                            <p class="shrink-0 text-base font-bold text-gray-900">{{ number_format($total['total'], 0, ',', ' ') }} <span class="text-xs font-medium text-gray-500">FCFA</span></p>
                        </div>
                    @empty
                        <div class="py-10 text-center">
                            <p class="text-sm font-medium text-gray-700">Aucun montant à percevoir</p>
                            <p class="mt-1 text-sm text-gray-500">Aucune commande avec assurance sur cette période.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Dernières commandes payées -->
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-5 py-4 sm:px-6">
                    <h2 class="font-serif text-lg font-semibold text-gray-900">Dernières commandes payées</h2>
                    <p class="mt-1 text-xs text-gray-500">Jusqu’à cinq commandes récentes</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[360px] divide-y divide-gray-100 text-sm">
                        <caption class="sr-only">Dernières commandes payées</caption>
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 sm:px-6">Client</th>
                                <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 sm:px-6">Montant payé</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($paidOrders->take(5) as $order)
                                @php
                                    $paidCustomerName = trim(($order->customer?->last_name ?? '') . ' ' . ($order->customer?->first_name ?? ''));
                                @endphp
                                <tr class="transition hover:bg-[#FCFAF9]">
                                    <td class="px-5 py-3.5 font-medium text-gray-800 sm:px-6">{{ $paidCustomerName !== '' ? $paidCustomerName : 'Client non renseigné' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5 text-right font-semibold text-gray-900 sm:px-6">{{ number_format($order->net_to_pay, 0, ',', ' ') }} <span class="text-xs font-medium text-gray-500">FCFA</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-5 py-10 text-center text-sm text-gray-500 sm:px-6">Aucune commande payée pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
