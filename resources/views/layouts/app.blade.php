<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>
        @yield('title', 'Cashier System')
    </title>

</head>

<body>


    <!-- HEADER -->

    <header>

        <div class="header-container">

            <a
                href="{{ route('dashboard') }}"
                class="brand"
            >
                🍽️ Cashier System
            </a>

        </div>

    </header>


    <!-- NAVIGATION -->

    <nav>

        <div class="nav-container">

            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>

            <a href="{{ route('transactions.index') }}">
                Kasir
            </a>

            <a href="{{ route('menus.index') }}">
                Menu
            </a>

            <a href="{{ route('categories.index') }}">
                Kategori
            </a>

            <a href="{{ route('transactions.history') }}">
                Riwayat
            </a>

        </div>

    </nav>


    <!-- CONTENT -->

    <main>

        @yield('content')

    </main>


    <!-- FOOTER -->

    <footer>

        Cashier System &copy; {{ date('Y') }}

    </footer>


</body>

</html>