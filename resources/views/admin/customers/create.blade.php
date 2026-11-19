@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-2xl mx-auto">
    <h1 class="text-2xl font-serif mb-4">Nouveau Client</h1>
    <form action="{{ route('admin.customers.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="first_name" placeholder="Prénom *" value="{{ old('first_name') }}" required class="w-full rounded-md border-gray-300 text-sm">
            <input type="text" name="last_name" placeholder="Nom *" value="{{ old('last_name') }}" required class="w-full rounded-md border-gray-300 text-sm">
        </div>
        <input type="text" name="phone" placeholder="Téléphone *" value="{{ old('phone') }}" required class="w-full rounded-md border-gray-300 text-sm">
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" class="w-full rounded-md border-gray-300 text-sm">
        <input type="text" name="profession" placeholder="Profession" value="{{ old('profession') }}" class="w-full rounded-md border-gray-300 text-sm">
        <input type="text" name="address" placeholder="Adresse" value="{{ old('address') }}" class="w-full rounded-md border-gray-300 text-sm">
        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="w-full rounded-md border-gray-300 text-sm">
        <div class="flex gap-2">
            <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded-md">Enregistrer</button>
            <a href="{{ route('admin.customers.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md">Annuler</a>
        </div>
    </form>
</div>
@endsection
