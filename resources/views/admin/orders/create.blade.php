@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen" x-data="orderForm()">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-serif font-bold text-gray-800">Nouvelle Commande</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-[#A33B36] text-sm">&larr; Retour</a>
        </div>

        <form action="{{ route('admin.orders.store') }}" method="POST" class="bg-white shadow-md rounded-xl p-6">
            @csrf

            <!-- Client -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Client</label>
                <select name="customer_id" required class="w-full rounded-md border-gray-300 text-sm focus:ring-[#A33B36] focus:border-[#A33B36]">
                    <option value="">Sélectionner un client...</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->last_name }} {{ $c->first_name }} ({{ $c->phone }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Ordonnance -->
            <h3 class="text-lg font-semibold mb-2 border-b pb-1">Ordonnance</h3>
            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                <input type="date" name="prescription_date" class="rounded-md border-gray-300">
                <input type="text" name="doctor_name" placeholder="Médecin" class="rounded-md border-gray-300">

                <div class="col-span-2 mt-2">
                    <p class="font-medium text-xs text-gray-500 mb-1">Œil Droit (OD)</p>
                    <div class="grid grid-cols-5 gap-1">
                        <input type="text" name="od_sph" placeholder="SPH" class="rounded-md border-gray-300 text-xs p-2 text-center">
                        <input type="text" name="od_cyl" placeholder="CYL" class="rounded-md border-gray-300 text-xs p-2 text-center">
                        <input type="text" name="od_axis" placeholder="AXE" class="rounded-md border-gray-300 text-xs p-2 text-center">
                        <input type="text" name="od_add" placeholder="ADD" class="rounded-md border-gray-300 text-xs p-2 text-center">
                        <input type="text" name="od_ep" placeholder="EP" class="rounded-md border-gray-300 text-xs p-2 text-center">
                    </div>
                </div>
                <div class="col-span-2">
                    <p class="font-medium text-xs text-gray-500 mb-1">Œil Gauche (OG)</p>
                    <div class="grid grid-cols-5 gap-1">
                        <input type="text" name="og_sph" placeholder="SPH" class="rounded-md border-gray-300 text-xs p-2 text-center">
                        <input type="text" name="og_cyl" placeholder="CYL" class="rounded-md border-gray-300 text-xs p-2 text-center">
                        <input type="text" name="og_axis" placeholder="AXE" class="rounded-md border-gray-300 text-xs p-2 text-center">
                        <input type="text" name="og_add" placeholder="ADD" class="rounded-md border-gray-300 text-xs p-2 text-center">
                        <input type="text" name="og_ep" placeholder="EP" class="rounded-md border-gray-300 text-xs p-2 text-center">
                    </div>
                </div>
                <!-- Type de Verres -->
                <div class="col-span-2">
                    <input type="text" name="lens_type" placeholder="Type de verres (ex: H56 Photo Gray, Progressif...)" class="w-full rounded-md border-gray-300 text-sm">
                </div>
            </div>

            <!-- Facturation -->
            <h3 class="text-lg font-semibold mb-2 border-b pb-1">Facturation</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="space-y-3 relative">
                    <!-- Checkbox PEC -->
                    <label class="flex items-center gap-2 bg-gray-50 p-2 rounded border border-gray-200 cursor-pointer">
                        <input type="checkbox" name="is_pec" value="1" x-model="isPec" @change="if(isPec) clearProduct()" class="rounded text-[#A33B36] focus:ring-[#A33B36]">
                        <span class="text-sm font-medium text-gray-800">P.E.C (Monture fournie par le client)</span>
                    </label>

                    <!-- Recherche Produit -->
                    <div>
                        <label class="text-sm text-gray-600">Monture (Scanner ou taper la réf.)</label>
                        <input type="text"
                               x-model="search"
                               @input.debounce.300ms="fetchProducts"
                               :disabled="isPec"
                               placeholder="Ex: TR30, 6003..."
                               class="w-full rounded-md border-gray-300 text-sm disabled:bg-gray-100 focus:ring-[#A33B36] focus:border-[#A33B36]"
                               autocomplete="off">

                        <input type="hidden" name="frame_product_id" x-model="frame_product_id">
                        <input type="hidden" name="frame_reference" x-model="frame_reference">

                        <!-- Menu déroulant de résultats -->
                        <div x-show="results.length > 0" class="absolute z-20 w-full bg-white border border-gray-200 rounded-md shadow-lg mt-1 max-h-60 overflow-y-auto" style="display: none;">
                            <template x-for="product in results" :key="product.id">
                                <div @click="selectProduct(product)" class="p-3 hover:bg-gray-50 cursor-pointer border-b last:border-0">
                                    <div class="font-medium text-sm text-gray-900" x-text="product.reference || product.name"></div>
                                    <div class="text-xs text-gray-500">
                                        <span x-text="product.name"></span> -
                                        <span class="text-green-600 font-bold" x-text="'Stock: ' + product.stock"></span> -
                                        <span x-text="new Intl.NumberFormat('fr-FR').format(product.price) + ' FCFA'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm text-gray-600">Prix Monture</label>
                            <input type="number" name="frame_price" x-model.number="frame_price" :disabled="isPec" class="w-full rounded-md border-gray-300 text-sm disabled:bg-gray-100">
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Prix Verre</label>
                            <input type="number" name="lens_price" x-model.number="lens_price" class="w-full rounded-md border-gray-300 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Assurance</label>
                        <select name="insurance_id" class="w-full rounded-md border-gray-300 text-sm">
                            <option value="">Aucune</option>
                            @foreach(\App\Models\Insurance::all() as $i) <option value="{{ $i->id }}">{{ $i->name }}</option> @endforeach
                        </select>
                    </div>
                </div>

                <!-- Résumé -->
                <div class="bg-gray-50 p-4 rounded-lg h-fit border border-gray-200 shadow-inner">
                    <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">Résumé Financier</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span>Total :</span><span x-text="formatMoney(total)"></span></div>
                        <div class="flex justify-between items-center">
                            <span>Remise :</span>
                            <input type="number" name="discount" x-model.number="discount" class="w-24 text-right rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="flex justify-between font-bold text-[#A33B36] border-t pt-2"><span>Net à payer :</span><span x-text="formatMoney(netToPay)"></span></div>
                        <div class="flex justify-between items-center border-t pt-2 mt-2">
                            <span>Acompte :</span>
                            <input type="number" name="deposit_amount" x-model.number="deposit" class="w-24 text-right rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="flex justify-between font-bold text-red-600 text-lg mt-2"><span>Reste :</span><span x-text="formatMoney(remaining)"></span></div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de Livraison prévue</label>
                <input type="date" name="delivery_date" class="w-full md:w-1/2 rounded-md border-gray-300 text-sm">
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="bg-[#A33B36] text-white px-8 py-3 rounded-md font-bold text-lg hover:bg-opacity-90 w-full md:w-auto shadow-md">
                    Enregistrer la Commande
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function orderForm() {
        return {
            // Variables calculs
            frame_price: 0, lens_price: 0, discount: 0, deposit: 0, isPec: false,

            // Variables recherche produit
            search: '',
            results: [],
            frame_product_id: '',
            frame_reference: '',

            // Propriétés calculées
            get total() { return (this.isPec ? 0 : Number(this.frame_price || 0)) + Number(this.lens_price || 0); },
            get netToPay() { return this.total - Number(this.discount || 0); },
            get remaining() { return this.netToPay - Number(this.deposit || 0); },

            // Fonctions
            formatMoney(value) { return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA'; },

            async fetchProducts() {
                if (this.search.length < 2) { this.results = []; return; }
                try {
                    const response = await fetch(`{{ route('admin.products.search-api') }}?q=${this.search}`);
                    this.results = await response.json();
                } catch (e) { console.error("Erreur de recherche", e); }
            },

            selectProduct(product) {
                this.search = product.reference || product.name;
                this.frame_reference = product.reference || product.name;
                this.frame_product_id = product.id;
                this.frame_price = parseFloat(product.price);
                this.results = []; // Cache la liste
            },

            clearProduct() {
                // Quand on coche PEC
                this.search = '';
                this.frame_product_id = '';
                this.frame_reference = '';
                this.frame_price = 0;
                this.results = [];
            }
        }
    }
</script>
@endsection
