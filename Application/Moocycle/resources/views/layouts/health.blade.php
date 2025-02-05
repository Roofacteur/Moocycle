@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <header>
        <div class = "title">
            Événements sanitaires
        </div>
    </header>
    <main>
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
                    <div><span>Race :</span> 
                        <p>
                            @foreach($cow->races as $race)
                                {{ $race->nom }}
                            @endforeach
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </main>
    <footer>
    </footer>
</body>
</html>




