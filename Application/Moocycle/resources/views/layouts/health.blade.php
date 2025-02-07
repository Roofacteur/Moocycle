@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{ asset('css/healthcows.css') }}">
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
                    data-edit-href="{{ route('editcows', ['num_tblVache' => $cow->num_tblVache]) }}" 
                    data-delete-href="{{ route('deletecows', ['num_tblVache' => $cow->num_tblVache]) }}"
                    data-cow-name="{{ $cow->nom }}">
                    <div id="enhancedText"><span><p>{{ $cow->nom }}</p></span></div>
                    <div><span>Collier : {{ $cow->numero_collier }}</span></div>
                    <div><span>Numéro : {{ $cow->numero_oreille }}</span></div>
                    <div class="cow-buttons">
                        <button id="lactation-btn">Lactation</button>
                        <button id="chaleur-btn">Chaleur</button>
                    </div>
                </li>
            @endforeach
        </ul>

 @endsection



