<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Http\Requests\Admin\StoreCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $customers = $query->latest()->paginate(15)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        // 1. On vérifie / crée le compte utilisateur
        $user = User::firstOrCreate(
            ['phone' => $data['phone']],
            [
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'] ?? $data['phone'] . '@optique.local',
                'password' => bcrypt(Str::random(16)),
                'role' => 'client',
            ]
        );

        // 2. On crée la fiche client liée
        $customer = Customer::create([
            'user_id' => $user->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'profession' => $data['profession'] ?? null,
            'address' => $data['address'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
        ]);

        // 3. Si c'est une requête AJAX (création rapide depuis le formulaire de commande)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->last_name . ' ' . $customer->first_name . ' (' . $customer->phone . ')'
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Client et compte créés avec succès.');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(StoreCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        // On synchronise aussi le nom sur le compte User si nécessaire
        if ($customer->user) {
            $customer->user->update([
                'name' => $customer->first_name . ' ' . $customer->last_name,
                'email' => $customer->email ?? $customer->phone . '@optique.local',
            ]);
        }

        return redirect()->route('admin.customers.index')->with('success', 'Client mis à jour.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete(); // Soft delete
        return back()->with('success', 'Client archivé.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders' => fn($q) => $q->latest(), 'appointments' => fn($q) => $q->latest()]);
        return view('admin.customers.show', compact('customer'));
    }

    public function export() {
        return Excel::download(new CustomersExport, 'clients_optique_' . now()->format('d_m_Y') . '.xlsx');
    }

    public function import(Request $request) {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new CustomersImport, $request->file('file'));
        return back()->with('success', 'Clients importés avec succès.');
    }
}
