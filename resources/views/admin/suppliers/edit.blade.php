@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-2xl mx-auto">
    <h1 class="text-2xl font-serif mb-4">Modifier le Fournisseur</h1>
    <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf @method('PUT')
        <input type="text" name="name" value="{{ $supplier->name }}" placeholder="Nom" class="w-full border rounded p-2" required>
        <input type="text" name="contact_name" value="{{ $supplier->contact_name }}" placeholder="Contact" class="w-full border rounded p-2">
        <input type="text" name="phone" value="{{ $supplier->phone }}" placeholder="Téléphone" class="w-full border rounded p-2">
        <input type="email" name="email" value="{{ $supplier->email }}" placeholder="Email" class="w-full border rounded p-2">
        <textarea name="address" placeholder="Adresse" class="w-full border rounded p-2">{{ $supplier->address }}</textarea>
        <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded">Mettre à jour</button>
    </form>
</div>
@endsection
