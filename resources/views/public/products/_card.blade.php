@php
    // Les photos ne sont pas stockées en base : elles sont nommées selon leur ordre
    // dans la liste (et leur position globale si le catalogue est paginé).
    $imageNumber = max(1, (int) ($imageNumber ?? $loop->iteration ?? 1));
    $manualImageName = 'monture-' . str_pad((string) $imageNumber, 2, '0', STR_PAD_LEFT) . '.jpg';
    $manualImagePath = 'images/montures/' . $manualImageName;
    $cardImage = is_file(public_path($manualImagePath)) ? asset($manualImagePath) : null;
    $categoryName = $product->category?->name ?? 'Monture';
@endphp

<article class="group h-full overflow-hidden rounded-2xl border border-optique-border bg-white transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.08] sm:rounded-3xl" data-reveal>
    <a href="{{ route('products.show', $product) }}" class="flex h-full flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-optique-red" aria-label="Découvrir {{ $product->name }}">
        <div class="relative aspect-[4/3] overflow-hidden bg-[#f5f1ef] p-4 sm:p-6">
            @if($cardImage)
                <img src="{{ $cardImage }}" alt="{{ $product->name }} — monture présentée par Optique Services" loading="lazy" decoding="async" class="h-full w-full object-contain transition duration-700 group-hover:scale-[1.04]" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                <div style="display:none" class="absolute inset-0 place-items-center bg-gradient-to-br from-[#f8f2ef] via-[#eee5e1] to-[#faf8f6]">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-[#9e645e]/70" fill="none" stroke="currentColor" viewBox="0 0 64 40" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/>
                            <path stroke-linecap="round" stroke-width="2.5" d="M25 9c2-3 4-4 9-4s7 1 9 4M3 18H1m62 0h-2"/>
                        </svg>
                        <p class="mt-3 text-[10px] font-semibold uppercase tracking-[.14em] text-optique-gray">Photo introuvable</p>
                        <p class="mt-1 text-[10px] text-optique-gray">{{ $manualImageName }}</p>
                    </div>
                </div>
            @else
                <div class="absolute inset-0 grid place-items-center bg-gradient-to-br from-[#f8f2ef] via-[#eee5e1] to-[#faf8f6]">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-[#9e645e]/70 transition duration-500 group-hover:scale-105" fill="none" stroke="currentColor" viewBox="0 0 64 40" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 19c1-7 5-11 13-11h9c6 0 8 3 9 8 1-5 3-8 9-8h5c8 0 12 4 13 11-1 9-5 13-13 13-7 0-11-5-13-13-2 8-6 13-13 13C8 32 4 28 3 19Z"/>
                            <path stroke-linecap="round" stroke-width="2.5" d="M25 9c2-3 4-4 9-4s7 1 9 4M3 18H1m62 0h-2"/>
                        </svg>
                        <p class="mt-3 text-[10px] font-semibold uppercase tracking-[.14em] text-optique-gray">Photo à ajouter</p>
                        <p class="mt-1 text-[10px] text-optique-gray">{{ $manualImageName }}</p>
                    </div>
                </div>
            @endif

            <span class="absolute right-3 top-3 max-w-[65%] truncate rounded-full border border-white/80 bg-white/90 px-2.5 py-1 text-[9px] font-bold uppercase tracking-[.1em] text-optique-gray shadow-sm backdrop-blur sm:right-4 sm:top-4 sm:text-[10px]">{{ $categoryName }}</span>
            <span class="absolute bottom-3 right-3 grid h-10 w-10 translate-y-1 place-items-center rounded-full bg-white text-lg text-optique-red opacity-0 shadow-lg transition duration-300 group-hover:translate-y-0 group-hover:opacity-100 group-focus-visible:translate-y-0 group-focus-visible:opacity-100" aria-hidden="true">↗</span>
        </div>

        <div class="flex flex-1 flex-col p-3.5 sm:p-5">
            <p class="text-[9px] font-bold uppercase tracking-[.17em] text-optique-red sm:text-[10px]">Optique Services</p>
            <h2 class="mt-1 font-serif text-base leading-snug text-optique-text transition group-hover:text-optique-red sm:text-lg">{{ $product->name }}</h2>
            <p class="mt-2 line-clamp-2 text-[11px] leading-5 text-optique-gray sm:text-sm">{{ $product->description ?: 'Découvrez ce modèle et demandez conseil à notre équipe en boutique.' }}</p>

            <div class="mt-auto flex items-end justify-between gap-3 border-t border-optique-border pt-3.5 sm:pt-4">
                <div class="min-w-0">
                    <p class="text-[9px] font-semibold uppercase tracking-[.12em] text-optique-gray">{{ $product->price_mode === 'fixed' || $product->price_mode === 'from' ? 'Prix indicatif' : 'En boutique' }}</p>
                    <p class="mt-1 text-xs font-semibold leading-5 text-optique-text sm:text-sm">
                        @if($product->price_mode === 'fixed' && $product->price)
                            {{ number_format($product->price, 0, ',', ' ') }} FCFA
                        @elseif($product->price_mode === 'from' && $product->price)
                            Dès {{ number_format($product->price, 0, ',', ' ') }} FCFA
                        @else
                            Prix et disponibilité à confirmer en magasin
                        @endif
                    </p>
                </div>
                <span class="shrink-0 text-[10px] font-bold text-optique-red transition group-hover:translate-x-1 sm:text-xs">Voir <span aria-hidden="true">→</span></span>
            </div>
        </div>
    </a>
</article>
