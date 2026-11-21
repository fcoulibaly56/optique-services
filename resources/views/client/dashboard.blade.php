@extends('layouts.client')
@section('title', 'Mon espace client')
@section('content')
<div class="min-h-screen bg-[#F9F8F6] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="mx-auto w-full max-w-5xl space-y-6">

        <!-- Accueil client -->
        <header class="rounded-2xl border border-[#EAD9D7] bg-white p-5 shadow-sm sm:p-7">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#A33B36]">Mon espace personnel</p>
            <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <!-- MODIFICATION ICI : Utilisation de $customer au lieu de auth()->user()->name -->
                    <h1 class="font-serif text-2xl font-bold leading-tight text-gray-900 sm:text-3xl">
                        Bonjour, {{ $customer->first_name }} {{ $customer->last_name }}
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">Retrouvez ici l’essentiel sur votre commande et vos rendez-vous.</p>
                </div>
                <div class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#A33B36]/10 text-[#A33B36] sm:flex" aria-hidden="true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                        <circle cx="12" cy="12" r="3" stroke-width="1.8"></circle>
                    </svg>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-2">
            <!-- Suivi de commande -->
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 7h14l1 13H4L5 7z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 9V6a3 3 0 016 0v3"></path>
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-serif text-lg font-semibold text-gray-900">Suivi de commande</h2>
                        <p class="text-xs text-gray-500">L’avancement de vos lunettes</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    @if($activeOrder)
                        @php
                            $isOrderInProgress = $activeOrder->status === 'en_cours';
                            $orderStatusLabel = $isOrderInProgress ? 'En cours' : 'Prête';
                            $orderStatusClass = $isOrderInProgress
                                ? 'bg-amber-50 text-amber-800 ring-amber-200'
                                : 'bg-emerald-50 text-emerald-800 ring-emerald-200';
                        @endphp

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Référence</p>
                                <p class="mt-1 break-all text-lg font-bold text-gray-900">{{ $activeOrder->reference }}</p>
                                <p class="mt-1 text-sm text-gray-500">Créée le {{ $activeOrder->created_at->format('d/m/Y') }}</p>
                            </div>
                            <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $orderStatusClass }}">
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                {{ $orderStatusLabel }}
                            </span>
                        </div>

                        <div class="mt-5 rounded-xl bg-[#FAF8F7] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Reste à régler</p>
                            <p class="mt-1 text-2xl font-bold tracking-tight text-gray-900">{{ number_format($activeOrder->remaining_amount, 0, ',', ' ') }} <span class="text-sm font-semibold text-gray-500">FCFA</span></p>
                        </div>

                        <a href="{{ route('client.orders.show', $activeOrder) }}" class="mt-5 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#A33B36] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#8F302C] focus:outline-none focus:ring-2 focus:ring-[#A33B36] focus:ring-offset-2">
                            Suivre ma commande
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6l6 6-6 6"></path></svg>
                        </a>
                    @else
                        <div class="py-5 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 7h14l1 13H4L5 7zM9 9V6a3 3 0 016 0v3"></path></svg>
                            </div>
                            <h3 class="mt-3 text-sm font-semibold text-gray-800">Aucune commande en cours</h3>
                            <p class="mt-1 text-sm text-gray-500">Vos commandes en cours de traitement apparaîtront ici.</p>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Prochain rendez-vous -->
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#A33B36]/10 text-[#A33B36]" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v4m8-4v4M4 9h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1z"></path>
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-serif text-lg font-semibold text-gray-900">Prochain rendez-vous</h2>
                        <p class="text-xs text-gray-500">Votre visite en boutique</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    @if($nextAppointment)
                        @php
                            $appointmentDate = \Carbon\Carbon::parse($nextAppointment->requested_at)->locale('fr');
                            $isAppointmentConfirmed = $nextAppointment->status === 'confirme';
                        @endphp

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Motif</p>
                                <!-- MODIFICATION ICI : Utilisation de motive_label -->
                                <h3 class="mt-1 break-words text-lg font-bold text-gray-900">{{ $nextAppointment->motive_label }}</h3>
                            </div>
                            <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $isAppointmentConfirmed ? 'bg-emerald-50 text-emerald-800 ring-emerald-200' : 'bg-amber-50 text-amber-800 ring-amber-200' }}">
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                <!-- MODIFICATION ICI : Utilisation de status_label -->
                                {{ $nextAppointment->status_label }}
                            </span>
                        </div>

                        <div class="mt-5 flex items-center gap-3 rounded-xl bg-[#FAF8F7] p-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#A33B36] shadow-sm" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v4m8-4v4M4 9h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1z"></path></svg>
                            </span>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $appointmentDate->translatedFormat('l d F Y') }}</p>
                                <p class="mt-0.5 text-sm text-gray-500">{{ $appointmentDate->format('H:i') }}</p>
                            </div>
                        </div>

                        <a href="{{ route('client.appointments.index') }}" class="mt-5 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-[#D9B4B1] hover:bg-[#FCFAF9] hover:text-[#A33B36] focus:outline-none focus:ring-2 focus:ring-[#A33B36] focus:ring-offset-2">
                            Voir mes rendez-vous
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6l6 6-6 6"></path></svg>
                        </a>
                    @else
                        <div class="py-5 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v4m8-4v4M4 9h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1z"></path></svg>
                            </div>
                            <h3 class="mt-3 text-sm font-semibold text-gray-800">Aucun rendez-vous prévu</h3>
                            <p class="mt-1 text-sm text-gray-500">Vos prochains rendez-vous apparaîtront ici.</p>
                            <a href="{{ route('client.appointments.index') }}" class="mt-4 inline-flex min-h-10 items-center justify-center rounded-xl border border-[#E8D2D0] px-4 py-2 text-sm font-semibold text-[#A33B36] transition hover:bg-red-50">Voir mes rendez-vous</a>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        <p class="flex items-start gap-2 rounded-xl border border-gray-200 bg-white/70 px-4 py-3 text-xs leading-5 text-gray-500">
            <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#A33B36]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 11v5m0-8h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Ces informations sont personnelles et visibles uniquement depuis votre espace client.</span>
        </p>
    </div>
</div>
@endsection
