@extends('layouts.app')

@section('content')
    <header>
        <div class="title">
            Accueil
        </div>
    </header>
    <main>
        <div class="mainButtons">
            <a href="{{ Auth::check() ? route('cows.get') : route('login') }}">
                <button id="buttonCows" class="mainButtons">
                    <img src="/assets/cowicon.png" alt="Cows">
                </button>
            </a>

            <a href="{{ Auth::check() ? route('calendar') : route('login') }}">
                <button id="buttonCalendar" class="mainButtons">
                    <img src="/assets/calendaricon.png" alt="Calendar">
                </button>
            </a>

            <a href="{{ Auth::check() ? route('health') : route('login') }}">
                <button id="buttonHealth" class="mainButtons">
                    <img src="/assets/crossicon.png" alt="Health">
                </button>
            </a>

            <a href="{{ Auth::check() ? route('tips') : route('login') }}">
                <button id="buttonInfo" class="mainButtons">
                    <img src="/assets/bulbicon.png" alt="Tips">
                </button>
            </a>
        </div>
    </main>
@endsection
