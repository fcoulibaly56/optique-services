@extends('layouts.auth')

@section('title', 'Espace Équipe — Optique Services')
@section('left_title', 'Une vision plus humaine au quotidien')
@section('left_text', 'Des équipements, des conseils, et surtout des personnes.')

@section('content')
    <div class="text-center mb-10">
        <div class="w-16 h-16 bg-optique-red/10 rounded-full flex items-center justify-center mx-auto mb-4 text-optique-red">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
        <h2 class="text-3xl font-serif text-optique-text mb-2">Espace équipe</h2>
        <p class="text-optique-gray">Accès réservé à l'équipe du magasin</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-optique-text mb-2">Adresse e-mail ou téléphone</label>
            <input type="text" name="email" required class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="votre@email.com">
        </div>
        <div>
            <div class="flex justify-between items-center mb-2">
                <label class="block text-sm font-medium text-optique-text">Mot de passe</label>
                <a href="#" class="text-sm text-optique-red hover:underline">Mot de passe oublié ?</a>
            </div>
            <input type="password" name="password" required class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="••••••••">
        </div>
        <button type="submit" class="w-full flex justify-center py-3.5 px-4 rounded-lg shadow-sm text-sm font-bold text-white bg-optique-red hover:bg-optique-redhover transition-all">
            Se connecter
        </button>
    </form>
    <p class="mt-8 text-center text-xs text-optique-gray">Pour toute difficulté, contactez le responsable du magasin.</p>
@endsection
