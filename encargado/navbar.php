<nav class="navbar">
<a href="principal.php" class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'principal.php') echo 'active'; ?>">
        <i class="fas fa-chart-line"></i>
        <span class="nav-text">Dashboard</span>
    </a>
    <div class="nav-item">
        <i class="fas fa-list"></i>
        <span class="nav-text">Solicitudes</span>
    </div>
    <a href="pendiente.php" class=" nav-item sub-item  <?php if(basename($_SERVER['PHP_SELF']) == 'pendiente.php') echo 'active'; ?>">
        <i class="fas fa-clock"></i>
        <span class="nav-text">Pendientes</span>
        <span class="nav-badge">3</span>
    </a>
    <a href="solicitudes.html?status=proceso" class="nav-item sub-item">
        <i class="fas fa-spinner"></i>
        <span class="nav-text">En Proceso</span>
        <span class="nav-badge">2</span>
    </a>
    <a href="solicitudes.html?status=cerrado" class="nav-item sub-item">
        <i class="fas fa-check-circle"></i>
        <span class="nav-text">Cerrados</span>
        <span class="nav-badge">5</span>
    </a>
   
</nav>