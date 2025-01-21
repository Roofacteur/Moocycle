@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/addcows.css') }}">
    <script type="module" src="{{ asset ('/js/javascript.js') }}" defer></script>
</head>
<body>
@section('header')
<div class="header-title">
        Créer une vache
</div>
@endsection
@section('content')
<div class="container">
    <form action="{{ route('addcows.store') }}" method="POST">
        @csrf
        <div>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required placeholder="Entrez le nom de la vache" value="{{ old('nom') }}">
            @error('nom')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="numero_collier">Numéro de collier :</label>
            <input type="text" name="numero_collier" id="numero_collier" required pattern="\d+" placeholder="Entrez le numéro de collier" value="{{ old('numero_collier') }}">
            @error('numero_collier')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="numero_oreille">Numéro d'oreille :</label>
            <input type="text" name="numero_oreille" id="numero_oreille" required pattern="\d+" required placeholder="Entrez le numéro d'oreille" value="{{ old('numero_oreille') }}">
            @error('numero_oreille')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="date_naissance">Date de naissance :</label>
            <input type="date" name="date_naissance" id="date_naissance" required placeholder="Sélectionnez la date de naissance" value="{{ old('date_naissance') }}">
            @error('date_naissance')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="num_tblRace">Race :</label>
            <select name="num_tblRace" id="num_tblRace" required>
                <option value="" disabled selected>Sélectionner une race</option>
                @foreach ($races as $race)
                    <option value="{{ $race->num_tblRace }}" {{ old('num_tblRace') == $race->num_tblRace ? 'selected' : '' }}>{{ $race->nom }}</option>
                @endforeach
            </select>
            @error('num_tblRace')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">Ajouter</button>
        <a href="{{ route('cows.get') }}">
        <button type="button" class="cancel">Annuler</button>
        </a>
    </form>
</div>
@endsection
</body>
</html>
