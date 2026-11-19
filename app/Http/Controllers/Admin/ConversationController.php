<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index() {
        $conversations = Conversation::with(['customer', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->orderBy('last_message_at', 'desc')->paginate(15);
        return view('admin.messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation) {
        $conversation->load(['customer', 'messages' => fn($q) => $q->oldest()]);
        // Marquer comme lus
        foreach ($conversation->messages as $message) {
            if ($message->sender_role === 'client') {
                $message->reads()->firstOrCreate(['user_id' => Auth::id()],['read_at'=>now()]);
            }
        }
        return view('admin.messages.show', compact('conversation'));
    }

    public function reply(Request $request, Conversation $conversation) {
        $request->validate(['body' => 'required|string']);
        $conversation->messages()->create([
            'sender_user_id' => Auth::id(),
            'sender_role' => 'staff',
            'body' => $request->body,
            'sent_at' => now(),
        ]);
        $conversation->update(['last_message_at' => now()]);
        return back()->with('success', 'Message envoyé.');
    }
}
