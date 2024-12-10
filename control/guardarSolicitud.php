<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "query.php";
$contiene = new query();
// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ruta donde se guardarán las imágenes
    $uploadDir = 'imagenes/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Procesar datos del formulario
    $title = $_POST['title'] ?? '';
    $location = $_POST['location'] ?? '';
    $category = $_POST['category'] ?? '';
    $subcategory = $_POST['subcategory'] ?? '';
    $description = $_POST['description'] ?? '';

    // Inicializar un array para guardar las rutas de las imágenes subidas
    $uploadedFiles = [];

    // Verificar si hay imágenes subidas
    if (isset($_FILES['photos']) && !empty($_FILES['photos']['tmp_name'][0])) {
        // Procesar cada imagen
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                // Obtener el nombre original del archivo
                $originalName = $_FILES['photos']['name'][$key];
                // Generar un nombre único para evitar colisiones
                $uniqueName = uniqid() . "_" . basename($originalName);
                // Ruta destino del archivo
                $targetFile = $uploadDir . $uniqueName;

                // Mover el archivo desde la ubicación temporal a la carpeta destino
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $uploadedFiles[] = $targetFile; // Guardar la ruta del archivo subido
                } else {
                    echo "Error al subir la imagen $originalName.<br>";
                }
            } else {
                echo "Error al procesar la imagen {$key}. Código de error: " . $_FILES['photos']['error'][$key] . "<br>";
            }
        }
    } else {
        echo "<p>No se recibieron imágenes para procesar.</p>";
    }

    // Mostrar datos del formulario y rutas de imágenes
    echo "<h2>Formulario Enviado</h2>";
    echo "<p><strong>Título:</strong> $title</p>";
    echo "<p><strong>Ubicación:</strong> $location</p>";
    echo "<p><strong>Categoría:</strong> $category</p>";
    echo "<p><strong>Subcategoría:</strong> $subcategory</p>";
    echo "<p><strong>Descripción:</strong> $description</p>";
    if (!empty($uploadedFiles)) {
        foreach ($uploadedFiles as $file) {
            $ruta="../control/".$file;
        }
    } else {
        echo "<p>No se subieron imágenes.</p>";
    }
    $idUsuario=htmlspecialchars($_SESSION["id"]);

    $resultado= $contiene->guardarSolicitud($title,$description, $ruta,$idUsuario,$location,$category,$subcategory);

if ($resultado > 0) {
        echo "Requerimiento guardado correctamente.";

    } else {
        echo "No se pudo guardar el requerimiento.";
        header("Location: ../Usuario/usuario.php");
    }
    //header("Location: ../Usuario/usuario.php");






} else {
    echo "Método no permitido.";
}
?>
