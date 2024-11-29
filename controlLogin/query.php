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
}
