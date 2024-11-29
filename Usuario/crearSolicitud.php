<?php
// Verificar si la sesión ya está activa antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["Nombre"])) {
    header("Location: index.php");
    exit();
}
$nombre = $_SESSION["Nombre"];
$apellido = $_SESSION["Apellido"];

?>

<html>

<head>
    <base href="." />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Solicitudes de Mantención</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/styleUsuario.css">
    <link rel="stylesheet" href="./style/styleSolicitud.css">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="top-bar">
        <button class="toggle-btn">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand" href="#">
            <img src="../img/SITRANS3.png" alt="Logo" width="150" height="27" class="d-inline-block align-text-top">
        </a>
        <div class="user-section">
            <span class="username"><?php echo $nombre, " ", $apellido ?></span>
            <div class="config-dropdown">
                <button class="config-btn">
                    <i class="fas fa-cog"></i>
                </button>
                <div class="config-menu">
                    <a href="#" class="config-item">
                        <i class="fas fa-bell"></i>
                        Notificaciones
                    </a>
                    <a href="#" class="config-item">
                        <i class="fas fa-key"></i>
                        Cambiar Contraseña
                    </a>
                    <a href="salir.php" class="config-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="form-container">
            <h2>Crear Nueva Solicitud</h2>
            <form id="requestForm" class="request-form">
                <div class="form-group">
                    <label for="title">Título del Requerimiento</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="location">Ubicación</label>
                    <select id="location" name="location" required>
                        <option value="">Seleccione ubicación</option>
                        <option value="bodega1">Bodega 1</option>
                        <option value="bodega2">Bodega 2</option>
                        <option value="cdi">CDI</option>
                        <option value="patioDemares">Patio Demares</option>
                        <option value="patioSIX">Patio SIX</option>
                        <option value="oficinaPrincipal">Oficina Principal</option>
                        <option value="ces">CES</option>
                        <option value="camarines">Camarines</option>
                        <option value="gate">GATE</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category">Categoría</label>
                    <select id="category" name="category" required>
                        <option value="">Seleccione categoría</option>
                        <option value="infraestructura">Infraestructura</option>
                        <option value="patio">Patio</option>
                        <option value="electricidad">Electricidad</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subcategory">Subcategoría</label>
                    <select id="subcategory" name="subcategory" required>
                        <option value="">Seleccione subcategoría</option>
                        <option value="enchufe">Enchufe</option>
                        <option value="iluminacion">Iluminación</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" rows="5" required></textarea>
                </div>

                <div class="form-group photo-upload">
                    <div class="photo-buttons">
                        <button type="button" class="action-btn photo-btn" id="takePhotoBtn">
                            <i class="fas fa-camera"></i> Tomar Fotografía
                        </button>
                        <button type="button" class="action-btn photo-btn" id="uploadPhotoBtn">
                            <i class="fas fa-upload"></i> Subir Fotografía
                        </button>
                    </div>
                    <input type="file" id="photoInput" accept="image/*" capture="environment" style="display: none">
                    <div id="photoPreview" class="photo-preview"></div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="action-btn btn-save">
                        <i class="fas fa-save"></i> Guardar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navbar = document.querySelector('.navbar');
            const mainContent = document.querySelector('.main-content');
            const toggleBtn = document.querySelector('.toggle-btn');
            const logoutBtn = document.querySelector('.logout-btn');

            toggleBtn.addEventListener('click', () => {
                navbar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
            });

            logoutBtn.addEventListener('click', () => {
                alert('Sesión cerrada');
            });

            const form = document.getElementById('requestForm');
            const photoInput = document.getElementById('photoInput');
            const takePhotoBtn = document.getElementById('takePhotoBtn');
            const uploadPhotoBtn = document.getElementById('uploadPhotoBtn');
            const photoPreview = document.getElementById('photoPreview');

            // Handle photo upload
            uploadPhotoBtn.addEventListener('click', () => {
                photoInput.click();
            });

            // Handle take photo
            takePhotoBtn.addEventListener('click', () => {
                photoInput.setAttribute('capture', 'environment');
                photoInput.click();
            });

            // Preview uploaded photo
            photoInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        photoPreview.innerHTML = '';
                        photoPreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form submission
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                // Here you would typically send the form data to your server
                console.log('Form submitted:', Object.fromEntries(formData));
                alert('Solicitud guardada exitosamente');
            });

            // Dynamic subcategories based on category
            const category = document.getElementById('category');
            const subcategory = document.getElementById('subcategory');

            const subcategories = {
                'electricidad': ['Enchufe', 'Iluminación', 'Tablero Eléctrico', 'Cableado'],
                'infraestructura': ['Paredes', 'Techo', 'Puertas', 'Ventanas'],
                'patio': ['Pavimento', 'Señalización', 'Drenaje', 'Iluminación Exterior']
            };

            category.addEventListener('change', () => {
                const selected = category.value;
                subcategory.innerHTML = '<option value="">Seleccione subcategoría</option>';

                if (selected && subcategories[selected]) {
                    subcategories[selected].forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.toLowerCase();
                        option.textContent = sub;
                        subcategory.appendChild(option);
                    });
                }
            });
        });
    </script>
</body>

</html>