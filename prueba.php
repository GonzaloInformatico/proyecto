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



<html><head><base href="." /><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistema de Requerimientos de Mantención</title>
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
}

.navbar {
  width: 250px;
  background: #0099FE;
  color: white;
  padding-top: 60px;
  transition: all 0.3s ease;
  position: fixed;
  height: 100vh;
}

.navbar.collapsed {
  width: 60px;
}

.nav-item {
  padding: 1rem;
  display: flex;
  align-items: center;
  color: white;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.nav-item:hover {
  background-color: rgba(255,255,255,0.1);
}

.nav-item i {
  margin-right: 1rem;
  width: 24px;
  text-align: center;
}

.nav-text {
  white-space: nowrap;
  padding-right: 16px;
  opacity: 1;
  transition: opacity 0.3s ease;
}

.collapsed .nav-text {
  opacity: 0;
  width: 0;
  overflow: hidden;
}

.top-bar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 60px;
  background: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  padding: 0 1rem;
  z-index: 100;
}

.toggle-btn {
  background: none;
  border: none;
  color: var(--dark);
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

.logout-btn {
  padding: 0.5rem 1rem;
  background: var(--primary);
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
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

.request-form {
  max-width: 800px;
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: var(--dark);
}

.form-control {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary);
  outline: none;
}

select.form-control {
  background-color: white;
}

textarea.form-control {
  min-height: 150px;
  resize: vertical;
}

.image-upload {
  border: 2px dashed #ddd;
  padding: 1.5rem;
  text-align: center;
  border-radius: 4px;
  margin-bottom: 1rem;
}

.image-preview {
  max-width: 300px;
  margin-top: 1rem;
  display: none;
}

.camera-preview {
  width: 100%;
  max-width: 400px;
  margin-top: 1rem;
  display: none;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  transition: background-color 0.3s ease;
}

.btn-primary {
  background-color: #0099FE;
  color: white;
}

.btn-secondary {
  background-color: var(--secondary);
  color: white;
  margin-right: 1rem;
}

.btn:hover {
  opacity: 0.9;
}

.button-group {
  margin-top: 2rem;
  display: flex;
  gap: 1rem;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
<nav class="navbar">
  <a href="crear-solicitud.html" class="nav-item">
  <i class="fas fa-plus-circle"></i>
    <span class="nav-text">Crear Solicitud</span>
  </a>
  <a href="mis-solicitudes.html" class="nav-item">
    <i class="fas fa-list"></i>
    <span class="nav-text">Mis Solicitudes</span>
  </a>
  <a href="solicitudes-cerradas.html" class="nav-item">
    <i class="fas fa-check-circle"></i>
    <span class="nav-text">Solicitudes Cerradas</span>
  </a>
</nav>

<div class="top-bar">
  <button class="toggle-btn">
    <i class="fas fa-bars"></i>
  </button>
  <a class="navbar-brand" href="#">
        <img src="img/SITRANS3.png" alt="Logo" width="150" height="27" class="d-inline-block align-text-top">
    </a>
  <div class="user-section">
    <span class="username"><?php echo $nombre, " ", $apellido ?></span>
    <button class="logout-btn" onclick="window.location.href='salir.php'">Cerrar Sesión</button>
  </div>
</div>

<div class="main-content">
  <form class="request-form" id="maintenanceForm">
    <div class="form-group">
      <label for="title">Título del Requerimiento</label>
      <input type="text" id="title" name="title" class="form-control" required>
    </div>

    <div class="form-group">
      <label for="category">Categoría</label>
      <select id="category" name="category" class="form-control" required>
        <option value="">Seleccione una categoría</option>
        <option value="infraestructura">Infraestructura</option>
        <option value="electricidad">Electricidad</option>
        <option value="piso">Piso</option>
        <option value="baño">Baño</option>
        <option value="bodega">Bodega</option>
        <option value="otros">Otros</option>
      </select>
    </div>

    <div class="form-group">
      <label for="description">Descripción Detallada</label>
      <textarea id="description" name="description" class="form-control" required></textarea>
    </div>

    <div class="form-group">
      <label>Imagen del Requerimiento</label>
      <div class="image-upload">
        <input type="file" id="imageInput" accept="image/*" capture="environment" style="display: none">
        <video id="cameraPreview" class="camera-preview" autoplay playsinline></video>
        <img id="imagePreview" class="image-preview" alt="Vista previa de la imagen">
        <div class="button-group">
          <button type="button" class="btn btn-secondary" id="uploadButton">Subir Imagen</button>
          <button type="button" class="btn btn-secondary" id="cameraButton">Tomar Foto</button>
        </div>
      </div>
    </div>

    <div class="button-group">
      <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
    </div>
  </form>
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
    // Add logout functionality here
    alert('Sesión cerrada');
  });

  const imageInput = document.getElementById('imageInput');
  const imagePreview = document.getElementById('imagePreview');
  const uploadButton = document.getElementById('uploadButton');
  const cameraButton = document.getElementById('cameraButton');
  const cameraPreview = document.getElementById('cameraPreview');
  let stream = null;

  uploadButton.addEventListener('click', () => {
    imageInput.click();
  });

  imageInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';
        cameraPreview.style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  });

  cameraButton.addEventListener('click', async () => {
    try {
      if (stream) {
        const tracks = stream.getTracks();
        tracks.forEach(track => track.stop());
        cameraPreview.style.display = 'none';
        imagePreview.style.display = 'none';
        stream = null;
        cameraButton.textContent = 'Tomar Foto';
      } else {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        cameraPreview.srcObject = stream;
        cameraPreview.style.display = 'block';
        imagePreview.style.display = 'none';
        cameraButton.textContent = 'Capturar';
      }
    } catch (err) {
      console.error('Error accessing camera:', err);
      alert('Error al acceder a la cámara. Por favor, asegúrese de que su dispositivo tiene una cámara y que ha dado los permisos necesarios.');
    }
  });

  document.getElementById('maintenanceForm').addEventListener('submit', (e) => {
    e.preventDefault();
    // Here you would typically send the form data to your server
    alert('Solicitud enviada con éxito');
    e.target.reset();
    imagePreview.style.display = 'none';
    if (stream) {
      const tracks = stream.getTracks();
      tracks.forEach(track => track.stop());
      cameraPreview.style.display = 'none';
      stream = null;
      cameraButton.textContent = 'Tomar Foto';
    }
  });
});
</script>
</body></html>