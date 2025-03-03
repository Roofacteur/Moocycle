@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{ asset('css/healthcows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
</head>
@section('head')
@endsection
<body>
    <header>
        <div class = "title">
            Événements sanitaires
        </div>
    </header>
@section('content')
        <div>
            <button id="search-btn" class ="btns">Rechercher</button>
        </div>
        <ul>
            @if($cows->isEmpty())
                <p>Aucune vache trouvée.</p>
            @endif
            @foreach($cows as $cow)
                <li id="cow-li"
                    data-cow-id="{{ $cow->num_tblVache}}"
                    data-cow-name="{{ $cow->nom }}"
                    data-cow-lactation="{{ $cow->nombre_lactation }}">
                    <div id="enhancedText"><span><p>{{ $cow->nom }}</p></span></div>
                    <div><span>Lactations : {{ $cow->nombre_lactation}}</span></div>
                    <div><span>Chaleur prévue : {{ $cow->date_prochaine_chaleur}}</span></div>
                    <div class="cow-buttons">
                        <button id ="lactation-btn" class="lactation-btn" data-cow-id="{{ $cow->num_tblVache }}" data-cow-lactation="{{ $cow->nombre_lactation }}">Lactation</button>
                        <button id ="chaleur-btn" class="chaleur-btn">Chaleur</button>
                    </div>
                </li>
            @endforeach
        </ul>
        <div id="custom-dialog" class="dialog-overlay" style="display: none;">
        <div class="dialog-box">
            <h3 id="dialog-title">Confirmation</h3>
            <p id="dialog-message"></p>
            <div class="dialog-buttons">
                <button id="dialog-confirm">Oui</button>
                <button id="dialog-cancel">Non</button>
            </div>
        </div>
    </div>
 @endsection



