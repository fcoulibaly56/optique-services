@extends('layouts.superadmin')

@section('title', 'Nouveau produit — Super Admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <a href="{{ route('superadmin.products.index') }}" class="text-sm text-optique-gray hover:text-optique-red">← Retour au catalogue</a>
        <h1 class="text-3xl font-serif text-optique-text mt-2">Nouveau produit</h1>
    </div>

    @include('superadmin.products._form', [
        'action' => route('superadmin.products.store'),
    ])
</div>
@endsection
