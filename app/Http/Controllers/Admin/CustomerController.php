<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\Admin\StoreCustomerRequest;
use Illuminate\Http\Request;
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

public function edit(Customer $customer)
{
    return view('admin.customers.edit', compact('customer'));
}

public function update(StoreCustomerRequest $request, Customer $customer)
{
    $customer->update($request->validated());
    return redirect()->route('admin.customers.index')->with('success', 'Client mis à jour.');
}

public function destroy(Customer $customer)
{
    $customer->delete(); // Soft delete
    return back()->with('success', 'Client archivé.');
}

   public function store(StoreCustomerRequest $request)
{
    $customer = Customer::create($request->validated());

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->last_name . ' ' . $customer->first_name . ' (' . $customer->phone . ')'
            ]
        ]);
    }

    return redirect()->back()->with('success', 'Client créé avec succès.');
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
