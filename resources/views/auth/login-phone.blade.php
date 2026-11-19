@extends('layouts.auth')

@section('title', 'Espace Client — Optique Services')

@section('content')
    <div class="text-center mb-8">
        <h2 class="text-3xl font-serif text-optique-text mb-2">Mon espace client</h2>
        <p class="text-optique-gray">Suivez vos commandes et échangez avec l'équipe.</p>
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

    <form method="POST" action="{{ route('login.phone.send') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-optique-text mb-2">Numéro de téléphone</label>
            <div class="flex rounded-xl shadow-sm border border-optique-border bg-gray-50 focus-within:bg-white focus-within:border-optique-red focus-within:ring-1 focus-within:ring-optique-red transition-all">
                <span class="inline-flex items-center px-4 text-optique-gray sm:text-base font-medium border-r border-optique-border">
                    +223
                </span>
                <input type="tel" name="phone" value="{{ old('phone') }}" required class="flex-1 min-w-0 block w-full rounded-r-xl border-0 bg-transparent py-4 px-4 focus:ring-0 sm:text-base" placeholder="76 00 00 00">
            </div>
        </div>

        <button type="submit" class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-optique-red hover:bg-optique-redhover transition-all duration-300 transform hover:-translate-y-1">
            Recevoir mon code
            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
    </form>

    <div class="mt-8 text-center border-t border-optique-border pt-6">
        <p class="text-sm text-optique-gray">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-bold text-optique-red hover:underline">Créer mon compte</a>
        </p>
    </div>
@endsection
