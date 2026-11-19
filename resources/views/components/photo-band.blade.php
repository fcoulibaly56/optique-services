@props([
    'image'  => null,
    'alt'    => '',
    'title'  => '',
    'text'   => null,
    'tag'    => 'h2',                                  // 'h1' sur les pages qui n'ont pas d'autre titre principal
    'height' => 'min-h-[26rem] sm:min-h-[32rem]',      // classes Tailwind écrites en entier (voir note JIT)
])
@php
    // Si le fichier n'existe pas encore, on affiche un fond de remplacement sobre (pas d'image cassée).
    $src = $image && file_exists(public_path($image)) ? asset($image) : null;
@endphp

<section {{ $attributes->merge(['class' => "relative isolate flex items-end overflow-hidden bg-[#2a2220] text-white $height"]) }}>
    <div class="absolute inset-0 -z-10 overflow-hidden" aria-hidden="{{ $src ? 'false' : 'true' }}">
        @if($src)
            {{-- h-[124%] : l'image dépasse de 24 % pour avoir de la marge à parcourir pendant la parallaxe --}}
            <img src="{{ $src }}" alt="{{ $alt }}" loading="lazy" decoding="async" data-parallax
                 class="absolute left-0 top-0 h-[124%] w-full object-cover will-change-transform">
        @else
            <div class="h-full w-full bg-gradient-to-br from-[#5b2f2c] to-[#2a2220]"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-[#1c1c1c]/80 via-[#1c1c1c]/35 to-[#1c1c1c]/10"></div>
    </div>

    <div class="mx-auto w-full max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
        <div class="max-w-2xl">
            <{{ $tag }} class="font-serif text-3xl leading-tight tracking-tight sm:text-4xl lg:text-5xl">{{ $title }}</{{ $tag }}>
            @if($text)
                <p class="mt-4 max-w-xl text-base leading-7 text-white/85">{{ $text }}</p>
            @endif
            @if(trim((string) $slot) !== '')
                <div class="mt-7 flex flex-col gap-3 sm:flex-row">{{ $slot }}</div>
            @endif
        </div>
    </div>
</section>