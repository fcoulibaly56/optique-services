<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Prescription;
use App\Http\Requests\Admin\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
     public function index(Request $request)
{
    $query = Order::with('customer')->latest();

    // 1. Recherche par nom, téléphone ou référence
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('reference', 'like', "%{$search}%")
              ->orWhereHas('customer', fn($c) => $c->where('last_name', 'like', "%{$search}%")
                                                  ->orWhere('first_name', 'like', "%{$search}%")
                                                  ->orWhere('phone', 'like', "%{$search}%"));
        });
    }

    // 2. Filtres par date
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    // 3. Filtre par onglet (statut)
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    } else {
        $query->where('status', 'en_cours');
    }

    $orders = $query->paginate(15)->withQueryString();

    $counters = [
        'en_cours' => Order::where('status', 'en_cours')->count(),
        'livraison' => Order::where('status', 'livraison_en_cours')->count(),
        'livre' => Order::where('status', 'livre_paye')->count(),
    ];

    return view('admin.orders.index', compact('orders', 'counters'));
}

    public function create()
    {
        $customers = Customer::orderBy('last_name')->get();
        $products = Product::where('stock', '>', 0)->get(); // Seulement les produits en stock
        return view('admin.orders.create', compact('customers', 'products'));
    }

    public function store(StoreOrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $isPec = $request->has('is_pec');

            // 1. Créer l'ordonnance
            $prescription = Prescription::create([
                'customer_id' => $data['customer_id'],
                'file_key' => 'manual', 'original_name' => 'Saisie manuelle', 'mime_type' => 'text/plain', 'size' => 0,
                'status' => 'validee', 'validated_by' => Auth::id(), 'validated_at' => now(),
                'doctor_name' => $data['doctor_name'] ?? null, 'prescription_date' => $data['prescription_date'] ?? null,
                'od_sph' => $data['od_sph'] ?? null, 'od_cyl' => $data['od_cyl'] ?? null, 'od_axis' => $data['od_axis'] ?? null, 'od_add' => $data['od_add'] ?? null, 'od_ep' => $data['od_ep'] ?? null,
                'og_sph' => $data['og_sph'] ?? null, 'og_cyl' => $data['og_cyl'] ?? null, 'og_axis' => $data['og_axis'] ?? null, 'og_add' => $data['og_add'] ?? null, 'og_ep' => $data['og_ep'] ?? null,
                'lens_type' => $data['lens_type'] ?? null,
            ]);

            // 2. Gestion du stock (Si un produit est sélectionné et que ce n'est pas PEC)
            $framePrice = $data['frame_price'] ?? 0;
            $frameReference = $data['frame_reference'] ?? null;
            $frameProductId = null;

            if (!$isPec && !empty($data['frame_product_id'])) {
                $product = Product::find($data['frame_product_id']);
                if ($product && $product->stock > 0) {
                    $product->decrement('stock', 1);
                    $framePrice = $product->price;
                    $frameReference = $product->name;
                    $frameProductId = $product->id;
                }
            }

            // Si P.E.C, le prix de la monture est forcé à 0
            if ($isPec) {
                $framePrice = 0;
            }

            // 3. Calculs
            $total = $framePrice + ($data['lens_price'] ?? 0);
            $netToPay = $total - ($data['discount'] ?? 0);
            $remaining = $netToPay - ($data['deposit_amount'] ?? 0);

            // 4. Créer la commande
            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'prescription_id' => $prescription->id,
                'reference' => 'CMD-' . strtoupper(Str::random(8)),
                'status' => 'en_cours',
                'is_pec' => $isPec,
                'frame_product_id' => $frameProductId,
                'frame_reference' => $frameReference,
                'frame_price' => $framePrice,
                'lens_price' => $data['lens_price'],
                'total_amount' => $total,
                'discount' => $data['discount'] ?? 0,
                'insurance_id' => $data['insurance_id'] ?? null,
                'net_to_pay' => $netToPay,
                'deposit_amount' => $data['deposit_amount'] ?? 0,
                'remaining_amount' => $remaining,
                'delivery_date' => $data['delivery_date'] ?? null,
                'created_by' => Auth::id(),
            ]);

            $order->statusHistory()->create([
                'to_status' => 'en_cours', 'changed_by' => Auth::id(), 'note' => 'Création en boutique.', 'visible_to_client' => true
            ]);
        });

        return redirect()->route('admin.orders.index')->with('success', 'Commande enregistrée.');
    }
        public function edit(Order $order)
    {
        $order->load('prescription');
        $customers = Customer::orderBy('last_name')->get();
        $products = Product::all();
        return view('admin.orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'frame_reference' => 'nullable|string',
            'frame_price' => 'nullable|numeric|min:0',
            'lens_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'insurance_id' => 'nullable|exists:insurances,id',
            'deposit_amount' => 'nullable|numeric|min:0',
            'delivery_date' => 'nullable|date|after_or_equal:today',
            'lens_type' => 'nullable|string',
        ]);

        // Gestion simple du PEC pour l'édition
        $framePrice = $request->has('is_pec') ? 0 : ($data['frame_price'] ?? 0);
        $total = $framePrice + $data['lens_price'];
        $netToPay = $total - ($data['discount'] ?? 0);
        $remaining = $netToPay - ($data['deposit_amount'] ?? 0);

        $order->update([
            'customer_id' => $data['customer_id'],
            'is_pec' => $request->has('is_pec'),
            'frame_reference' => $data['frame_reference'],
            'frame_price' => $framePrice,
            'lens_price' => $data['lens_price'],
            'total_amount' => $total,
            'discount' => $data['discount'] ?? 0,
            'net_to_pay' => $netToPay,
            'deposit_amount' => $data['deposit_amount'] ?? 0,
            'remaining_amount' => $remaining,
            'delivery_date' => $data['delivery_date'],
            'insurance_id' => $data['insurance_id'],
        ]);

        // Mettre à jour l'ordonnance liée
        if ($order->prescription) {
            $order->prescription->update([
                'doctor_name' => $request->doctor_name,
                'prescription_date' => $request->prescription_date,
                'od_sph' => $request->od_sph, 'od_cyl' => $request->od_cyl, 'od_axis' => $request->od_axis, 'od_add' => $request->od_add, 'od_ep' => $request->od_ep,
                'og_sph' => $request->og_sph, 'og_cyl' => $request->og_cyl, 'og_axis' => $request->og_axis, 'og_add' => $request->og_add, 'og_ep' => $request->og_ep,
                'lens_type' => $data['lens_type'], // <--- AJOUTÉ
            ]);
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Commande modifiée avec succès.');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'prescription', 'statusHistory.user', 'insurance', 'frameProduct']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:en_cours,livraison_en_cours,livre_paye,annulee']);

        DB::transaction(function () use ($request, $order) {
            $oldStatus = $order->status;
            $updateData = ['status' => $request->status];

            // Si on annule une commande qui avait un produit du stock, on le remet en stock
            if ($request->status === 'annulee' && $oldStatus !== 'annulee' && $order->frame_product_id) {
                Product::find($order->frame_product_id)->increment('stock', 1);
            }

            if ($request->status === 'livre_paye') {
                $updateData['remaining_amount'] = 0;
                $updateData['deposit_amount'] = $order->net_to_pay;
            }

            $order->update($updateData);
            $order->statusHistory()->create([
                'from_status' => $oldStatus, 'to_status' => $request->status,
                'changed_by' => Auth::id(), 'note' => 'Mise à jour statut.', 'visible_to_client' => true
            ]);
        });

        return redirect()->route('admin.orders.index', ['status' => $request->status])->with('success', 'Statut mis à jour.');
    }
}
