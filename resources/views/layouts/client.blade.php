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
    <!-- Conteneur des Toasts -->
    <div class="fixed top-20 right-4 z-50 space-y-2 w-11/12 max-w-sm">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                class="bg-green-500 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                class="bg-red-500 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Contenu Principal -->
    <main class="flex-1 overflow-y-auto p-4 pb-24">
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
        <a href="{{ route('client.appointments.index') }}" class="relative flex flex-col items-center gap-1 {{ request()->routeIs('client.appointments*') ? 'text-[#A33B36]' : 'text-gray-400 hover:text-gray-600' }}">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
    <span class="text-[10px] font-medium">Rendez-vous</span>
    @php
        $apptCount = Auth::user()->customer
            ? \App\Models\Appointment::where('customer_id', Auth::user()->customer->id)
                ->whereIn('status', ['confirme', 'deplace', 'annule'])
                ->whereNull('client_notified_at')
                ->count()
            : 0;
    @endphp
    @if($apptCount > 0)
        <span id="client-appt-badge" class="absolute top-0 right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">{{ $apptCount }}</span>
    @else
        <span id="client-appt-badge" class="hidden"></span>
    @endif
</a>
           <a href="{{ route('client.messages.index') }}" class="relative flex flex-col items-center gap-1 {{ request()->routeIs('client.messages*') ? 'text-[#A33B36]' : 'text-gray-400 hover:text-gray-600' }}">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
    <span class="text-[10px] font-medium">Messages</span>
    @if($globalUnreadCount > 0)
        <span id="client-unread-badge" class="absolute top-0 right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">{{ $globalUnreadCount }}</span>
    @else
        <span id="client-unread-badge" class="hidden"></span>
    @endif
</a>
    </nav>
       <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. Mise à jour des badges toutes les 30 secondes (sans recharger)
            setInterval(async () => {
                try {
                    const response = await fetch('{{ route("api.unread") }}');
                    const data = await response.json();

                    // Badge Messages
                    const msgBadge = document.getElementById('client-unread-badge');
                    if (msgBadge) {
                        if (data.messages > 0) {
                            msgBadge.textContent = data.messages;
                            msgBadge.classList.remove('hidden');
                        } else {
                            msgBadge.classList.add('hidden');
                        }
                    }

                    // Badge Rendez-vous
                    const apptBadge = document.getElementById('client-appt-badge');
                    if (apptBadge) {
                        if (data.appointments > 0) {
                            apptBadge.textContent = data.appointments;
                            apptBadge.classList.remove('hidden');
                        } else {
                            apptBadge.classList.add('hidden');
                        }
                    }
                } catch (e) {
                    console.error('Erreur de mise à jour des badges', e);
                }
            }, 30000); // Toutes les 30 secondes

            // 2. Rafraîchissement automatique de la page (uniquement sur le Dashboard et RDV)
            @if(request()->routeIs('client.dashboard') || request()->routeIs('client.appointments.index'))
                setTimeout(() => {
                    window.location.reload();
                }, 60000); // Recharge la page après 60 secondes
            @endif

        });
    </script>

</body>
</html>
