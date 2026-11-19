@extends('layouts.admin')
@section('title', 'Assurances')
@section('content')
<div class="min-h-screen bg-[#F9F8F6] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="mx-auto w-full max-w-5xl space-y-6">

        <!-- En-tête -->
        <header>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#A33B36]">Gestion des dossiers</p>
            <h1 class="mt-1 font-serif text-2xl font-bold leading-tight text-gray-900 sm:text-3xl">Assurances</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">Consultez les commandes associées à chaque organisme d’assurance.</p>
        </header>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($insurances as $insurance)
                <a href="{{ route('admin.insurances.orders', $insurance) }}" class="group flex min-h-48 flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#D9B4B1] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#A33B36] focus:ring-offset-2 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36] transition group-hover:bg-[#A33B36]/15" aria-hidden="true">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l8 4v5c0 5-3.4 8-8 9-4.6-1-8-4-8-9V7l8-4z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4"></path>
                            </svg>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-200">{{ $insurance->orders_count }}</span>
                    </div>

                    <div class="mt-5 flex-1">
                        <h2 class="break-words text-lg font-semibold text-gray-900 transition group-hover:text-[#A33B36]">{{ $insurance->name }}</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $insurance->orders_count }}
                            {{ $insurance->orders_count == 1 ? 'commande liée' : 'commandes liées' }}
                        </p>
                    </div>

                    <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4 text-sm font-medium text-[#A33B36]">
                        <span>Voir les commandes</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6l6 6-6 6"></path>
                        </svg>
                    </div>
                </a>
            @empty
                <section class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center shadow-sm">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l8 4v5c0 5-3.4 8-8 9-4.6-1-8-4-8-9V7l8-4z"></path>
                        </svg>
                    </div>
                    <h2 class="font-serif text-lg font-semibold text-gray-900">Aucune assurance enregistrée</h2>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">Les organismes d’assurance disponibles apparaîtront ici.</p>
                </section>
            @endforelse
        </div>
    </div>
</div>
@endsection
