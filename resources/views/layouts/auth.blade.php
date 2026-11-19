<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Connexion — Optique Services')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body class="font-sans antialiased h-screen flex items-center justify-center relative overflow-hidden bg-gray-900">

    <!-- Image de fond (Boutique ou Lunettes) -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1574258495973-f010dfbb5371?q=80&w=2070&auto=format&fit=crop" alt="Fond Optique" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
    </div>

    <!-- Carte Centrale (Glassmorphism) -->
    <div class="relative z-10 w-full max-w-lg mx-4 animate-float">
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.5)] border border-white/50 p-8 sm:p-12 overflow-hidden">

            <!-- Logo bien visible sur fond blanc -->
            <div class="flex justify-center mb-8">
                <a href="{{ route('home') }}" class="transition-transform hover:scale-105">
                    <img src="{{ asset('images/logo.png') }}" alt="Optique Services" class="h-20 w-auto object-contain">
                </a>
            </div>

            <!-- Contenu (Formulaire) -->
            @yield('content')

        </div>

        <!-- Liens de navigation en bas -->
        <div class="mt-6 text-center text-sm text-white/80 flex justify-center gap-6">
            <a href="{{ route('login.phone') }}" class="hover:text-white transition">Espace Client</a>
            <a href="{{ route('login.team') }}" class="hover:text-white transition">Espace Équipe</a>
            <a href="{{ route('login.admin') }}" class="hover:text-white transition">Administration</a>
        </div>
    </div>

</body>
</html>
