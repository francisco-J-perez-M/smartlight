@extends('layouts.app')

@section('title', 'Gráficas de Postes')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Gráficas de Postes</h1>

        <!-- Botón para regresar a la lista de postes -->
        <a href="{{ route('postes.index') }}" class="btn btn-outline-light mb-4">Regresar a la Lista de Postes</a>

        <div class="row">
            <!-- Gráfica 1: Postes por Estado -->
            <div class="col-md-6">
                <h3>Postes por Estado</h3>
                <canvas id="estadosChart"></canvas>
            </div>

            <!-- Gráfica 2: Postes por Ubicación -->
            <div class="col-md-6">
                <h3>Postes por Ubicación</h3>
                <canvas id="ubicacionesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Incluir Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script para la gráfica de Postes por Estado -->
    <script>
        // Datos para la gráfica de Postes por Estado
        const estadosData = {
            labels: {!! json_encode($estados->keys()) !!},
            datasets: [{
                label: 'Postes por Estado',
                data: {!! json_encode($estados->values()) !!},
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)', // Activo
                    'rgba(255, 99, 132, 0.6)', // Inactivo
                    'rgba(255, 206, 86, 0.6)', // Mantenimiento
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de Postes por Estado
        const estadosConfig = {
            type: 'pie',
            data: estadosData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true,
                    }
                }
            }
        };

        // Renderizar la gráfica de Postes por Estado
        const estadosChart = new Chart(
            document.getElementById('estadosChart'),
            estadosConfig
        );
    </script>

    <!-- Script para la gráfica de Postes por Ubicación -->
    <script>
        // Datos para la gráfica de Postes por Ubicación
        const ubicacionesData = {
            labels: {!! json_encode($ubicaciones->keys()) !!},
            datasets: [{
                label: 'Postes por Ubicación',
                data: {!! json_encode($ubicaciones->values()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de Postes por Ubicación
        const ubicacionesConfig = {
            type: 'bar',
            data: ubicacionesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Renderizar la gráfica de Postes por Ubicación
        const ubicacionesChart = new Chart(
            document.getElementById('ubicacionesChart'),
            ubicacionesConfig
        );
    </script>
@endsection