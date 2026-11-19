@extends('layouts.superadmin')

@section('title', 'Modifier la photo — Super Admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <a href="{{ route('superadmin.gallery.index') }}" class="text-sm text-optique-gray hover:text-optique-red">← Retour à la galerie</a>
        <h1 class="text-3xl font-serif text-optique-text mt-2">Modifier : {{ $galleryItem->name }}</h1>
    </div>

    @include('superadmin.gallery._form', [
        'action' => route('superadmin.gallery.update', $galleryItem),
        'method' => 'PUT',
    ])
</div>
@endsection
