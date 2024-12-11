<?php
// Verificar si la sesión ya está activa antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["Nombre"])) {
    header("Location: index.php");
    exit();
}

require_once "../control/query.php";
$contiene = new query();
$nuevo = $contiene->ContarNuevos();
$proceso = $contiene->ContarProcesos();

foreach ($nuevo as $fila) {
    $numNuevo= $fila["num_nuevos"];
}
foreach ($proceso as $fila) {
    $NumProceso = $fila["num_procesos"];
}


?>

<nav class="navbar">
    <a href="principal.php" class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'principal.php') echo 'active'; ?>">
        <i class="fas fa-chart-line"></i>
        <span class="nav-text">Dashboard</span>
    </a>
    <div class="nav-item">
        <i class="fas fa-list"></i>
        <span class="nav-text">Solicitudes</span>
    </div>
    <a href="pendiente.php" class=" nav-item sub-item  <?php if (basename($_SERVER['PHP_SELF']) == 'pendiente.php') echo 'active'; ?>">
        <i class="fas fa-clock"></i>
        <span class="nav-text">Nuevas</span>
        <span class="nav-badge"><?php echo $numNuevo  ?></span>
    </a>
    <a href="proceso.php" class="nav-item sub-item">
        <i class="fas fa-spinner"></i>
        <span class="nav-text">En Proceso</span>
        <span class="nav-badge"><?php echo $NumProceso  ?></span>
    </a>
    <a href="solicitudes.html?status=cerrado" class="nav-item sub-item">
        <i class="fas fa-check-circle"></i>
        <span class="nav-text">Cerrados</span>
        <span class="nav-badge">5</span>
    </a>

</nav>