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
<title>Mis Solicitudes de Mantención</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="styleUsuario.css">
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
</nav>

<div class="top-bar">
  <button class="toggle-btn">
    <i class="fas fa-bars"></i>
  </button>
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
        <a href="salir.php" class="config-item" >
          <i class="fas fa-sign-out-alt" ></i>
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

    <!-- Request 1 -->
    <div class="request-card">
      <div class="request-header">
        <h3 class="request-title">Reparación de Luminaria en Oficina 201</h3>
        <span class="request-status status-pending">Pendiente</span>
      </div>
      <div class="request-details">
        <div class="detail-item">
          <div class="detail-label">Categoría</div>
          <div class="detail-value">Electricidad</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Fecha</div>
          <div class="detail-value">15/05/2023</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">ID Solicitud</div>
          <div class="detail-value">#REQ-2023-001</div>
        </div>
      </div>
      <p class="request-description">Luminaria del techo parpadea constantemente y necesita reemplazo urgente.</p>
      <div class="request-actions">
        <button class="action-btn btn-view"><i class="fas fa-eye"></i> Ver Detalles</button>
      </div>
    </div>

    <!-- Request 2 -->
    <div class="request-card">
      <div class="request-header">
        <h3 class="request-title">Filtración en Baño Principal</h3>
        <span class="request-status status-in-progress">En Proceso</span>
      </div>
      <div class="request-details">
        <div class="detail-item">
          <div class="detail-label">Categoría</div>
          <div class="detail-value">Baño</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Fecha</div>
          <div class="detail-value">18/05/2023</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">ID Solicitud</div>
          <div class="detail-value">#REQ-2023-002</div>
        </div>
      </div>
      <p class="request-description">Hay una filtración de agua en la base del inodoro que está causando humedad en el piso.</p>
      <div class="request-actions">
        <button class="action-btn btn-view"><i class="fas fa-eye"></i> Ver Detalles</button>
      </div>
    </div>

    <!-- Request 3 -->
    <div class="request-card">
      <div class="request-header">
        <h3 class="request-title">Reparación de Piso en Sala de Reuniones</h3>
        <span class="request-status status-pending">Pendiente</span>
      </div>
      <div class="request-details">
        <div class="detail-item">
          <div class="detail-label">Categoría</div>
          <div class="detail-value">Piso</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Fecha</div>
          <div class="detail-value">20/05/2023</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">ID Solicitud</div>
          <div class="detail-value">#REQ-2023-003</div>
        </div>
      </div>
      <p class="request-description">Baldosas sueltas en el centro de la sala de reuniones, representa un riesgo de seguridad.</p>
      <div class="request-actions">
        <button class="action-btn btn-view"><i class="fas fa-eye"></i> Ver Detalles</button>
      </div>
    </div>

    <!-- Request 4 -->
    <div class="request-card">
      <div class="request-header">
        <h3 class="request-title">Mantenimiento de Aire Acondicionado</h3>
        <span class="request-status status-in-progress">En Proceso</span>
      </div>
      <div class="request-details">
        <div class="detail-item">
          <div class="detail-label">Categoría</div>
          <div class="detail-value">Infraestructura</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Fecha</div>
          <div class="detail-value">22/05/2023</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">ID Solicitud</div>
          <div class="detail-value">#REQ-2023-004</div>
        </div>
      </div>
      <p class="request-description">El aire acondicionado hace ruidos extraños y no enfría adecuadamente.</p>
      <div class="request-actions">
        <button class="action-btn btn-view"><i class="fas fa-eye"></i> Ver Detalles</button>
      </div>
    </div>

    <!-- Request 5 -->
    <div class="request-card">
      <div class="request-header">
        <h3 class="request-title">Organización de Bodega Principal</h3>
        <span class="request-status status-pending">Pendiente</span>
      </div>
      <div class="request-details">
        <div class="detail-item">
          <div class="detail-label">Categoría</div>
          <div class="detail-value">Bodega</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Fecha</div>
          <div class="detail-value">25/05/2023</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">ID Solicitud</div>
          <div class="detail-value">#REQ-2023-005</div>
        </div>
      </div>
      <p class="request-description">Se requiere instalación de nuevos estantes y organización general de la bodega.</p>
      <div class="request-actions">
        <button class="action-btn btn-view"><i class="fas fa-eye"></i> Ver Detalles</button>
      </div>
    </div>

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
      
      switch(action) {
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

  // Add modal close functionality
  document.querySelector('.modal-close').addEventListener('click', () => {
    document.querySelector('.modal-backdrop').style.display = 'none';
  });

  // Close modal when clicking outside
  document.querySelector('.modal-backdrop').addEventListener('click', (e) => {
    if (e.target === document.querySelector('.modal-backdrop')) {
      document.querySelector('.modal-backdrop').style.display = 'none';
    }
  });

  // Filtering functionality
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
});
</script>
</body></html>