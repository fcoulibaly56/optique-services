@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen" x-data="stockForm()">
    <h1 class="text-2xl font-serif mb-6">Entrée de Stock (Approvisionnement)</h1>

    <form action="{{ route('admin.purchases.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow max-w-3xl">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="supplier-name" class="block text-sm mb-1">Provenance (Fournisseur, Pays, etc.)</label>
                <input id="supplier-name" type="text" name="supplier_name" value="{{ old('supplier_name') }}" placeholder="Ex: Import Dubaï..." class="w-full border rounded p-2 text-sm" required>
            </div>
            <div>
                <label for="purchase-date" class="block text-sm mb-1">Date de réception</label>
                <input id="purchase-date" type="date" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" class="w-full border rounded p-2 text-sm" required>
            </div>
        </div>

        <div class="flex justify-between items-center mb-2">
            <h2 class="font-bold">Produits reçus</h2>
            <button type="button" @click="openProductModal = true" class="text-sm bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700">
                + Nouveau Produit
            </button>
        </div>

        <template x-for="(item, index) in items" :key="index">
            <div class="flex gap-2 mb-2 items-end">
                <div class="flex-1">
                    <label :for="`purchase-product-${index}`" class="sr-only">Produit reçu</label>
                    <select :id="`purchase-product-${index}`" :name="`items[${index}][product_id]`" x-model="item.product_id" class="w-full border rounded p-2 text-sm" required>
                        <option value="">-- Choisir un produit --</option>
                        <template x-for="product in productList" :key="product.id">
                            <option :value="product.id" x-text="product.name + ' (Stock: ' + product.stock + ')' "></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label :for="`purchase-quantity-${index}`" class="sr-only">Quantité reçue</label>
                    <input :id="`purchase-quantity-${index}`" type="number" min="1" :name="`items[${index}][quantity]`" x-model.number="item.quantity" placeholder="Qté" class="w-24 border rounded p-2 text-sm" required>
                </div>
                <button type="button" @click="items.splice(index, 1)" class="text-red-500 font-bold p-2 text-xl" x-show="items.length > 1" aria-label="Supprimer cette ligne">&times;</button>
            </div>
        </template>

        <button type="button" @click="items.push({product_id: '', quantity: 1})" class="text-[#A33B36] font-medium text-sm mt-2">+ Ajouter une ligne</button>

        <div class="mt-6 border-t pt-4 flex justify-end">
            <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded">Enregistrer l'entrée de stock</button>
        </div>
    </form>

    <!-- Modal de création rapide de produit -->
    <div x-show="openProductModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;" x-transition>
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4" @click.outside="openProductModal = false" @keydown.escape.window="openProductModal = false">
            <h2 class="text-lg font-bold mb-4">Créer un nouveau produit</h2>
            <form @submit.prevent="createProduct">
                <div class="space-y-3">
                    <label for="new-product-name" class="sr-only">Nom du produit</label>
                    <input id="new-product-name" type="text" x-model="newProduct.name" placeholder="Nom du produit *" required class="w-full border rounded p-2 text-sm">

                    <label for="new-product-reference" class="sr-only">Référence du produit</label>
                    <input id="new-product-reference" type="text" x-model="newProduct.reference" placeholder="Référence (ex. TR30_...)" class="w-full border rounded p-2 text-sm">

                    <label for="new-product-category" class="sr-only">Catégorie</label>
                    <select id="new-product-category" x-model="newProduct.category_id" required class="w-full border rounded p-2 text-sm">
                        <option value="">Catégorie...</option>
                        @foreach(\App\Models\Category::forAdmin()->orderBy('position')->orderBy('name')->get() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <label for="new-product-price" class="sr-only">Prix de vente en FCFA</label>
                    <input id="new-product-price" type="number" min="0" step="1" x-model.number="newProduct.price" placeholder="Prix de vente (FCFA) *" required class="w-full border rounded p-2 text-sm">

                    <label for="new-product-stock" class="sr-only">Stock initial</label>
                    <input id="new-product-stock" type="number" min="0" step="1" x-model.number="newProduct.stock" placeholder="Stock initial" class="w-full border rounded p-2 text-sm">
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
            productList: @json($products->map(fn ($product) => ['id' => $product->id, 'name' => $product->name, 'stock' => $product->stock])->values()),
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

                    if (!response.ok || !data.success) {
                        alert(data.message || 'Erreur de validation. Vérifiez les champs.');
                        return;
                    }

                    this.productList.push({
                        id: data.product.id,
                        name: data.product.name,
                        stock: this.newProduct.stock
                    });

                    this.items[this.items.length - 1].product_id = data.product.id;
                    this.openProductModal = false;
                    this.newProduct = { name: '', reference: '', category_id: '', price: 0, stock: 0 };
                } catch (error) {
                    alert('Erreur réseau : ' + error.message);
                }
            }
        };
    }
</script>
@endsection
