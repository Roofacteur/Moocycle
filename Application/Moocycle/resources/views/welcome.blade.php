<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="{{ asset ('/js/javascript.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <title>Moocycle</title>
</head>
<body>
    <header>
        <div id="logo">
            <img src="/assets/logo.png" alt="logo">
        </div>
        <div id = "clock"></div>
        <div class = "title">
            Accueil
        </div>
    </header>
    <main>
        <div class = "mainButtons">
            <button id = "buttonCows" class = "mainButtons"><img src="/assets/cowicon.png" alt=""></button>
            <button id = "buttonCalendar" class = "mainButtons"><img src="/assets/calendaricon.png" alt=""></button>
            <button id = "buttonHealth" class = "mainButtons"><img src="/assets/crossicon.png" alt=""></button>
            <button id = "buttonInfo" class = "mainButtons"><img src="/assets/bulbicon.png" alt=""></button>
        </div>
        <div id="options">
            <img src="/assets/wheel.png" alt="">
        </div>
    </main>
    <footer id="footer">
            <div id="copyright">
                <p id="owners">Copyright 2022-<span id="currentyear"></span> Moocycle. All rights reserved.</p>
            </div>
            <div id="socials">
            </div>
    </footer>
</body>
</html>