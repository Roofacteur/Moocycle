@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
</head>
@section('content')
    <header>
        <div class="title">Calendrier</div>
    </header>
    <main>
        <div id="calendar-controls">
            <button onclick="switchView('year')">Année</button>
            <button onclick="switchView('month')">Mois</button>
            <button onclick="switchView('week')">Semaine</button>
        </div>

        <div id="calendar"></div>
    </main>
@endsection


