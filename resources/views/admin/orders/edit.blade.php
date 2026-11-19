@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen" x-data="orderForm()">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-serif font-bold mb-6">Modifier la Commande {{ $order->reference }}</h1>
        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="bg-white shadow-md rounded-xl p-6">
            @csrf @method('PUT')

            <!-- Client -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Client</label>
                <select name="customer_id" required class="w-full rounded-md border-gray-300 text-sm">
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ $order->customer_id == $c->id ? 'selected' : '' }}>{{ $c->last_name }} {{ $c->first_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Ordonnance -->
            <h3 class="text-lg font-semibold mb-2 border-b pb-1">Ordonnance</h3>
            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                <input type="date" name="prescription_date" value="{{ $order->prescription->prescription_date ?? '' }}" class="rounded-md border-gray-300">
                <input type="text" name="doctor_name" value="{{ $order->prescription->doctor_name ?? '' }}" placeholder="Médecin" class="rounded-md border-gray-300">

                <div class="col-span-2">
                    <p class="font-medium text-xs text-gray-500 mb-1">Œil Droit (OD)</p>
                    <div class="grid grid-cols-5 gap-1">
                        <input type="text" name="od_sph" value="{{ $order->prescription->od_sph ?? '' }}" placeholder="SPH" class="rounded-md border-gray-300 text-xs p-2">
                        <input type="text" name="od_cyl" value="{{ $order->prescription->od_cyl ?? '' }}" placeholder="CYL" class="rounded-md border-gray-300 text-xs p-2">
                        <input type="text" name="od_axis" value="{{ $order->prescription->od_axis ?? '' }}" placeholder="AXE" class="rounded-md border-gray-300 text-xs p-2">
                        <input type="text" name="od_add" value="{{ $order->prescription->od_add ?? '' }}" placeholder="ADD" class="rounded-md border-gray-300 text-xs p-2">
                        <input type="text" name="od_ep" value="{{ $order->prescription->od_ep ?? '' }}" placeholder="EP" class="rounded-md border-gray-300 text-xs p-2">
                    </div>
                </div>
                <div class="col-span-2">
                    <p class="font-medium text-xs text-gray-500 mb-1">Œil Gauche (OG)</p>
                    <div class="grid grid-cols-5 gap-1">
                        <input type="text" name="og_sph" value="{{ $order->prescription->og_sph ?? '' }}" placeholder="SPH" class="rounded-md border-gray-300 text-xs p-2">
                        <input type="text" name="og_cyl" value="{{ $order->prescription->og_cyl ?? '' }}" placeholder="CYL" class="rounded-md border-gray-300 text-xs p-2">
                        <input type="text" name="og_axis" value="{{ $order->prescription->og_axis ?? '' }}" placeholder="AXE" class="rounded-md border-gray-300 text-xs p-2">
                        <input type="text" name="og_add" value="{{ $order->prescription->og_add ?? '' }}" placeholder="ADD" class="rounded-md border-gray-300 text-xs p-2">
                        <input type="text" name="og_ep" value="{{ $order->prescription->og_ep ?? '' }}" placeholder="EP" class="rounded-md border-gray-300 text-xs p-2">
                    </div>
                </div>
                <div class="col-span-2 mt-2">
                    <input type="text" name="lens_type" value="{{ $order->prescription->lens_type ?? '' }}" placeholder="Type de verres" class="w-full rounded-md border-gray-300 text-sm">
                </div>
            </div>

            <!-- Facturation -->
            <h3 class="text-lg font-semibold mb-2 border-b pb-1">Facturation</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="space-y-3">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_pec" value="1" x-model="isPec" class="rounded text-[#A33B36]" {{ $order->is_pec ? 'checked' : '' }}>
                        <span class="text-sm font-medium">P.E.C (Monture fournie par le client)</span>
                    </label>
                    <div>
                        <label class="text-sm text-gray-600">Réf. Monture</label>
                        <input type="text" name="frame_reference" x-model="frame_reference" :disabled="isPec" value="{{ $order->frame_reference }}" class="w-full rounded-md border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Prix Monture (FCFA)</label>
                        <input type="number" name="frame_price" x-model.number="frame_price" :disabled="isPec" class="w-full rounded-md border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Prix Verre (FCFA)</label>
                        <input type="number" name="lens_price" x-model.number="lens_price" class="w-full rounded-md border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Assurance</label>
                        <select name="insurance_id" class="w-full rounded-md border-gray-300 text-sm">
                            <option value="">Aucune</option>
                            @foreach(\App\Models\Insurance::all() as $i)
                                <option value="{{ $i->id }}" {{ $order->insurance_id == $i->id ? 'selected' : '' }}>{{ $i->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg h-fit">
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span>Total :</span><span x-text="formatMoney(total)"></span></div>
                        <div class="flex justify-between items-center">
                            <span>Remise :</span>
                            <input type="number" name="discount" x-model.number="discount" class="w-24 text-right rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="flex justify-between font-bold text-[#A33B36] border-t pt-2"><span>Net :</span><span x-text="formatMoney(netToPay)"></span></div>
                        <div class="flex justify-between items-center border-t pt-2 mt-2">
                            <span>Acompte :</span>
                            <input type="number" name="deposit_amount" x-model.number="deposit" class="w-24 text-right rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="flex justify-between font-bold text-red-600"><span>Reste :</span><span x-text="formatMoney(remaining)"></span></div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de Livraison prévue</label>
                <input type="date" name="delivery_date" value="{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') : '' }}" class="w-full md:w-1/2 rounded-md border-gray-300 text-sm">
            </div>

            <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded-md font-medium">Mettre à jour</button>
        </form>
    </div>
</div>
<script>
    function orderForm() {
        return {
            frame_reference: '{{ $order->frame_reference }}',
            frame_price: {{ $order->frame_price }}, lens_price: {{ $order->lens_price }},
            discount: {{ $order->discount }}, deposit: {{ $order->deposit_amount }},
            isPec: {{ $order->is_pec ? 'true' : 'false' }},

            get total() { return (this.isPec ? 0 : Number(this.frame_price || 0)) + Number(this.lens_price || 0); },
            get netToPay() { return this.total - Number(this.discount || 0); },
            get remaining() { return this.netToPay - Number(this.deposit || 0); },
            formatMoney(value) { return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA'; }
        }
    }
</script>
@endsection
