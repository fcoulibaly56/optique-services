@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-4xl mx-auto">
    <h1 class="text-2xl font-serif font-bold text-gray-800 mb-6">Messagerie Interne</h1>
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100">
        @forelse($conversations as $conv)
            <a href="{{ route('admin.messages.show', $conv) }}" class="block p-4 hover:bg-gray-50 transition group">
                <div class="flex items-center gap-4">
                    <!-- Avatar -->
                    <div class="w-10 h-10 rounded-full bg-[#A33B36]/10 text-[#A33B36] flex items-center justify-center font-bold flex-shrink-0">
                        {{ substr($conv->customer->first_name, 0, 1) }}{{ substr($conv->customer->last_name, 0, 1) }}
                    </div>

                    <!-- Contenu -->
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline mb-1">
                            <p class="font-bold text-gray-900 truncate">{{ $conv->customer->first_name }} {{ $conv->customer->last_name }}</p>
                            <span class="text-xs text-gray-500 ml-2 flex-shrink-0">{{ $conv->last_message_at ? \Carbon\Carbon::parse($conv->last_message_at)->diffForHumans() : '' }}</span>
                        </div>
                        <p class="text-sm text-gray-500 truncate group-hover:text-gray-700">{{ $conv->subject }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="p-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                <p>Aucune conversation pour le moment.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $conversations->links() }}</div>
</div>
@endsection
