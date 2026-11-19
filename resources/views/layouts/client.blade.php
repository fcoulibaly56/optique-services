<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Espace — Optique Services')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F9F8F6] text-[#1C1C1C] font-sans antialiased h-screen flex flex-col overflow-hidden">

    <!-- Header Client -->
    <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 shrink-0 shadow-sm">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
            <span class="font-serif font-bold text-[#A33B36] text-lg">Optique Services</span>
        </div>
        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="flex-1 overflow-y-auto p-4 pb-24">
        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4 text-sm">
                @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bottom Navigation (Mobile) -->
    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 h-16 flex justify-around items-center pb-safe z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <a href="{{ route('client.dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('client.dashboard') ? 'text-[#A33B36]' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-medium">Accueil</span>
        </a>
        <a href="{{ route('client.orders.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('client.orders*') ? 'text-[#A33B36]' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <span class="text-[10px] font-medium">Commandes</span>
        </a>
        <a href="{{ route('client.appointments.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('client.appointments*') ? 'text-[#A33B36]' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="text-[10px] font-medium">Rendez-vous</span>
        </a>
                <a href="{{ route('client.messages.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('client.messages*') ? 'text-[#A33B36]' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <span class="text-[10px] font-medium">Messages</span>
        </a>
    </nav>
</body>
</html>
