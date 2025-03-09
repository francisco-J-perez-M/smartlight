<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
        .error-message {
            color: #dc3545; /* Color rojo para los mensajes de error */
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container d-flex justify-content-center">
        <div class="card shadow-lg p-4">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">Registro de Técnico</h4>
            </div>
            <div class="card-body">
                <!-- Mostrar errores generales -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/register">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>