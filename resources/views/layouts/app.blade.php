<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* стили для кастомной директивы блейд ыделение своих вещей в таблице */
        .table tr.highlight-owner td {
            background-color: #e9dcf7 !important;
            transition: background-color 0.2s;
        }

        /* для активных вкладок */
        .navbar-dark .navbar-nav .nav-link.active,
        .navbar-dark .navbar-nav .dropdown.active > .nav-link {
            color: #e08ef3 !important; 
            font-weight: 600;
        }
        .dropdown-menu .dropdown-item.active {
            background-color: #f9e0fe !important;
            color: #e08ef3  !important;
        }

        .table tr.highlight-repair td {
            background-color: #e6f7e6 !important; 
        }
        .table tr.highlight-work td {
            background-color: #fff9e6 !important; 
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Storage Of Things</a>
            <div class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown {{ request()->routeIs('things.my', 'things.repair', 'things.work', 'things.used', 'things.index') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('things.my', 'things.repair', 'things.work', 'things.used', 'things.index') ? 'active' : '' }}"
                           href="#" id="thingsDropdown" role="button" data-bs-toggle="dropdown">
                            Мои вещи
                        </a>
                        <!-- кастомная директория обновления цвета активной вкладки -->
                        <ul class="dropdown-menu" aria-labelledby="thingsDropdown">
                            <li><a class="dropdown-item {{ request()->routeIs('things.my') ? 'active' : '' }}" href="{{ route('things.my') }}">My things</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('things.repair') ? 'active' : '' }}" href="{{ route('things.repair') }}">Repair things</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('things.work') ? 'active' : '' }}" href="{{ route('things.work') }}">Work</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('things.used') ? 'active' : '' }}" href="{{ route('things.used') }}">Used things</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item {{ request()->routeIs('things.index') ? 'active' : '' }}" href="{{ route('things.index') }}">Все вещи</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('places.index') ? 'active' : '' }}" href="{{ route('places.index') }}">Места</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Профиль</a>
                    </li>
                   <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Выход
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @can('admin-access')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.things') ? 'active' : '' }}" href="{{ route('admin.things') }}">Админка: вещи</a>
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
    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        Pusher.logToConsole = true; 

        const pusher = new Pusher('29826454bf883ab0360a', {
            cluster: 'eu',
            forceTLS: false
        });

        // Канал для вещей
        const thingChannel = pusher.subscribe('thing-updates');
        thingChannel.bind('App\\Events\\ThingCreated', function(data) {
            Toastify({
                text: ` Новая вещь: ${data.name}`,
                duration: 4000,
                backgroundColor: "#4CAF50",
            }).showToast();
        });

        // Канал для мест
        const placeChannel = pusher.subscribe('place-updates');
        placeChannel.bind('App\\Events\\PlaceCreated', function(data) {
            Toastify({
                text: `Новое место: ${data.name}`,
                duration: 4000,
                backgroundColor: "#2196F3",
            }).showToast();
        });
    </script>
</body>
</html>