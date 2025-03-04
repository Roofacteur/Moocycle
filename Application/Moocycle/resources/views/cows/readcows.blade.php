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
    <div><span>Naissance<p class = "cow-data">{{ $birth }}</p></span></div>
    <div><span>Collier<p class = "cow-data">{{ $cow->numero_collier }}</p></span></div>
    <div><span>Numéro d'oreille<p class = "cow-data">{{ $cow->numero_oreille }}</p></span></div>
    <div><span>Nombre de lactation<p class = "cow-data">{{ $cow->nombre_lactation }}</p></span></div>
    <div class="date-chaleurs">
        <div><span>Date dernière chaleur<p class="cow-data">{{ $lastHeatDate }}</p></span></div>
        <div><span>Date prochaine chaleur<p class="cow-data">{{ $nextHeatDate }}</p></span></div>
        
        <div class="average-cycle">
            <div><span>Moyenne (jours) entre les chaleurs<p class="cow-data">{{ $average }} jours</p></span></div>
        </div>
    </div>
    
    <div class ="action-buttons">
        <a class="action-button" href="{{ route('cows.edit', ['num_tblVache' => $cow->num_tblVache]) }}">Modifier</a>
        <a class="action-button delete-btn" 
            href="#" 
            data-delete-href="{{ route('cows.delete', ['num_tblVache' => $cow->num_tblVache]) }}"
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
