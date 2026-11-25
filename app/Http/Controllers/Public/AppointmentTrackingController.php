<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentTrackingController extends Controller
{
    public function show()
    {
        return view('public.track-appointment');
    }

    public function track(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'reference' => 'required|string',
        ], [
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'reference.required' => 'La référence du rendez-vous est obligatoire.',
        ]);

        // Nettoyage du téléphone
        $phone = preg_replace('/\D+/', '', $request->phone);
        if (strlen($phone) === 11 && str_starts_with($phone, '223')) {
            $phone = substr($phone, 3);
        }

        $appointment = Appointment::where('reference', strtoupper(trim($request->reference)))
            ->where(function ($q) use ($phone) {
                $q->where('guest_phone', $phone)
                  ->orWhereHas('customer', fn($c) => $c->where('phone', $phone));
            })
            ->with('customer')
            ->first();

        if (!$appointment) {
            return back()
                ->withErrors(['reference' => 'Aucun rendez-vous trouvé avec ces informations. Vérifiez votre numéro et la référence.'])
                ->withInput();
        }

        return view('public.track-appointment-result', compact('appointment'));
    }
}
