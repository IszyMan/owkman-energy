<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    

    <title>@yield('title', 'Owkman Energy - Dealers on all kinds of CCTV Cameras, Smart Glasses & Watches and Solar Batteries')</title>
    <meta name="description" content="@yield('meta_description', 'Buy CCTV, solar street lights, smart gadgets and solar batteries in Enugu, Nigeria')">
    <meta name="keywords" content="@yield('meta_keywords', 'CCTV, solar batteries, ai glasses, meta glasses, ai watches, smart watches Nigeria')">

    <!-- Open Graph (for WhatsApp, Facebook) -->
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:image" content="@yield('meta_image')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="product">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('meta_description')">
    <meta name="twitter:image" content="@yield('meta_image')">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Owkman-Favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/Owkman-Favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/Owkman-Favicon.png') }}">

    <!-- custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/Owkman-Logo.png') }}" alt="Owkman Energy Logo">
            </a>
        </div>

        <div class="search-wrapper">
            <form class="search-form" method="GET" action="{{ url('/search') }}">
                <input 
                    type="text" 
                    id="searchInput"
                    name="q"
                    placeholder="Search products..."
                    autocomplete="off"
                >

                <button type="submit" class="search-btn">🔍</button>
            </form>

            <!-- DROPDOWN -->
            <div id="searchResults" class="search-results"></div>
        </div>

        <div class="nav-links">
            <a href="#">Cart 🛒</a>

            @auth
              <div class="user-menu">
                <span class="user-name" id="userToggle">
                    Hi, {{ auth()->user()->name }} ▼
                </span>

                <div class="user-dropdown" id="userDropdown">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="#">Orders</a>
                    <a href="#">Profile</a>

                    <hr>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>
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

    <script>
const input = document.getElementById('searchInput');
const resultsBox = document.getElementById('searchResults');

input.addEventListener('keyup', function () {

    let query = this.value;

    if (query.length < 2) {
        resultsBox.style.display = "none";
        return;
    }

    fetch(`/search-suggestions?q=${query}`)
        .then(res => res.json())
        .then(data => {

            resultsBox.innerHTML = "";

            if (data.length === 0) {
                resultsBox.innerHTML = "<div class='search-item'>No results</div>";
                resultsBox.style.display = "block";
                return;
            }

            data.forEach(item => {
                let div = document.createElement('div');
                div.classList.add('search-item');

                div.innerHTML = `
                    <img src="${item.image}" class="search-thumb">
                    <span>${item.name}</span>
                `;

                div.onclick = () => {
                    window.location.href = `/product/${item.slug}`;
                };

                resultsBox.appendChild(div);
            });

            resultsBox.style.display = "block";
        });
});

// hide dropdown
document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-wrapper')) {
        resultsBox.style.display = "none";
    }
});
</script>


<script>
const toggle = document.getElementById('userToggle');
const dropdown = document.getElementById('userDropdown');

toggle.addEventListener('click', function (e) {
    e.stopPropagation();
    dropdown.classList.toggle('active');
});

// close when clicking outside
document.addEventListener('click', function () {
    dropdown.classList.remove('active');
});
</script>

</body>


</html>