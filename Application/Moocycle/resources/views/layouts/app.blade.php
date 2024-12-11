<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <title>Moocycle</title>
    @yield("head")
</head>
<body>
    <header>
        <div id="logo">
            <img src="/assets/logo.png" alt="logo">
        </div>
        <div class = "title">
            Moocycle
        </div>
    </header>
    <main>
        <div class="content">
            @yield('content')
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