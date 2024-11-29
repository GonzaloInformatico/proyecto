<?php
session_start();

try {
    $conexion = new PDO('mysql:host=localhost;dbname=SitransMantencion', 'root', '1234');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = $_POST["usuario"];
        $contraseña = $_POST["password"];

        $sql_verificar = "SELECT * FROM usuario WHERE Correo = :correo AND Contrasenna = :contrasena";
        $stmt = $conexion->prepare($sql_verificar);

        // Asociamos los parámetros a las variables
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contraseña, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION["Nombre"] = $fila["Nombre"];
            $_SESSION["Apellido"] = $fila["Apellido"];


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
            header("Location: ../index.php?error=credenciales_invalidas");
            exit();
        }
    }
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
