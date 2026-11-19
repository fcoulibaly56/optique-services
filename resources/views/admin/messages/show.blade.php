@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-3xl mx-auto flex flex-col h-[calc(100vh-100px)]">
    <div class="mb-4">
        <a href="{{ route('admin.messages.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Retour</a>
        <h1 class="text-xl font-serif font-bold">{{ $conversation->subject }}</h1>
        <p class="text-sm text-gray-500">Client : {{ $conversation->customer->first_name }} {{ $conversation->customer->last_name }}</p>
    </div>

    <div class="flex-1 bg-white shadow rounded-lg p-4 overflow-y-auto mb-4 space-y-4">
        @foreach($conversation->messages as $msg)
            <div class="flex {{ $msg->sender_role === 'staff' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] p-3 rounded-lg text-sm {{ $msg->sender_role === 'staff' ? 'bg-[#A33B36] text-white' : 'bg-gray-100 text-gray-800' }}">
                    {{ $msg->body }}
                    <div class="text-xs mt-1 opacity-70 text-right">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('admin.messages.reply', $conversation) }}" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="body" placeholder="Répondre..." class="flex-1 border rounded-lg p-3 focus:ring-[#A33B36] focus:border-[#A33B36]" required>
        <button type="submit" class="bg-[#A33B36] text-white px-4 rounded-lg">Envoyer</button>
    </form>
</div>
@endsection
