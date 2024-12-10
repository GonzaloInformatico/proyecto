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