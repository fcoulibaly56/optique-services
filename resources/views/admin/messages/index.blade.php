@extends('layouts.admin')
@section('title', 'Messagerie interne')
@section('content')
<div class="min-h-screen bg-[#F9F8F6] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="mx-auto w-full max-w-5xl space-y-6">

        <!-- En-tête -->
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#A33B36]">Espace équipe</p>
                <h1 class="mt-1 font-serif text-2xl font-bold leading-tight text-gray-900 sm:text-3xl">Messagerie interne</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">Retrouvez les conversations et reprenez facilement le suivi des échanges avec vos clients.</p>
            </div>

            @if(method_exists($conversations, 'total'))
                <div class="inline-flex w-fit items-center gap-2 rounded-full border border-gray-200 bg-white px-3.5 py-2 text-sm text-gray-600 shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-[#A33B36]"></span>
                    <span><strong class="font-semibold text-gray-900">{{ $conversations->total() }}</strong> conversation(s)</span>
                </div>
            @endif
        </header>

        <!-- Liste des conversations -->
        @forelse($conversations as $conv)
            @php
                $customerName = trim(($conv->customer?->first_name ?? '') . ' ' . ($conv->customer?->last_name ?? ''));
                $customerName = $customerName !== '' ? $customerName : 'Client sans nom';
                $firstInitial = mb_substr($conv->customer?->first_name ?? 'C', 0, 1);
                $lastInitial = mb_substr($conv->customer?->last_name ?? '', 0, 1);
                $messageDate = $conv->last_message_at
                    ? \Carbon\Carbon::parse($conv->last_message_at)->locale('fr')
                    : null;
            @endphp

            <a href="{{ route('admin.messages.show', $conv) }}" class="group flex min-w-0 items-center gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#D9B4B1] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#A33B36] focus:ring-offset-2 sm:gap-5 sm:px-5 sm:py-4">
                <!-- Initiales du client -->
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#A33B36]/10 text-sm font-bold uppercase tracking-wide text-[#A33B36] sm:h-14 sm:w-14" aria-hidden="true">
                    {{ strtoupper($firstInitial . $lastInitial) }}
                </div>

                <!-- Sujet et nom -->
                <div class="min-w-0 flex-1">
                    <div class="flex min-w-0 flex-col gap-1 sm:flex-row sm:items-center sm:gap-3">
                        <h2 class="truncate text-sm font-semibold text-gray-900 sm:text-base">{{ $customerName }}</h2>
                        <span class="hidden h-1 w-1 shrink-0 rounded-full bg-gray-300 sm:block" aria-hidden="true"></span>
                        <p class="truncate text-sm text-gray-500 group-hover:text-gray-700">{{ $conv->subject ?: 'Conversation sans objet' }}</p>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Conversation avec l’équipe Optique Services</p>
                </div>

                <!-- Dernière activité et accès -->
                <div class="flex shrink-0 items-center gap-3 sm:gap-4">
                    @if($messageDate)
                        <time datetime="{{ $messageDate->toIso8601String() }}" title="{{ $messageDate->translatedFormat('d F Y à H:i') }}" class="max-w-24 text-right text-xs text-gray-500 sm:max-w-none sm:text-sm">
                            {{ $messageDate->diffForHumans() }}
                        </time>
                    @else
                        <span class="text-xs text-gray-400 sm:text-sm">Pas encore de message</span>
                    @endif
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-50 text-gray-400 transition group-hover:bg-[#A33B36]/10 group-hover:text-[#A33B36]" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
            </a>
        @empty
            <section class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center shadow-sm">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#A33B36]/10 text-[#A33B36]">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <h2 class="font-serif text-lg font-semibold text-gray-900">Aucune conversation pour le moment</h2>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">Les échanges avec les clients apparaîtront ici dès qu’une conversation sera créée.</p>
            </section>
        @endforelse

        @if(method_exists($conversations, 'links'))
            <div class="pt-1">{{ $conversations->links() }}</div>
        @endif
    </div>
</div>
@endsection
