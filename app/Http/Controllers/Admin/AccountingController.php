<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index(Request $request)
    {
        // Par défaut, on affiche le mois en cours
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Toutes les commandes payées sur la période
        $paidOrders = Order::where('status', 'livre_paye')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->with(['customer', 'insurance'])
            ->latest()
            ->get();

        $totalRevenue = $paidOrders->sum('net_to_pay');
        $totalOrders = $paidOrders->count();

        // Somme par assurance
        $insuranceTotals = $paidOrders->whereNotNull('insurance_id')
            ->groupBy('insurance_id')
            ->map(function ($orders) {
                return [
                    'name' => $orders->first()->insurance->name ?? 'Inconnue',
                    'total' => $orders->sum('net_to_pay'),
                    'count' => $orders->count(),
                ];
            });

        return view('admin.accounting.index', compact('paidOrders', 'totalRevenue', 'totalOrders', 'insuranceTotals', 'startDate', 'endDate'));
    }
}
