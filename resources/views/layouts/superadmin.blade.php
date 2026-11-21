<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Super Admin — Optique Services')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-[#F9F8F6] font-sans text-[#1C1C1C] antialiased" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">

    <!-- Menu mobile Alpine -->
    <div x-cloak x-show="sidebarOpen" x-transition.opacity id="superadmin-mobile-menu" class="fixed inset-0 z-40 md:hidden" role="dialog" aria-modal="true" aria-label="Menu de navigation super-admin" :aria-hidden="(!sidebarOpen).toString()">
        <button type="button" @click="sidebarOpen = false" class="absolute inset-0 h-full w-full bg-black/50" aria-label="Fermer le menu"></button>

        <aside x-show="sidebarOpen"
               x-transition:enter="transform transition ease-out duration-200"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transform transition ease-in duration-150"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="absolute inset-y-0 left-0 flex h-full w-72 max-w-[85vw] flex-col border-r border-optique-border bg-white shadow-xl">
            <div class="flex h-24 shrink-0 items-center justify-between border-b border-optique-border px-5">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Optique Services" class="h-11 w-auto">
                    <span class="mt-1 text-[10px] uppercase tracking-widest text-optique-gray">Super Admin</span>
                </div>
                <button type="button" @click="sidebarOpen = false" class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-optique-red focus:outline-none focus:ring-2 focus:ring-optique-red" aria-label="Fermer le menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6" aria-label="Navigation principale">
                <a href="{{ route('superadmin.dashboard') }}" @click="sidebarOpen = false" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('superadmin.dashboard') ? 'bg-red-50 text-optique-red' : 'text-optique-gray hover:bg-gray-50' }} transition-colors">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Vue d'ensemble
                </a>
                <a href="{{ route('superadmin.gallery.index') }}" @click="sidebarOpen = false" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium text-optique-gray transition-colors hover:bg-gray-50">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Galerie publique
                </a>
                <a href="{{ route('superadmin.categories.index') }}" @click="sidebarOpen = false" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('superadmin.categories.*') ? 'bg-red-50 text-optique-red' : 'text-optique-gray hover:bg-gray-50' }} transition-colors">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Catégories
                </a>
                <a href="#" @click="sidebarOpen = false" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium text-optique-gray transition-colors hover:bg-gray-50">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Équipe &amp; Accès
                </a>
            </nav>

            <div class="shrink-0 border-t border-optique-border p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-gray-50 px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-red-50 hover:text-optique-red">Déconnexion</button>
                </form>
            </div>
        </aside>
    </div>

    <!-- Sidebar desktop -->
    <aside class="z-20 hidden h-full w-72 shrink-0 flex-col border-r border-optique-border bg-white md:flex">
        <div class="flex h-24 shrink-0 flex-col items-center justify-center border-b border-optique-border">
            <img src="{{ asset('images/logo.png') }}" alt="Optique Services" class="mb-2 h-12 w-auto">
            <span class="text-[10px] uppercase tracking-widest text-optique-gray">Super Admin</span>
        </div>
        <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6" aria-label="Navigation principale">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('superadmin.dashboard') ? 'bg-red-50 text-optique-red' : 'text-optique-gray hover:bg-gray-50' }} transition-colors">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Vue d'ensemble
            </a>
            <a href="{{ route('superadmin.gallery.index') }}" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium text-optique-gray transition-colors hover:bg-gray-50">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Galerie publique
            </a>
            <a href="{{ route('superadmin.categories.index') }}" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('superadmin.categories.*') ? 'bg-red-50 text-optique-red' : 'text-optique-gray hover:bg-gray-50' }} transition-colors">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                Catégories
            </a>
             <a href="{{ route('superadmin.users.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('superadmin.users.*') ? 'bg-red-50 text-optique-red' : 'text-optique-gray hover:bg-gray-50' }} transition-colors">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
    Équipe & Accès
</a>
        </nav>
        <div class="shrink-0 border-t border-optique-border p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-gray-50 px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-red-50 hover:text-optique-red">Déconnexion</button>
            </form>
        </div>
    </aside>

    <!-- Contenu principal -->
    <div class="flex h-full min-w-0 flex-1 flex-col overflow-hidden">
        <header class="z-10 flex h-20 shrink-0 items-center justify-between border-b border-optique-border bg-white px-4 md:px-8">
            <div class="flex min-w-0 items-center gap-3">
                <button type="button" @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-optique-red focus:outline-none focus:ring-2 focus:ring-optique-red md:hidden" aria-controls="superadmin-mobile-menu" :aria-expanded="sidebarOpen.toString()" aria-label="Ouvrir ou fermer le menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="hidden truncate text-sm font-medium text-optique-gray md:block">Voir mieux. Accompagner toujours.</div>
                <span class="truncate text-sm font-medium text-optique-gray md:hidden">Espace Super Admin</span>
            </div>
            <div class="flex shrink-0 items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-optique-red text-sm font-bold text-white" aria-hidden="true">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-bold leading-tight text-optique-text">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-optique-gray">Super Admin</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>
