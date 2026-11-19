<?php

 namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('public.appointment');
    }

    public function store(Request $request)
    {
        // À remplacer par une vraie validation et logique métier plus tard
        $validated = $request->validate([
            'motive' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
        ]);

        $requestedAt = \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['time']);

        Appointment::create([
            'reference' => 'RDV-' . strtoupper(Str::random(6)),
            'motive' => $validated['motive'] === 'examen' ? 'eye_exam' : ($validated['motive'] === 'essayage' ? 'frame_try_on' : 'other'),
            'requested_at' => $requestedAt,
            'guest_name' => $validated['name'],
            'guest_phone' => $validated['phone'],
            'guest_email' => $validated['email'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('appointment.create')->with('success', 'Votre demande de rendez-vous a bien été enregistrée. Nous vous confirmerons le créneau rapidement.');
    }
}
