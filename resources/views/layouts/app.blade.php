<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owkman Energy - Dealers on all kinds of CCTV Cameras, Smart Glasses & Watches and Solar Batteries</title>

    <!-- custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <h1 class="logo">Owkman Energy</h1>

        <form class="search-form">
            <input type="text" placeholder="Search products...">
        </form>

        <div class="nav-links">
            <a href="#">Cart 🛒</a>

            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Sign Up</a>
            @endauth
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© {{ date('Y') }} Owkman Energy. All rights reserved.</p>
    </footer>

</body>
</html>