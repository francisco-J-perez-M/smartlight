@extends('layouts.app')

@section('title', 'Gráficas de Alertas')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Gráficas de Alertas</h1>

        <!-- Botón para regresar a la lista de alertas -->
        <a href="{{ route('alertas.index') }}" class="btn btn-outline-light mb-4">Regresar a la Lista de Alertas</a>

        <div class="row">
            <!-- Gráfica 1: Alertas por Estado -->
            <div class="col-md-6">
                <h3>Alertas por Estado</h3>
                <canvas id="estadosChart"></canvas>
            </div>

            <!-- Gráfica 2: Alertas por Mes -->
            <div class="col-md-6">
                <h3>Alertas por Mes</h3>
                <canvas id="alertasPorMesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Incluir Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script para la gráfica de Alertas por Estado -->
    <script>
        // Datos para la gráfica de Alertas por Estado
        const estadosData = {
            labels: {!! json_encode(array_keys($estados)) !!},
            datasets: [{
                label: 'Alertas por Estado',
                data: {!! json_encode(array_values($estados)) !!},
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)', // Resueltas
                    'rgba(255, 99, 132, 0.6)', // Pendientes
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de Alertas por Estado
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

        // Renderizar la gráfica de Alertas por Estado
        const estadosChart = new Chart(
            document.getElementById('estadosChart'),
            estadosConfig
        );
    </script>

    <!-- Script para la gráfica de Alertas por Mes -->
    <script>
        // Datos para la gráfica de Alertas por Mes
        const alertasPorMesData = {
            labels: {!! json_encode($alertasPorMes->keys()) !!},
            datasets: [{
                label: 'Alertas por Mes',
                data: {!! json_encode($alertasPorMes->values()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de Alertas por Mes
        const alertasPorMesConfig = {
            type: 'bar',
            data: alertasPorMesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Renderizar la gráfica de Alertas por Mes
        const alertasPorMesChart = new Chart(
            document.getElementById('alertasPorMesChart'),
            alertasPorMesConfig
        );
    </script>
@endsection