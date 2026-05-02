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

    <nav class="navbar">
        <h1 class="logo">
            <a href="{{ url('/') }}" style="text-decoration:none">Owkman Energy</a>
        </h1>

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

</body>


</html>