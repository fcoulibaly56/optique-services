@extends('layouts.auth')

@section('title', 'Administration — Optique Services')
@section('left_title', 'Bienvenue dans votre espace administration')
@section('left_text', 'Gérez simplement votre activité, vos équipes et vos services Optique Services.')
@section('footer_left', 'Accès réservé au super-administrateur.')

@section('content')
    <div class="mb-10">
        <h2 class="text-3xl font-serif text-optique-text mb-2 text-center">Espace administration</h2>
        <p class="text-optique-gray text-center">Connexion sécurisée</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-optique-text mb-2">Adresse e-mail</label>
            <input type="email" name="email" required class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="votre@email.com">
        </div>
        <div>
            <label class="block text-sm font-medium text-optique-text mb-2">Mot de passe</label>
            <input type="password" name="password" required class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="••••••••">
        </div>
        <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 rounded-lg shadow-sm text-sm font-bold text-white bg-optique-red hover:bg-optique-redhover transition-all">
            Se connecter
            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
    </form>
    <p class="mt-8 text-center text-xs text-optique-gray">Accès réservé au super-administrateur</p>
@endsection
