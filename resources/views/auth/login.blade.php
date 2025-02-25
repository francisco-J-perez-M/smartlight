<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40; /* Fondo oscuro para el cuerpo */
        }
        .card {
            background-color: #454d55; /* Fondo oscuro para la tarjeta */
            color: #ffffff; /* Texto claro */
        }
        .form-control {
            background-color: #343a40; /* Fondo oscuro para los campos de formulario */
            color: #ffffff; /* Texto claro */
            border: 1px solid #6c757d; /* Borde gris */
        }
        .form-control:focus {
            background-color: #343a40; /* Fondo oscuro al enfocar */
            color: #ffffff; /* Texto claro al enfocar */
            border-color: #6c757d; /* Borde gris al enfocar */
        }
        .btn-primary {
            background-color: #0d6efd; /* Color primario para el botón */
            border-color: #0d6efd; /* Borde del botón */
        }
        .btn-primary:hover {
            background-color: #0b5ed7; /* Color primario al pasar el mouse */
            border-color: #0b5ed7; /* Borde del botón al pasar el mouse */
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Iniciar Sesión</h4>
                    </div>
                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>