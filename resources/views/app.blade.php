<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $popis ?? 'Default Description' }}">
    <meta name="keywords" content="{{ $klicova_slova ?? 'Default Keywords' }}">
    <title>{{ $titulek ?? 'Pojišťovna Solida' }}</title>

<!-- Použití Vite pro načítání CSS a JS -->
@vite(['resources/scss/app.scss', 'resources/js/app.js'])

</head>

<body>
<header>
    <!-- NAVIGACE -->
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.webp') }}" alt="Pojišťovna Solida">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Domů</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('insuredPersons.create') }}">Zaeviduj pojištěnce</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('insuredPersons.index') }}">Přehled pojištěnců</a>
                    </li>
                    <!-- Nová záložka pro přehled pojištění -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('insurances.index') }}">Přehled pojištění</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
    @yield('content') <!-- Obsah konkrétní stránky -->
</main>

<footer class="footer">
    <div class="container-fluid text-center">
        <p class="m-0 py-3">© 2025 Pojišťovna Solida</p>
    </div>
</footer>

<!-- Přidání Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
