@extends('layouts.auth')

@section('title', 'Mon espace client — Optique Services')
@section('left_title', 'Bien plus qu\'une simple vision')
@section('left_text', 'Chez Optique Services, nous vous accompagnons dans toutes les étapes de votre parcours visuel, avec des conseils personnalisés et un suivi de qualité.')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-serif text-optique-text mb-2">Mon espace client</h2>
        <p class="text-optique-gray">Accédez à vos informations et suivez votre parcours visuel en toute simplicité.</p>
    </div>

    <!-- Formulaire Téléphone (Vue principale) -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ showEmail: false }">
        @csrf

        <div x-show="!showEmail">
            <label class="block text-sm font-medium text-optique-text mb-2">Numéro de téléphone</label>
            <div class="flex">
                <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-optique-border bg-gray-50 text-optique-gray sm:text-sm">
                    +223
                </span>
                <input type="tel" name="phone" required class="flex-1 min-w-0 block w-full rounded-none rounded-r-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="76 00 00 00">
            </div>
            <button type="button" class="mt-4 w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-optique-red hover:bg-optique-redhover transition-all">
                Recevoir mon code
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

        <div class="relative py-4" x-show="!showEmail">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-optique-border"></div></div>
            <div class="relative flex justify-center text-sm"><span class="px-2 bg-white text-optique-gray">Ou</span></div>
        </div>

        <button type="button" @click="showEmail = !showEmail" class="w-full flex justify-center items-center py-3.5 px-4 border border-optique-border rounded-lg shadow-sm text-sm font-medium text-optique-text bg-white hover:bg-gray-50 transition-all" x-show="!showEmail">
            <svg class="w-5 h-5 mr-2 text-optique-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Continuer avec mon e-mail
        </button>

        <!-- Formulaire Email (Caché par défaut) -->
        <div x-show="showEmail" x-transition style="display: none;">
            <div class="mb-4">
                <label class="block text-sm font-medium text-optique-text mb-2">Adresse e-mail</label>
                <input type="email" name="email" class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="vous@exemple.com">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-optique-text mb-2">Mot de passe</label>
                <input type="password" name="password" class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 rounded-lg shadow-sm text-sm font-bold text-white bg-optique-red hover:bg-optique-redhover transition-all">
                Se connecter
            </button>
        </div>
    </form>

    <p class="mt-8 text-center text-sm text-optique-gray">
        Pas encore de compte ? <a href="#" class="font-bold text-optique-red hover:underline">Créer mon compte</a>
    </p>
    <p class="mt-6 text-center text-xs text-optique-gray flex justify-center items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        Vos informations personnelles restent confidentielles.
    </p>
@endsection
