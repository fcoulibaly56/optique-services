@extends('layouts.public')

@section('title', 'Le magasin — Optique Services')
@section('description', 'Découvrez l’approche d’Optique Services à ACI 2000 : écoute, conseils pour le choix de vos montures et accompagnement en boutique.')

@section('content')
@php
    $appointmentUrl = \Illuminate\Support\Facades\Route::has('appointment.create') ? route('appointment.create') : url('/#contact');
    $contactUrl = \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact');
    $storePath = 'images/boutique.png';
    $storeImage = is_file(public_path($storePath)) ? asset($storePath) : null;
    $teamPath = 'images/equipe/equipe-optique-services.jpg';
    $teamImage = is_file(public_path($teamPath)) ? asset($teamPath) : null;
@endphp

<section class="relative isolate overflow-hidden bg-[#fbf8f6]">
    <div class="pointer-events-none absolute -right-20 -top-24 -z-10 h-80 w-80 rounded-full bg-[#f1deda]/70 blur-3xl sm:h-[32rem] sm:w-[32rem]" aria-hidden="true"></div>
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-12 sm:px-6 sm:py-16 lg:grid-cols-[.95fr_1.05fr] lg:gap-14 lg:px-8 lg:py-20">
        <div data-reveal>
            <a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="mb-6 inline-flex items-center gap-2 text-xs font-semibold text-optique-gray transition hover:text-optique-red"><span aria-hidden="true">←</span> Accueil</a>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Le magasin</p>
            <h1 class="mt-3 max-w-2xl font-serif text-4xl leading-[1.04] tracking-[-.04em] text-optique-text sm:text-5xl lg:text-6xl">Un regard attentif.<br><span class="italic text-optique-red">Un accueil chaleureux.</span></h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-optique-gray sm:text-lg sm:leading-8">Chez Optique Services, nous vous accompagnons dans le choix de lunettes adaptées à votre style, à vos envies et à votre quotidien.</p>
            <div class="mt-7 flex flex-col gap-3 sm:flex-row"><a href="{{ $appointmentUrl }}" class="group inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-optique-red px-6 py-3 text-sm font-semibold text-white shadow-md shadow-optique-red/15 transition duration-300 hover:-translate-y-0.5 hover:bg-optique-redhover">Préparer ma visite <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></a><a href="{{ $contactUrl }}" class="inline-flex min-h-12 items-center justify-center rounded-full border border-optique-border bg-white px-6 py-3 text-sm font-semibold transition hover:border-optique-red/50 hover:text-optique-red">Nous contacter</a></div>
        </div>
        <div class="relative" data-reveal>
            <div class="absolute -bottom-4 -left-3 h-2/3 w-2/3 rounded-[2rem] bg-[#edd8d3] sm:-bottom-6 sm:-left-5" aria-hidden="true"></div>
            <div class="relative grid aspect-[4/3] place-items-center overflow-hidden rounded-[1.75rem] bg-[#eee4e0] shadow-2xl shadow-[#593b35]/10 sm:rounded-[2.25rem]">
                @if($storeImage)
                    <img src="{{ $storeImage }}" alt="La boutique Optique Services à ACI 2000" class="absolute inset-0 h-full w-full object-cover transition duration-700 hover:scale-[1.03]" fetchpriority="high" onerror="this.style.display='none';">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#211a18]/40 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between text-white sm:bottom-6 sm:left-6 sm:right-6"><div><p class="text-[10px] font-bold uppercase tracking-[.18em] text-white/75">Votre opticien de proximité</p><p class="mt-1 font-serif text-2xl sm:text-3xl">ACI 2000 · Bamako</p></div><span class="grid h-11 w-11 place-items-center rounded-full border border-white/40 bg-white/15 text-xl backdrop-blur-md" aria-hidden="true">✳</span></div>
                @else
                    <div class="p-6 text-center"><span class="text-4xl text-optique-red" aria-hidden="true">⌂</span><p class="mt-3 text-xs font-semibold uppercase tracking-[.15em] text-optique-red">Photo du magasin à ajouter</p><p class="mt-1 text-xs text-optique-gray">images/boutique.png</p></div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-14 sm:py-20">
    <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 sm:px-6 lg:grid-cols-[1.05fr_.95fr] lg:gap-14 lg:px-8">
        <div class="relative overflow-hidden rounded-[1.75rem] bg-[#f5efec] shadow-xl shadow-[#593b35]/[.07] sm:rounded-[2rem]" data-reveal>
            <div class="relative aspect-[4/3]">
                @if($teamImage)
                    <img src="{{ $teamImage }}" alt="L’équipe d’Optique Services dans la boutique" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover" onerror="this.style.display='none';">
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#211a18]/55 to-transparent p-5 pt-16 text-white sm:p-7 sm:pt-20"><p class="text-[10px] font-bold uppercase tracking-[.18em] text-white/80">Optique Services</p><p class="mt-1 font-serif text-2xl">Une équipe à votre écoute.</p></div>
                @else
                    <div class="absolute inset-0 grid place-items-center bg-gradient-to-br from-[#faf7f5] via-[#eee5e1] to-[#f8f5f3] p-6 text-center">
                        <div>
                            <svg class="mx-auto h-16 w-16 text-[#9e645e]/70" viewBox="0 0 64 40" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/><path stroke-linecap="round" stroke-width="2.5" d="M25 9c2-3 4-4 9-4s7 1 9 4M3 18H1m62 0h-2"/></svg>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div data-reveal>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Les personnes derrière votre accueil</p>
            <h2 class="mt-3 font-serif text-3xl leading-tight tracking-tight text-optique-text sm:text-4xl">Une équipe, un conseil plus proche.</h2>
            <p class="mt-5 max-w-xl text-base leading-7 text-optique-gray">Nous vous accueillons pour vous conseiller et vous accompagner dans le choix de vos lunettes.</p>
        </div>
    </div>
</section>

<section class="bg-[#fbf8f6] py-16 sm:py-24">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[.7fr_1.3fr] lg:gap-20 lg:px-8">
        <div data-reveal><p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Notre approche</p><h2 class="mt-3 font-serif text-3xl leading-tight tracking-tight sm:text-4xl">Le bon choix commence par une bonne écoute.</h2></div>
        <div class="space-y-5" data-reveal>
            <p class="text-base leading-8 text-optique-gray">Choisir une monture, c’est à la fois une question de confort, d’usage et de style. Nous prenons le temps de comprendre ce que vous recherchez et de vous présenter des options à essayer en boutique.</p>
            <p class="text-base leading-8 text-optique-gray">Des modèles classiques aux formes plus affirmées, notre sélection est là pour vous aider à trouver une paire qui vous ressemble. Et si vous avez une question après votre visite, l’équipe reste disponible pour vous accompagner.</p>
            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                <div class="rounded-2xl border border-optique-border bg-white p-5 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be]"><p class="text-[10px] font-bold uppercase tracking-[.16em] text-optique-red">01 · Échanger</p><p class="mt-2 font-serif text-xl">Comprendre vos envies</p><p class="mt-2 text-sm leading-6 text-optique-gray">Votre quotidien, vos préférences et vos questions guident le conseil.</p></div>
                <div class="rounded-2xl border border-optique-border bg-white p-5 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be]"><p class="text-[10px] font-bold uppercase tracking-[.16em] text-optique-red">02 · Essayer</p><p class="mt-2 font-serif text-xl">Trouver votre monture</p><p class="mt-2 text-sm leading-6 text-optique-gray">Prenez le temps de comparer les styles et de choisir en confiance.</p></div>
            </div>
        </div>
    </div>
</section>

<section class="overflow-hidden bg-white py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl" data-reveal><p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Ce qui nous guide</p><h2 class="mt-3 font-serif text-3xl tracking-tight sm:text-4xl">Une relation simple, un service attentionné.</h2><p class="mt-4 text-sm leading-6 text-optique-gray sm:text-base">Les engagements d’Optique Services dans chaque échange avec vous.</p></div>
        <div class="mt-9 grid gap-4 sm:grid-cols-2 lg:mt-12 lg:grid-cols-3">
            <article data-reveal class="group rounded-3xl border border-optique-border bg-[#fbf8f6] p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-8"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbefed] text-optique-red"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5a7.5 7.5 0 1 0 7.5 7.5M12 8v4l2.5 1.5M19 3v5h-5"/></svg></span><h3 class="mt-5 font-serif text-xl">À votre écoute</h3><p class="mt-2 text-sm leading-6 text-optique-gray">Vos besoins et vos préférences sont au cœur de nos conseils.</p></article>
            <article data-reveal class="group rounded-3xl border border-optique-border bg-[#fbf8f6] p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-8"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbefed] text-optique-red"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12s3.3-6 9-6 9 6 9 6-3.3 6-9 6-9-6-9-6Z"/><circle cx="12" cy="12" r="2.5"/></svg></span><h3 class="mt-5 font-serif text-xl">Le choix en confiance</h3><p class="mt-2 text-sm leading-6 text-optique-gray">Nous vous aidons à comparer les montures et à vous sentir bien dans votre choix.</p></article>
            <article data-reveal class="group rounded-3xl border border-optique-border bg-[#fbf8f6] p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-8"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbefed] text-optique-red"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4.5 6v5.2c0 4.4 3.1 7.7 7.5 9.8 4.4-2.1 7.5-5.4 7.5-9.8V6L12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg></span><h3 class="mt-5 font-serif text-xl">Un suivi de proximité</h3><p class="mt-2 text-sm leading-6 text-optique-gray">Nous restons disponibles pour vos questions, ajustages et besoins après votre visite.</p></article>
        </div>
    </div>
</section>

<section class="px-4 py-16 sm:px-6 sm:py-24 lg:px-8"><div data-reveal class="relative mx-auto max-w-7xl overflow-hidden rounded-[1.75rem] bg-[#8f403c] px-6 py-10 text-white sm:rounded-[2.25rem] sm:px-12 sm:py-14 lg:px-16"><div class="absolute -right-16 -top-24 h-64 w-64 rounded-full border border-white/10 sm:h-96 sm:w-96" aria-hidden="true"></div><div class="relative flex flex-col gap-7 sm:flex-row sm:items-center sm:justify-between"><div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[.2em] text-white/70">On se rencontre ?</p><h2 class="mt-3 font-serif text-3xl leading-tight sm:text-4xl">Passez nous voir à ACI 2000.</h2><p class="mt-3 max-w-xl text-sm leading-6 text-white/80 sm:text-base">Venez découvrir les montures en boutique ou contactez-nous pour préparer votre visite.</p></div><div class="flex shrink-0 flex-col gap-3 sm:flex-row"><a href="{{ $contactUrl }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-bold text-[#773531] transition hover:-translate-y-0.5 hover:bg-[#fff8f6]">Nous contacter <span aria-hidden="true">↗</span></a><a href="{{ $appointmentUrl }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Prendre rendez-vous</a></div></div></div></section>
@endsection
