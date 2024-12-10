<?php
// Verificar si la sesión ya está activa antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["Nombre"])) {
    header("Location: index.php");
    exit();
}
$nombre = htmlspecialchars($_SESSION["Nombre"]);
$apellido = htmlspecialchars($_SESSION["Apellido"]);
$id = htmlspecialchars($_SESSION["id"]);

require_once "../control/query.php";
$contiene = new query();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Mantención</title>
    <link rel="stylesheet" href="style-navbar.css">
    <link rel="stylesheet" href="topbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 20px;
            flex: 1;
            transition: margin-left 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: 60px;
        }

        .dashboard-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-filters {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group label {
            font-weight: 600;
            color: var(--secondary);
            font-size: 0.9rem;
        }

        .filter-group select,
        .filter-group input {
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.9rem;
            min-width: 200px;
            transition: all 0.3s ease;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(41, 98, 255, 0.1);
        }

        .action-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            height: fit-content;
        }

        .action-btn:hover {
            background-color: #1565c0;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(41, 98, 255, 0.2);
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--secondary);
            font-size: 0.9rem;
        }

        /* Contenedor general de los gráficos */
        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Fila de gráficos (para disposición en cuadrícula) */
        .chart-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* Dos gráficos por fila */
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Título de cada gráfico */
        .chart-title {
            font-size: 1.2rem;
            color: var(--dark);
            /* Color oscuro definido en :root */
            margin-bottom: 15px;
        }

        /* Estilo general de las tarjetas estadísticas */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            /* Tarjetas adaptables */
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
            /* Azul principal */
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--secondary);
            /* Gris oscuro */
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>
    <?php include('topbar.php'); ?>
    <div class="main-content">
        <div class="dashboard-container">
            <div class="dashboard-filters">
                <div class="filter-group">
                    <label for="dashboard-status">Estado:</label>
                    <select id="dashboard-status">
                        <option value="">Todos</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Cerrado">Cerrado</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="dashboard-date-start">Fecha Inicio:</label>
                    <input type="date" id="dashboard-date-start">
                </div>

                <div class="filter-group">
                    <label for="dashboard-date-end">Fecha Fin:</label>
                    <input type="date" id="dashboard-date-end">
                </div>

                <div class="filter-group">
                    <label for="dashboard-category">Categoría:</label>
                    <select id="dashboard-category">
                        <option value="">Todas</option>
                        <option value="Electricidad">Electricidad</option>
                        <option value="Baño">Baño</option>
                        <option value="Piso">Piso</option>
                        <option value="Infraestructura">Infraestructura</option>
                        <option value="Bodega">Bodega</option>
                    </select>
                </div>

                <button id="dashboard-clear-filters" class="action-btn">Limpiar Filtros</button>
            </div>

            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-value">23</div>
                    <div class="stat-label">Total Solicitudes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">8</div>
                    <div class="stat-label">Pendientes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">12</div>
                    <div class="stat-label">En Proceso</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">3</div>
                    <div class="stat-label">Cerradas</div>
                </div>
            </div>

            <div class="chart-row">
                <div class="chart-container">
                    <h3 class="chart-title">Solicitudes por Estado</h3>
                    <canvas id="statusPieChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3 class="chart-title">Solicitudes por Categoría</h3>
                    <canvas id="categoryBarChart"></canvas>
                </div>
            </div>

            <div class="chart-container">
                <h3 class="chart-title">Tendencia de Solicitudes</h3>
                <canvas id="trendLineChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Initialize charts
        document.addEventListener('DOMContentLoaded', () => {
            // Pie Chart - Status Distribution
            const statusCtx = document.getElementById('statusPieChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: ['Pendiente', 'En Proceso', 'Cerrado'],
                    datasets: [{
                        data: [8, 12, 3],
                        backgroundColor: ['#ff9800', '#2196f3', '#4caf50']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Bar Chart - Category Distribution
            const categoryCtx = document.getElementById('categoryBarChart').getContext('2d');
            const categoryChart = new Chart(categoryCtx, {
                type: 'bar',
                data: {
                    labels: ['Electricidad', 'Baño', 'Piso', 'Infraestructura', 'Bodega'],
                    datasets: [{
                        label: 'Número de Solicitudes',
                        data: [5, 3, 4, 6, 5],
                        backgroundColor: '#2962ff'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Line Chart - Trend
            const trendCtx = document.getElementById('trendLineChart').getContext('2d');
            const trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                    datasets: [{
                        label: 'Solicitudes',
                        data: [10, 15, 8, 12, 23],
                        borderColor: '#2962ff',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Filter functionality
            const filters = document.querySelectorAll('.dashboard-filters select, .dashboard-filters input');
            filters.forEach(filter => {
                filter.addEventListener('change', updateCharts);
            });

            function updateCharts() {
                const status = document.getElementById('dashboard-status').value;
                const startDate = document.getElementById('dashboard-date-start').value;
                const endDate = document.getElementById('dashboard-date-end').value;
                const category = document.getElementById('dashboard-category').value;

                // Here you would typically make an API call to get filtered data
                // For now, we'll just simulate the update with random data
                const randomData = () => Math.floor(Math.random() * 20) + 1;

                // Update charts with new data
                statusChart.data.datasets[0].data = [randomData(), randomData(), randomData()];
                statusChart.update();

                categoryChart.data.datasets[0].data = [
                    randomData(), randomData(), randomData(), randomData(), randomData()
                ];
                categoryChart.update();

                trendChart.data.datasets[0].data = [
                    randomData(), randomData(), randomData(), randomData(), randomData()
                ];
                trendChart.update();
            }

            // Clear filters
            document.getElementById('dashboard-clear-filters').addEventListener('click', () => {
                filters.forEach(filter => {
                    filter.value = '';
                });
                updateCharts();
            });
        });
    </script>
</body>

</html>