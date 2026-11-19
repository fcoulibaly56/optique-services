@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-2xl mx-auto">
    <h1 class="text-2xl font-serif mb-4">{{ isset($supplier) ? 'Modifier' : 'Nouveau' }} Fournisseur</h1>
    <form action="{{ isset($supplier) ? route('admin.suppliers.update', $supplier) : route('admin.suppliers.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @if(isset($supplier)) @method('PUT') @endif
        <input type="text" name="name" placeholder="Nom" value="{{ old('name', $supplier->name ?? '') }}" class="w-full border rounded p-2" required>
        <input type="text" name="contact_name" placeholder="Nom du contact" value="{{ old('contact_name', $supplier->contact_name ?? '') }}" class="w-full border rounded p-2">
        <input type="text" name="phone" placeholder="Téléphone" value="{{ old('phone', $supplier->phone ?? '') }}" class="w-full border rounded p-2">
        <input type="email" name="email" placeholder="Email" value="{{ old('email', $supplier->email ?? '') }}" class="w-full border rounded p-2">
        <textarea name="address" placeholder="Adresse" class="w-full border rounded p-2">{{ old('address', $supplier->address ?? '') }}</textarea>
        <button type="submit" class="bg-[#A33B36] text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
@endsection
