@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/cows.css') }}">
</head>
<body>
    <header>
        <div class = "title">
            Mes vaches
        </div>
    </header>
    @section('content')
    <main>
        <div class="content">
            <ul>
                @foreach($cows as $cow)
                    <li id="cow-li">
                        <div id="enhancedText"><span><p>{{ $cow->nom }}</p></span></div>
                        <div ><span>Collier : {{ $cow->numero_collier }}</span></div>
                        <div ><span>Numéro : {{ $cow->numero_oreille }}</span></div>
                        <div><span>Naissance :</span> <p>{{ $cow->date_naissance }}</p></div>
                    </li>
                @endforeach
            </ul>
        </div>
    </main>
    @endsection
    <footer>
    </footer>
</body>
</html>




