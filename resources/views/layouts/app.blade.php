<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <div class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="thingsDropdown" role="button" data-bs-toggle="dropdown">
                            Мои вещи
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="thingsDropdown">
                            <li><a class="dropdown-item" href="{{ route('things.my') }}">My things</a></li>
                            <li><a class="dropdown-item" href="{{ route('things.repair') }}">Repair things</a></li>
                            <li><a class="dropdown-item" href="{{ route('things.work') }}">Work</a></li>
                            <li><a class="dropdown-item" href="{{ route('things.used') }}">Used things</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('things.index') }}">Все вещи</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('places.index') }}">Места</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-white p-0">Выход</button>
                        </form>
                    </li>
                    @can('admin-access')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.things') }}">Админка: вещи</a>
                        </li>
                    @endcan
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>