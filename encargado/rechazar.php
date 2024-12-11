<?php
// rechazar.php
session_start();

if (!isset($_SESSION["Nombre"])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    // echo "Se rechazó la solicitud con el ID: " . $id;
    // Aquí podrías añadir lógica adicional para manejar el rechazo de la solicitud
} else {
    // echo "No se proporcionó ID de solicitud.";
}

require_once "../control/query.php";
$contiene = new query();
?>
<html>

<head>
    <base href="." />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechazar Solicitud</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style-navbar.css">
    <link rel="stylesheet" href="topbar.css">
    <style>
       :root {
            --primary: #2962ff;
            --secondary: #455a64;
            --success: #43a047;
            --light: #f5f5f5;
            --dark: #212121;
        }

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

        .rejection-header {
            margin-bottom: 2rem;
        }

        .rejection-title {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .rejection-subtitle {
            color: var(--secondary);
            font-size: 1.1rem;
        }

        .rejection-form {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 500;
        }

        textarea {
            width: 100%;
            min-height: 150px;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 1rem;
            resize: vertical;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-reject {
            background-color: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background-color: #c82333;
        }

        .btn-cancel {
            background-color: var(--secondary);
            color: white;
        }

        .btn-cancel:hover {
            background-color: #3d4f57;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>
    <?php include('topbar.php'); ?>
    <?php
            $lista = $contiene->Requerimiento($id);
            foreach ($lista as $fila) {
            ?>

    <div class="main-content">
        <div class="rejection-container">
            <div class="rejection-header">
                <h1 class="rejection-title">Rechazar Solicitud</h1>
                <h3><?php echo $fila["Titulo"]  ?></h3>
                <?php } ?>
            </div>

            <div class="rejection-form">
                <div class="form-group">
                    <label class="form-label">Motivo del Rechazo</label>
                    <textarea id="rejection-reason" placeholder="Ingrese el motivo del rechazo..."></textarea>
                </div>

                <div class="button-group">
                    <button class="btn btn-reject" id="send-rejection">
                        <i class="fas fa-paper-plane"></i> Enviar Rechazo
                    </button>
                    <button class="btn btn-cancel" id="cancel-rejection">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const requestTitle = sessionStorage.getItem('rejectionTitle');
            const requestId = sessionStorage.getItem('rejectionId');

            // Display request info
           // document.getElementById('request-info').textContent = `${requestTitle} - ${requestId}`;

            // Handle send rejection
            document.getElementById('send-rejection').addEventListener('click', () => {
                const reason = document.getElementById('rejection-reason').value;
                if (reason.trim()) {
                    if (confirm('¿Está seguro que desea rechazar esta solicitud?')) {
                        alert('Solicitud rechazada exitosamente');
                        window.location.href = 'solicitudes.html';
                    }
                } else {
                    alert('Por favor ingrese el motivo del rechazo');
                }
            });

            // Handle cancel
            document.getElementById('cancel-rejection').addEventListener('click', () => {
                window.location.href = 'pendiente.php';
            });
        });
    </script>
</body>

</html>