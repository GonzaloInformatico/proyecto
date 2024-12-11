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
<html>

<head>
    <base href="." />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Solicitudes de Mantención</title>
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


        .toggle-btn {
            background: none;
            border: none;
            color: #455a64;
            cursor: pointer;
            padding: 0.5rem;
            font-size: 1.5rem;
        }

        .user-section {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .username {
            font-weight: 500;
        }

        .config-dropdown {
            position: relative;
        }

        .config-btn {
            background: none;
            border: none;
            color: #455a64;
            cursor: pointer;
            padding: 0.5rem;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .config-btn:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .config-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            padding: 0.5rem 0;
            display: none;
            z-index: 1000;
        }

        .config-dropdown.active .config-menu {
            display: block;
        }

        .config-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--dark);
            text-decoration: none;
            transition: background-color 0.3s ease;
            gap: 0.75rem;
        }

        .config-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .config-item i {
            width: 20px;
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

        .request-list {
            max-width: 1000px;
            margin: 0 auto;
        }

        .filter-section {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group label {
            font-size: 0.875rem;
            color: var(--secondary);
            font-weight: 500;
        }

        .filter-group select,
        .filter-group input {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 150px;
        }

        #clear-filters {
            background-color: var(--secondary);
            color: white;
            align-self: flex-end;
            margin-top: auto;
        }

        .request-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .request-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .request-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .request-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3e0;
            color: #e65100;
        }

        .status-in-progress {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .request-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            font-size: 0.875rem;
        }

        .detail-label {
            color: #666;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-weight: 500;
            color: var(--dark);
        }

        .request-description {
            color: #666;
            font-size: 0.9375rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .request-actions {
            display: flex;
            gap: 1rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-view {
            background-color: var(--secondary);
            color: white;
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal {
            background: white;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            padding: 2rem;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--secondary);
        }

        .modal-header {
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            color: var(--dark);
            margin: 0;
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .modal-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .sub-item {
            padding-left: 2.5rem !important;
            font-size: 0.9em;
            background: rgba(0, 0, 0, 0.1);
        }

        .sub-item:hover {
            background: rgba(0, 0, 0, 0.2);
        }

        .nav-item:not(a) {
            font-weight: bold;
            cursor: default;
            padding: 1rem;
            display: flex;
            align-items: center;
            color: white;
        }

        .nav-item:not(a) i {
            margin-right: 1rem;
            width: 24px;
            text-align: center;
        }

        .collapsed .sub-item {
            padding-left: 1rem !important;
        }

        .modal-footer {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            justify-content: flex-end;
        }

        .btn-accept {
            background-color: var(--success);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-reject {
            background-color: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .rejection-reason {
            margin-top: 1rem;
            display: none;
        }

        .rejection-reason textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 0.5rem;
            min-height: 100px;
        }

        /* Add styles for the send button */
        .btn-send-rejection {
            background-color: var(--success);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
            display: none;
            /* Hidden by default */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style-navbar.css">
    <link rel="stylesheet" href="topbar.css">
</head>

<body>

    <?php include('navbar.php'); ?>
    <?php include('topbar.php'); ?>


    <div class="main-content">
        <div class="request-list">

            <?php
            $lista = $contiene->RequerimientoEnProcesos();
            foreach ($lista as $fila) {
                $fecha_str = $fila["fecha"];
                $fecha = new DateTime($fecha_str);
                $formattedDate = $fecha->format('d/m/Y');
                $imagePath = $fila["Imagen"];
            ?>

                <!-- Request 1 -->
                <div class="request-card">
                    <div class="request-header">
                        <h3 class="request-title"><?php echo $fila["Titulo"]  ?></h3>
                        <span class="request-status status-pending"><?php echo $fila["NombreEstado"]  ?></span>
                    </div>
                    <div class="request-details">
                        <div class="detail-item">
                            <div class="detail-label">Categoría</div>
                            <div class="detail-value"><?php echo $fila["NombreCategoria"]  ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Fecha</div>
                            <div class="detail-value"><?php echo (string)$formattedDate ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">ID Solicitud</div>
                            <div class="detail-value">CAS-<?php echo $fila["ano"]  ?>-<?php echo $fila["idrequerimiento"]  ?></div>
                        </div>
                    </div>
                    <p class="request-description"><?php echo $fila["Descripcion"]  ?></p>
                    <div class="request-actions">
                        <button class="action-btn btn-view" data-image="<?php echo $imagePath ?>"><i class="fas fa-eye" data-id="<?php echo $fila["idrequerimiento"]; ?>" onclick="openModal(this)"></i> Ver Detalles</button>
                    </div>
                </div>
            <?php } ?>

        

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const navbar = document.querySelector('.navbar');
                    const mainContent = document.querySelector('.main-content');
                    const toggleBtn = document.querySelector('.toggle-btn');

                    toggleBtn.addEventListener('click', () => {
                        navbar.classList.toggle('collapsed');
                        mainContent.classList.toggle('collapsed');
                    });

                    const configBtn = document.querySelector('.config-btn');
                    const configDropdown = document.querySelector('.config-dropdown');

                    configBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        configDropdown.classList.toggle('active');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', (e) => {
                        if (!configDropdown.contains(e.target)) {
                            configDropdown.classList.remove('active');
                        }
                    });

                    // Handle config menu items
                    document.querySelectorAll('.config-item').forEach(item => {
                        item.addEventListener('click', function(e) {
                            e.preventDefault();
                            const action = this.textContent.trim();

                            switch (action) {
                                case 'Notificaciones':
                                    alert('Configuración de notificaciones');
                                    break;
                                case 'Cambiar Contraseña':
                                    alert('Cambiar contraseña');
                                    break;
                                case 'Cerrar Sesión':
                                    alert('Sesión cerrada');
                                    break;
                            }

                            configDropdown.classList.remove('active');
                        });
                    });

                    // Add click handlers for view buttons
                    document.querySelectorAll('.btn-view').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const requestCard = this.closest('.request-card');
                            const title = requestCard.querySelector('.request-title').textContent;
                            const status = requestCard.querySelector('.request-status').textContent;
                            const category = requestCard.querySelector('.detail-item:nth-child(1) .detail-value').textContent;
                            const date = requestCard.querySelector('.detail-item:nth-child(2) .detail-value').textContent;
                            const id = requestCard.querySelector('.detail-item:nth-child(3) .detail-value').textContent.split('-')[2].trim(); // Extract ID from formatted string

                            // Populate modal
                            const modal = document.querySelector('.modal');
                            modal.querySelector('.modal-title').textContent = title;
                            modal.querySelector('.modal-details').innerHTML = `
            <div class="detail-item">
                <div class="detail-label">Estado</div>
                <div class="detail-value">${status}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Categoría</div>
                <div class="detail-value">${category}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Fecha</div>
                <div class="detail-value">${date}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">ID Solicitud</div>
                <div class="detail-value">${id}</div>
            </div>
        `;
                            modal.querySelector('.modal-description').innerHTML = `
            <div class="detail-label">Descripción</div>
            <p>${requestCard.querySelector('.request-description').textContent}</p>
        `;

                            // Assign the ID to the accept and reject buttons
                            modal.querySelector('.btn-accept').setAttribute('data-id', id);
                            modal.querySelector('.btn-reject').setAttribute('data-id', id);

                            // Show modal
                            document.querySelector('.modal-backdrop').style.display = 'flex';
                        });
                    });

                    // Accept button functionality
                    document.querySelector('.btn-accept').addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        window.location.href = `aceptar.php?id=${id}`;
                    });

                    // Reject button functionality
                    document.querySelector('.btn-reject').addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        window.location.href = `rechazar.php?id=${id}`;
                    });


                    // Simplify modal close handler
                    document.querySelector('.modal-close').addEventListener('click', () => {
                        document.querySelector('.modal-backdrop').style.display = 'none';
                    });

                    document.querySelector('.modal-backdrop').addEventListener('click', (e) => {
                        if (e.target === document.querySelector('.modal-backdrop')) {
                            document.querySelector('.modal-backdrop').style.display = 'none';
                        }
                    });

                    // confirmacion de rechazar la solicitud 
                    document.querySelector('.btn-reject').addEventListener('click', function() {
                        if (confirm('¿Está seguro que desea rechazar esta solicitud?')) {
                            document.querySelector('.modal-backdrop').style.display = 'none';
                        }
                    });

                    // confirmacion de aceptar la solicitud
                    document.querySelector('.btn-accept').addEventListener('click', function() {
                        if (confirm('¿Está seguro que desea aceptar  esta solicitud?')) {
                            alert('Solicitud Aceptada');
                            document.querySelector('.modal-backdrop').style.display = 'none';
                        }
                    });












                    updateCounters(); // Call this at the end of the existing DOMContentLoaded handler
                });
            </script>
</body>

</html>