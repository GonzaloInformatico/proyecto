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
?>

<html>

<head>
  <base href="." />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Solicitudes de Mantención</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="./style/styleUsuario.css">
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
      <span class="username"><?php echo $nombre . " " . $apellido; ?></span>
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
    <div class="request-list">

      <div class="filter-section">
        <div class="filter-group">
          <label for="status-filter">Estado:</label>
          <select id="status-filter">
            <option value="">Todos</option>
            <option value="Pendiente">Pendiente</option>
            <option value="En Proceso">En Proceso</option>
          </select>
        </div>

        <div class="filter-group">
          <label for="date-filter">Fecha:</label>
          <input type="date" id="date-filter">
        </div>

        <div class="filter-group">
          <label for="category-filter">Categoría:</label>
          <select id="category-filter">
            <option value="">Todas</option>
            <option value="Electricidad">Electricidad</option>
            <option value="Baño">Baño</option>
            <option value="Piso">Piso</option>
            <option value="Infraestructura">Infraestructura</option>
            <option value="Bodega">Bodega</option>
          </select>
        </div>

        <button id="clear-filters" class="action-btn">Limpiar Filtros</button>
      </div>

      <?php
        require_once "../controlLogin/query.php";
        $contiene = new query();
        $lista = $contiene->cargarrequerimiento($id);
        foreach ($lista as $fila) {
          $fecha_str= $fila["fecha"] ;
          $fecha = new DateTime($fecha_str);
          $formattedDate = $fecha->format('d-m-Y');
        ?>
      <!-- Request-->
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
            <div class="detail-value"><?php  echo $formattedDate ?></div>
          </div>
          <div class="detail-item">
            <div class="detail-label">ID Solicitud</div>
            <div class="detail-value">#REQ-<?php echo $fila["ano"]  ?>-<?php echo $fila["idrequerimiento"]  ?></div>
          </div>
        </div>
        <p class="request-description"><?php echo $fila["Descripcion"]  ?></p>
        <div class="request-actions">
          <button class="action-btn btn-view"><i class="fas fa-eye"></i> Ver Detalles</button>
        </div>
      </div>
      <?php } ?>



    </div>
  </div>

  <div class="modal-backdrop">
    <div class="modal">
      <button class="modal-close">
        <i class="fas fa-times"></i>
      </button>
      <div class="modal-header">
        <h2 class="modal-title"></h2>
      </div>
      <div class="modal-body">
        <div class="modal-details">
        </div>
        <div class="modal-description"></div>
      </div>
    </div>
  </div>

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
              window.location.href = '../salir.php';
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
          const id = requestCard.querySelector('.detail-item:nth-child(3) .detail-value').textContent;
          const description = requestCard.querySelector('.request-description').textContent;

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
        <p>${description}</p>
      `;

          // Show modal
          document.querySelector('.modal-backdrop').style.display = 'flex';
        });
      });

      // Close modal
      document.querySelector('.modal-close').addEventListener('click', () => {
        document.querySelector('.modal-backdrop').style.display = 'none';
      });

      // Clear filters
      document.getElementById('clear-filters').addEventListener('click', () => {
        document.getElementById('status-filter').value = '';
        document.getElementById('date-filter').value = '';
        document.getElementById('category-filter').value = '';
      });
    });
  </script>

</body>

</html>