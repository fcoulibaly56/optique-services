@extends('layouts.public')

@section('title', 'Comprendre les troubles de la vision — Optique Services')
@section('description', 'Myopie, hypermétropie, astigmatisme, presbytie : repères simples sur les défauts de réfraction et les corrections optiques possibles.')

@section('content')
@php
    $appointmentUrl = \Illuminate\Support\Facades\Route::has('appointment.create') ? route('appointment.create') : url('/#contact');
    $contactUrl = \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact');
    $catalogUrl = \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : url('/#collection');
@endphp

<!-- Introduction -->
<section class="relative isolate overflow-hidden bg-[#fbf8f6]">
    <div class="pointer-events-none absolute -right-24 -top-24 -z-10 h-80 w-80 rounded-full bg-[#f1deda]/70 blur-3xl sm:h-[34rem] sm:w-[34rem]" aria-hidden="true"></div>
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-12 sm:px-6 sm:py-16 lg:grid-cols-[1.05fr_.95fr] lg:gap-14 lg:px-8 lg:py-20">
        <div data-reveal>
            <a href="{{ \Illuminate\Support\Facades\Route::has('services') ? route('services') : url('/services') }}" class="mb-6 inline-flex items-center gap-2 text-xs font-semibold text-optique-gray transition hover:text-optique-red"><span aria-hidden="true">←</span> Nos services</a>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Comprendre votre vision</p>
            <h1 class="mt-3 max-w-2xl font-serif text-4xl leading-[1.04] tracking-[-.04em] text-optique-text sm:text-5xl lg:text-6xl">Quand la vision change, <span class="italic text-optique-red">les bons repères aident.</span></h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-optique-gray sm:text-lg sm:leading-8">Une vision floue peut avoir plusieurs causes. Découvrez quatre défauts de réfraction fréquents et les corrections optiques qu’un professionnel peut proposer après évaluation.</p>
            <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $appointmentUrl }}" class="group inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-optique-red px-6 py-3 text-sm font-semibold text-white shadow-md shadow-optique-red/15 transition duration-300 hover:-translate-y-0.5 hover:bg-optique-redhover">Demander un rendez-vous <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></a>
                <a href="{{ $contactUrl }}" class="inline-flex min-h-12 items-center justify-center rounded-full border border-optique-border bg-white px-6 py-3 text-sm font-semibold transition hover:border-optique-red/50 hover:text-optique-red">Poser une question</a>
            </div>
            <p class="mt-4 max-w-xl text-xs leading-5 text-optique-gray">Cette page donne des informations générales. Elle ne permet pas d’identifier soi-même un trouble ni de choisir une correction.</p>
        </div>

        <!-- Schéma pédagogique original, sans photographie ni portrait -->
        <div class="relative mx-auto w-full max-w-xl" data-reveal>
            <div class="absolute -bottom-4 -left-3 h-2/3 w-2/3 rounded-[2rem] bg-[#edd8d3] sm:-bottom-6 sm:-left-5" aria-hidden="true"></div>
            <div class="relative overflow-hidden rounded-[1.75rem] border border-white/80 bg-white p-5 shadow-2xl shadow-[#593b35]/10 sm:rounded-[2.25rem] sm:p-8">
                <div class="flex items-center justify-between gap-3">
                    <div><p class="text-[10px] font-bold uppercase tracking-[.18em] text-optique-red">Le trajet de la lumière</p><p class="mt-1 font-serif text-xl text-optique-text sm:text-2xl">De l’œil à la netteté</p></div>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#fbefed] text-optique-red" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M12 2v3m0 14v3M4.93 4.93l2.12 2.12m9.9 9.9 2.12 2.12M2 12h3m14 0h3M4.93 19.07l2.12-2.12m9.9-9.9 2.12-2.12"/></svg></span>
                </div>
                <div class="mt-5 overflow-hidden rounded-2xl bg-[#fbf8f6] px-3 py-4 sm:px-5 sm:py-6">
                    <svg viewBox="0 0 520 245" class="h-auto w-full" role="img" aria-labelledby="vision-diagram-title vision-diagram-desc">
                        <title id="vision-diagram-title">Schéma simplifié du trajet de la lumière dans l’œil</title>
                        <desc id="vision-diagram-desc">Des rayons lumineux traversent la cornée et le cristallin, puis convergent vers la rétine au fond de l’œil.</desc>
                        <defs>
                            <linearGradient id="eyeFill" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fff"/><stop offset="1" stop-color="#f5e9e6"/></linearGradient>
                            <marker id="rayArrow" markerWidth="8" markerHeight="8" refX="6" refY="4" orient="auto"><path d="M0 0 8 4 0 8Z" fill="#A94742"/></marker>
                        </defs>
                        <path d="M105 122c33-61 96-91 184-91 86 0 154 38 191 91-37 53-105 91-191 91-88 0-151-30-184-91Z" fill="url(#eyeFill)" stroke="#b56f68" stroke-width="4"/>
                        <path d="M111 78c-19 18-29 32-37 44 8 12 18 26 37 44" fill="none" stroke="#A94742" stroke-width="5" stroke-linecap="round"/>
                        <path d="M181 78c-27 21-27 67 0 88 28-21 28-67 0-88Z" fill="#f3deda" stroke="#A94742" stroke-width="3"/>
                        <path d="M455 66c-20 34-20 78 0 112" fill="none" stroke="#8f403c" stroke-width="7" stroke-linecap="round"/>
                        <path d="M16 96H92L181 122 455 122M16 148H92L181 122" fill="none" stroke="#A94742" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" marker-end="url(#rayArrow)"/>
                        <circle cx="455" cy="122" r="8" fill="#A94742"/>
                        <text x="72" y="57" fill="#746765" font-size="14" font-family="sans-serif">Cornée</text>
                        <text x="152" y="207" fill="#746765" font-size="14" font-family="sans-serif">Cristallin</text>
                        <text x="386" y="47" fill="#746765" font-size="14" font-family="sans-serif">Rétine</text>
                    </svg>
                </div>
                <div class="mt-4 flex items-start gap-2 text-xs leading-5 text-optique-gray"><svg class="mt-0.5 h-4 w-4 shrink-0 text-optique-red" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M12 11v5m0-8h.01"/></svg><p>Schéma simplifié à visée pédagogique : chaque situation visuelle nécessite une évaluation adaptée.</p></div>
            </div>
        </div>
    </div>
</section>

<!-- Quatre défauts de réfraction -->
<section class="bg-white py-14 sm:py-20" aria-labelledby="common-conditions-title">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl" data-reveal>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Quatre situations fréquentes</p>
            <h2 id="common-conditions-title" class="mt-3 font-serif text-3xl leading-tight tracking-tight text-optique-text sm:text-4xl">Les défauts de réfraction, en clair.</h2>
            <p class="mt-4 text-sm leading-6 text-optique-gray sm:text-base">Ils surviennent lorsque l’œil ne focalise pas la lumière correctement sur la rétine. Les sensations décrites ci-dessous sont des repères, pas un diagnostic.</p>
        </div>

        <div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2">
            <article data-reveal class="group rounded-3xl border border-optique-border bg-[#fbf8f6] p-5 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-7">
                <div class="flex items-start justify-between gap-4"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbefed] text-optique-red" aria-hidden="true"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6-10-6-10-6Z"/><circle cx="12" cy="12" r="2.5"/><path stroke-linecap="round" d="M3 4 1.5 2.5m19 19L19 20"/></svg></span><span class="text-[10px] font-bold uppercase tracking-[.16em] text-optique-red">01 · De loin</span></div>
                <h3 class="mt-5 font-serif text-2xl text-optique-text">Myopie</h3>
                <p class="mt-2 text-sm leading-6 text-optique-gray">Les objets éloignés peuvent paraître flous, tandis que la vision de près peut rester plus nette.</p>
                <div class="mt-5 border-t border-optique-border pt-4"><p class="text-[10px] font-bold uppercase tracking-[.15em] text-optique-red">Correction possible</p><p class="mt-1 text-sm leading-6 text-optique-gray">Des lunettes ou lentilles correctrices peuvent aider à voir plus nettement, avec une correction déterminée après examen.</p></div>
            </article>

            <article data-reveal class="group rounded-3xl border border-optique-border bg-[#fbf8f6] p-5 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-7">
                <div class="flex items-start justify-between gap-4"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbefed] text-optique-red" aria-hidden="true"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7"><circle cx="12" cy="12" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16m-8-8c2.5 2.3 3.5 5 3.5 8s-1 5.7-3.5 8c-2.5-2.3-3.5-5-3.5-8s1-5.7 3.5-8Z"/></svg></span><span class="text-[10px] font-bold uppercase tracking-[.16em] text-optique-red">02 · De près</span></div>
                <h3 class="mt-5 font-serif text-2xl text-optique-text">Hypermétropie</h3>
                <p class="mt-2 text-sm leading-6 text-optique-gray">La vision de près peut être floue ou demander davantage d’effort. Les effets varient selon les personnes et le degré de correction.</p>
                <div class="mt-5 border-t border-optique-border pt-4"><p class="text-[10px] font-bold uppercase tracking-[.15em] text-optique-red">Correction possible</p><p class="mt-1 text-sm leading-6 text-optique-gray">Un professionnel peut prescrire des lunettes ou des lentilles adaptées après un examen visuel.</p></div>
            </article>

            <article data-reveal class="group rounded-3xl border border-optique-border bg-[#fbf8f6] p-5 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-7">
                <div class="flex items-start justify-between gap-4"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbefed] text-optique-red" aria-hidden="true"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7"><path stroke-linecap="round" d="M3 7h18M3 12h18M3 17h18"/><path stroke-linecap="round" stroke-width="2.5" d="M7 4v16m10-16v16"/></svg></span><span class="text-[10px] font-bold uppercase tracking-[.16em] text-optique-red">03 · À toute distance</span></div>
                <h3 class="mt-5 font-serif text-2xl text-optique-text">Astigmatisme</h3>
                <p class="mt-2 text-sm leading-6 text-optique-gray">La vision peut sembler floue ou déformée de près comme de loin. L’astigmatisme peut être associé à un autre défaut de réfraction.</p>
                <div class="mt-5 border-t border-optique-border pt-4"><p class="text-[10px] font-bold uppercase tracking-[.15em] text-optique-red">Correction possible</p><p class="mt-1 text-sm leading-6 text-optique-gray">Des verres ou lentilles adaptés à la correction prescrite peuvent compenser l’astigmatisme.</p></div>
            </article>

            <article data-reveal class="group rounded-3xl border border-optique-border bg-[#fbf8f6] p-5 transition duration-300 hover:-translate-y-1 hover:border-[#e7c5be] hover:shadow-xl hover:shadow-[#593b35]/[.06] sm:p-7">
                <div class="flex items-start justify-between gap-4"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-[#fbefed] text-optique-red" aria-hidden="true"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4zM8 9h8M8 12h5M8 15h3"/><circle cx="18" cy="17" r="4" fill="#fbefed"/><path stroke-linecap="round" d="M18 15v2l1.2.8"/></svg></span><span class="text-[10px] font-bold uppercase tracking-[.16em] text-optique-red">04 · La vision de près</span></div>
                <h3 class="mt-5 font-serif text-2xl text-optique-text">Presbytie</h3>
                <p class="mt-2 text-sm leading-6 text-optique-gray">Avec l’âge, la mise au point de près devient souvent plus difficile, notamment pour lire ou regarder un écran.</p>
                <div class="mt-5 border-t border-optique-border pt-4"><p class="text-[10px] font-bold uppercase tracking-[.15em] text-optique-red">Correction possible</p><p class="mt-1 text-sm leading-6 text-optique-gray">Selon le bilan et les besoins, des lunettes de près ou des verres multifocaux peuvent être proposés.</p></div>
            </article>
        </div>
    </div>
</section>

<!-- Parcours et limites -->
<section class="bg-[#fbf8f6] py-14 sm:py-20">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[.8fr_1.2fr] lg:gap-14 lg:px-8">
        <div data-reveal>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">La bonne démarche</p>
            <h2 class="mt-3 font-serif text-3xl leading-tight tracking-tight text-optique-text sm:text-4xl">D’abord comprendre. Ensuite choisir.</h2>
            <p class="mt-4 text-sm leading-7 text-optique-gray">Un symptôme ne suffit pas pour connaître sa cause. Un examen réalisé par un professionnel de la santé visuelle permet d’évaluer la vision et de déterminer si une correction est nécessaire.</p>
            <a href="{{ $appointmentUrl }}" class="group mt-6 inline-flex min-h-11 items-center justify-center gap-2 rounded-full bg-optique-red px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-optique-redhover">Demander un rendez-vous <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></a>
        </div>
        <div class="grid gap-3 sm:grid-cols-3" data-reveal>
            <article class="rounded-2xl border border-optique-border bg-white p-5"><span class="text-[10px] font-bold uppercase tracking-[.15em] text-optique-red">01</span><h3 class="mt-3 font-serif text-lg">Décrire</h3><p class="mt-2 text-sm leading-6 text-optique-gray">Notez ce qui vous gêne et depuis quand.</p></article>
            <article class="rounded-2xl border border-optique-border bg-white p-5"><span class="text-[10px] font-bold uppercase tracking-[.15em] text-optique-red">02</span><h3 class="mt-3 font-serif text-lg">Faire évaluer</h3><p class="mt-2 text-sm leading-6 text-optique-gray">Demandez un examen à un professionnel de la vue.</p></article>
            <article class="rounded-2xl border border-optique-border bg-white p-5"><span class="text-[10px] font-bold uppercase tracking-[.15em] text-optique-red">03</span><h3 class="mt-3 font-serif text-lg">Être accompagné</h3><p class="mt-2 text-sm leading-6 text-optique-gray">L’équipe peut vous renseigner sur les montures et les options optiques adaptées à votre prescription.</p></article>
        </div>
    </div>
</section>

<!-- Signes d’urgence -->
<section class="bg-white px-4 py-14 sm:px-6 sm:py-16 lg:px-8" aria-labelledby="urgent-eye-title">
    <div class="mx-auto max-w-7xl" data-reveal>
        <div class="flex flex-col gap-4 rounded-3xl border border-[#E8C9C6] bg-[#FCF5F4] p-5 sm:flex-row sm:items-start sm:p-7">
            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-[#A33B36]/10 text-[#8F302C]" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18.2A1.8 1.8 0 003.3 21h17.4a1.8 1.8 0 001.5-2.8L13.7 3.9a2 2 0 00-3.4 0Z"/></svg></span>
            <div>
                <h2 id="urgent-eye-title" class="font-serif text-xl font-semibold text-[#773531]">Certains signes nécessitent une aide rapide</h2>
                <p class="mt-2 text-sm leading-6 text-gray-700">Une baisse soudaine de la vision, l’apparition brutale de nombreux points flottants ou d’éclairs lumineux, ou une ombre en forme de rideau dans le champ visuel peuvent être des signes d’urgence. Contactez sans attendre un ophtalmologiste ou un service d’urgence plutôt que d’attendre un rendez-vous en boutique.</p>
            </div>
        </div>
        <p class="mt-5 max-w-4xl text-xs leading-5 text-optique-gray">Cette page traite des défauts de réfraction et de leurs corrections optiques possibles. Elle ne couvre pas l’ensemble des maladies de l’œil et ne remplace ni un examen, ni un diagnostic, ni un avis médical.</p>
    </div>
</section>

<!-- CTA final -->
<section class="bg-[#fbf8f6] px-4 py-14 sm:px-6 sm:py-20 lg:px-8">
    <div data-reveal class="relative mx-auto max-w-7xl overflow-hidden rounded-[1.75rem] bg-[#8f403c] px-6 py-9 text-white sm:rounded-[2.25rem] sm:px-12 sm:py-12 lg:px-16">
        <div class="absolute -right-16 -top-24 h-64 w-64 rounded-full border border-white/10 sm:h-96 sm:w-96" aria-hidden="true"></div>
        <div class="relative flex flex-col gap-7 sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[.2em] text-white/70">Un conseil pour votre prochaine paire ?</p><h2 class="mt-3 font-serif text-3xl leading-tight sm:text-4xl">L’équipe Optique Services est là pour vous orienter.</h2><p class="mt-3 max-w-xl text-sm leading-6 text-white/80 sm:text-base">Venez découvrir les montures en boutique ou contactez-nous pour préparer votre visite.</p></div>
            <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
                <a href="{{ $contactUrl }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-bold text-[#773531] transition hover:-translate-y-0.5 hover:bg-[#fff8f6]">Nous contacter <span aria-hidden="true">↗</span></a>
                <a href="{{ $catalogUrl }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Découvrir les montures</a>
            </div>
        </div>
    </div>
</section>

<!-- Sources médicales -->
<section class="bg-white px-4 py-7 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl border-t border-optique-border pt-5 text-xs leading-5 text-optique-gray">
        <p>Sources d’information médicale : <a href="https://www.nei.nih.gov/eye-health-information/eye-conditions-and-diseases/refractive-errors" target="_blank" rel="noopener noreferrer" class="font-medium text-optique-red underline underline-offset-2">National Eye Institute — défauts de réfraction</a> et <a href="https://www.nei.nih.gov/eye-health-information/eye-conditions-and-diseases/retinal-detachment" target="_blank" rel="noopener noreferrer" class="font-medium text-optique-red underline underline-offset-2">signes d’alerte du décollement de rétine</a> (en anglais).</p>
    </div>
</section>
@endsection
