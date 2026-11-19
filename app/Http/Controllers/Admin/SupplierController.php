<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index() {
        $suppliers = Supplier::withCount('purchases')->latest()->paginate(15);
        return view('admin.suppliers.index', compact('suppliers'));
    }
    public function create() { return view('admin.suppliers.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        Supplier::create($data);
        return redirect()->route('admin.suppliers.index')->with('success', 'Fournisseur ajouté.');
    }
    public function show(Supplier $supplier) {
    $supplier->load(['purchases' => fn($q) => $q->latest()]);
    return view('admin.suppliers.show', compact('supplier'));
}
    public function edit(Supplier $supplier) { return view('admin.suppliers.edit', compact('supplier')); }
    public function update(Request $request, Supplier $supplier) {
        $supplier->update($request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string', 'phone' => 'nullable|string',
            'email' => 'nullable|email', 'address' => 'nullable|string', 'notes' => 'nullable|string',
        ]));
        return redirect()->route('admin.suppliers.index')->with('success', 'Fournisseur mis à jour.');
    }
    public function destroy(Supplier $supplier) {
        $supplier->delete();
        return back()->with('success', 'Fournisseur supprimé.');
    }
}
