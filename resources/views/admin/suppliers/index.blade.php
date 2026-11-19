@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Fournisseurs</h1>
        <a href="{{ route('admin.suppliers.create') }}" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm">+ Ajouter</a>
    </div>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 hidden md:table">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs uppercase text-gray-500">Nom</th>
                    <th class="px-6 py-3 text-left text-xs uppercase text-gray-500">Contact</th>
                    <th class="px-6 py-3 text-left text-xs uppercase text-gray-500">Achats</th>
                    <th class="px-6 py-3 text-right text-xs uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                <tr class="border-b">
                    <td class="px-6 py-4">{{ $supplier->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $supplier->contact_name }}<br>{{ $supplier->phone }}</td>
                    <td class="px-6 py-4 text-sm">{{ $supplier->purchases_count }} achats</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="text-blue-600 mr-2">Modifier</a>
                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Version Mobile -->
        <div class="md:hidden p-4 space-y-4">
            @foreach($suppliers as $supplier)
                <div class="border-b pb-2">
                    <p class="font-bold">{{ $supplier->name }}</p>
                    <p class="text-sm text-gray-500">{{ $supplier->contact_name }} - {{ $supplier->phone }}</p>
                    <div class="mt-2 flex gap-3">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="text-blue-600 text-sm">Modifier</a>
                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm">Supprimer</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{ $suppliers->links() }}
</div>
@endsection
