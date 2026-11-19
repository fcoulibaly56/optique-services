<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            abort(403, 'Aucun profil client trouvé pour ce compte.');
        }

        // Récupérer la dernière commande active (en cours ou livraison)
        $activeOrder = $customer->orders()
            ->whereIn('status', ['en_cours', 'livraison_en_cours'])
            ->latest()
            ->first();

        // Prochain rendez-vous (s'il y en a un)
        $nextAppointment = $customer->appointments()
            ->whereIn('status', ['en_attente', 'confirme'])
            ->where('requested_at', '>=', now())
            ->orderBy('requested_at')
            ->first();

        return view('client.dashboard', compact('customer', 'activeOrder', 'nextAppointment'));
    }
}
