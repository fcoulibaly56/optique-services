<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    public function index() {
        $purchases = Purchase::latest()->paginate(15);
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create() {
        $products = Product::all();
        return view('admin.purchases.create', compact('products'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($data) {
            $purchase = Purchase::create([
                'supplier_name' => $data['supplier_name'],
                'reference' => 'ENT-' . strtoupper(Str::random(8)),
                'purchase_date' => $data['purchase_date'],
                'total_amount' => 0,
                'status' => 'recu', // On considère que la réception est immédiate
                'created_by' => Auth::id(),
            ]);

            foreach ($data['items'] as $item) {
                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => 0,
                ]);

                // MISE A JOUR DU STOCK DIRECTEMENT ICI
                Product::find($item['product_id'])->increment('stock', $item['quantity']);
            }
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Entrée de stock enregistrée. Les quantités ont été ajoutées.');
    }

    public function show(Purchase $purchase) {
        $purchase->load(['items.product']);
        return view('admin.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase) {
        $purchase->load('items');
        return view('admin.purchases.edit', compact('purchase'));
    }

    public function update(Request $request, Purchase $purchase) {
        $request->validate(['status' => 'required|in:en_attente,recu,annule']);

        DB::transaction(function () use ($request, $purchase) {
            $oldStatus = $purchase->status;
            $newStatus = $request->status;

            // GESTION DU STOCK LORS DU CHANGEMENT DE STATUT
            if ($oldStatus !== 'recu' && $newStatus === 'recu') {
                // Si on passe à "Reçu", on ajoute le stock
                foreach ($purchase->items as $item) {
                    Product::find($item->product_id)->increment('stock', $item->quantity);
                }
            } elseif ($oldStatus === 'recu' && $newStatus === 'annule') {
                // Si on annule un achat déjà reçu, on retire le stock
                foreach ($purchase->items as $item) {
                    Product::find($item->product_id)->decrement('stock', $item->quantity);
                }
            }

            $purchase->update([
                'status' => $newStatus,
                'purchase_date' => $request->purchase_date // On permet aussi de corriger la date
            ]);
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Achat mis à jour. Le stock a été ajusté.');
    }

    public function destroy(Purchase $purchase) {
        DB::transaction(function () use ($purchase) {
            // Si l'achat était "reçu", on retire les quantités du stock avant de supprimer
            if ($purchase->status === 'recu') {
                foreach ($purchase->items as $item) {
                    Product::find($item->product_id)->decrement('stock', $item->quantity);
                }
            }
            $purchase->delete();
        });

        return back()->with('success', 'Achat supprimé et stock ajusté.');
    }
}
