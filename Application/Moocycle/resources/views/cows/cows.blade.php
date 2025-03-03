@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
    <script type="module" src="{{ asset ('/js/javascript.js') }}" defer></script>
@endsection

<body>
    <header>
        <div class="title">
            Mes vaches
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
                    data-edit-href="{{ route('cows.edit', ['num_tblVache' => $cow->num_tblVache]) }}" 
                    data-delete-href="{{ route('cows.delete', ['num_tblVache' => $cow->num_tblVache]) }}"
                    data-cow-name="{{ $cow->nom }}">
                    <a href="{{ route('cows.read', ['num_tblVache' => $cow->num_tblVache]) }}" style="text-decoration: none; color: inherit; display: block; height: 100%; width: 100%;">
                        <div id="enhancedText"><span><p>{{ $cow->nom }}</p></span></div>
                        <div><span>Collier : {{ $cow->numero_collier }}</span></div>
                        <div><span>Numéro : {{ $cow->numero_oreille }}</span></div>
                        <div><span>Race :
                        @foreach($cow->races as $race)
                            {{ $race->nom }}
                        @endforeach</span></div>
                    </a>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('addcows.form') }}" class="fab" aria-label="Ajouter une vache">
            +
        </a>
    
    @endsection
<footer>
</footer>
</body>