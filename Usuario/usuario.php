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
  <?php include('barra.php'); ?>


  <div class="main-content">
    <div class="request-list">

      <div class="filter-section">
        <div class="filter-group">
          <label for="status-filter">Estado:</label>
          <select id="status-filter">
            <option value="">Todos</option>
            <?php
        $lista = $contiene->Estados();
        foreach ($lista as $fila) {
        ?>
            <option value="<?php echo $fila["NombreEstado"]  ?>"><?php echo $fila["NombreEstado"]  ?></option>
            <?php } ?>
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
            <?php
        $lista = $contiene->Categoria();
        foreach ($lista as $fila) {
        ?>
            <option value="<?php echo $fila["NombreCategoria"]  ?>"><?php echo $fila["NombreCategoria"]  ?></option>
            <?php } ?>
          </select>
        </div>

        <button id="clear-filters" class="action-btn">Limpiar Filtros</button>
      </div>

      <?php
        $lista = $contiene->cargarrequerimiento($id);
        foreach ($lista as $fila) {
          $fecha_str= $fila["fecha"] ;
          $fecha = new DateTime($fecha_str);
          $formattedDate = $fecha->format('d/m/Y');
          $imagePath = $fila["Imagen"];
        ?>
      <!-- Request-->
      <div class="request-card">
        <div class="request-header">
          <h3 class="request-title"><?php echo $fila["Titulo"]  ?></h3>
          <span class="request-status status-<?php echo str_replace(" ","_",$fila["NombreEstado"] )  ?>"><?php echo $fila["NombreEstado"]  ?></span>
        </div>
        <div class="request-details">
          <div class="detail-item">
            <div class="detail-label">Categoría</div>
            <div class="detail-value"><?php echo $fila["NombreCategoria"]  ?></div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Fecha</div>
            <div class="detail-value"><?php  echo (string)$formattedDate ?></div>
          </div>
          <div class="detail-item">
            <div class="detail-label">ID Solicitud</div>
            <div class="detail-value">#REQ-<?php echo $fila["ano"]  ?>-<?php echo $fila["idrequerimiento"]  ?></div>
          </div>
        </div>
        <p class="request-description"><?php echo $fila["Descripcion"]  ?></p>
        <div class="request-actions">
        <button class="action-btn btn-view" data-image="<?php echo $imagePath ?>"><i class="fas fa-eye"></i> Ver Detalles</button>
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
        <div class="modal-image-container">
        <img src="" class="modal-image" alt="No hay imagen disponible"> <!-- Etiqueta de imagen agregada -->
      </div>
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
          const imagePath = btn.getAttribute('data-image'); // Usa data attribute para la imagen

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
      modal.querySelector('.modal-image').src = imagePath || './path-to-default-image.jpg'; // Añadir una ruta de imagen por defecto si imagePath está vacío

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

     // funcionalidad de los filtros 
  const statusFilter = document.getElementById('status-filter');
  const dateFilter = document.getElementById('date-filter');
  const categoryFilter = document.getElementById('category-filter');
  const clearFiltersBtn = document.getElementById('clear-filters');
  const requestCards = document.querySelectorAll('.request-card');

  function applyFilters() {
    requestCards.forEach(card => {
      const status = card.querySelector('.request-status').textContent;
      const category = card.querySelector('.detail-value').textContent;
      const dateStr = card.querySelector('.detail-item:nth-child(2) .detail-value').textContent;
      
      // Convert date string to comparable format
      const cardDate = new Date(dateStr.split('/').reverse().join('-'));
      const filterDate = dateFilter.value ? new Date(dateFilter.value) : null;

      const statusMatch = !statusFilter.value || status === statusFilter.value;
      const categoryMatch = !categoryFilter.value || category === categoryFilter.value;
      const dateMatch = !filterDate || 
        (cardDate.getFullYear() === filterDate.getFullYear() && 
         cardDate.getMonth() === filterDate.getMonth() && 
         cardDate.getDate() === filterDate.getDate());

      if (statusMatch && categoryMatch && dateMatch) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  }

  // Add event listeners for filters
  statusFilter.addEventListener('change', applyFilters);
  dateFilter.addEventListener('change', applyFilters);
  categoryFilter.addEventListener('change', applyFilters);

  // Clear filters functionality
  clearFiltersBtn.addEventListener('click', () => {
    statusFilter.value = '';
    dateFilter.value = '';
    categoryFilter.value = '';
    requestCards.forEach(card => card.style.display = '');
  });
  </script>

</body>

</html>