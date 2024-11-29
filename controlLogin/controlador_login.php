<?php
session_start();
require_once 'db.php';

try {
    // Crear instancia de la clase db
    $base = new db();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = $_POST["usuario"];
        $contraseña = $_POST["password"];

        // Consulta SQL para verificar las credenciales
        $sql_verificar = "SELECT * FROM usuario WHERE Correo = :correo AND Contrasenna = :contrasena";

        // Preparar la consulta utilizando la conexión de la clase db
        $stmt = $base->conexion->prepare($sql_verificar);

        // Asociar los parámetros a la consulta
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contraseña, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Comprobar si se encontraron resultados
        if ($stmt->rowCount() == 1) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION["id"] = $fila["idUsuario"];
            $_SESSION["Nombre"] = $fila["Nombre"];
            $_SESSION["Apellido"] = $fila["Apellido"];

            // Redirigir según el perfil del usuario
            if ($fila["Perfil_idPerfil"] == 1) {
                header("Location: ../Usuario/usuario.php");
                exit();
            }
            if ($fila["Perfil_idPerfil"] == 2) {
                header("Location: ../Encargado.php");
                exit();
            }
            if ($fila["Perfil_idPerfil"] == 3) {
                header("Location: ../Jefatura.php");
                exit();
            }
        } else {
            // Si no se encuentran resultados, redirigir con un error
            header("Location: ../index.php?error=credenciales_invalidas");
            exit();
        }
    }
} catch (PDOException $e) {
    // Si ocurre un error con la conexión o la consulta, mostrar el mensaje de error
    die("Error en la conexión: " . $e->getMessage());
}
?>
