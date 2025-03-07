<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #212529; /* Fondo oscuro elegante */
        }
        .card {
            background-color: #2c3034;
            color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 500px; /* Aumentado el ancho máximo */
        }
        .form-control {
            background-color: #3a3f44;
            color: #ffffff;
            border: 1px solid #6c757d;
            border-radius: 10px;
            font-size: 1.2rem; /* Aumentado el tamaño del texto */
        }
        .form-control:focus {
            background-color: #3a3f44;
            color: #ffffff;
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }
        .btn-primary {
            background-color: #0d6efd;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1.2rem; /* Aumentado el tamaño del botón */
            padding: 10px;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-size: 1.5rem; /* Aumentado el tamaño del texto del encabezado */
        }
        .register-link {
            text-align: center;
            margin-top: 1rem;
        }
        .register-link a {
            color: #0d6efd;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container d-flex justify-content-center">
        <div class="card shadow-lg p-4">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">Iniciar Sesión</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="/login">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </form>
                <!-- Botón o enlace para redirigir al registro -->
                <div class="register-link">
                    <p class="mt-3">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>