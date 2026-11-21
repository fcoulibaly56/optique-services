<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('public.appointment');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'motive'  => ['required', 'string', 'max:50'],
            'date'    => ['required', 'date', 'after_or_equal:today'],
            'time'    => ['required', 'date_format:H:i'],
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['required', 'string', 'max:20'],
            'email'   => ['nullable', 'email', 'max:255'],
            'consent' => ['accepted'],
        ], [
            'required'            => 'Ce champ est obligatoire.',
            'date.date'           => "La date n'est pas valide.",
            'date.after_or_equal' => "Choisissez une date à partir d'aujourd'hui.",
            'time.date_format'    => 'Choisissez un créneau valide.',
            'email.email'         => "L'adresse e-mail n'est pas valide.",
            'consent.accepted'    => 'Veuillez cocher la case pour que nous puissions vous recontacter.',
            'max'                 => 'Ce champ est trop long.',
        ]);

        // "+223 65 81 05 01" devient "65810501" (même format que les comptes clients)
        $phone = preg_replace('/\D+/', '', $validated['phone']);
        if (strlen($phone) === 11 && str_starts_with($phone, '223')) {
            $phone = substr($phone, 3);
        }
        if (strlen($phone) < 8) {
            return back()->withErrors(['phone' => 'Le numéro doit contenir au moins 8 chiffres.'])->withInput();
        }

        $requestedAt = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        if ($requestedAt->isPast()) {
            return back()->withErrors(['time' => 'Ce créneau est déjà passé. Choisissez un autre horaire.'])->withInput();
        }

        Appointment::create([
            'reference'    => 'RDV-' . strtoupper(Str::random(6)),
            'motive'       => match ($validated['motive']) {
                'examen'   => 'eye_exam',
                'essayage' => 'frame_try_on',
                default    => 'other',
            },
            'requested_at' => $requestedAt,
            'customer_id'  => Customer::where('phone', $phone)->value('id'), // lié au client s'il existe déjà
            'guest_name'   => $validated['name'],
            'guest_phone'  => $phone,
            'guest_email'  => $validated['email'] ?? null,
            'status'       => 'en_attente',
        ]);

        return redirect()->route('appointment.create')
            ->with('success', 'Votre demande de rendez-vous a bien été enregistrée. Nous vous confirmerons le créneau rapidement.');
    }
}
