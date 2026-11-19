<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $stats = [
        'orders_active' => Order::where('status', 'en_cours')->count(),
        'orders_ready' => Order::where('status', 'livraison_en_cours')->count(),
        'appointments_today' => Appointment::whereDate('requested_at', today())->count(),
        'customers_total' => Customer::count(),
    ];

    // Alertes stock bas
    $lowStockProducts = Product::where('stock', '<=', 5)->orderBy('stock', 'asc')->get();

    $recentOrders = Order::with('customer')->latest()->limit(5)->get();

    return view('admin.dashboard', compact('stats', 'lowStockProducts', 'recentOrders'));
}
}
