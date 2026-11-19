<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Super Admin — Optique Services')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F9F8F6] text-[#1C1C1C] font-sans antialiased h-screen flex overflow-hidden" x-data="{ sidebarOpen: false }">
    <!-- Sidebar Desktop -->
    <aside class="hidden md:flex w-72 bg-white border-r border-optique-border flex-col h-full z-20">
        <div class="h-24 flex flex-col items-center justify-center border-b border-optique-border">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto mb-2">
            <span class="text-[10px] uppercase tracking-widest text-optique-gray">Super Admin</span>
        </div>
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('superadmin.dashboard') ? 'bg-red-50 text-optique-red' : 'text-optique-gray hover:bg-gray-50' }} transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Vue d'ensemble
            </a>
            <a href="{{ route('superadmin.products.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl text-optique-gray hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Gestion Catalogue
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl text-optique-gray hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2
                Équipe & Accès
            </a>
        </nav>
        <div class="p-4 border-t border-optique-border">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-optique-red bg-gray-50 rounded-lg transition">
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="h-20 bg-white border-b border-optique-border flex items-center justify-between px-4 md:px-8 z-10">
            <!-- Mobile menu button -->
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-optique-text p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="hidden md:block text-sm font-medium text-optique-gray">Voir mieux. Accompagner toujours.</div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-optique-red text-white flex items-center justify-center font-bold text-sm">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-bold text-optique-text leading-tight">{{ auth()->user()->name }}</p>
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
