<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'smartLight')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 70px;
            background-color: #343a40; /* Fondo oscuro */
            color: #ffffff; /* Texto claro */
        }

        /* Personalización de la barra de desplazamiento */
        body::-webkit-scrollbar {
            width: 8px;
        }
        body::-webkit-scrollbar-track {
            background: #343a40;
        }
        body::-webkit-scrollbar-thumb {
            background: #6c757d;
            border-radius: 4px;
        }
        body::-webkit-scrollbar-thumb:hover {
            background: #495057;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .card {
            border: 1px solid rgba(255, 255, 255, 0.125);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #454d55;
            color: #ffffff;
        }
        .card-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .card-text {
            font-size: 1.1rem;
        }
        hr {
            margin: 1.5rem 0;
            border-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-dark text-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Mi App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('postes.*') ? 'active' : '' }}" href="{{ route('postes.index') }}">Postes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('sensores.*') ? 'active' : '' }}" href="{{ route('sensores.index') }}">Sensores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alertas.*') ? 'active' : '' }}" href="{{ route('alertas.index') }}">Alertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">Usuarios</a>
                    </li>
                </ul>
                <!-- Formulario oculto para logout -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <!-- Botón de logout -->
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger px-4 py-2 rounded-pill">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container mt-5 bg-transparent">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
