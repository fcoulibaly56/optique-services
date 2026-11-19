@extends('layouts.client')
@section('content')
<div class="max-w-2xl mx-auto flex flex-col h-[calc(100vh-140px)]">
    <div class="mb-4">
        <a href="{{ route('client.messages.index') }}" class="text-sm text-gray-500">&larr; Retour</a>
        <h1 class="text-lg font-bold text-gray-800 mt-1">{{ $conversation->subject }}</h1>
    </div>

    <!-- Fil de discussion -->
    <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 p-4 overflow-y-auto mb-4 space-y-4">
        @foreach($conversation->messages as $msg)
            <div class="flex {{ $msg->sender_role === 'client' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] p-3 rounded-lg text-sm {{ $msg->sender_role === 'client' ? 'bg-[#A33B36] text-white' : 'bg-gray-100 text-gray-800' }}">
                    {{ $msg->body }}
                    <div class="text-xs mt-1 opacity-70 text-right">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Répondre -->
    <form action="{{ route('client.messages.reply', $conversation) }}" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="body" placeholder="Écrire un message..." required class="flex-1 border rounded-lg p-3 focus:ring-[#A33B36] focus:border-[#A33B36] text-sm shadow-sm">
        <button type="submit" class="bg-[#A33B36] text-white px-4 rounded-lg">Envoyer</button>
    </form>
</div>
@endsection
