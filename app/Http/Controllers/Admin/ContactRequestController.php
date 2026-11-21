<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
    public function index(Request $request)
    {
        $filter = in_array($request->query('filter'), ['new', 'done', 'all'], true)
            ? $request->query('filter')
            : 'new';

        $search = trim((string) $request->query('q'));

        $messages = ContactRequest::query()
            ->when($filter === 'new', fn ($q) => $q->where('processed', false))
            ->when($filter === 'done', fn ($q) => $q->where('processed', true))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(fn ($w) => $w
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'new'  => ContactRequest::where('processed', false)->count(),
            'done' => ContactRequest::where('processed', true)->count(),
        ];

        return view('admin.contact-requests.index', compact('messages', 'filter', 'counts'));
    }

    public function toggleProcessed(ContactRequest $contactRequest)
    {
        $contactRequest->processed = ! $contactRequest->processed;
        $contactRequest->save();

        return back()->with('success', $contactRequest->processed
            ? 'Message marqué comme traité.'
            : 'Message remis dans les nouveaux.');
    }

    public function destroy(ContactRequest $contactRequest)
    {
        $contactRequest->delete();

        return back()->with('success', 'Message supprimé.');
    }
}
