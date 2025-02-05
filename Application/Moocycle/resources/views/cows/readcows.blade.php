@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/readcows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backbutton.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
    <script type="module" src="{{ asset ('/js/javascript.js') }}" defer></script>
</head>
<body>
    <div class="button-container">
        <a class="back-button" href="{{ route('cows.get') }}">⬅</a>
    </div>
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
        <div><span>Date prochaine chaleur<p>{{ $cow->date_prochaine_chaleur }}</p></span></div>
        <div class="average-cycle">
            <div><span>Moyenne (jours) entre les chaleurs<p>{{ $average }} jours</p></span></div>
        </div>
    </div>
    
    <div class ="action-buttons">
        <a class="action-button" href="{{ route('editcows', ['num_tblVache' => $cow->num_tblVache]) }}">Modifier</a>
        <a class="action-button delete-btn" 
            href="#" 
            data-delete-href="{{ route('deletecows', ['num_tblVache' => $cow->num_tblVache]) }}"
            data-cow-name="{{ $cow->nom }}">
            Supprimer
        </a>
    </div>
    <div id="custom-dialog" class="dialog-overlay" style="display: none;">
        <div class="dialog-box">
            <h3 id="dialog-title">Confirmation</h3>
            <p id="dialog-message">Voulez-vous vraiment supprimer cette vache ?</p>
            <div class="dialog-buttons">
                <button id="dialog-confirm">Oui</button>
                <button id="dialog-cancel">Non</button>
            </div>
        </div>
    </div>

@endsection
<footer>
</footer>
</body>
</html>
