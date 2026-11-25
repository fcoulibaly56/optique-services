@extends('layouts.client')
@section('content')
<!-- On ouvre le formulaire automatiquement si un sujet OU un message est pré-rempli -->
<div class="max-w-2xl mx-auto" x-data="{ showForm: {{ ($prefillSubject || $prefillMessage) ? 'true' : 'false' }} }">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Messagerie</h1>
        <button @click="showForm = !showForm" class="bg-[#A33B36] text-white px-3 py-1.5 rounded-md text-sm">
            + Nouveau message
        </button>
    </div>

    <!-- Formulaire nouveau message -->
    <div x-show="showForm" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6" style="display: none;" x-transition>
        <h2 class="font-bold text-gray-800 mb-4">Poser une question</h2>
        <form action="{{ route('client.messages.store') }}" method="POST" class="space-y-3">
            @csrf
            <input type="text" name="subject" value="{{ $prefillSubject ?? '' }}" placeholder="Sujet..." required class="w-full rounded-md border-gray-300 text-sm">

            <!-- Injection du message pré-rempli -->
            <textarea name="message" rows="3" required class="w-full rounded-md border-gray-300 text-sm">{{ $prefillMessage ?? '' }}</textarea>

            <button type="submit" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm w-full">Envoyer</button>
        </form>
    </div>

    <!-- Liste des conversations -->
     <div class="space-y-2">
    @forelse($conversations as $conv)
        <a href="{{ route('client.messages.show', $conv) }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:border-[#A33B36] transition">
            <div class="flex justify-between items-center gap-3">
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-900 truncate">{{ $conv->subject }}</p>
                    <p class="text-xs text-gray-500">{{ $conv->last_message_at ? \Carbon\Carbon::parse($conv->last_message_at)->locale('fr')->diffForHumans() : '' }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    @if($conv->unread_count > 0)
                        <span class="bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">{{ $conv->unread_count }}</span>
                    @endif
                    <span class="text-[#A33B36]">&rarr;</span>
                </div>
            </div>
        </a>
    @empty
        <div class="text-center py-8 text-gray-500">Aucune conversation.</div>
    @endforelse
</div>
</div>
@endsection
