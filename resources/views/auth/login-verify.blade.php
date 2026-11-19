@extends('layouts.auth')

@section('title', 'Vérification — Optique Services')
@section('left_title', 'Presque terminé !')
@section('left_text', 'Entrez le code de sécurité pour accéder à votre espace.')

@section('content')
    <div class="text-center mb-8">
        <h2 class="text-2xl font-serif text-optique-text mb-2">Vérification</h2>
        <p class="text-optique-gray">Nous avons généré un code à 6 chiffres.</p>

        <!-- Affichage temporaire du code (à retirer quand tu auras l'API SMS) -->
        @if(session('otp_debug'))
            <div class="mt-4 p-3 bg-optique-red/10 border border-optique-red/20 rounded-lg text-optique-red font-mono text-xl font-bold tracking-widest">
                {{ session('otp_debug') }}
            </div>
        @endif
    </div>

    @if ($errors->any())
        <div class="mb-4 text-center text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.phone.verify.post') }}" class="space-y-6">
        @csrf
        <div>
            <input type="text" name="code" required maxlength="6" autofocus class="block w-full text-center tracking-[1em] text-2xl font-bold rounded-xl border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red py-4" placeholder="000000">
        </div>
        <button type="submit" class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-optique-red hover:bg-optique-redhover transition-all duration-300 transform hover:-translate-y-1">
            Vérifier et se connecter
        </button>
    </form>
@endsection
