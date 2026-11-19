@extends('layouts.public')

@section('title', 'Contact — Optique Services')
@section('description', 'Contactez Optique Services à ACI 2000, Bamako : téléphone, WhatsApp, horaires et formulaire de message.')

@section('content')
@php
    $phonePrimary = '+22376882712';
    $phoneSecondary = '+22365868757';
    $whatsAppUrl = 'https://wa.me/22376882712?text=' . rawurlencode('Bonjour Optique Services, je souhaite obtenir un renseignement.');
    $mapsUrl = 'https://maps.google.com/?q=' . rawurlencode('Station TOTAL, Place CAN, ACI 2000, Bamako');
@endphp

<section class="relative isolate overflow-hidden bg-[#fbf8f6]">
    <div class="pointer-events-none absolute -right-20 -top-24 -z-10 h-80 w-80 rounded-full bg-[#f1deda]/70 blur-3xl sm:h-[32rem] sm:w-[32rem]" aria-hidden="true"></div>
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
        <div class="max-w-3xl" data-reveal>
            <a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="mb-6 inline-flex items-center gap-2 text-xs font-semibold text-optique-gray transition hover:text-optique-red"><span aria-hidden="true">←</span> Accueil</a>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">On est là pour vous</p>
            <h1 class="mt-3 font-serif text-4xl leading-[1.05] tracking-[-.04em] text-optique-text sm:text-5xl lg:text-6xl">Parlons de votre prochain regard.</h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-optique-gray sm:text-lg sm:leading-8">Une question sur une monture, un service ou une visite en boutique ? Contactez l’équipe Optique Services, nous serons heureux de vous orienter.</p>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 sm:pb-24 lg:px-8">
    <div class="grid gap-6 lg:grid-cols-[.72fr_1.28fr] lg:gap-8">
        <aside class="space-y-4" data-reveal aria-label="Coordonnées du magasin">
            <article class="rounded-3xl border border-optique-border bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-lg sm:p-6">
                <div class="flex gap-4"><span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#fbefed] text-optique-red"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0Z"/><circle cx="12" cy="11" r="2.5"/></svg></span><div><h2 class="font-serif text-lg">Venez nous voir</h2><p class="mt-1 text-sm leading-6 text-optique-gray">Station TOTAL, près de la Place CAN<br>ACI 2000, Bamako</p><a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-optique-red hover:underline">Ouvrir l’itinéraire <span aria-hidden="true">↗</span></a></div></div>
            </article>
            <article class="rounded-3xl border border-optique-border bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-lg sm:p-6">
                <div class="flex gap-4"><span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#fbefed] text-optique-red"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h3.2a1 1 0 0 1 .95.68l1.5 4.5a1 1 0 0 1-.5 1.2l-2.3 1.15a11 11 0 0 0 5.5 5.5l1.15-2.3a1 1 0 0 1 1.2-.5l4.5 1.5a1 1 0 0 1 .7.95V19a2 2 0 0 1-2 2h-1C9.7 21 3 14.3 3 6V5Z"/></svg></span><div><h2 class="font-serif text-lg">Appelez-nous</h2><div class="mt-1 space-y-1 text-sm"><a href="tel:{{ $phonePrimary }}" class="block text-optique-gray transition hover:text-optique-red">76 88 27 12</a><a href="tel:{{ $phoneSecondary }}" class="block text-optique-gray transition hover:text-optique-red">65 86 87 57</a></div></div></div>
            </article>
            <article class="rounded-3xl border border-optique-border bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-lg sm:p-6">
                <div class="flex gap-4"><span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#fbefed] text-optique-red"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg></span><div><h2 class="font-serif text-lg">Horaires d’ouverture</h2><div class="mt-2 space-y-1 text-sm text-optique-gray"><p class="flex justify-between gap-6"><span>Lundi – vendredi</span><span class="font-medium text-optique-text">08:30 – 18:30</span></p><p class="flex justify-between gap-6"><span>Samedi</span><span class="font-medium text-optique-text">09:00 – 14:00</span></p><p class="flex justify-between gap-6"><span>Dimanche</span><span class="font-medium text-optique-red">Fermé</span></p></div></div></div>
            </article>
            <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer" class="group flex min-h-14 items-center justify-center gap-3 rounded-full border border-[#25D366]/40 bg-white px-5 py-4 text-sm font-bold text-[#178c45] shadow-sm transition duration-300 hover:-translate-y-0.5 hover:bg-[#25D366] hover:text-white hover:shadow-lg"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>Écrire sur WhatsApp <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">↗</span></a>
        </aside>

        <div class="overflow-hidden rounded-[1.75rem] border border-optique-border bg-white shadow-xl shadow-[#593b35]/[.06] sm:rounded-[2rem]" data-reveal>
            <div class="p-5 sm:p-8 lg:p-10">
                <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Écrivez-nous</p>
                <h2 class="mt-2 font-serif text-2xl sm:text-3xl">Envoyez un message à l’équipe.</h2>
                <p class="mt-2 text-sm leading-6 text-optique-gray">Remplissez le formulaire ci-dessous et nous reviendrons vers vous.</p>

                @if(session('success'))
                    <div role="status" class="mt-6 flex gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-800"><span aria-hidden="true">✓</span><p>{{ session('success') }}</p></div>
                @endif
                @if($errors->any())
                    <div role="alert" class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800"><p class="font-semibold">Vérifiez les informations suivantes :</p><ul class="mt-2 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif

                <form action="{{ \Illuminate\Support\Facades\Route::has('contact.store') ? route('contact.store') : '#' }}" method="POST" class="mt-7 space-y-5">
                    @csrf
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div><label for="name" class="mb-1.5 block text-sm font-semibold">Nom complet <span class="text-optique-red">*</span></label><input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="name" required aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" class="block min-h-12 w-full rounded-xl border border-optique-border bg-[#fcfaf9] px-4 py-3 text-sm outline-none transition focus:border-optique-red focus:bg-white focus:ring-4 focus:ring-optique-red/10 @error('name') border-red-500 @enderror">@error('name')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                        <div><label for="phone" class="mb-1.5 block text-sm font-semibold">Téléphone <span class="text-optique-red">*</span></label><input type="tel" name="phone" id="phone" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" required aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}" class="block min-h-12 w-full rounded-xl border border-optique-border bg-[#fcfaf9] px-4 py-3 text-sm outline-none transition focus:border-optique-red focus:bg-white focus:ring-4 focus:ring-optique-red/10 @error('phone') border-red-500 @enderror">@error('phone')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                    </div>
                    <div><label for="email" class="mb-1.5 block text-sm font-semibold">Adresse email <span class="font-normal text-optique-gray">(facultatif)</span></label><input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" class="block min-h-12 w-full rounded-xl border border-optique-border bg-[#fcfaf9] px-4 py-3 text-sm outline-none transition focus:border-optique-red focus:bg-white focus:ring-4 focus:ring-optique-red/10 @error('email') border-red-500 @enderror">@error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                    <div><label for="message" class="mb-1.5 block text-sm font-semibold">Votre message <span class="text-optique-red">*</span></label><textarea name="message" id="message" rows="5" required aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}" class="block w-full resize-y rounded-xl border border-optique-border bg-[#fcfaf9] px-4 py-3 text-sm outline-none transition placeholder:text-optique-gray/70 focus:border-optique-red focus:bg-white focus:ring-4 focus:ring-optique-red/10 @error('message') border-red-500 @enderror" placeholder="Comment pouvons-nous vous aider ?">{{ old('message') }}</textarea>@error('message')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                    <button type="submit" class="group inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-optique-red px-7 py-3 text-sm font-bold text-white shadow-md shadow-optique-red/15 transition duration-300 hover:-translate-y-0.5 hover:bg-optique-redhover hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-optique-red focus:ring-offset-2 sm:w-auto">Envoyer le message <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></button>
                    <p class="text-xs leading-5 text-optique-gray">Les champs marqués d’un astérisque sont obligatoires. N’indiquez pas d’informations médicales sensibles dans ce formulaire.</p>
                </form>
            </div>
            <div class="relative overflow-hidden border-t border-optique-border bg-[#f4eeeb]">
                <iframe title="Carte Google Maps — Optique Services, Station TOTAL près de la Place CAN, ACI 2000, Bamako" src="https://www.google.com/maps?q={{ rawurlencode('Station TOTAL, près de la Place CAN, ACI 2000, Bamako') }}&amp;output=embed" class="block h-72 w-full border-0 sm:h-[22rem]" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between gap-3 rounded-xl border border-white/70 bg-white/95 px-4 py-3 shadow-lg backdrop-blur"><p class="text-xs font-medium leading-5 text-optique-text">Station TOTAL, près de la Place CAN · ACI 2000</p><a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="shrink-0 text-xs font-bold text-optique-red hover:underline">Itinéraire ↗</a></div>
            </div>
        </div>
    </div>
</section>
@endsection
