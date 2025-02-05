@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cows.css') }}">
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
            <button id="filters-btn" class ="btns">Filtres</button>
            <div id="filters" style="display: none;">
                <form method="GET" action="{{ route('cows.filter') }}">
                    <label for="race">Filtrer par race :</label>
                    <select name="race" id="race">
                        <option value="">Toutes les races</option>
                        @foreach($races as $race)
                            <option value="{{ $race->id }}" {{ request('race') == $race->id ? 'selected' : '' }}>
                                {{ $race->nom }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit">Filtrer</button>
                </form>
            </div>
        </div>

        <ul>
            @if($cows->isEmpty())
                <p>Aucune vache trouvée.</p>
            @endif
            @foreach($cows as $cow)
                <li id="cow-li"
                    data-edit-href="{{ route('editcows', ['num_tblVache' => $cow->num_tblVache]) }}" 
                    data-delete-href="{{ route('deletecows', ['num_tblVache' => $cow->num_tblVache]) }}"
                    data-cow-name="{{ $cow->nom }}">
                    <a href="{{ route('readcows', ['num_tblVache' => $cow->num_tblVache]) }}" style="text-decoration: none; color: inherit; display: block; height: 100%; width: 100%;">
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