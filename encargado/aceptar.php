<?php
// procesar.php
session_start();

if (!isset($_SESSION["Nombre"])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    echo "Llegue aquí con el ID: " . $id;
    // Aquí iría el código para procesar la aceptación de la solicitud
} else {
    echo "No se proporcionó ID de solicitud.";
}
?>
