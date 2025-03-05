@extends('layouts.app')

@section('title', 'Gráficas de Sensores')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Gráficas de Sensores</h1>

        <!-- Botón para regresar a la lista de sensores -->
        <a href="{{ route('sensores.index') }}" class="btn btn-outline-light mb-4">Regresar a la Lista de Sensores</a>

        <div class="row">
            <!-- Gráfica 1: Sensores por Estado -->
            <div class="col-md-6">
                <h3>Sensores por Estado</h3>
                <canvas id="estadosChart"></canvas>
            </div>

            <!-- Gráfica 2: Sensores por Poste -->
            <div class="col-md-6">
                <h3>Sensores por Poste</h3>
                <canvas id="sensoresPorPosteChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Incluir Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script para la gráfica de Sensores por Estado -->
    <script>
        // Datos para la gráfica de Sensores por Estado
        const estadosData = {
            labels: {!! json_encode($estados->keys()) !!},
            datasets: [{
                label: 'Sensores por Estado',
                data: {!! json_encode($estados->values()) !!},
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)', // Funcionando
                    'rgba(255, 99, 132, 0.6)', // Fallado
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de Sensores por Estado
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

        // Renderizar la gráfica de Sensores por Estado
        const estadosChart = new Chart(
            document.getElementById('estadosChart'),
            estadosConfig
        );
    </script>

    <!-- Script para la gráfica de Sensores por Poste -->
    <script>
        // Datos para la gráfica de Sensores por Poste
        const sensoresPorPosteData = {
            labels: {!! json_encode($sensoresPorPoste->keys()) !!},
            datasets: [{
                label: 'Sensores por Poste',
                data: {!! json_encode($sensoresPorPoste->values()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de Sensores por Poste
        const sensoresPorPosteConfig = {
            type: 'bar',
            data: sensoresPorPosteData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Renderizar la gráfica de Sensores por Poste
        const sensoresPorPosteChart = new Chart(
            document.getElementById('sensoresPorPosteChart'),
            sensoresPorPosteConfig
        );
    </script>
@endsection