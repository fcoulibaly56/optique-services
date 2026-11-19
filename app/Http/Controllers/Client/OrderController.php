<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $orders = $customer->orders()->latest()->paginate(10);
        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Sécurité : le client ne peut voir que ses propres commandes
        if ($order->customer_id !== Auth::user()->customer->id) {
            abort(403);
        }
        $order->load(['prescription', 'statusHistory', 'insurance']);
        return view('client.orders.show', compact('order'));
    }
}
