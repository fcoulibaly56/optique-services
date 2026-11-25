@extends('layouts.public')

@section('title', 'Optique Services — Votre regard, notre priorité')
@section('description', 'Découvrez les montures et services d’Optique Services à ACI 2000, Bamako. Prenez rendez-vous et bénéficiez de conseils personnalisés.')

@section('content')
@php
    $appointmentUrl = \Illuminate\Support\Facades\Route::has('appointment.create') ? route('appointment.create') : '#contact';
    $productsUrl = \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : '#collection';
    $servicesUrl = \Illuminate\Support\Facades\Route::has('services') ? route('services') : '#services';
    $contactUrl = \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : '#contact';
    $montureConfig = config('montures', []);
    $montures = array_values(array_filter($montureConfig['items'] ?? [], function ($monture) {
        $image = basename($monture['image'] ?? '');
        return preg_match('/^monture-[a-z0-9_-]+\\.(?:jpe?g|png|webp)$/i', $image)
            && is_file(public_path('images/montures/' . $image));
    }));
    $montureFilters = $montureConfig['filters'] ?? [];
    $filterLabelMap = array_column($montureFilters, 'label', 'key');
    $preferredHeroPath = 'images/montures/hero-monture.jpg';
    $firstMonturePath = !empty($montures) ? 'images/montures/' . basename($montures[0]['image']) : null;
    $heroImagePath = is_file(public_path($preferredHeroPath)) ? $preferredHeroPath : $firstMonturePath;
    $heroImage = $heroImagePath ? asset($heroImagePath) : null;
@endphp

<section class="relative isolate overflow-hidden bg-[#fbf8f6]">
    <div class="pointer-events-none absolute -right-28 -top-24 -z-10 h-80 w-80 rounded-full bg-[#f1deda]/70 blur-3xl sm:h-[34rem] sm:w-[34rem]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-32 left-[38%] -z-10 h-72 w-72 rounded-full bg-[#f7e9e5]/80 blur-3xl" aria-hidden="true"></div>
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 pb-16 pt-9 sm:px-6 sm:pb-24 sm:pt-14 lg:grid-cols-[.92fr_1.08fr] lg:gap-12 lg:px-8 lg:py-20">
        <div class="relative z-10" data-reveal>
            <div class="mb-5 inline-flex items-center gap-2.5 rounded-full border border-[#ead8d4] bg-white/85 px-3.5 py-2 text-xs font-semibold tracking-wide text-optique-text shadow-sm sm:mb-7 sm:text-sm"><span class="relative flex h-2.5 w-2.5"><span class="os-pulse-ring absolute inset-0 rounded-full bg-optique-red"></span><span class="relative m-auto h-2 w-2 rounded-full bg-optique-red"></span></span> Votre opticien à ACI 2000</div>
            <h1 class="max-w-2xl font-serif text-[2.8rem] font-medium leading-[1.04] tracking-[-.045em] text-optique-text sm:text-6xl lg:text-[4.4rem]">Le monde est plus beau <span class="relative inline-block text-optique-red">quand on le voit bien<span class="absolute -bottom-1 left-0 -z-10 h-2 w-full rounded-full bg-[#e7c5be]/65 sm:-bottom-2 sm:h-3" aria-hidden="true"></span></span></h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-optique-gray sm:mt-6 sm:text-lg sm:leading-8">Des montures soigneusement choisies, des conseils à votre écoute et un accompagnement attentionné pour toute la famille.</p>
            <div class="mt-7 flex flex-col gap-3 sm:mt-8 sm:flex-row sm:items-center">
                <a href="{{ $appointmentUrl }}" class="group inline-flex min-h-14 items-center justify-center gap-3 rounded-full bg-optique-red px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-optique-red/20 transition duration-300 hover:-translate-y-1 hover:bg-optique-redhover hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-optique-red focus:ring-offset-2 sm:text-base">Prendre rendez-vous <span class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span></a>
                <a href="{{ $productsUrl }}" class="group inline-flex min-h-14 items-center justify-center gap-2 rounded-full border border-optique-border bg-white/70 px-7 py-4 text-sm font-semibold text-optique-text transition duration-300 hover:border-optique-red/40 hover:bg-white">Voir les montures <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">↗</span></a>
            </div>
            <div class="mt-7 flex flex-wrap items-center gap-x-5 gap-y-3 text-xs font-medium text-optique-gray sm:text-sm"><span class="inline-flex items-center gap-2"><span class="text-optique-red">✓</span> Conseil personnalisé</span><span class="inline-flex items-center gap-2"><span class="text-optique-red">✓</span> Pour petits et grands</span></div>
        </div>

        <div class="relative mx-auto w-full max-w-xl lg:max-w-none" data-reveal>
            <div class="absolute -left-3 top-8 z-20 hidden max-w-[13rem] rounded-2xl border border-white/80 bg-white/95 p-4 shadow-xl shadow-black/5 os-float-slow sm:block lg:-left-6"><p class="text-[10px] font-bold uppercase tracking-[.17em] text-optique-gray">Le détail fait le style</p><p class="mt-1 font-serif text-lg leading-snug">Une monture choisie pour vous.</p></div>
            <div class="relative aspect-[1.03/1] overflow-hidden rounded-[2rem] bg-[#eae1dd] shadow-2xl shadow-[#593b35]/10 sm:aspect-[1.13/1] sm:rounded-[2.5rem]">
                @if($heroImage)
                    <img src="{{ $heroImage }}" alt="Monture présentée par Optique Services" class="h-full w-full object-contain p-4 transition duration-700 hover:scale-[1.03] sm:p-8" fetchpriority="high" onerror="this.style.display='none';">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#211a18]/45 via-transparent to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 flex items-end justify-between p-5 text-white sm:p-8"><div><p class="text-[10px] font-bold uppercase tracking-[.2em] text-white/75 sm:text-xs">Optique Services</p><p class="mt-1 font-serif text-2xl sm:text-3xl">Le style vous va bien.</p></div><span class="grid h-11 w-11 place-items-center rounded-full border border-white/40 bg-white/15 text-xl backdrop-blur-md transition hover:rotate-12" aria-hidden="true">✳</span></div>
                @else
                    <div class="absolute inset-0 grid place-items-center bg-gradient-to-br from-[#faf7f5] via-[#eee5e1] to-[#f8f5f3] p-6"><svg class="h-16 w-16 text-[#9e645e]/70" viewBox="0 0 64 40" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/><path stroke-linecap="round" stroke-width="2.5" d="M25 9c2-3 4-4 9-4s7 1 9 4M3 18H1m62 0h-2"/></svg></div>
                @endif
            </div>
            <div class="absolute -bottom-4 right-3 z-20 flex items-center gap-3 rounded-2xl border border-white bg-white px-4 py-3 shadow-xl shadow-black/10 os-float sm:-bottom-5 sm:right-8 sm:px-5 sm:py-4"><span class="grid h-10 w-10 place-items-center rounded-xl bg-[#fbefed] text-xl text-optique-red" aria-hidden="true">◎</span><div><p class="text-[10px] font-bold uppercase tracking-[.14em] text-optique-gray">À découvrir</p><p class="mt-0.5 text-sm font-semibold">Nos montures en boutique</p></div></div>
            <span class="absolute -right-3 top-[22%] z-10 hidden h-14 w-14 rounded-2xl border border-white/70 bg-white/40 backdrop-blur-sm os-float sm:block" aria-hidden="true"></span>
        </div>
    </div>
</section>

<div class="overflow-hidden border-y border-[#f0e6e3] bg-white py-3.5" aria-label="Nos engagements">
    <div class="flex min-w-max items-center justify-center gap-6 px-4 text-[11px] font-semibold uppercase tracking-[.16em] text-optique-gray sm:gap-10 sm:text-xs"><span>Conseil personnalisé</span><span class="text-optique-red">✳</span><span>Montures pour toute la famille</span><span class="text-optique-red">✳</span><span>À ACI 2000, Bamako</span><span class="hidden text-optique-red sm:inline">✳</span><span class="hidden sm:inline">Un accueil à votre écoute</span></div>
</div>

<section id="collection" class="scroll-mt-24 py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end" data-reveal><div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">À chacun son regard</p><h2 class="mt-3 font-serif text-3xl leading-tight tracking-tight sm:text-4xl lg:text-5xl">Nos montures, vos coups de cœur.</h2><p class="mt-3 max-w-xl text-sm leading-6 text-optique-gray sm:text-base">Découvrez quelques modèles disponibles en boutique. Passez les essayer et parlons ensemble de ce qui vous convient.</p></div><div class="flex items-center gap-4"><a href="{{ $productsUrl }}" class="group inline-flex w-fit items-center gap-2 border-b border-optique-red pb-1 text-sm font-semibold text-optique-red">Tout le catalogue <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></a></div></div>
        <div class="mt-7 flex flex-col gap-4 sm:mt-9 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex gap-2 overflow-x-auto pb-2" role="group" aria-label="Filtrer les montures">
            @foreach($montureFilters as $filter)
                <button type="button" data-category-filter="{{ $filter['key'] }}" aria-pressed="{{ $filter['key'] === 'all' ? 'true' : 'false' }}" @class(['shrink-0 rounded-full border px-5 py-2.5 text-xs font-semibold transition duration-200 sm:text-sm', 'bg-optique-red text-white border-optique-red shadow-md shadow-optique-red/15' => $filter['key'] === 'all', 'bg-white text-optique-gray border-optique-border hover:border-optique-red/40 hover:text-optique-text' => $filter['key'] !== 'all'])>{{ $filter['label'] }}</button>
            @endforeach
        </div>
        <label class="relative block w-full sm:max-w-xs"><span class="sr-only">Rechercher une monture</span><svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-optique-gray" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m16 16 4 4"/></svg><input type="search" data-product-search placeholder="Rechercher une monture…" class="w-full rounded-full border border-optique-border bg-white py-3 pl-11 pr-4 text-sm outline-none transition placeholder:text-optique-gray/70 focus:border-optique-red focus:ring-4 focus:ring-optique-red/10"></label>
        </div>
        <p data-product-count aria-live="polite" class="mt-2 text-xs text-optique-gray">{{ count($montures) }} modèles</p>
        <div id="home-monture-carousel" data-product-carousel tabindex="0" role="region" aria-label="Montures disponibles en boutique" aria-roledescription="carrousel" class="mt-5 -mx-4 flex snap-x snap-mandatory gap-3 overflow-x-auto overscroll-x-contain px-4 pb-4 scroll-smooth motion-reduce:scroll-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-optique-red sm:mx-0 sm:mt-7 sm:gap-5 sm:px-0">
            @foreach($montures as $index => $monture)
                @php
                    $photoName = basename($monture['image']);
                    $photoPath = 'images/montures/' . $photoName;
                    $photoUrl = is_file(public_path($photoPath)) ? asset($photoPath) : null;
                    $filterKeys = array_values(array_unique(array_filter(array_merge($monture['audiences'] ?? [], $monture['types'] ?? [], $monture['styles'] ?? []))));
                    $filterLabels = array_values(array_filter(array_map(fn ($key) => $filterLabelMap[$key] ?? null, $filterKeys)));
                    $searchText = implode(' ', array_filter(array_merge([$monture['name'] ?? '', $monture['note'] ?? ''], $filterLabels)));
                    $montureName = $monture['name'] ?? 'Monture ' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                @endphp
                <article data-category-card="{{ implode(' ', $filterKeys) }}" data-search="{{ $searchText }}" data-reveal class="group w-[82%] shrink-0 snap-start overflow-hidden rounded-2xl border border-optique-border bg-white transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.08] sm:w-[47%] sm:rounded-3xl lg:w-[31%]" style="transition-delay: {{ $index * 70 }}ms" role="group" aria-roledescription="diapositive" aria-label="{{ $montureName }}, {{ $index + 1 }} sur {{ count($montures) }}">
                    <a href="{{ $productsUrl }}" class="block" aria-label="Découvrir {{ strtolower($monture['name']) }}">
                        <div class="relative aspect-[1/1] overflow-hidden bg-[#f5f1ef] p-2 sm:p-4">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $montureName }} — photo du magasin" loading="lazy" decoding="async" class="h-full w-full rounded-xl object-contain transition duration-500 group-hover:scale-[1.04] sm:rounded-2xl" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                                <div style="display:none" class="absolute inset-0 place-items-center bg-[#f5f1ef]"><p class="text-xs text-optique-gray">Photo à vérifier : {{ $photoName }}</p></div>
                            @else
                                <div class="absolute inset-0 grid place-items-center bg-[#f5f1ef] p-4 text-center"><div><span class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-white text-optique-red" aria-hidden="true">◎</span><p class="mt-3 text-[10px] font-semibold uppercase tracking-[.13em] text-optique-gray">Photo à ajouter</p><p class="mt-1 text-[10px] text-optique-gray">{{ $photoName }}</p></div></div>
                            @endif
                            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[9px] font-bold uppercase tracking-[.13em] text-optique-gray shadow-sm backdrop-blur">{{ count($filterLabels) ? implode(' · ', $filterLabels) : 'Collection' }}</span>
                            <span class="absolute bottom-3 right-3 grid h-9 w-9 translate-y-2 place-items-center rounded-full bg-white text-optique-red opacity-0 shadow-md transition duration-300 group-hover:translate-y-0 group-hover:opacity-100" aria-hidden="true">↗</span>
                        </div>
                        <div class="p-3.5 sm:p-5"><h3 class="font-serif text-base sm:text-lg">{{ $montureName }}</h3><p class="mt-1 text-[11px] leading-5 text-optique-gray sm:text-xs">{{ $monture['note'] ?: 'Essayage et disponibilité à confirmer en boutique.' }}</p><div class="mt-3 flex items-center justify-between border-t border-optique-border pt-3"><span class="text-[10px] font-medium text-optique-gray sm:text-xs">Infos en boutique</span><span class="text-xs font-semibold text-optique-red transition group-hover:translate-x-1">Découvrir →</span></div></div>
                    </a>
                </article>
            @endforeach
        </div>
        <p data-carousel-status class="sr-only" role="status" aria-live="polite"></p>
        <div data-product-empty hidden class="mt-8 rounded-2xl border border-dashed border-optique-border bg-white px-5 py-10 text-center"><span class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-[#fbf1ef] text-xl text-optique-red">⌕</span><p class="mt-3 font-serif text-xl">Aucune monture trouvée</p><p class="mt-1 text-sm text-optique-gray">Essayez une autre recherche ou sélectionnez une autre catégorie.</p><button type="button" data-reset-products class="mt-4 text-sm font-semibold text-optique-red underline underline-offset-4">Effacer les filtres</button></div>
        <p class="mt-4 text-center text-[11px] text-optique-gray">Essayage et disponibilité des modèles à confirmer en boutique.</p>
    </div>
</section>

<section id="services" class="scroll-mt-24 bg-white py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"><div class="mx-auto max-w-2xl text-center" data-reveal><p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">À vos côtés</p><h2 class="mt-3 font-serif text-3xl tracking-tight sm:text-4xl">Bien plus qu’une monture.</h2><p class="mt-4 text-sm leading-6 text-optique-gray sm:text-base">Un accompagnement attentif, de la découverte de votre monture à son ajustage.</p></div>
        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:mt-14 lg:grid-cols-3">
            <article data-reveal class="group rounded-2xl border border-optique-border bg-[#fffdfc] p-6 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-7"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbf1ef] text-optique-red transition duration-300 group-hover:rotate-[-8deg] group-hover:scale-110"><svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6-10-6-10-6Z"/><circle cx="12" cy="12" r="2.5"/></svg></span><h3 class="mt-5 font-serif text-xl">Conseil personnalisé</h3><p class="mt-2 text-sm leading-6 text-optique-gray">Prenons le temps de trouver la monture qui vous ressemble.</p></article>
            <article data-reveal class="group rounded-2xl border border-optique-border bg-[#fffdfc] p-6 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-7"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbf1ef] text-optique-red transition duration-300 group-hover:rotate-[-8deg] group-hover:scale-110"><svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M6 3v4m12-4v4M5 11h14v9H5zM8 14h3m2 0h3"/></svg></span><h3 class="mt-5 font-serif text-xl">Rendez-vous</h3><p class="mt-2 text-sm leading-6 text-optique-gray">Demandez un créneau pour échanger avec notre équipe en boutique.</p></article>
            <article data-reveal class="group rounded-2xl border border-optique-border bg-[#fffdfc] p-6 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-7"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbf1ef] text-optique-red transition duration-300 group-hover:rotate-[-8deg] group-hover:scale-110"><svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4 7v5c0 4.3 3.3 7.2 8 9 4.7-1.8 8-4.7 8-9V7l-8-4Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg></span><h3 class="mt-5 font-serif text-xl">Ajustage & réparation</h3><p class="mt-2 text-sm leading-6 text-optique-gray">Pour l’entretien et les petites réparations de vos lunettes.</p></article>
        </div><div class="mt-8 text-center"><a href="{{ $servicesUrl }}" class="group inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-optique-border px-6 py-3 text-sm font-semibold transition hover:border-optique-red hover:text-optique-red">Découvrir nos services <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></a></div>
    </div>
</section>

<section id="boutique" class="scroll-mt-24 overflow-hidden py-16 sm:py-24"><div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
    <div class="relative" data-reveal><div class="absolute -bottom-4 -right-3 h-2/3 w-2/3 rounded-[2rem] bg-[#f1dfdb]" aria-hidden="true"></div><img src="{{ asset('images/boutique.png') }}" alt="La boutique Optique Services à ACI 2000" loading="lazy" class="relative aspect-[4/3] w-full rounded-[1.75rem] object-cover shadow-xl shadow-[#593b35]/10 sm:rounded-[2rem]" onerror="this.style.display='none';"><div class="absolute left-4 top-4 rounded-xl bg-white/95 px-4 py-3 shadow-lg backdrop-blur sm:left-6 sm:top-6"><p class="text-[10px] font-bold uppercase tracking-[.16em] text-optique-gray">Retrouvez-nous</p><p class="mt-1 text-sm font-semibold">ACI 2000 · Bamako</p></div></div>
    <div data-reveal><p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Un magasin de proximité</p><h2 class="mt-3 max-w-xl font-serif text-3xl leading-tight tracking-tight sm:text-4xl lg:text-5xl">Le bon conseil, tout près de chez vous.</h2><p class="mt-5 max-w-xl text-sm leading-7 text-optique-gray sm:text-base">Situé à ACI 2000, Optique Services vous accueille pour découvrir les montures, poser vos questions et bénéficier d’un accompagnement personnalisé.</p><div class="mt-7 flex flex-col gap-3 sm:flex-row"><a href="{{ $contactUrl }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-optique-text px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-black">Nous contacter <span aria-hidden="true">↗</span></a><a href="{{ $appointmentUrl }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-optique-border px-6 py-3 text-sm font-semibold transition hover:border-optique-red hover:text-optique-red">Prendre rendez-vous</a></div></div>
</div></section>

<section class="px-4 pb-16 sm:px-6 sm:pb-24 lg:px-8"><div data-reveal class="relative mx-auto max-w-7xl overflow-hidden rounded-[1.75rem] bg-[#8f403c] px-6 py-10 text-white sm:rounded-[2.25rem] sm:px-12 sm:py-14 lg:px-16"><div class="absolute -right-16 -top-24 h-64 w-64 rounded-full border border-white/10 sm:h-96 sm:w-96" aria-hidden="true"></div><div class="absolute -right-4 -top-12 h-48 w-48 rounded-full border border-white/10" aria-hidden="true"></div><div class="relative flex flex-col gap-7 sm:flex-row sm:items-center sm:justify-between"><div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[.2em] text-white/70">On se rencontre ?</p><h2 class="mt-3 font-serif text-3xl leading-tight sm:text-4xl">Votre prochaine monture commence par une conversation.</h2><p class="mt-3 max-w-xl text-sm leading-6 text-white/80 sm:text-base">Choisissez un créneau ou contactez notre équipe pour préparer votre visite.</p></div><a href="{{ $appointmentUrl }}" class="group inline-flex min-h-14 shrink-0 items-center justify-center gap-3 rounded-full bg-white px-7 py-4 text-sm font-bold text-[#773531] shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-[#fff8f6] sm:text-base">Prendre rendez-vous <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></a></div></div></section>
@endsection

@push('scripts')
<script>
(() => {
    const track = document.querySelector('[data-product-carousel]');
    if (!track) return;

    const status = document.querySelector('[data-carousel-status]');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let hoverPaused = false;
    let focusWithin = false;
    let interactionPaused = false;
    let rotationTimer = null;
    let interactionTimer = null;

    const hasOverflow = () => track.scrollWidth - track.clientWidth > 4;

    const syncRotation = () => {
        window.clearInterval(rotationTimer);
        rotationTimer = null;
        if (reduceMotion || hoverPaused || focusWithin || interactionPaused || document.hidden || !hasOverflow()) return;

        rotationTimer = window.setInterval(() => {
            const maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
            if (track.scrollLeft >= maxScroll - 3) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: Math.max(240, track.clientWidth * 0.82), behavior: 'smooth' });
            }
        }, 5000);
    };

    const pauseBriefly = () => {
        interactionPaused = true;
        syncRotation();
        window.clearTimeout(interactionTimer);
        interactionTimer = window.setTimeout(() => {
            interactionPaused = false;
            syncRotation();
        }, 1600);
    };

    const move = direction => {
        const distance = Math.max(240, track.clientWidth * 0.82) * direction;
        track.scrollBy({ left: distance, behavior: reduceMotion ? 'auto' : 'smooth' });
        if (status) status.textContent = direction > 0 ? 'Défilement vers les montures suivantes.' : 'Défilement vers les montures précédentes.';
    };

    track.addEventListener('mouseenter', () => { hoverPaused = true; syncRotation(); });
    track.addEventListener('mouseleave', () => { hoverPaused = false; syncRotation(); });
    track.addEventListener('pointerdown', () => { interactionPaused = true; syncRotation(); }, { passive: true });
    track.addEventListener('pointerup', pauseBriefly, { passive: true });
    track.addEventListener('pointercancel', pauseBriefly, { passive: true });
    track.addEventListener('wheel', pauseBriefly, { passive: true });
    track.addEventListener('focusin', () => { focusWithin = true; syncRotation(); });
    track.addEventListener('focusout', event => {
        if (!track.contains(event.relatedTarget)) { focusWithin = false; syncRotation(); }
    });
    track.addEventListener('keydown', event => {
        if (event.target !== track) return;
        if (event.key === 'ArrowRight') { event.preventDefault(); pauseBriefly(); move(1); }
        if (event.key === 'ArrowLeft') { event.preventDefault(); pauseBriefly(); move(-1); }
    });

    const filters = document.querySelectorAll('[data-category-filter], [data-product-search], [data-reset-products]');
    filters.forEach(control => control.addEventListener('click', () => {
        pauseBriefly();
        track.scrollTo({ left: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        window.requestAnimationFrame(syncRotation);
    }));
    document.querySelector('[data-product-search]')?.addEventListener('input', () => {
        pauseBriefly();
        track.scrollTo({ left: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        window.requestAnimationFrame(syncRotation);
    });

    if ('MutationObserver' in window) {
        const visibilityObserver = new MutationObserver(() => {
            track.scrollTo({ left: 0, behavior: 'auto' });
            window.requestAnimationFrame(syncRotation);
        });
        visibilityObserver.observe(track, { attributes: true, attributeFilter: ['hidden'], subtree: true });
    }

    document.addEventListener('visibilitychange', syncRotation);
    window.addEventListener('resize', syncRotation, { passive: true });
    syncRotation();
})();
</script>
@endpush
