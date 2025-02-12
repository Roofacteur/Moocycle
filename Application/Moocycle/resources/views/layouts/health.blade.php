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
                    <div><span>Collier : {{ $cow->numero_collier }}</span></div>
                    <div><span>Numéro : {{ $cow->numero_oreille }}</span></div>
                    <div class="cow-buttons">
                        <button class="lactation-btn">Lactation</button>
                        <button class="chaleur-btn">Chaleur</button>
                    </div>
                </li>
            @endforeach
        </ul>
        <div id="custom-dialog" class="dialog-overlay" style="display: none;">
            <div class="dialog-box">
                <h3 id="dialog-title">Confirmation</h3>
                <p id="dialog-message">Ajouter une lactation à votre vache ?</p>
                <div class="dialog-buttons">
                    <button id="dialog-confirm">Oui</button>
                    <button id="dialog-cancel">Non</button>
                </div>
            </div>
        </div>
 @endsection



