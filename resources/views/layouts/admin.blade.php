<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Espace Équipe — Optique Services')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F9F8F6] text-[#1C1C1C] font-sans antialiased h-screen flex overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Desktop -->
    <aside class="hidden md:flex w-64 bg-white border-r border-optique-border flex-col h-full z-20">
        <div class="h-20 flex items-center justify-center border-b border-optique-border">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
        </div>
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Tableau de bord
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.orders*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Commandes
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.customers*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Clients
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.products*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4-8-4m8 4v10l-3 3m11-13l-3 3M4 7l8 4m0 0l8-4m-8 4v10l-3 3"></path></svg>
                Produits
            </a>

            <!-- Rendez-vous (avec pastille des demandes en attente) -->
            <a href="{{ route('admin.appointments.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.appointments*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Rendez-vous
                @if(($pendingAppointmentsCount ?? 0) > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingAppointmentsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.purchases.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.purchases*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Entrées de Stock
            </a>
            <!-- Comptabilité -->
            <a href="{{ route('admin.accounting.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.accounting*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Comptabilité
            </a>
            <!-- Assurances -->
            <a href="{{ route('admin.insurances.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.insurances*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Assurances
            </a>

            <!-- Messagerie (clients connectés) -->
            <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.messages*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    Messagerie
                </div>
                @if(($globalUnreadCount ?? 0) > 0)
                    <span id="admin-unread-badge" class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $globalUnreadCount }}</span>
                @else
                    <span id="admin-unread-badge" class="hidden"></span>
                @endif
            </a>

            <!-- Demandes de contact (formulaire du site public) -->
            <a href="{{ route('admin.contact-requests.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.contact-requests*') ? 'bg-optique-red/10 text-optique-red' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Demandes de contact
                @if(($newContactsCount ?? 0) > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $newContactsCount }}</span>
                @endif
            </a>
        </nav>
        <div class="p-4 border-t border-optique-border">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg">Déconnexion</button>
            </form>
        </div>
    </aside>

    <!-- Contenu Principal -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="h-16 md:h-20 bg-white border-b border-optique-border flex items-center justify-between px-4 md:px-8 z-10">
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="hidden md:block text-sm font-medium text-gray-500">Espace Équipe</div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-[#A33B36] text-white flex items-center justify-center font-bold text-sm">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Menu Mobile -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 md:hidden" style="display: none;" x-transition>
            <div class="fixed inset-0 bg-black/50" @click="sidebarOpen = false"></div>
            <nav class="fixed top-0 left-0 bottom-0 w-64 bg-white shadow-xl flex flex-col">
                <div class="h-16 flex items-center justify-between px-4 border-b">
                    <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto">
                    <button @click="sidebarOpen = false" class="text-gray-500 p-2">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Tableau de bord</a>
                    <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Commandes</a>
                    <a href="{{ route('admin.customers.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Clients</a>
                    <a href="{{ route('admin.products.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Produits</a>
                    <a href="{{ route('admin.appointments.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">
                        Rendez-vous
                        @if(($pendingAppointmentsCount ?? 0) > 0)
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingAppointmentsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.purchases.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Stock & Achats</a>
                    <a href="{{ route('admin.accounting.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Comptabilité</a>
                    <a href="{{ route('admin.insurances.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Assurances</a>
                    <a href="{{ route('admin.messages.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Messagerie</a>
                    <a href="{{ route('admin.contact-requests.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">
                        Demandes de contact
                        @if(($newContactsCount ?? 0) > 0)
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $newContactsCount }}</span>
                        @endif
                    </a>
                </div>
                <div class="p-4 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Se déconnecter</button>
                    </form>
                </div>
            </nav>
        </div>

        <main class="flex-1 overflow-y-auto bg-[#F9F8F6] p-4 md:p-8">
            <!-- Toasts & Erreurs -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                    class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-2">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                    class="fixed top-4 right-4 z-50 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            setInterval(async () => {
                try {
                    const response = await fetch('{{ route('api.unread') }}');
                    const data = await response.json();

                    // Mise à jour côté Admin
                    const adminBadge = document.getElementById('admin-unread-badge');
                    if (adminBadge) {
                        if (data.count > 0) {
                            adminBadge.textContent = data.count;
                            adminBadge.classList.remove('hidden');
                        } else {
                            adminBadge.classList.add('hidden');
                        }
                    }

                    // Mise à jour côté Client
                    const clientBadge = document.getElementById('client-unread-badge');
                    if (clientBadge) {
                        if (data.count > 0) {
                            clientBadge.textContent = data.count;
                            clientBadge.classList.remove('hidden');
                        } else {
                            clientBadge.classList.add('hidden');
                        }
                    }
                } catch (e) {
                    console.error('Erreur polling messages', e);
                }
            }, 30000); // Vérifie toutes les 30 secondes
        });
    </script>
</body>
</html>
