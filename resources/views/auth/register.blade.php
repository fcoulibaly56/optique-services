@extends('layouts.auth')

@section('title', 'Créer un compte — Optique Services')

@section('content')
    <div class="text-center mb-8">
        <h2 class="text-2xl font-serif text-optique-text mb-2">Créer un compte</h2>
        <p class="text-optique-gray">Rejoignez Optique Services pour un suivi personnalisé.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-optique-text mb-1">Nom complet</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="Ex: Aïssata Traoré">
        </div>

        <div>
            <label class="block text-sm font-medium text-optique-text mb-1">Téléphone</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" required class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="76 00 00 00">
        </div>

        <div>
            <label class="block text-sm font-medium text-optique-text mb-1">Email (facultatif)</label>
            <input type="email" name="email" value="{{ old('email') }}" class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="vous@exemple.com">
        </div>

        <div>
            <label class="block text-sm font-medium text-optique-text mb-1">Mot de passe</label>
            <input type="password" name="password" required class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="••••••••">
        </div>

        <div>
            <label class="block text-sm font-medium text-optique-text mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required class="block w-full rounded-lg border-optique-border bg-gray-50 focus:bg-white focus:border-optique-red focus:ring-optique-red sm:text-sm px-4 py-3" placeholder="••••••••">
        </div>

        <button type="submit" class="w-full flex justify-center py-3.5 px-4 rounded-xl shadow-sm text-sm font-bold text-white bg-optique-red hover:bg-optique-redhover transition-all mt-4">
            S'inscrire
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-optique-gray">
        Déjà un compte ? <a href="{{ route('login.phone') }}" class="font-bold text-optique-red hover:underline">Se connecter</a>
    </p>
@endsection
