@extends('layouts.app')

@section('title', 'Gráficas de Usuarios')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Gráficas de Usuarios</h1>

        <!-- Botón para regresar a la lista de usuarios -->
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-light mb-4">Regresar a la Lista de Usuarios</a>

        <div class="row">
            <!-- Gráfica 1: Usuarios por Rol -->
            <div class="col-md-6">
                <h3>Usuarios por Rol</h3>
                <canvas id="rolesChart"></canvas>
            </div>

            <!-- Gráfica 2: Usuarios por Dominio de Correo -->
            <div class="col-md-6">
                <h3>Usuarios por Dominio de Correo</h3>
                <canvas id="dominiosChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Incluir Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script para la gráfica de Usuarios por Rol -->
    <script>
        // Datos para la gráfica de Usuarios por Rol
        const rolesData = {
            labels: {!! json_encode($roles->keys()) !!},
            datasets: [{
                label: 'Usuarios por Rol',
                data: {!! json_encode($roles->values()) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',  // Rojo
                    'rgba(54, 162, 235, 0.6)',  // Azul
                    'rgba(255, 206, 86, 0.6)',  // Amarillo
                    'rgba(75, 192, 192, 0.6)',  // Verde agua
                    'rgba(153, 102, 255, 0.6)', // Morado
                    'rgba(255, 159, 64, 0.6)',  // Naranja
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de Usuarios por Rol
        const rolesConfig = {
            type: 'bar',
            data: rolesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Renderizar la gráfica de Usuarios por Rol
        const rolesChart = new Chart(
            document.getElementById('rolesChart'),
            rolesConfig
        );
    </script>

    <!-- Script para la gráfica de Usuarios por Dominio de Correo -->
    <script>
        // Datos para la gráfica de Usuarios por Dominio de Correo
        const dominiosData = {
            labels: {!! json_encode($dominios->keys()) !!},
            datasets: [{
                label: 'Usuarios por Dominio de Correo',
                data: {!! json_encode($dominios->values()) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',  // Rojo
                    'rgba(54, 162, 235, 0.6)',  // Azul
                    'rgba(255, 206, 86, 0.6)',  // Amarillo
                    'rgba(75, 192, 192, 0.6)',  // Verde agua
                    'rgba(153, 102, 255, 0.6)', // Morado
                    'rgba(255, 159, 64, 0.6)',  // Naranja
                    'rgba(199, 199, 199, 0.6)',  // Gris
                    'rgba(83, 102, 255, 0.6)',   // Azul oscuro
                    'rgba(255, 99, 255, 0.6)',   // Rosa
                    'rgba(102, 255, 102, 0.6)',  // Verde claro
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(255, 99, 255, 1)',
                    'rgba(102, 255, 102, 1)',
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de Usuarios por Dominio de Correo
        const dominiosConfig = {
            type: 'pie',
            data: dominiosData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar tooltips
                    }
                }
            }
        };

        // Renderizar la gráfica de Usuarios por Dominio de Correo
        const dominiosChart = new Chart(
            document.getElementById('dominiosChart'),
            dominiosConfig
        );
    </script>
@endsection