@extends('layouts.superadmin')

@section('title', 'Nouvelle catégorie — Super Admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('superadmin.categories.index') }}" class="text-sm text-optique-gray hover:text-optique-red">← Retour aux catégories</a>
        <h1 class="text-3xl font-serif text-optique-text mt-2">Nouvelle catégorie</h1>
    </div>

    @include('superadmin.categories._form', ['action' => route('superadmin.categories.store')])
</div>
@endsection
