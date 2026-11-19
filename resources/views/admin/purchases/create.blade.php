@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen" x-data="stockForm()">
    <h1 class="text-2xl font-serif mb-6">Entrée de Stock (Approvisionnement)</h1>
    <form action="{{ route('admin.purchases.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow max-w-3xl">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm mb-1">Provenance (Fournisseur, Pays, etc.)</label>
                <input type="text" name="supplier_name" placeholder="Ex: Import Dubaï..." class="w-full border rounded p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm mb-1">Date de réception</label>
                <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" class="w-full border rounded p-2 text-sm" required>
            </div>
        </div>

        <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold">Produits reçus</h3>
            <!-- BOUTON POUR CRÉER UN PRODUIT A LA VOLEE -->
            <button type="button" @click="openProductModal = true" class="text-sm bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700">
                + Nouveau Produit
            </button>
        </div>

        <template x-for="(item, index) in items" :key="index">
            <div class="flex gap-2 mb-2 items-end">
                <div class="flex-1">
                    <select :name="`items[${index}][product_id]`" x-model="item.product_id" class="w-full border rounded p-2 text-sm" required>
                        <option value="">-- Choisir un produit --</option>
                        <!-- On boucle sur la liste dynamique pour inclure les nouveaux produits créés -->
                        <template x-for="p in productList" :key="p.id">
                            <option :value="p.id" x-text="p.name + ' (Stock: ' + p.stock + ')'"></option>
                        </template>
                    </select>
                </div>
                <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" placeholder="Qté" class="w-24 border rounded p-2 text-sm" required>
                <button type="button" @click="items.splice(index, 1)" class="text-red-500 font-bold p-2 text-xl" x-show="items.length > 1">&times;</button>
            </div>
        </template>
        <button type="button" @click="items.push({product_id: '', quantity: 1})" class="text-[#A33B36] font-medium text-sm mt-2">+ Ajouter une ligne</button>

        <div class="mt-6 border-t pt-4 flex justify-end">
            <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded">Enregistrer l'entrée de stock</button>
        </div>
    </form>

    <!-- MODAL DE CREATION RAPIDE DE PRODUIT -->
    <div x-show="openProductModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;" x-transition>
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-bold mb-4">Créer un nouveau produit</h3>
            <form @submit.prevent="createProduct">
                <div class="space-y-3">
                    <input type="text" x-model="newProduct.name" placeholder="Nom du produit *" required class="w-full border rounded p-2 text-sm">
                    <!-- CHAMP REFERENCE AJOUTE -->
                    <input type="text" x-model="newProduct.reference" placeholder="Référence (ex: TR30_...)" class="w-full border rounded p-2 text-sm">
                    <select x-model="newProduct.category_id" required class="w-full border rounded p-2 text-sm">
                        <option value="">Catégorie...</option>
                        @foreach(\App\Models\Category::all() as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                    </select>
                    <input type="number" x-model.number="newProduct.price" placeholder="Prix de vente (FCFA) *" required class="w-full border rounded p-2 text-sm">
                    <input type="number" x-model.number="newProduct.stock" placeholder="Stock initial" value="0" class="w-full border rounded p-2 text-sm">
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="openProductModal = false" class="bg-gray-200 px-4 py-2 rounded text-sm">Annuler</button>
                    <button type="submit" class="bg-[#A33B36] text-white px-4 py-2 rounded text-sm">Créer et ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function stockForm() {
        return {
            items: [{ product_id: '', quantity: 1 }],
            // On initialise la liste avec les produits existants
            productList: @json($products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'stock' => $p->stock])),
            openProductModal: false,
            newProduct: { name: '', reference: '', category_id: '', price: 0, stock: 0 },

            async createProduct() {
                try {
                    const response = await fetch('{{ route('admin.products.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.newProduct)
                    });
                    const data = await response.json();

                    if (data.success) {
                        // On ajoute le nouveau produit à la liste locale
                        this.productList.push({
                            id: data.product.id,
                            name: data.product.name,
                            stock: this.newProduct.stock
                        });
                        // On le sélectionne automatiquement dans la dernière ligne
                        this.items[this.items.length - 1].product_id = data.product.id;

                        // On ferme le modal et on reset le formulaire
                        this.openProductModal = false;
                        this.newProduct = { name: '', reference: '', category_id: '', price: 0, stock: 0 };
                    } else {
                        alert(data.message || 'Erreur de validation. Vérifiez les champs.');
                    }
                } catch (error) {
                    alert('Erreur réseau : ' + error.message);
                }
            }
        }
    }
</script>
@endsection
