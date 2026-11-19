@extends('layouts.public')

@section('title', $product->name . ' — Optique Services')
@section('description', $product->description ?: $product->name . ' : découvrez les caractéristiques et demandez un essayage chez Optique Services à ACI 2000, Bamako.')

@section('content')
@php
    $categoryName = $product->category->name ?? 'Monture';
    $rawImage = $product->image ?? $product->image_path ?? null;
    $productImage = $rawImage
        ? (\Illuminate\Support\Str::startsWith($rawImage, ['http://', 'https://'])
            ? $rawImage
            : \Illuminate\Support\Facades\Storage::url($rawImage))
        : null;
    $appointmentUrl = \Illuminate\Support\Facades\Route::has('appointment.create')
        ? route('appointment.create', ['motive' => 'essayage'])
        : url('/#contact');
    $contactUrl = \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact');
@endphp

<section class="relative isolate overflow-hidden bg-[#fbf8f6]">
    <div class="pointer-events-none absolute -right-24 -top-24 -z-10 h-80 w-80 rounded-full bg-[#f1deda]/70 blur-3xl sm:h-[34rem] sm:w-[34rem]" aria-hidden="true"></div>
    <div class="mx-auto max-w-7xl px-4 pb-14 pt-7 sm:px-6 sm:pb-20 sm:pt-10 lg:px-8">
        <nav aria-label="Fil d’Ariane" class="mb-7 overflow-x-auto whitespace-nowrap text-xs text-optique-gray sm:mb-9 sm:text-sm">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="transition hover:text-optique-red">Accueil</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="{{ \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : url('/#collection') }}" class="transition hover:text-optique-red">Nos lunettes</a></li>
                <li aria-hidden="true">/</li>
                <li aria-current="page" class="max-w-[12rem] truncate font-semibold text-optique-text sm:max-w-xs">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid gap-8 lg:grid-cols-[1.08fr_.92fr] lg:items-start lg:gap-14 xl:gap-20">
            <div data-reveal>
                <div class="group relative overflow-hidden rounded-[1.75rem] border border-optique-border bg-white p-3 shadow-xl shadow-[#593b35]/[.06] sm:rounded-[2rem] sm:p-5">
                    <div class="relative grid aspect-[4/3] place-items-center overflow-hidden rounded-[1.25rem] bg-gradient-to-br from-[#faf7f5] via-[#f1ebe8] to-[#f8f5f3] sm:rounded-[1.5rem]">
                        @if($productImage)
                            <button type="button" data-product-image-open class="absolute inset-0 grid h-full w-full place-items-center p-5 sm:p-10" aria-label="Agrandir la photo de {{ $product->name }}">
                                <img src="{{ $productImage }}" alt="{{ $product->name }} — {{ $categoryName }}" fetchpriority="high" class="h-full w-full object-contain transition duration-700 group-hover:scale-[1.025]" onerror="this.onerror=null;this.hidden=true;document.getElementById('product-image-fallback').hidden=false;">
                            </button>
                            <div id="product-image-fallback" hidden class="absolute inset-0 grid place-items-center p-6 text-center"><div><svg class="mx-auto h-20 w-20 text-[#9e645e]/70" fill="none" stroke="currentColor" viewBox="0 0 64 40" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/><path stroke-linecap="round" stroke-width="2.4" d="M25 9c2-3 4-4 9-4s7 1 9 4M3 18H1m62 0h-2"/></svg><p class="mt-4 text-xs font-semibold uppercase tracking-[.16em] text-optique-gray">Photo du modèle à ajouter</p></div></div>
                        @else
                            <div class="px-6 text-center"><svg class="mx-auto h-24 w-24 text-[#9e645e]/70 transition duration-500 group-hover:scale-105 group-hover:-rotate-2" fill="none" stroke="currentColor" viewBox="0 0 64 40" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/><path stroke-linecap="round" stroke-width="2.4" d="M25 9c2-3 4-4 9-4s7 1 9 4M3 18H1m62 0h-2"/></svg><p class="mt-4 text-xs font-semibold uppercase tracking-[.16em] text-optique-gray">Photo du modèle à ajouter</p></div>
                        @endif
                        <span class="pointer-events-none absolute left-4 top-4 rounded-full border border-white/80 bg-white/90 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[.15em] text-optique-red shadow-sm backdrop-blur sm:left-5 sm:top-5">{{ $categoryName }}</span>
                        @if($productImage)<span class="pointer-events-none absolute bottom-4 right-4 grid h-10 w-10 place-items-center rounded-full border border-white/70 bg-white/85 text-optique-text shadow-md backdrop-blur transition group-hover:scale-105" aria-hidden="true"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10.5" cy="10.5" r="6.5"/><path stroke-linecap="round" d="m15.5 15.5 5 5M10.5 7.5v6m-3-3h6"/></svg></span>@endif
                    </div>
                    <p class="px-2 pb-1 pt-3 text-center text-[10px] text-optique-gray sm:text-xs">{{ $productImage ? 'Photo du modèle · Appuyez pour agrandir' : 'Photo réelle à ajouter pour présenter ce modèle' }}</p>
                </div>

                @if($productImage)
                    <dialog id="product-image-dialog" class="m-auto max-h-[92vh] max-w-[94vw] overflow-visible rounded-2xl bg-transparent p-0 backdrop:bg-[#171312]/80 backdrop:backdrop-blur-sm">
                        <div class="relative rounded-2xl border border-white/20 bg-white p-2 shadow-2xl sm:p-3">
                            <button type="button" data-product-image-close class="absolute -right-3 -top-3 z-10 grid h-10 w-10 place-items-center rounded-full bg-white text-xl text-optique-text shadow-lg transition hover:bg-[#fbefed] hover:text-optique-red" aria-label="Fermer l’image agrandie">×</button>
                            <img src="{{ $productImage }}" alt="{{ $product->name }} — vue agrandie" class="max-h-[82vh] max-w-[90vw] rounded-xl object-contain">
                        </div>
                    </dialog>
                @endif
            </div>

            <div class="lg:sticky lg:top-28" data-reveal>
                <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">{{ $categoryName }} · Optique Services</p>
                <h1 class="mt-3 font-serif text-3xl leading-[1.08] tracking-[-.035em] text-optique-text sm:text-4xl lg:text-5xl">{{ $product->name }}</h1>

                <div class="mt-5 inline-flex max-w-full items-center gap-2 rounded-2xl border border-[#ead8d4] bg-white/80 px-4 py-3">
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fbefed] text-optique-red" aria-hidden="true"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M6 3v4m12-4v4M5 11h14v9H5z"/></svg></span>
                    <div class="min-w-0"><p class="text-[9px] font-bold uppercase tracking-[.14em] text-optique-gray">{{ $product->price_mode === 'fixed' || $product->price_mode === 'from' ? 'Prix indiqué' : 'Disponibilité' }}</p><p class="text-sm font-semibold leading-5 text-optique-text">@if ($product->price_mode === 'fixed' && $product->price){{ number_format($product->price, 0, ',', ' ') }} FCFA @elseif ($product->price_mode === 'from' && $product->price)À partir de {{ number_format($product->price, 0, ',', ' ') }} FCFA @else Prix et disponibilité à confirmer en magasin @endif</p></div>
                </div>

                <div class="mt-6 border-t border-optique-border pt-5">
                    <h2 class="text-xs font-bold uppercase tracking-[.16em] text-optique-gray">À propos du modèle</h2>
                    <p class="mt-3 text-sm leading-7 text-optique-gray sm:text-base">{{ $product->description ?: 'Contactez notre équipe pour en savoir plus sur ce modèle et vérifier sa disponibilité en boutique.' }}</p>
                </div>

                @if($product->brand || $product->material || $product->size)
                    <div class="mt-6 border-t border-optique-border pt-5">
                        <h2 class="text-xs font-bold uppercase tracking-[.16em] text-optique-gray">Caractéristiques</h2>
                        <dl class="mt-3 divide-y divide-optique-border text-sm">
                            @if($product->brand)<div class="flex items-center justify-between gap-4 py-3"><dt class="text-optique-gray">Marque</dt><dd class="text-right font-semibold text-optique-text">{{ $product->brand }}</dd></div>@endif
                            @if($product->material)<div class="flex items-center justify-between gap-4 py-3"><dt class="text-optique-gray">Matériau</dt><dd class="text-right font-semibold text-optique-text">{{ $product->material }}</dd></div>@endif
                            @if($product->size)<div class="flex items-center justify-between gap-4 py-3"><dt class="text-optique-gray">Taille</dt><dd class="text-right font-semibold text-optique-text">{{ $product->size }}</dd></div>@endif
                        </dl>
                    </div>
                @endif

                <div class="mt-7 space-y-3">
                    <a href="{{ $appointmentUrl }}" class="group inline-flex min-h-14 w-full items-center justify-center gap-3 rounded-full bg-optique-red px-6 py-4 text-sm font-bold text-white shadow-lg shadow-optique-red/15 transition duration-300 hover:-translate-y-0.5 hover:bg-optique-redhover hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-optique-red focus:ring-offset-2 sm:text-base">Demander un essayage <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></a>
                    <a href="{{ $contactUrl }}" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-full border border-optique-border bg-white px-6 py-3 text-sm font-semibold text-optique-text transition hover:border-optique-red/40 hover:text-optique-red">Poser une question sur ce modèle</a>
                </div>

                <div class="mt-5 flex items-start gap-3 rounded-2xl border border-optique-border bg-white/75 p-4"><span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-[#fbefed] text-optique-red" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg></span><div><p class="text-sm font-semibold text-optique-text">Essayage et ajustage en boutique</p><p class="mt-1 text-xs leading-5 text-optique-gray">Notre équipe vous accompagne pour vérifier le confort et l’ajustement de la monture.</p></div></div>
            </div>
        </div>

        @if($related->count() > 0)
            <section class="mt-16 border-t border-optique-border pt-12 sm:mt-24 sm:pt-16" aria-labelledby="related-products-title">
                <div class="flex items-end justify-between gap-4" data-reveal><div><p class="text-xs font-bold uppercase tracking-[.18em] text-optique-red">À découvrir aussi</p><h2 id="related-products-title" class="mt-2 font-serif text-2xl sm:text-3xl">Dans le même esprit.</h2></div><a href="{{ \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : url('/#collection') }}" class="shrink-0 text-xs font-semibold text-optique-red underline underline-offset-4">Tout voir</a></div>
                <div class="mt-6 grid grid-cols-2 gap-3 sm:mt-8 sm:gap-5 lg:grid-cols-4">
                    @foreach($related as $rel)
                        @php
                            $relatedRawImage = $rel->image ?? $rel->image_path ?? null;
                            $relatedImage = $relatedRawImage
                                ? (\Illuminate\Support\Str::startsWith($relatedRawImage, ['http://', 'https://'])
                                    ? $relatedRawImage
                                    : \Illuminate\Support\Facades\Storage::url($relatedRawImage))
                                : null;
                        @endphp
                        <a href="{{ route('products.show', $rel) }}" class="group overflow-hidden rounded-2xl border border-optique-border bg-white transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-lg sm:rounded-3xl" data-reveal>
                            <div class="relative aspect-[1/1] overflow-hidden bg-gradient-to-br from-[#faf7f5] to-[#eee5e1] p-3 sm:p-5">
                                @if($relatedImage)
                                    <img src="{{ $relatedImage }}" alt="{{ $rel->name }}" loading="lazy" class="h-full w-full object-contain transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.hidden=true;this.nextElementSibling.hidden=false;">
                                    <div hidden class="absolute inset-0 grid place-items-center"><svg class="h-14 w-14 text-[#9e645e]/60" fill="none" stroke="currentColor" viewBox="0 0 64 40" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/></svg></div>
                                @else
                                    <div class="absolute inset-0 grid place-items-center"><svg class="h-14 w-14 text-[#9e645e]/60" fill="none" stroke="currentColor" viewBox="0 0 64 40" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/></svg></div>
                                @endif
                                <span class="absolute left-2.5 top-2.5 rounded-full bg-white/90 px-2.5 py-1 text-[9px] font-bold uppercase tracking-[.12em] text-optique-gray shadow-sm">{{ $rel->category->name ?? 'Monture' }}</span>
                            </div>
                            <div class="p-3.5 sm:p-5"><h3 class="font-serif text-sm leading-snug text-optique-text transition group-hover:text-optique-red sm:text-base">{{ $rel->name }}</h3><p class="mt-2 border-t border-optique-border pt-2 text-[10px] font-medium text-optique-gray sm:text-xs">Voir le modèle <span class="text-optique-red" aria-hidden="true">→</span></p></div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
    const dialog = document.getElementById('product-image-dialog');
    const openButton = document.querySelector('[data-product-image-open]');
    const closeButton = document.querySelector('[data-product-image-close]');
    if (!dialog || !openButton || typeof dialog.showModal !== 'function') return;
    openButton.addEventListener('click', () => dialog.showModal());
    closeButton?.addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', event => { if (event.target === dialog) dialog.close(); });
})();
</script>
@endpush
