@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/editcows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
    <script type="module" src="{{ asset ('/js/javascript.js') }}" defer></script>
</head>
<body>
@section('header')
<div class="header-title">
    Modifier <span>{{ $cow->nom }}</span>
</div>
@endsection
@section('content')
<form action="{{ route('cows.update', ['num_tblVache' => $cow->num_tblVache]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="{{ $cow->nom }}" required>
    </div>

    <div class="form-group">
        <label for="numero_collier">Numéro de collier</label>
        <input type="text" id="numero_collier" name="numero_collier" value="{{ $cow->numero_collier }}" required>
    </div>

    <div class="form-group">
        <label for="numero_oreille">Numéro d'oreille</label>
        <input type="text" id="numero_oreille" name="numero_oreille" value="{{ $cow->numero_oreille }}" required>
    </div>

    <div class="form-group">
        <label for="date_naissance">Date de naissance</label>
        <input type="date" id="date_naissance" name="date_naissance" value="{{ $cow->date_naissance }}" required>
    </div>
    <div class="form-group">
        <label for="num_tblRace">Race</label>
        <select name="num_tblRace" id="num_tblRace" required>
            <option value="" disabled {{ !$currentRace ? 'selected' : '' }}>Sélectionner une race</option>
            @foreach($races as $race)
                <option value="{{ $race->num_tblRace }}" 
                    {{ $currentRace && $currentRace->num_tblRace == $race->num_tblRace ? 'selected' : '' }}>
                    {{ $race->nom }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit">Enregistrer</button>
    <a href="{{ route('cows.read', ['num_tblVache' => $cow->num_tblVache]) }}">
        <button type="button" class="cancel">Annuler</button>
    </a>
</form>
<!-- Boîte de dialogue personnalisée -->
<div id="custom-dialog" class="dialog-overlay" style="display: none;">
    <div class="dialog-box">
        <h3 id="dialog-title">Confirmation</h3>
        <p id="dialog-message">Vos changements ne seront pas enregistrés. Voulez-vous vraiment quitter ?</p>
        <div class="dialog-buttons">
        <a href="http://moocycle.test/cows">
            <button id="dialog-confirm">Oui</button>
        </a>
            <button id="dialog-cancel">Non</button>
        </div>
    </div>
</div>

@endsection
<footer>
</footer>
</body>
</html>
