@extends('layouts.public')

@section('title', 'Nos montures — Optique Services')
@section('description', 'Parcourez les montures présentées par Optique Services à ACI 2000 et contactez la boutique pour connaître leur disponibilité.')

@section('content')
@php
    $montureConfig = config('montures', []);
    $montures = array_values(array_filter($montureConfig['items'] ?? [], function ($monture) {
        $image = basename($monture['image'] ?? '');
        return preg_match('/^monture-[a-z0-9_-]+\\.(?:jpe?g|png|webp)$/i', $image)
            && is_file(public_path('images/montures/' . $image));
    }));
    $montureFilters = $montureConfig['filters'] ?? [];
    $filterLabelMap = array_column($montureFilters, 'label', 'key');
    $coverPath = 'images/montures/catalogue-cover.jpg';
    if (!is_file(public_path($coverPath)) && !empty($montures)) {
        $coverPath = 'images/montures/' . basename($montures[0]['image']);
    }
    $coverImage = is_file(public_path($coverPath)) ? asset($coverPath) : null;
    $contactUrl = \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact');
@endphp

<section class="relative isolate overflow-hidden bg-[#fbf8f6]">
    <div class="pointer-events-none absolute -right-20 -top-24 -z-10 h-80 w-80 rounded-full bg-[#f1deda]/70 blur-3xl sm:h-[30rem] sm:w-[30rem]" aria-hidden="true"></div>
    <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 py-8 sm:px-6 sm:py-12 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:py-16">
        <div data-reveal>
            <a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="mb-5 inline-flex items-center gap-2 text-xs font-semibold text-optique-gray transition hover:text-optique-red">
                <span aria-hidden="true">←</span> Retour à l’accueil
            </a>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">La collection en boutique</p>
            <h1 class="mt-3 max-w-2xl font-serif text-4xl leading-[1.06] tracking-[-.04em] text-optique-text sm:text-5xl lg:text-6xl">Découvrez nos montures.</h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-optique-gray">Parcourez les modèles et filtrez la sélection par public, type de lunettes ou style. Pour vérifier une disponibilité, contactez notre équipe en boutique.</p>
            <a href="{{ $contactUrl }}" class="group mt-7 inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-optique-red px-6 py-3 text-sm font-semibold text-white shadow-md shadow-optique-red/15 transition duration-300 hover:-translate-y-0.5 hover:bg-optique-redhover">
                Contacter la boutique <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="group relative min-h-[14rem] overflow-hidden rounded-[1.75rem] bg-[#eee8e5] shadow-xl shadow-[#593b35]/10 sm:min-h-[20rem] sm:rounded-[2rem]" data-reveal>
            @if($coverImage)
                <img src="{{ $coverImage }}" alt="Monture de la sélection Optique Services" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-contain p-4 transition duration-700 group-hover:scale-[1.03] sm:p-8">
                <div class="absolute inset-0 bg-gradient-to-t from-[#211a18]/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-5 left-5 right-5 text-white sm:bottom-7 sm:left-7">
                    <p class="text-[10px] font-bold uppercase tracking-[.18em] text-white/80">Optique Services · ACI 2000</p>
                    <p class="mt-1 font-serif text-2xl">Bienvenue en boutique.</p>
                </div>
            @else
                <div class="absolute inset-0 grid place-items-center bg-gradient-to-br from-[#faf7f5] via-[#eee5e1] to-[#f8f5f3] p-6 text-center">
                    <div>
                        <svg class="mx-auto h-16 w-16 text-[#9e645e]/70" viewBox="0 0 64 40" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/>
                            <path stroke-linecap="round" stroke-width="2.5" d="M25 9c2-3 4-4 9-4s7 1 9 4M3 18H1m62 0h-2"/>
                        </svg>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-9 sm:px-6 sm:py-14 lg:px-8">
    <div class="flex flex-col gap-3 border-b border-optique-border pb-6 sm:flex-row sm:items-end sm:justify-between" data-reveal>
        <div>
            <p class="text-xs font-bold uppercase tracking-[.18em] text-optique-red">La sélection</p>
            <h2 class="mt-2 font-serif text-2xl tracking-tight text-optique-text sm:text-3xl">Nos montures</h2>
            <p class="mt-2 text-sm text-optique-gray">Les photos et leur classement sont gérés dans la sélection de la boutique.</p>
        </div>
        <p class="text-xs text-optique-gray" data-product-count aria-live="polite">{{ count($montures) }} modèle(s)</p>
    </div>

    <div class="mt-6 flex flex-col gap-4 sm:mt-8 lg:flex-row lg:items-center lg:justify-between" data-reveal>
        <div class="flex gap-2 overflow-x-auto pb-2" role="group" aria-label="Filtrer les montures">
            @foreach($montureFilters as $filter)
                <button type="button" data-category-filter="{{ $filter['key'] }}" aria-pressed="{{ $filter['key'] === 'all' ? 'true' : 'false' }}" @class(['shrink-0 rounded-full border px-4 py-2.5 text-xs font-semibold transition duration-200', 'bg-optique-red text-white border-optique-red shadow-md shadow-optique-red/15' => $filter['key'] === 'all', 'bg-white text-optique-gray border-optique-border hover:border-optique-red/40 hover:text-optique-text' => $filter['key'] !== 'all'])>{{ $filter['label'] }}</button>
            @endforeach
        </div>
        <label class="relative block w-full lg:max-w-xs">
            <span class="sr-only">Rechercher une monture</span>
            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-optique-gray" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m16 16 4 4"/></svg>
            <input type="search" data-product-search placeholder="Rechercher une monture…" class="w-full rounded-full border border-optique-border bg-white py-3 pl-11 pr-4 text-sm outline-none transition placeholder:text-optique-gray/70 focus:border-optique-red focus:ring-4 focus:ring-optique-red/10">
        </label>
    </div>

    @if(count($montures))
        <div class="mt-5 grid grid-cols-2 gap-3 sm:mt-7 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($montures as $index => $monture)
                @php
                    $montureName = $monture['name'] ?? 'Monture ' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                    $photoName = basename($monture['image'] ?? '');
                    $photoPath = 'images/montures/' . $photoName;
                    $validPhotoName = preg_match('/^monture-[a-z0-9_-]+\\.(?:jpe?g|png|webp)$/i', $photoName);
                    $photoUrl = $validPhotoName && is_file(public_path($photoPath)) ? asset($photoPath) : null;
                    $filterKeys = array_values(array_unique(array_filter(array_merge($monture['audiences'] ?? [], $monture['types'] ?? [], $monture['styles'] ?? []))));
                    $filterLabels = array_values(array_filter(array_map(fn ($key) => $filterLabelMap[$key] ?? null, $filterKeys)));
                    $searchText = implode(' ', array_filter(array_merge([$montureName, $monture['note'] ?? ''], $filterLabels)));
                @endphp
                <article data-category-card="{{ implode(' ', $filterKeys) }}" data-search="{{ $searchText }}" data-reveal class="group overflow-hidden rounded-2xl border border-optique-border bg-white transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.08] sm:rounded-3xl">
                    <div class="relative aspect-[4/3] overflow-hidden bg-[#f5f1ef] p-4 sm:p-6">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $montureName }} — photo du magasin" loading="lazy" decoding="async" class="h-full w-full object-contain transition duration-700 group-hover:scale-[1.04]" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <div style="display:none" class="absolute inset-0 place-items-center bg-gradient-to-br from-[#f8f2ef] via-[#eee5e1] to-[#faf8f6]"><div class="text-center"><span class="text-optique-red" aria-hidden="true">◎</span><p class="mt-2 text-[10px] text-optique-gray">Photo introuvable : {{ $photoName }}</p></div></div>
                        @else
                            <div class="absolute inset-0 grid place-items-center bg-gradient-to-br from-[#f8f2ef] via-[#eee5e1] to-[#faf8f6] p-4 text-center"><div><span class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-white text-xl text-optique-red" aria-hidden="true">◎</span><p class="mt-3 text-[10px] font-semibold uppercase tracking-[.13em] text-optique-gray">Photo à ajouter</p><p class="mt-1 text-[10px] text-optique-gray">{{ $photoName }}</p></div></div>
                        @endif
                        <span class="absolute right-3 top-3 rounded-full border border-white/80 bg-white/90 px-2.5 py-1 text-[9px] font-bold uppercase tracking-[.1em] text-optique-gray shadow-sm backdrop-blur sm:right-4 sm:top-4 sm:text-[10px]">{{ count($filterLabels) ? implode(' · ', $filterLabels) : 'Collection' }}</span>
                    </div>
                    <div class="p-3.5 sm:p-5">
                        <h3 class="font-serif text-base text-optique-text sm:text-lg">{{ $montureName }}</h3>
                        <p class="mt-1 text-xs leading-5 text-optique-gray">{{ $monture['note'] ?: 'Essayage et disponibilité à confirmer en boutique.' }}</p>
                        <div class="mt-4 flex items-center justify-between border-t border-optique-border pt-3">
                            <span class="text-[10px] font-medium uppercase tracking-[.12em] text-optique-gray">Infos en boutique</span>
                            <a href="{{ $photoUrl ?? $contactUrl }}" @if($photoUrl) target="_blank" rel="noopener" @endif class="text-xs font-semibold text-optique-red transition hover:underline">{{ $photoUrl ? 'Agrandir ↗' : 'Nous contacter →' }}</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div data-product-empty hidden class="mt-8 rounded-2xl border border-dashed border-optique-border bg-white px-5 py-10 text-center"><span class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-[#fbf1ef] text-xl text-optique-red" aria-hidden="true">⌕</span><p class="mt-3 font-serif text-xl">Aucune monture trouvée</p><p class="mt-1 text-sm text-optique-gray">Essayez une autre recherche ou sélectionnez une autre catégorie.</p><button type="button" data-reset-products class="mt-4 text-sm font-semibold text-optique-red underline underline-offset-4">Effacer les filtres</button></div>
    @else
        <div class="mt-7 rounded-3xl border border-dashed border-optique-border bg-white px-5 py-14 text-center sm:py-20" data-reveal>
            <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-[#fbf1ef] text-2xl text-optique-red" aria-hidden="true">⌕</span>
            <h3 class="mt-4 font-serif text-2xl text-optique-text">Une monture faite pour vous</h3>
            <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-optique-gray">Venez découvrir les modèles disponibles et demander conseil à notre équipe en boutique.</p>
            <a href="{{ $contactUrl }}" class="mt-5 inline-flex items-center gap-2 rounded-full bg-optique-red px-5 py-3 text-sm font-semibold text-white transition hover:bg-optique-redhover">Contacter la boutique <span aria-hidden="true">→</span></a>
        </div>
    @endif
</section>
@endsection
