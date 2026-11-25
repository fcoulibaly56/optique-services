<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
  public function index(Request $request)
{
    $customer = Auth::user()->customer;

    $conversations = $customer->conversations()
        ->withCount(['messages as unread_count' => function($q) {
            $q->where('sender_role', 'staff')
              ->whereDoesntHave('reads', fn($r) => $r->where('user_id', Auth::id()));
        }])
        ->orderBy('last_message_at', 'desc')
        ->get();

    $prefillSubject = $request->query('subject');
    $prefillMessage = $request->query('message');

    return view('client.messages.index', compact('conversations', 'prefillSubject', 'prefillMessage'));
}

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $customer = Auth::user()->customer;

        $conversation = Conversation::create([
            'customer_id' => $customer->id,
            'subject' => $request->subject,
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $conversation->messages()->create([
            'sender_user_id' => Auth::id(),
            'sender_role' => 'client',
            'body' => $request->message,
            'sent_at' => now(),
        ]);

        return redirect()->route('client.messages.show', $conversation)->with('success', 'Message envoyé à l\'équipe.');
    }

    public function show(Conversation $conversation)
    {
        // Sécurité : Le client ne voit que ses propres conversations
        if ($conversation->customer_id !== Auth::user()->customer->id) {
            abort(403);
        }

        $conversation->load(['messages' => fn($q) => $q->oldest()]);

        // On marque les messages du staff comme lus par le client
        foreach ($conversation->messages as $msg) {
            if ($msg->sender_role === 'staff') {
                $msg->reads()->firstOrCreate(['user_id' => Auth::id()], ['read_at' => now()]);
            }
        }

        return view('client.messages.show', compact('conversation'));
    }

    public function reply(Request $request, Conversation $conversation)
    {
        if ($conversation->customer_id !== Auth::user()->customer->id) {
            abort(403);
        }

        $request->validate(['body' => 'required|string']);

        $conversation->messages()->create([
            'sender_user_id' => Auth::id(),
            'sender_role' => 'client',
            'body' => $request->body,
            'sent_at' => now(),
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('client.messages.show', $conversation);
    }
}
