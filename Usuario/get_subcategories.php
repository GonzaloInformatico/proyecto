<?php
require_once "../control/query.php";

$cadena = "";
if (isset($_POST["category_id"])) {
    $idCategoria = $_POST["category_id"];

    try {
        $query = new query();
        $subcategorias = $query->subCategoria($idCategoria);
        $cadena='<option value="">Seleccione subcategoría</option>';
        foreach ($subcategorias as $fila) {
            $cadena .= "<option value='" . $fila['idSubCategoria'] . "'>" . $fila['NombreSub'] . "</option>";
        }
        echo $cadena;

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Ocurrió un error en el servidor', 'details' => $e->getMessage()]);
    }
}

?>
