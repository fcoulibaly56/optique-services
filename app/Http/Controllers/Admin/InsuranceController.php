<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\Order;

class InsuranceController extends Controller
{
    public function index()
    {
        // On liste les assurances avec le nombre total de commandes liées
        $insurances = Insurance::withCount(['orders' => function($query) {
            $query->where('status', '!=', 'annulee'); // On ne compte pas les annulées
        }])->get();

        return view('admin.insurances.index', compact('insurances'));
    }

    public function orders(Insurance $insurance)
    {
        // Toutes les commandes pour cette assurance spécifique
        $orders = Order::where('insurance_id', $insurance->id)
            ->with('customer')
            ->latest()
            ->paginate(15);

        return view('admin.insurances.orders', compact('orders', 'insurance'));
    }
}
