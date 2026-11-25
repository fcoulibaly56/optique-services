@extends('layouts.public')

@section('title', 'Suivre mon rendez-vous — Optique Services')
@section('description', 'Suivez l\'état de votre rendez-vous chez Optique Services avec votre numéro de téléphone et votre référence.')

@section('content')
<section class="relative isolate overflow-hidden bg-[#fbf8f6] min-h-[60vh]">
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
        <a href="{{ route('home') }}" class="mb-6 inline-flex items-center gap-2 text-xs font-semibold text-optique-gray transition hover:text-optique-red"><span aria-hidden="true">←</span> Accueil</a>

        <div class="text-center mb-8">
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">Suivi de rendez-vous</p>
            <h1 class="mt-3 font-serif text-3xl sm:text-4xl lg:text-5xl text-optique-text">Où en est mon rendez-vous ?</h1>
            <p class="mt-4 max-w-xl mx-auto text-base text-optique-gray">Entrez votre numéro de téléphone et la référence reçue lors de votre demande pour voir l'état de votre rendez-vous.</p>
        </div>

        <div class="bg-white rounded-2xl border border-optique-border shadow-sm p-6 sm:p-8">
            @if($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                    @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
                </div>
            @endif

            <form action="{{ route('appointment.track.search') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                        placeholder="Ex: 76 88 27 12" required
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-[#A33B36] focus:ring-[#A33B36]">
                </div>
                <div>
                    <label for="reference" class="block text-sm font-semibold text-gray-700 mb-1">Référence du rendez-vous</label>
                    <input type="text" name="reference" id="reference" value="{{ old('reference') }}"
                        placeholder="Ex: RDV-XXXXXXX" required
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm uppercase focus:border-[#A33B36] focus:ring-[#A33B36]">
                </div>
                <button type="submit" class="w-full bg-[#A33B36] text-white font-bold py-3 rounded-xl hover:bg-[#8F302C] transition">
                    Rechercher mon rendez-vous
                </button>
            </form>

            <p class="mt-4 text-xs text-gray-500 text-center">
                💡 La référence vous a été donnée après votre demande de rendez-vous.
            </p>
        </div>
    </div>
</section>
@endsection
