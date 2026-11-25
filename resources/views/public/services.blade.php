@extends('layouts.public')

@section('title', 'Nos services — Optique Services')
@section('description', 'Découvrez les services d’Optique Services : conseils, rendez-vous, ajustage et réparation, lentilles de contact.')

@section('content')
@php
    $appointmentUrl = \Illuminate\Support\Facades\Route::has('appointment.create') ? route('appointment.create') : url('/#contact');
    $contactUrl = \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact');

    // Une photo par service : renomme les chemins avec tes vraies images (dossier public/images/services/).
    $serviceItems = [
        ['id' => 'conseil', 'title' => 'Conseil & choix des montures', 'photo' => 'images/services/conseil.jpg', 'alt' => 'Une opticienne aide une cliente à choisir sa monture',
         'description' => 'Parlons de vos préférences, de votre quotidien et du style que vous recherchez pour explorer les montures qui pourraient vous correspondre.', 'label' => 'Découvrir les montures', 'target' => 'appointment'],
        ['id' => 'examen', 'title' => 'Examen de la vue', 'photo' => 'images/services/examen.jpg', 'alt' => 'Espace dédié à l’examen de la vue',
         'description' => 'Renseignez-vous auprès de l’équipe sur les possibilités de rendez-vous et les modalités proposées par le magasin.', 'label' => 'Demander un rendez-vous', 'target' => 'appointment'],
        ['id' => 'ajustage', 'title' => 'Adaptation & ajustage', 'photo' => 'images/services/ajustage.jpg', 'alt' => 'Ajustage d’une paire de lunettes à l’atelier',
         'description' => 'Un ajustage adapté contribue au confort de vos lunettes. L’équipe peut vous renseigner sur les options et les disponibilités en boutique.', 'label' => 'Contacter le magasin', 'target' => 'contact'],
        ['id' => 'reparation', 'title' => 'Entretien & réparation', 'photo' => 'images/services/reparation.jpg', 'alt' => 'Outils de réparation de lunettes',
         'description' => 'Pour une question sur l’entretien, un réglage ou une réparation, contactez le magasin afin de vérifier ce qui peut être pris en charge.', 'label' => 'Poser une question', 'target' => 'contact'],
        ['id' => 'lentilles', 'title' => 'Lentilles de contact', 'photo' => 'images/services/lentilles.jpg', 'alt' => 'Boîtes de lentilles de contact',
         'description' => 'L’équipe peut vous informer sur les solutions proposées en boutique et vous orienter selon votre demande.', 'label' => 'Nous demander conseil', 'target' => 'contact'],
    ];
@endphp

{{-- Bandeau d'ouverture : le seul <h1> de la page --}}
<x-photo-band tag="h1"
              image="images/services/bandeau.jpg"
              alt="La boutique Optique Services"
              title="Des services pensés autour de votre regard."
              text="Du choix de vos lunettes à leur ajustage, l’équipe Optique Services vous accueille et vous accompagne selon vos besoins."
              height="min-h-[22rem] sm:min-h-[28rem]">
    <a href="{{ $appointmentUrl }}" class="inline-flex min-h-12 items-center justify-center rounded-full bg-optique-red px-6 py-3 text-sm font-semibold text-white shadow-md shadow-black/20 transition hover:-translate-y-0.5 hover:bg-optique-redhover">Prendre rendez-vous</a>
    <a href="{{ $contactUrl }}" class="inline-flex min-h-12 items-center justify-center rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Poser une question</a>
</x-photo-band>

{{-- Un service = une rangée photo + texte, en alternance gauche/droite sur grand écran --}}
<section class="mx-auto max-w-7xl space-y-16 px-4 py-16 sm:space-y-24 sm:px-6 sm:py-24 lg:px-8">
    @foreach($serviceItems as $i => $service)
        @php
            $src = file_exists(public_path($service['photo'])) ? asset($service['photo']) : null;
            $href = $service['target'] === 'appointment' ? $appointmentUrl : $contactUrl;
        @endphp
        <article id="{{ $service['id'] }}" data-reveal class="grid scroll-mt-28 items-center gap-8 lg:grid-cols-2 lg:gap-16">
            {{-- Les classes sont écrites EN ENTIER ('lg:order-2'), jamais assemblées : Tailwind ne les trouverait pas sinon --}}
            <div class="relative {{ $i % 2 === 1 ? 'lg:order-2' : '' }}">
                <div class="absolute -bottom-3 -right-3 h-2/3 w-2/3 rounded-[2rem] bg-[#f1dfdb]" aria-hidden="true"></div>
                @if($src)
                    <img src="{{ $src }}" alt="{{ $service['alt'] }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}" decoding="async" width="1200" height="900"
                         class="relative aspect-[4/3] w-full rounded-[1.75rem] object-cover shadow-xl shadow-[#593b35]/10 sm:rounded-[2rem]">
                @else
                    <div class="relative aspect-[4/3] w-full rounded-[1.75rem] bg-[#eae1dd] sm:rounded-[2rem]" role="img" aria-label="Photo à venir"></div>
                @endif
            </div>
            <div>
                <h2 class="font-serif text-3xl leading-tight tracking-tight sm:text-4xl">{{ $service['title'] }}</h2>
                <p class="mt-4 max-w-xl text-base leading-7 text-optique-gray">{{ $service['description'] }}</p>
                <a href="{{ $href }}" class="mt-6 inline-flex min-h-12 items-center justify-center rounded-full border border-optique-border px-6 py-3 text-sm font-semibold transition hover:border-optique-red hover:text-optique-red">{{ $service['label'] }}</a>
            </div>
        </article>
    @endforeach
      <a href="{{ \Illuminate\Support\Facades\Route::has('vision') ? route('vision') : url('/troubles-de-la-vision') }}" class="group mt-6 flex flex-col gap-4 rounded-2xl border border-[#EAD9D7] bg-[#fbf8f6] p-5 transition duration-300 hover:-translate-y-0.5 hover:border-[#dcb4af] hover:shadow-lg sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <span class="flex items-start gap-4">
            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-[#fbefed] text-optique-red" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6-10-6-10-6Z"/><circle cx="12" cy="12" r="2.5"/></svg></span>
            <span><span class="block font-serif text-xl text-optique-text">Comprendre les troubles de la vision</span><span class="mt-1 block max-w-2xl text-sm leading-6 text-optique-gray">Myopie, hypermétropie, astigmatisme, presbytie : des repères simples sur les corrections optiques possibles.</span></span>
        </span>
        <span class="inline-flex shrink-0 items-center gap-2 text-sm font-semibold text-optique-red transition group-hover:gap-3">Découvrir <span aria-hidden="true">→</span></span>
    </a>
</section>

{{-- Bande finale --}}
<x-photo-band image="images/boutique/accueil-client.jpg"
              alt="Accueil à la boutique Optique Services"
              title="Parlons de ce qui vous ferait du bien."
              text="Contactez l’équipe ou demandez un rendez-vous en boutique à ACI 2000."
              height="min-h-[22rem] sm:min-h-[26rem]">
    <a href="{{ $contactUrl }}" class="inline-flex min-h-12 items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-optique-text transition hover:-translate-y-0.5 hover:bg-optique-bg">Nous contacter</a>
    <a href="{{ $appointmentUrl }}" class="inline-flex min-h-12 items-center justify-center rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Prendre rendez-vous</a>
</x-photo-band>
@endsection
