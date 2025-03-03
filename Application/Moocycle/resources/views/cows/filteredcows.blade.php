@extends('layouts.app')
@section('head')
@endsection
<body>
    <header>
        <div class="title">
            Mes vaches
        </div>
    </header>
@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul>
        @if($cows->isEmpty())
            <p>Aucune vache trouvée.</p>
        @endif
        @foreach($cows as $cow)
            <li id="cow-li" 
                data-edit-href="{{ route('cows.edit', ['num_tblVache' => $cow->num_tblVache]) }}" 
                data-delete-href="{{ route('cows.delete', ['num_tblVache' => $cow->num_tblVache]) }}"
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

    <a href="{{ route('addcows.form') }}" class="fab" aria-label="Ajouter une vache">
        +
    </a>

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
