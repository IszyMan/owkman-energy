<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

   <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        background: #e5e7eb;
    }

    /* Sidebar */
    .sidebar {
        width: 240px;
        height: 100vh;
        background: #111827;
        color: white;
        padding: 25px;
        position: fixed;
        left: 0;
        top: 0;
        box-shadow: 2px 0 10px rgba(0,0,0,0.2);
    }

    .sidebar h2 {
        color: #fff;
        margin-bottom: 30px;
    }

    .sidebar a {
        display: block;
        color: #d1d5db;
        padding: 12px;
        text-decoration: none;
        margin-bottom: 8px;
        border-radius: 6px;
        transition: 0.2s;
    }

    .sidebar a:hover {
        background: #374151;
        color: white;
    }

    /* Main content */
    .main {
        margin-left: 260px; /* 🔥 increased spacing from sidebar */
        padding: 30px;
        width: calc(100% - 260px);
        min-height: 100vh;
    }

    .card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .menu-group {
        margin-bottom: 20px;
    }

    .menu-title {
        color: #9ca3af;
        font-size: 13px;
        margin: 15px 0 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .menu-group a {
        padding-left: 20px;
        font-size: 14px;
    }

    .dropdown {
    margin-bottom: 10px;
    }

    .dropdown-btn {
        width: 100%;
        background: none;
        border: none;
        color: #d1d5db;
        text-align: left;
        padding: 12px;
        font-size: 15px;
        cursor: pointer;
        border-radius: 6px;
        transition: 0.2s;
    }

    .dropdown-btn:hover {
        background: #374151;
        color: white;
    }

    .dropdown-container {
        display: none;
        padding-left: 15px;
    }

    .dropdown-container a {
        display: block;
        padding: 8px;
        color: #9ca3af;
        text-decoration: none;
        font-size: 14px;
        border-radius: 5px;
    }

    .dropdown-container a:hover {
        background: #1f2937;
        color: white;
    }

</style>
</head>
<body>

    <div class="sidebar">
        <h2>⚡ Admin</h2>

        <a href="/admin">Dashboard</a>

        <!-- CATEGORIES -->
        <div class="dropdown">
            <button class="dropdown-btn">📂 Categories ▾</button>
            <div class="dropdown-container">
                <a href="/admin/categories">View Categories</a>
                <a href="/admin/categories/create">Add Category</a>
            </div>
        </div>

        <!-- PRODUCTS -->
        <div class="dropdown">
            <button class="dropdown-btn">📦 Products ▾</button>
            <div class="dropdown-container">
                <a href="/admin/products">View Products</a>
                <a href="/admin/products/create">Add Product</a>
            </div>
        </div>

        
    </div>

    <!-- Main Content -->
    <div class="main">
        @yield('content')
    </div>



<script>
   const dropdownBtns = document.querySelectorAll(".dropdown-btn");

    dropdownBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            const container = this.nextElementSibling;

            // toggle visibility
            if (container.style.display === "block") {
                container.style.display = "none";
            } else {
                container.style.display = "block";
            }
        });
    });
</script>

</body>
</html>