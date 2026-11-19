<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Appointment;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_count' => Order::where('status', '!=', 'delivered')->count(),
            'appointments_count' => Appointment::whereDate('requested_at', today())->count(),
            'users_count' => User::where('role', 'client')->count(),
            'products_count' => Product::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('superadmin.dashboard', compact('stats', 'recentUsers'));
    }
}
