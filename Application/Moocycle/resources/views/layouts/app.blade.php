<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="{{ asset ('/js/javascript.js') }}" defer></script>
    <script type="module" src="{{ asset ('/js/clock.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/burger.css') }}">

    <link rel="stylesheet" href="{{ asset('css/FiltersAndSearch.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Moocycle</title>
    @yield('head')
</head>
<body>
    <header>
    <a href="{{ route('login') }}">Login</a>
        <div id = "clock"></div>
        <nav>
            <div class="ham-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="off-screen-menu">
                <ul>
                    <li><a href="http://moocycle.test">Accueil</a></li>
                    <li><a href="#">Compte</a></li>
                    <li><a href="#">Langues</a></li>
                    <li><a href="#">Paramètres</a></li>
                    <li><a href="#">Aide</a></li>
                </ul>
            </div>
        </nav>
        @yield('header')
    </header>

        
    <main>
        <div class = "content">
            @yield('content')
        </div>
    </main>
    <footer id="footer">
            <div id="copyright">
                <p id="owners">Copyright 2022-<span id="currentyear"></span> Moocycle. All rights reserved.</p>
            </div>
            <div id="socials">
            </div>
            @yield('footer')
    </footer>
    <div class="menu-overlay"></div>
</body>
</html>