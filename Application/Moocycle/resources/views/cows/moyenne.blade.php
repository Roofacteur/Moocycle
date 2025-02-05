@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">average du Cycle de la Vache</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Vache : {{ $vache->nom }}</h5>
            <p class="card-text">
                La average du cycle de chaleur est de <strong>{{ $average }} jours</strong>.
            </p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('cows.get') }}" class="btn btn-primary">Retour à la liste</a>
    </div>
</div>
@endsection
