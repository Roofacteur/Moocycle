@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <header>
        <div class = "title">
            Accueil
        </div>
    </header>
    <main>
        <div class = "mainButtons">
        <a href="{{ route('cows') }}">
                <button id="buttonCows" class="mainButtons">
                    <img src="/assets/cowicon.png" alt="Cows">
                </button>
            </a>

            <a href="{{ route('calendar') }}">
                <button id="buttonCalendar" class="mainButtons">
                    <img src="/assets/calendaricon.png" alt="Calendar">
                </button>
            </a>

            <a href="{{ route('health') }}">
                <button id="buttonHealth" class="mainButtons">
                    <img src="/assets/crossicon.png" alt="Health">
                </button>
            </a>

            <a href="{{ route('tips') }}">
                <button id="buttonInfo" class="mainButtons">
                    <img src="/assets/bulbicon.png" alt="Tips">
                </button>
            </a>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>