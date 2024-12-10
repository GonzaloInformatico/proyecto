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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Solicitudes de Mantención</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/styleUsuario.css">
    <link rel="stylesheet" href="./style/styleSolicitud.css">
</head>

<body>
    <?php include('navbar.php'); ?>
    <?php include('barra.php'); ?>

    <div class="main-content">
        <div class="form-container">
            <h2>Crear Nueva Solicitud</h2>
            <form id="requestForm" class="request-form" method="POST" action="../control/guardarSolicitud.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Título del Requerimiento</label>
                    <input type="text" id="title" name="title" required>
                </div>



                <div class="form-group">
                    <label for="location">Ubicación</label>
                    <select id="location" name="location" required>
                        <option value="">Seleccione ubicación</option>
                        <?php
                        require_once "../control/query.php";
                        $contiene = new query();
                        $lista = $contiene->Ubicacion();
                        foreach ($lista as $fila) {
                        ?>
                            <option value="<?php echo $fila["idUbicacion"] ?>">
                                <?php echo $fila["NombreUbicacion"] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category">Categoría</label>
                    <select id="category" name="category" required>
                        <option value="">Seleccione categoría</option>
                        <?php
                        $lista = $contiene->Categoria();
                        foreach ($lista as $fila) {
                        ?>
                            <option value="<?php echo $fila["idCategoria"] ?>">
                                <?php echo $fila["NombreCategoria"] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subcategory">Subcategoría</label>
                    <select id="subcategory" name="subcategory" required>
                        <option value="">Seleccione subcategoría</option>
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
                            <i class="fas fa-upload"></i> Subir Fotografías
                        </button>
                    </div>
                    <input type="file" name="photos[]" id="photoInput" multiple accept="image/jpeg, image/png, image/gif" style="display: none">
                    <canvas id="cameraCanvas" style="display: none;"></canvas>
                    <video id="cameraVideo" style="display: none;" autoplay></video>
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
            const takePhotoBtn = document.getElementById('takePhotoBtn');
            const uploadPhotoBtn = document.getElementById('uploadPhotoBtn');
            const photoInput = document.getElementById('photoInput');
            const photoPreview = document.getElementById('photoPreview');
            const cameraCanvas = document.getElementById('cameraCanvas');
            const cameraVideo = document.getElementById('cameraVideo');
            const maxPhotos = 1; // Máximo de fotos permitidas
            let photoCount = 0;

            // Abrir la cámara web
            takePhotoBtn.addEventListener('click', async () => {
                if (photoCount >= maxPhotos) {
                    alert(`Solo puedes agregar hasta ${maxPhotos} fotos.`);
                    return;
                }

                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    cameraVideo.srcObject = stream;
                    cameraVideo.style.display = "block";
                    cameraCanvas.style.display = "none";
                } catch (err) {
                    alert("No se puede acceder a la cámara: " + err.message);
                }
            });

            // Capturar foto desde la cámara
            cameraVideo.addEventListener('click', () => {
                if (photoCount >= maxPhotos) {
                    alert(`Solo puedes agregar hasta ${maxPhotos} fotos.`);
                    return;
                }

                const context = cameraCanvas.getContext('2d');
                cameraCanvas.width = cameraVideo.videoWidth;
                cameraCanvas.height = cameraVideo.videoHeight;
                context.drawImage(cameraVideo, 0, 0, cameraCanvas.width, cameraCanvas.height);

                const photoData = cameraCanvas.toDataURL('image/png');
                addPhotoToPreview(photoData);

                photoCount++;
                cameraVideo.style.display = "none";
                cameraCanvas.style.display = "block";
            });

            // Subir fotos desde la galería
            uploadPhotoBtn.addEventListener('click', () => {
                if (photoCount >= maxPhotos) {
                    alert(`Solo puedes agregar hasta ${maxPhotos} fotos.`);
                    return;
                }
                photoInput.click();
            });

            // Vista previa de las fotos seleccionadas
            photoInput.addEventListener('change', (e) => {
                const files = e.target.files;

                if (photoCount + files.length > maxPhotos) {
                    alert(`Solo puedes agregar hasta ${maxPhotos} fotos en total.`);
                    return;
                }

                Array.from(files).forEach((file) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        addPhotoToPreview(e.target.result);
                        photoCount++;
                    };
                    reader.readAsDataURL(file);
                });
            });

            // Agregar fotos a la vista previa
            function addPhotoToPreview(photoData) {
                const photoContainer = document.createElement('div');
                photoContainer.classList.add('photo-container');

                const img = document.createElement('img');
                img.src = photoData;
                img.alt = `Foto ${photoCount + 1}`;
                img.style.margin = "5px";
                img.style.maxWidth = "300px";
                img.style.maxHeight = "100px";

                const deleteBtn = document.createElement('button');
                deleteBtn.textContent = 'Eliminar';
                deleteBtn.classList.add('delete-btn');
                deleteBtn.addEventListener('click', () => {
                    photoPreview.removeChild(photoContainer);
                    photoCount--;
                });

                photoContainer.appendChild(img);
                photoContainer.appendChild(deleteBtn);
                photoPreview.appendChild(photoContainer);
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
                        window.location.href = '../salir.php';
                        break;
                }

                configDropdown.classList.remove('active');
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');

            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                fetchSubcategories(categoryId);
            });

            function fetchSubcategories(categoryId) {
                fetch('get_subcategories.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'category_id=' + categoryId
                    })
                    .then(response => response.text())
                    .then(data => {
                        subcategorySelect.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                        subcategorySelect.innerHTML = '<option>Error loading subcategories</option>';
                    });
            }
        });
    </script>

    <style>
        .photo-container {
            display: inline-block;
            position: relative;

        }

        .photo-container img {
            display: block;
            /* width: auto;*/
            /* Ajusta automáticamente el ancho para mantener la relación de aspecto */
            max-width: 900px;
            /* Aumenta el ancho máximo */
            max-height: 600px;
            /* Aumenta la altura máxima */
        }

        .delete-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</body>

</html>