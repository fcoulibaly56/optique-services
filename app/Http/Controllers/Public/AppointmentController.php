<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'time'    => ['required', Rule::in(config('shop.appointment_slots'))],
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['required', 'string', 'max:20'],
            'email'   => ['nullable', 'email', 'max:255'],
            'consent' => ['accepted'],
        ], [
            'required'            => 'Ce champ est obligatoire.',
            'date.date'           => "La date n'est pas valide.",
            'date.after_or_equal' => "Choisissez une date à partir d'aujourd'hui.",
            'time.in'             => 'Choisissez un créneau valide.',
            'email.email'         => "L'adresse e-mail n'est pas valide.",
            'consent.accepted'    => 'Veuillez cocher la case pour que nous puissions vous recontacter.',
            'max'                 => 'Ce champ est trop long.',
        ]);

        $phone = preg_replace('/\D+/', '', $validated['phone']);
        if (strlen($phone) === 11 && str_starts_with($phone, '223')) {
            $phone = substr($phone, 3);
        }
        if (strlen($phone) < 8) {
            return back()->withErrors(['phone' => 'Le numéro doit contenir au moins 8 chiffres.'])->withInput();
        }

        $date = Carbon::parse($validated['date']);

        if ($date->isSunday()) {
            return back()->withErrors(['date' => 'Le magasin est fermé le dimanche. Choisissez un autre jour.'])->withInput();
        }

        if ($date->isSaturday() && ! in_array($validated['time'], config('shop.saturday_slots'), true)) {
            return back()->withErrors(['time' => "Le samedi, le magasin ferme à 14h. Choisissez un créneau plus tôt."])->withInput();
        }

        $requestedAt = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        if ($requestedAt->isPast()) {
            return back()->withErrors(['time' => 'Ce créneau est déjà passé. Choisissez un autre horaire.'])->withInput();
        }

        // 1. Créer ou récupérer la fiche Client (sans créer de compte User, juste le Customer)
        $customer = Customer::firstOrCreate(
            ['phone' => $phone],
            [
                'first_name' => $validated['name'],
                'last_name'  => '',
                'email'      => $validated['email'] ?? null,
            ]
        );

        // 2. Créer le rendez-vous UNE SEULE FOIS
        $appointment = Appointment::create([
            'reference'    => 'RDV-' . strtoupper(Str::random(6)),
            'motive'       => match ($validated['motive']) {
                'examen'   => 'eye_exam',
                'essayage' => 'frame_try_on',
                'retrait'  => 'pick_up',
                default    => 'other',
            },
            'requested_at' => $requestedAt,
            'customer_id'  => $customer->id, // Lié à la fiche client
            'guest_name'   => $validated['name'],
            'guest_phone'  => $phone,
            'guest_email'  => $validated['email'] ?? null,
            'status'       => 'en_attente',
        ]);

        // 3. Vérifier si le client a déjà un compte User pour l'affichage
        $hasAccount = $customer->user_id !== null;

        return redirect()->route('appointment.create')->with([
            'success' => 'Votre demande de rendez-vous a bien été enregistrée.',
            'appointment_reference' => $appointment->reference,
            'appointment_phone' => $phone,
            'has_account' => $hasAccount,
        ]);
    }
}
