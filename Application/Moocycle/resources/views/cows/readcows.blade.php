@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/readcows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
    <script type="module" src="{{ asset ('/js/javascript.js') }}" defer></script>
</head>
<body>
@section('header')
<div class="header-title">
        Infos de : <span>{{ $cow->nom }}</span>
</div>
@endsection
@section('content')
    <div><span>Nom<p>{{ $cow->nom }}</p></span></div>
    <div><span>Race
        <p>
            @foreach($cow->races as $race)
                {{ $race->nom }}
            @endforeach
        </p>
        </span>
    </div>
    <div><span>Naissance<p>{{ $cow->date_naissance }}</p></span></div>
    <div><span>Collier<p>{{ $cow->numero_collier }}</p></span></div>
    <div><span>Numéro d'oreille<p>{{ $cow->numero_oreille }}</p></span></div>
    <div><span>Nombre de lactation<p>{{ $cow->nombre_lactation }}</p></span></div>
    <div class="date-chaleurs">
        <div><span>Date dernière chaleur<p>{{ $cow->date_derniere_chaleur }}</p></span></div>
        <div><span>Date prochaine chaleur<p>{{ $cow->date_prochaine_chaleur }}</p></span></div>
    </div>
    <a href="{{ route('editcows.form') }}"></a>
@endsection
<footer>
</footer>
</body>
</html>
