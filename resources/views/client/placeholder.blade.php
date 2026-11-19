@extends('layouts.client')

@section('title', $title . ' — Optique Services')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <div class="w-20 h-20 bg-optique-red/10 rounded-full flex items-center justify-center mx-auto mb-6 text-optique-red">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
    </div>
    <h1 class="text-3xl font-serif text-optique-text mb-4">{{ $title }}</h1>
    <p class="text-optique-gray mb-8 max-w-md mx-auto">Cette page est en cours de construction par l'équipe Optique Services. Revenez très bientôt !</p>
    <a href="{{ route('client.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-optique-red hover:bg-optique-redhover transition">
        Retour au tableau de bord
    </a>
</div>
@endsection
