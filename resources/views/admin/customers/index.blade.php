@extends('layouts.admin')
@section('title', 'Fichier Clients')
@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 bg-[#F9F8F6] min-h-screen">

    <!-- En-tête, Recherche et Actions -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-6 gap-4">
        <h1 class="text-2xl font-serif font-bold text-gray-800">Fichier Clients</h1>

        <div class="flex flex-col lg:flex-row gap-3 w-full xl:w-auto">
            <!-- Recherche & Filtres -->
            <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-wrap gap-2 items-center bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, téléphone..." class="rounded-md border-gray-300 text-sm w-full sm:w-48 focus:ring-[#A33B36] focus:border-[#A33B36]">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-md border-gray-300 text-sm focus:ring-[#A33B36] focus:border-[#A33B36]">
                <span class="text-gray-400">au</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-md border-gray-300 text-sm focus:ring-[#A33B36] focus:border-[#A33B36]">
                <button type="submit" class="bg-gray-800 text-white px-3 py-2 rounded-md text-sm hover:bg-gray-700">Filtrer</button>
                @if(request()->anyFilled(['search', 'date_from', 'date_to']))
                    <a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-500 hover:text-red-500">Réinitialiser</a>
                @endif
            </form>

            <!-- Import / Export -->
            <div class="flex gap-2 items-center">
                <a href="{{ route('admin.customers.export') }}" class="bg-green-600 text-white px-3 py-2 rounded-md text-sm hover:bg-green-700 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Exporter
                </a>
                <form action="{{ route('admin.customers.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center bg-white border border-gray-300 rounded-md p-1">
                    @csrf
                    <input type="file" name="file" class="text-xs w-32" required>
                    <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700">Importer</button>
                </form>
                <a href="{{ route('admin.customers.create') }}" class="bg-[#A33B36] text-white px-4 py-2 rounded-md text-sm hover:bg-opacity-90 whitespace-nowrap">+ Nouveau</a>
            </div>
        </div>
    </div>

    <!-- Vue Mobile (Cartes) -->
    <div class="md:hidden space-y-4">
        @forelse($customers as $customer)
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[#A33B36]">
                <p class="font-medium text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                <p class="text-sm text-gray-500">{{ $customer->phone }}</p>
                <div class="mt-3 pt-3 border-t flex justify-between items-center">
                    <a href="{{ route('admin.customers.show', $customer) }}" class="text-[#A33B36] text-sm font-medium">Dossier &rarr;</a>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="text-blue-600 text-sm">Modifier</a>
                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Archiver ce client ?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm">Archiver</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">Aucun client trouvé.</p>
        @endforelse
    </div>

    <!-- Vue Desktop (Tableau) -->
    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom complet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Inscrit le</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->last_name }} {{ $customer->first_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-[#A33B36] bg-red-50 px-3 py-1 rounded-md mr-2">Dossier</a>
                            <a href="{{ route('admin.customers.edit', $customer) }}" class="text-blue-600 hover:underline mr-2">Modifier</a>
                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Archiver ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Archiver</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucun client trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t">{{ $customers->links() }}</div>
    </div>
</div>
@endsection
