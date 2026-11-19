<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Http\Requests\Admin\UpdateAppointmentStatusRequest;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with('customer')->latest('requested_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_phone', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($qCustomer) use ($search) {
                      $qCustomer->where('last_name', 'like', "%{$search}%")
                                ->orWhere('first_name', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('requested_at', $request->input('date'));
        } elseif ($request->input('view') === 'today') {
            $query->whereDate('requested_at', now()->toDateString());
        } elseif ($request->input('view') === 'upcoming') {
            $query->where('requested_at', '>=', now());
        }

        $appointments = $query->paginate(15)->withQueryString();

        $counters = [
            'today'     => Appointment::whereDate('requested_at', now()->toDateString())->count(),
            'pending'   => Appointment::where('status', 'en_attente')->count(),
            'confirmed' => Appointment::where('status', 'confirme')->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'counters'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('customer');
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(UpdateAppointmentStatusRequest $request, Appointment $appointment)
    {
        if ($appointment->status === 'termine') {
            return back()->with('error', 'Ce rendez-vous est terminé et ne peut plus être modifié.');
        }

        $appointment->update([
            'status'      => $request->status,
            'proposed_at' => $request->proposed_at ?? $appointment->proposed_at,
            'comment'     => $request->comment ?? $appointment->comment,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Rendez-vous mis à jour.');
    }
}
