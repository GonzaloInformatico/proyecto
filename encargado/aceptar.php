<?php
// procesar.php
session_start();
require_once "../control/query.php";
$contiene = new query();

if (!isset($_SESSION["Nombre"])) {
    header('Location: login.php');
    exit();
}

// Asume que el ID ya está en el formato correcto y no necesita ser descompuesto
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {  // Cambia POST por GET si pasas el ID por URL
    $id = $_GET['id'];  // Cambia POST por GET si pasas el ID por URL
    //echo "Llegué aquí con el ID: " . $id;

    $lista = $contiene->cambioEstado(2,$id);
    header('Location: pendiente.php');


} else {
    echo "No se proporcionó ID de solicitud.";
}



?>

