<?php
require_once 'db.php';

class query
{

    public function __construct()
    {
        // Constructor vacío
    }

    public function cargarrequerimiento($id)
    {

        $base = new db();
        $sql_verificar = "select idrequerimiento, 
                            Titulo,
                            Descripcion,
                            fecha,
                            sc.NombreSub,
                            es.NombreEstado, 
                            Imagen,
                            c.NombreCategoria,
                            year(fecha) as ano
                            from requerimiento r
                            join estados es on es.idEstados= r.Estados_idEstados
                            join subcategoria sc on sc.idSubCategoria=r.SubCategoria_idSubCategoria
                            join categoria c on c.idCategoria=sc.Categoria_idCategoria
                            where Usuario_idUsuario=:id
                            order by fecha desc";

        // Preparar la consulta utilizando la conexión de la clase db
        $stmt = $base->conexion->prepare($sql_verificar);

        // Asociar los parámetros a la consulta
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function RequerimientosPendientes()
    {

        $base = new db();
        $sql_verificar = "select idrequerimiento, 
                            Titulo,
                            Descripcion,
                            fecha,
                            sc.NombreSub,
                            es.NombreEstado, 
                            Imagen,
                            c.NombreCategoria,
                            year(fecha) as ano
                            from requerimiento r
                            join estados es on es.idEstados= r.Estados_idEstados
                            join subcategoria sc on sc.idSubCategoria=r.SubCategoria_idSubCategoria
                            join categoria c on c.idCategoria=sc.Categoria_idCategoria
                            where es.idEstados=1
                            order by fecha desc";

        // Preparar la consulta utilizando la conexión de la clase db
        $stmt = $base->conexion->prepare($sql_verificar);
        // Ejecutar la consulta
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }
    


    public function Estados()
    {

        $base = new db();
        $sql_verificar = "select NombreEstado from estados";
        $stmt = $base->conexion->prepare($sql_verificar);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function Ubicacion()
    {

        $base = new db();
        $sql_verificar = "select * from ubicacion order by NombreUbicacion asc";
        $stmt = $base->conexion->prepare($sql_verificar);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
    public function Categoria()
    {

        $base = new db();
        $sql_verificar = "select * from categoria order by NombreCategoria asc";
        $stmt = $base->conexion->prepare($sql_verificar);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
    public function subCategoria($idCate)
    {

        $base = new db();
        $sql_verificar = "select * from subcategoria where Categoria_idCategoria=:id";
        $stmt = $base->conexion->prepare($sql_verificar);
        $stmt->bindParam(':id', $idCate, PDO::PARAM_STR);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function guardarSolicitud($titulo, $descripcion, $imagen, $idUsuario,
    $idUbicacion, $idCategoria, $idSubcategoria)
{
    $base = new db();
    $sql = "INSERT INTO requerimiento
            (Titulo, Descripcion, Imagen, fecha, Notificacion, Usuario_idUsuario, Estados_idEstados,
            Proveedor_idProveedor, Ubicacion_idUbicacion, SubCategoria_idSubCategoria, Categoria_idCategoria)
            VALUES
            (:titulo, :descripcion, :imagen, NOW(), 1, :idUsuario, 1,
            1, :idUbicacion, :idSubcategoria, :idCategoria)";
    
    try {
        $stmt = $base->conexion->prepare($sql);
        
        // Enlazar los parámetros correctamente
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':idUbicacion', $idUbicacion, PDO::PARAM_INT);
        $stmt->bindParam(':idSubcategoria', $idSubcategoria, PDO::PARAM_INT);
        $stmt->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
        
        $stmt->execute();
        $base->conexion->commit();
        
        // Opcional: Verificar cuántas filas fueron afectadas
        return $stmt->rowCount();
        
    } catch (PDOException $e) {
        // Manejo del error
        error_log("Error en guardarSolicitud: " . $e->getMessage());
        return false;
    }
}

}
