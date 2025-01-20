@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/cows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
    <script type="module" src="{{ asset ('/js/javascript.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <div class="title">
            Mes vaches
        </div>
    </header>
    @section('content')
        <ul>
        @foreach($cows as $cow)
        <li id="cow-li" 
            data-edit-href="{{ route('editcows', ['num_tblVache' => $cow->num_tblVache]) }}" 
            data-delete-href="{{ route('deletecows', ['num_tblVache' => $cow->num_tblVache]) }}"
            data-cow-name="{{ $cow->nom }}">
            <div id="enhancedText"><span><p>{{ $cow->nom }}</p></span></div>
            <div><span>Collier : {{ $cow->numero_collier }}</span></div>
            <div><span>Numéro : {{ $cow->numero_oreille }}</span></div>
            <div><span>Naissance :</span> <p>{{ $cow->date_naissance }}</p></div>
        </li>
        @endforeach
        </ul>
    <button class="fab" aria-label="Ajouter une vache">
        +
    </button>
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
