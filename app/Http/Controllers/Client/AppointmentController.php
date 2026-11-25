<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index()
{
    $customer = Auth::user()->customer;

    // On marque tous les RDV comme "vus" par le client
    $customer->appointments()->update(['client_notified_at' => now()]);

    $appointments = $customer->appointments()->orderBy('requested_at', 'desc')->get();

    return view('client.appointments.index', compact('appointments'));
}

    public function store(Request $request)
    {
        $request->validate([
            'motive' => 'required|in:eye_exam,frame_try_on,pick_up,other',
            'requested_at' => 'required|date|after:now',
            'comment' => 'nullable|string|max:500'
        ]);

        $customer = Auth::user()->customer;

        Appointment::create([
            'customer_id' => $customer->id,
            'reference' => 'RDV-' . strtoupper(Str::random(8)),
            'motive' => $request->motive,
            'requested_at' => $request->requested_at,
            'duration_minutes' => 30,
            'status' => 'en_attente',
            'comment' => $request->comment,
        ]);

        return redirect()->route('client.appointments.index')->with('success', 'Votre demande de rendez-vous a bien été envoyée. L\'équipe la validera rapidement.');
    }
}
