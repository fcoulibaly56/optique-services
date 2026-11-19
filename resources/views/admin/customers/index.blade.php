 @extends('layouts.admin')
@section('title', 'Fichier Clients')
@section('content')
<div class="min-h-screen w-full bg-[#F9F8F6] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="mx-auto w-full max-w-[1440px] space-y-6">

        <!-- Titre et action principale -->
        <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#A33B36]">Espace équipe</p>
                <h1 class="mt-1 whitespace-nowrap font-serif text-2xl font-bold leading-tight text-gray-900 sm:text-3xl">Fichier Clients</h1>
                <p class="mt-1 text-sm text-gray-500">Retrouvez et gérez les dossiers des clients du magasin.</p>
            </div>

            <a href="{{ route('admin.customers.create') }}" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#A33B36] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#8F302C] focus:outline-none focus:ring-2 focus:ring-[#A33B36] focus:ring-offset-2">
                <span aria-hidden="true" class="text-lg leading-none">+</span>
                <span>Nouveau client</span>
            </a>
        </header>

        <!-- Recherche et filtres : bloc séparé du titre -->
        <form method="GET" action="{{ route('admin.customers.index') }}" class="w-full rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-[minmax(260px,1.6fr)_minmax(170px,1fr)_minmax(170px,1fr)_auto] xl:items-end">
                <div class="sm:col-span-2 xl:col-span-1">
                    <label for="customer-search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Recherche</label>
                    <input id="customer-search" type="search" name="search" value="{{ request('search') }}" placeholder="Nom ou téléphone" class="w-full rounded-xl border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-[#A33B36] focus:ring-[#A33B36]">
                </div>

                <div>
                    <label for="customer-date-from" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Inscrit à partir du</label>
                    <input id="customer-date-from" type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-xl border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 focus:border-[#A33B36] focus:ring-[#A33B36]">
                </div>

                <div>
                    <label for="customer-date-to" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Jusqu’au</label>
                    <input id="customer-date-to" type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-xl border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 focus:border-[#A33B36] focus:ring-[#A33B36]">
                </div>

                <div class="flex flex-wrap items-center gap-2 sm:col-span-2 xl:col-span-1 xl:justify-end">
                    <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2">Filtrer</button>
                    @if(request()->anyFilled(['search', 'date_from', 'date_to']))
                        <a href="{{ route('admin.customers.index') }}" class="inline-flex min-h-10 items-center justify-center rounded-xl border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 hover:text-gray-900">Réinitialiser</a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Résultats sur mobile -->
        <div class="space-y-3 md:hidden">
            @forelse($customers as $customer)
                <article class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="break-words font-semibold text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ $customer->phone }}</p>
                            <p class="mt-1 text-xs text-gray-400">Inscrit le {{ $customer->created_at->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('admin.customers.show', $customer) }}" class="shrink-0 rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-[#A33B36] transition hover:bg-red-100">Dossier</a>
                    </div>
                    <div class="mt-4 flex flex-wrap items-center justify-end gap-x-4 gap-y-2 border-t border-gray-100 pt-3">
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="text-sm font-medium text-blue-700 hover:underline">Modifier</a>
                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Archiver ce client ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-red-700 hover:underline">Archiver</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-5 py-10 text-center">
                    <p class="font-medium text-gray-700">Aucun client trouvé</p>
                    <p class="mt-1 text-sm text-gray-500">Essayez de modifier votre recherche ou vos filtres.</p>
                </div>
            @endforelse
        </div>

        <!-- Résultats sur tablette et ordinateur -->
        <section class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm md:block" aria-label="Liste des clients">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] divide-y divide-gray-200">
                    <caption class="sr-only">Liste des clients du magasin</caption>
                    <thead class="bg-gray-50/90">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nom complet</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Contact</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Inscrit le</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($customers as $customer)
                            <tr class="transition hover:bg-[#FCFAF9]">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">{{ $customer->last_name }} {{ $customer->first_name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $customer->phone }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $customer->created_at->format('d/m/Y') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="rounded-lg bg-red-50 px-3 py-2 font-medium text-[#A33B36] transition hover:bg-red-100">Dossier</a>
                                        <a href="{{ route('admin.customers.edit', $customer) }}" class="font-medium text-blue-700 hover:underline">Modifier</a>
                                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Archiver ce client ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-700 hover:underline">Archiver</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="font-medium text-gray-700">Aucun client trouvé</p>
                                    <p class="mt-1 text-sm text-gray-500">Essayez de modifier votre recherche ou vos filtres.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($customers, 'links'))
                <div class="border-t border-gray-100 px-5 py-4 sm:px-6">{{ $customers->links() }}</div>
            @endif
        </section>
    </div>
</div>
@endsection
