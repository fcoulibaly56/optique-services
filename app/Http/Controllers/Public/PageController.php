<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function services()
    {
        return view('public.services');
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['required', 'string', 'max:20'],
            'email'   => ['nullable', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ], [
            'required' => 'Le champ « :attribute » est obligatoire.',
            'email'    => "L'adresse e-mail n'est pas valide.",
            'max'      => 'Le champ « :attribute » est trop long.',
        ], [
            'name'    => 'nom',
            'phone'   => 'téléphone',
            'email'   => 'e-mail',
            'message' => 'message',
        ]);

        ContactRequest::create([
            'name'       => $validated['name'],
            'phone'      => $validated['phone'],
            'email'      => $validated['email'] ?? null,
            'message'    => $validated['message'],
            'consent_at' => now(),
        ]);

        return back()->with('success', 'Votre message a bien été envoyé. Nous vous recontacterons très vite.');
    }
        public function vision()
    {
        return view('public.vision');
    }
}
