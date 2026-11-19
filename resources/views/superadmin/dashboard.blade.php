@extends('layouts.superadmin')

@section('title', 'Vue d\'ensemble — Super Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <p class="text-xs font-bold tracking-widest text-optique-red uppercase mb-2">Optique Services</p>
            <h1 class="text-3xl md:text-4xl font-serif text-optique-text">Vue d'ensemble</h1>
            <h2 class="text-xl font-serif text-optique-text mt-2">Bonjour, {{ auth()->user()->name }}</h2>
            <p class="text-optique-gray mt-1">Voici un aperçu de l'activité de votre boutique aujourd'hui.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Cartes stats (utilisant les variables passées par le contrôleur) -->
        <div class="bg-white p-6 rounded-2xl border border-optique-border shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-optique-gray mb-1">Commandes ouvertes</p>
                <p class="text-4xl font-light text-optique-text">{{ $stats['orders_count'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-optique-red">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-optique-border shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-optique-gray mb-1">Rendez-vous (aujourd'hui)</p>
                <p class="text-4xl font-light text-optique-text">{{ $stats['appointments_count'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-optique-red">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-optique-border shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-optique-gray mb-1">Clients</p>
                <p class="text-4xl font-light text-optique-text">{{ $stats['users_count'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-optique-red">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-optique-border shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-optique-gray mb-1">Produits au catalogue</p>
                <p class="text-4xl font-light text-optique-text">{{ $stats['products_count'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-optique-red">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
        </div>
    </div>
</div>
@endsection
