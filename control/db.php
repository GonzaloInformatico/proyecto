<?php
// db.php
class db {

    public $conexion;

    public function __construct() {
        try {
            // Asignamos la conexión a la propiedad de la clase
            $this->conexion = new PDO('mysql:host=localhost;dbname=SitransMantencion', 'root', '1234');
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }

    // PDO - seguro -- USAR
    public function ejecutar_pdo($sql, $parametros)  {
        $resultado = $this->conexion->prepare($sql);
        
        // Vinculamos los parámetros en la consulta
        if (sizeof($parametros)) {
            // Suponiendo que todos los parámetros son cadenas
            $tipos = str_repeat("s", sizeof($parametros));  
            // Vinculamos los parámetros utilizando bindParam o bindValue
            foreach ($parametros as $key => $parametro) {
                $resultado->bindValue($key + 1, $parametro, PDO::PARAM_STR); // Usamos bindValue
            }
        }

        $resultado->execute();
        return $resultado;
    }

    public function cerrar() {
        $this->conexion = null;
    }
}
?>
