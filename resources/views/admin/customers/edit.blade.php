@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-2xl mx-auto">
    <h1 class="text-2xl font-serif mb-4">Modifier Client</h1>
    <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}" required class="w-full rounded-md border-gray-300 text-sm">
            <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}" required class="w-full rounded-md border-gray-300 text-sm">
        </div>
        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required class="w-full rounded-md border-gray-300 text-sm">
        <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full rounded-md border-gray-300 text-sm">
        <input type="text" name="profession" value="{{ old('profession', $customer->profession) }}" class="w-full rounded-md border-gray-300 text-sm">
        <input type="text" name="address" value="{{ old('address', $customer->address) }}" class="w-full rounded-md border-gray-300 text-sm">
        <input type="date" name="birth_date" value="{{ old('birth_date', $customer->birth_date) }}" class="w-full rounded-md border-gray-300 text-sm">
        <div class="flex gap-2">
            <button type="submit" class="bg-[#A33B36] text-white px-6 py-2 rounded-md">Mettre à jour</button>
            <a href="{{ route('admin.customers.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-md">Annuler</a>
        </div>
    </form>
</div>
@endsection
