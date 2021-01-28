<?php

// Entidades
require_once("./classes/classExposicion.php");
// Datos de la conexión a la base de datos
require_once("./conexion/Connection.php");

class DaoExposicion extends Conexion
{

    // Array de objetos Exposicion
    public $Exposiciones = array();

    public function listar()
    {
        // vaciamos el array
        $this->Exposiciones = array();

        $query = "SELECT * FROM exposicion";
        $this->Query($query, array());

        foreach ($this->returnData as $row) {
            $exposicion = new Exposicion();

            $exposicion->__SET("id_exposicion", $row["id_exposicion"]);
            $exposicion->__SET("galeria_id_galeria", $row["galeria_id_galeria"]);
            $exposicion->__SET("galeria_id_artista", $row["galeria_id_artista"]);
            $exposicion->__SET("nombre_exposicion", $row["nombre_exposicion"]);
            $exposicion->__SET("fecha_inicio", $row["fecha_inicio"]);
            $exposicion->__SET("fecha_fin", $row["fecha_fin"]);
            $exposicion->__SET("cartel", $row["cartel"]);
            $exposicion->__SET("descripcion_cartel", $row["descripcion_cartel"]);

            $this->Exposiciones[] = $exposicion;
        }
    }

    public function obtenerExposicion($id)
    {
        $query = "SELECT * FROM exposicion WHERE id_exposicion = :id_exposicion";

        $parameter = array(":id_exposicion" => $id);

        $this->Query($query, $parameter);

        $exposicion = new Exposicion();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $exposicion->__SET("id_exposicion", $row["id_exposicion"]);
            $exposicion->__SET("galeria_id_galeria", $row["galeria_id_galeria"]);
            $exposicion->__SET("galeria_id_artista", $row["galeria_id_artista"]);
            $exposicion->__SET("nombre_exposicion", $row["nombre_exposicion"]);
            $exposicion->__SET("fecha_inicio", $row["fecha_inicio"]);
            $exposicion->__SET("fecha_fin", $row["fecha_fin"]);
            $exposicion->__SET("cartel", $row["cartel"]);
            $exposicion->__SET("descripcion_cartel", $row["descripcion_cartel"]);
        }

        return $exposicion;
    }

    public function insertar($exposicion)
    {
        $query = "INSERT INTO exposicion (galeria_id_galeria, galeria_id_artista, nombre_exposicion, fecha_inicio, fecha_fin, cartel, descripcion_cartel)
        VALUES (:galeria_id_galeria, :galeria_id_artista, :nombre_exposicion, :fecha_inicio, :fecha_fin, :cartel, :descripcion_cartel)";

        $parameter = array(
            ":galeria_id_galeria" => $exposicion->__GET("galeria_id_galeria"),
            ":galeria_id_artista" => $exposicion->__GET("galeria_id_artista"),
            ":nombre_exposicion" => $exposicion->__GET("nombre_exposicion"),
            ":fecha_inicio" => $exposicion->__GET("fecha_inicio"),
            ":fecha_fin" => $exposicion->__GET("fecha_fin"),
            ":cartel" => $exposicion->__GET("cartel"),
            ":descripcion_cartel" =>$exposicion->__GET("descripcion_cartel")
        );
        $this->Query($query, $parameter);
    }

    public function actualizar($exposicion)
    {
        $query = "UPDATE exposicion SET galeria_id_galeria=:galeria_id_galeria, nombre_exposicion=:nombre_exposicion, nombre_usuario=:nombre_usuario,
        fecha_inicio=:fecha_inicio, fecha_fin=:fecha_fin, cartel=:cartel, descripcion_cartel=:descripcion_cartel WHERE id_exposicion=:id_exposicion";

        $parameter = array(
            ":galeria_id_galeria" => $exposicion->__GET("galeria_id_galeria"),
            ":galeria_id_artista" => $exposicion->__GET("galeria_id_artista"),
            ":nombre_exposicion" => $exposicion->__GET("nombre_exposicion"),
            ":fecha_inicio" => $exposicion->__GET("fecha_inicio"),
            ":fecha_fin" => $exposicion->__GET("fecha_fin"),
            ":cartel" => $exposicion->__GET("cartel"),
            ":descripcion_cartel" =>$exposicion->__GET("descripcion_cartel"),
            ":id_exposicion" => $exposicion->__GET("id_exposicion")
        );
        $this->Query($query, $parameter);
    }

    public function eliminar($id_exposicion)
    {
        $query = "DELETE FROM exposicion WHERE id_exposicion = :id_exposicion";
        $parameter = array(":id_exposicion"=>$id_exposicion);
        $this->Query($query, $parameter);
    }
}
