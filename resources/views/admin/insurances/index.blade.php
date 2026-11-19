@extends('layouts.admin')
@section('content')
<div class="py-6 px-4 bg-[#F9F8F6] min-h-screen max-w-3xl mx-auto">
    <h1 class="text-2xl font-serif font-bold text-gray-800 mb-6">Assurances</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($insurances as $insurance)
            <a href="{{ route('admin.insurances.orders', $insurance) }}" class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition block group">
                <p class="font-bold text-lg text-gray-800 group-hover:text-[#A33B36]">{{ $insurance->name }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $insurance->orders_count }} commande(s) liée(s)</p>
            </a>
        @endforeach
    </div>
</div>
@endsection
