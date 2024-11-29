<!-- navbar.php -->
<nav class="navbar">
    <p></p>
    <a href="usuario.php" class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'usuario.php') echo 'active'; ?>">
        <i class="fas fa-list"></i>
        <span class="nav-text">Mis Solicitudes</span>
    </a>
    <a href="crearSolicitud.php" class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'crearSolicitud.php') echo 'active'; ?>">
        <i class="fas fa-plus-circle"></i>
        <span class="nav-text">Crear Solicitud</span>
    </a>
</nav>
