<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $popis ?? 'Default Description' }}">
    <meta name="keywords" content="{{ $klicova_slova ?? 'Default Keywords' }}">
    <title>{{ $titulek ?? 'Pojišťovna Solida' }}</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
<header>
    <!-- NAVIGACE -->
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.webp') }}" alt="Pojišťovna Solida" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Domů</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('insuredPersons.create') }}">Zaeviduj pojištěnce</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('insuredPersons.index') }}">Přehled pojištěnců</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('insurances.index') }}">Přehled pojištění</a>
                    </li>
                    @role('admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Správa uživatelů</a>
                    </li>
                    @endrole
                    @role('admin|agent')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.index') }}">Reporty</a>
                    </li>
                    @endrole
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Můj účet</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn nav-link" type="submit">Odhlásit se</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Přihlášení</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrace</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="main-content">
    @yield('content')
</main>

<footer class="footer">
    <div class="container-fluid text-center">
        <p class="m-0 py-3">© 2025 Pojišťovna Solida</p>
    </div>
</footer>

</body>
</html>
