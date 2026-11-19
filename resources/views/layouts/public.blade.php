<!doctype html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fffdfb">
    <title>@yield('title', 'Optique Services — Votre regard, notre priorité')</title>
    <meta name="description" content="@yield('description', 'Découvrez les montures et services d’Optique Services à ACI 2000, Bamako.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak]{display:none!important}
        html{scroll-behavior:smooth}
        @keyframes os-float{0%,100%{transform:translateY(0) rotate(-2deg)}50%{transform:translateY(-12px) rotate(1deg)}}
        @keyframes os-float-slow{0%,100%{transform:translateY(0)}50%{transform:translateY(9px)}}
        @keyframes os-pulse-ring{0%{transform:scale(.85);opacity:.5}100%{transform:scale(1.35);opacity:0}}
        @keyframes os-marquee{from{transform:translateX(0)}to{transform:translateX(-50%)}}
        .os-float{animation:os-float 6s ease-in-out infinite}.os-float-slow{animation:os-float-slow 7s ease-in-out infinite}.os-pulse-ring{animation:os-pulse-ring 2.2s ease-out infinite}
        .motion-ready [data-reveal]{opacity:0;transform:translateY(22px);transition:opacity .7s ease,transform .7s cubic-bezier(.2,.7,.2,1)}
        .motion-ready [data-reveal].is-visible{opacity:1;transform:translateY(0)}
        @media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}.motion-ready [data-reveal]{opacity:1;transform:none}}
    </style>
    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-optique-bg font-sans text-optique-text antialiased selection:bg-optique-red selection:text-white">
    <a href="#contenu" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-3 focus:shadow-lg">Aller au contenu</a>
    <div class="hidden bg-[#f8f3f1] text-optique-gray sm:block"><div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2 text-xs sm:px-6 lg:px-8"><p class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-optique-red"></span> Votre opticien de proximité à ACI 2000</p><a href="{{ \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact') }}" class="font-medium hover:text-optique-red">Nous trouver <span aria-hidden="true">↗</span></a></div></div>

    <header class="sticky top-0 z-50 border-b border-optique-border/70 bg-white/95 backdrop-blur-xl">
        <div class="mx-auto flex h-[4.5rem] max-w-7xl items-center justify-between px-4 sm:h-20 sm:px-6 lg:px-8">
            <a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="group flex min-w-0 items-center gap-2.5" aria-label="Optique Services — accueil">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Optique Services" class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105 sm:h-12">
                @else
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-optique-red text-white shadow-sm shadow-optique-red/20 transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-105" aria-hidden="true"><svg viewBox="0 0 32 32" class="h-6 w-6" fill="none"><path d="M3 16c3.3-5.3 7.6-8 13-8s9.7 2.7 13 8c-3.3 5.3-7.6 8-13 8S6.3 21.3 3 16Z" stroke="currentColor" stroke-width="2.2"/><circle cx="16" cy="16" r="4" stroke="currentColor" stroke-width="2.2"/></svg></span>
                    <span class="leading-tight"><span class="block font-serif text-lg font-semibold tracking-tight sm:text-xl">Optique Services</span><span class="hidden text-[10px] font-medium uppercase tracking-[.18em] text-optique-gray sm:block">Votre regard, notre priorité</span></span>
                @endif
            </a>
            <nav class="hidden items-center gap-7 lg:flex" aria-label="Navigation principale">
                <a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="text-sm font-medium transition hover:text-optique-red">Accueil</a>
                <a href="{{ \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : url('/#collection') }}" class="text-sm font-medium transition hover:text-optique-red">Nos lunettes</a>
                <a href="{{ \Illuminate\Support\Facades\Route::has('services') ? route('services') : url('/#services') }}" class="text-sm font-medium transition hover:text-optique-red">Nos services</a>
                <a href="{{ \Illuminate\Support\Facades\Route::has('about') ? route('about') : url('/#boutique') }}" class="text-sm font-medium transition hover:text-optique-red">Le magasin</a>
                <a href="{{ \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact') }}" class="text-sm font-medium transition hover:text-optique-red">Contact</a>
            </nav>
            <div class="hidden items-center gap-3 lg:flex">
                @if(\Illuminate\Support\Facades\Route::has('login'))<a href="{{ route('login') }}" class="rounded-full px-4 py-2.5 text-sm font-semibold text-optique-gray transition hover:bg-optique-bg hover:text-optique-text">Mon espace</a>@endif
                <a href="{{ \Illuminate\Support\Facades\Route::has('appointment.create') ? route('appointment.create') : url('/#contact') }}" class="group inline-flex items-center gap-2 rounded-full bg-optique-red px-5 py-3 text-sm font-semibold text-white shadow-md shadow-optique-red/15 transition duration-200 hover:-translate-y-0.5 hover:bg-optique-redhover hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-optique-red focus:ring-offset-2">Prendre rendez-vous <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">↗</span></a>
            </div>
            <button id="menu-mobile-toggle" type="button" class="grid h-11 w-11 place-items-center rounded-full border border-optique-border transition hover:bg-optique-bg focus:outline-none focus:ring-2 focus:ring-optique-red lg:hidden" aria-expanded="false" aria-controls="menu-mobile" aria-label="Ouvrir le menu"><svg data-menu-icon="open" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg><svg data-menu-icon="close" hidden viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg></button>
        </div>
        <div id="menu-mobile" hidden class="absolute inset-x-0 top-full border-b border-optique-border bg-white px-4 pb-5 pt-2 shadow-xl shadow-black/5 lg:hidden"><nav class="mx-auto flex max-w-7xl flex-col" aria-label="Navigation mobile">
            <a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="rounded-xl px-3 py-3 font-medium hover:bg-optique-bg">Accueil</a><a href="{{ \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : url('/#collection') }}" class="rounded-xl px-3 py-3 font-medium hover:bg-optique-bg">Nos lunettes</a><a href="{{ \Illuminate\Support\Facades\Route::has('services') ? route('services') : url('/#services') }}" class="rounded-xl px-3 py-3 font-medium hover:bg-optique-bg">Nos services</a><a href="{{ \Illuminate\Support\Facades\Route::has('about') ? route('about') : url('/#boutique') }}" class="rounded-xl px-3 py-3 font-medium hover:bg-optique-bg">Le magasin</a><a href="{{ \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact') }}" class="rounded-xl px-3 py-3 font-medium hover:bg-optique-bg">Contact</a>
            @if(\Illuminate\Support\Facades\Route::has('login'))<a href="{{ route('login') }}" class="rounded-xl px-3 py-3 font-medium text-optique-gray hover:bg-optique-bg">Mon espace client</a>@endif
            <a href="{{ \Illuminate\Support\Facades\Route::has('appointment.create') ? route('appointment.create') : url('/#contact') }}" class="mt-3 inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-optique-red px-5 py-3 font-semibold text-white">Prendre rendez-vous <span aria-hidden="true">↗</span></a>
        </nav></div>
    </header>

    <main id="contenu" class="flex-1">@yield('content')</main>

    <footer id="contact" class="mt-14 border-t border-optique-border bg-white sm:mt-20">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8"><div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2 lg:col-span-1"><a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="inline-flex items-center gap-2.5"><span class="grid h-10 w-10 place-items-center rounded-2xl bg-optique-red text-white" aria-hidden="true"><svg viewBox="0 0 32 32" class="h-6 w-6" fill="none"><path d="M3 16c3.3-5.3 7.6-8 13-8s9.7 2.7 13 8c-3.3 5.3-7.6 8-13 8S6.3 21.3 3 16Z" stroke="currentColor" stroke-width="2.2"/><circle cx="16" cy="16" r="4" stroke="currentColor" stroke-width="2.2"/></svg></span><span class="font-serif text-lg font-semibold">Optique Services</span></a><p class="mt-4 max-w-xs text-sm leading-6 text-optique-gray">Des conseils attentifs et un accompagnement de proximité pour le confort de votre regard.</p></div>
            <div><h2 class="text-sm font-semibold uppercase tracking-[.14em]">Découvrir</h2><ul class="mt-4 space-y-3 text-sm text-optique-gray"><li><a class="hover:text-optique-red" href="{{ \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : url('/#collection') }}">Nos lunettes</a></li><li><a class="hover:text-optique-red" href="{{ \Illuminate\Support\Facades\Route::has('services') ? route('services') : url('/#services') }}">Nos services</a></li><li><a class="hover:text-optique-red" href="{{ \Illuminate\Support\Facades\Route::has('about') ? route('about') : url('/#boutique') }}">Le magasin</a></li></ul></div>
            <div><h2 class="text-sm font-semibold uppercase tracking-[.14em]">Nous contacter</h2><p class="mt-4 text-sm leading-6 text-optique-gray">ACI 2000, Bamako<br><span class="text-xs">Adresse détaillée et horaires à confirmer</span></p><a href="{{ \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/#contact') }}" class="mt-3 inline-block text-sm font-semibold text-optique-red hover:underline">Voir nos coordonnées</a></div>
            <div><h2 class="text-sm font-semibold uppercase tracking-[.14em]">Un conseil ?</h2><p class="mt-4 text-sm leading-6 text-optique-gray">Notre équipe vous accompagne dans le choix de votre prochaine monture.</p><a href="{{ \Illuminate\Support\Facades\Route::has('appointment.create') ? route('appointment.create') : url('/#contact') }}" class="mt-4 inline-flex items-center gap-2 font-semibold text-optique-red">Réserver un créneau <span aria-hidden="true">→</span></a></div>
        </div><div class="mt-10 flex flex-col gap-4 border-t border-optique-border pt-6 text-xs text-optique-gray sm:flex-row sm:items-center sm:justify-between"><p>© {{ date('Y') }} Optique Services. Tous droits réservés.</p><div class="flex gap-5"><a href="#mentions-legales" class="hover:text-optique-red">Mentions légales</a><a href="#confidentialite" class="hover:text-optique-red">Confidentialité</a></div></div></div>
    </footer>
    @stack('scripts')
    <script>
        (() => {
            const root = document.documentElement;
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (!reduceMotion) root.classList.add('motion-ready');
            const items = document.querySelectorAll('[data-reveal]');
            if (reduceMotion || !('IntersectionObserver' in window)) {
                items.forEach(item => item.classList.add('is-visible'));
            } else {
                const observer = new IntersectionObserver(entries => entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); } }), { threshold: .12, rootMargin: '0px 0px -35px 0px' });
                items.forEach(item => observer.observe(item));
            }
            const toggle = document.getElementById('menu-mobile-toggle');
            const menu = document.getElementById('menu-mobile');
            if (toggle && menu) {
                const openIcon = toggle.querySelector('[data-menu-icon="open"]');
                const closeIcon = toggle.querySelector('[data-menu-icon="close"]');
                const setMenu = open => { menu.hidden = !open; toggle.setAttribute('aria-expanded', String(open)); toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu'); if (openIcon) openIcon.hidden = open; if (closeIcon) closeIcon.hidden = !open; };
                toggle.addEventListener('click', () => setMenu(menu.hidden));
                menu.querySelectorAll('a').forEach(link => link.addEventListener('click', () => setMenu(false)));
                document.addEventListener('keydown', event => { if (event.key === 'Escape') setMenu(false); });
                document.addEventListener('click', event => { if (!menu.hidden && !menu.contains(event.target) && !toggle.contains(event.target)) setMenu(false); });
            }
            const filterButtons = document.querySelectorAll('[data-category-filter]');
            const productCards = document.querySelectorAll('[data-category-card]');
            const searchInput = document.querySelector('[data-product-search]');
            const resultCount = document.querySelector('[data-product-count]');
            const emptyState = document.querySelector('[data-product-empty]');
            const resetButton = document.querySelector('[data-reset-products]');
            let activeCategory = 'all';
            const applyFilters = () => {
                const query = (searchInput?.value || '').trim().toLocaleLowerCase('fr');
                let visibleCount = 0;
                productCards.forEach(card => {
                    const cardCategories = (card.dataset.categoryCard || '').split(/\s+/).filter(Boolean);
                    const categoryMatches = activeCategory === 'all' || cardCategories.includes(activeCategory);
                    const searchMatches = !query || (card.dataset.search || '').toLocaleLowerCase('fr').includes(query);
                    const visible = categoryMatches && searchMatches;
                    const wasHidden = card.hidden;
                    card.hidden = !visible;
                    if (visible) { visibleCount++; if (wasHidden) { card.classList.add('is-visible'); if (card.animate && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) card.animate([{opacity:0,transform:'translateY(10px)'},{opacity:1,transform:'translateY(0)'}],{duration:260,easing:'ease-out'}); } }
                });
                filterButtons.forEach(button => { const selected = button.dataset.categoryFilter === activeCategory; button.setAttribute('aria-pressed', String(selected)); button.classList.toggle('bg-optique-red', selected); button.classList.toggle('text-white', selected); button.classList.toggle('border-optique-red', selected); button.classList.toggle('shadow-md', selected); button.classList.toggle('shadow-optique-red/15', selected); button.classList.toggle('bg-white', !selected); button.classList.toggle('text-optique-gray', !selected); button.classList.toggle('border-optique-border', !selected); });
                if (resultCount) resultCount.textContent = `${visibleCount} modèle${visibleCount > 1 ? 's' : ''}`;
                if (emptyState) emptyState.hidden = visibleCount > 0;
            };
            filterButtons.forEach(button => button.addEventListener('click', () => { activeCategory = button.dataset.categoryFilter || 'all'; applyFilters(); }));
            searchInput?.addEventListener('input', applyFilters);
            resetButton?.addEventListener('click', () => { activeCategory = 'all'; if (searchInput) searchInput.value = ''; applyFilters(); });
            applyFilters();
        })();
    </script>
</body>
</html>
