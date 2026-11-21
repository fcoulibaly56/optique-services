@extends('layouts.superadmin')

@section('title', 'Modifier le compte — Super Admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('superadmin.users.index') }}" class="text-sm text-optique-gray hover:text-optique-red">← Retour à l'équipe</a>
        <h1 class="text-3xl font-serif text-optique-text mt-2">Modifier : {{ $member->name }}</h1>
    </div>

    @include('superadmin.users._form', [
        'action' => route('superadmin.users.update', $member),
        'method' => 'PUT',
    ])
</div>
@endsection
