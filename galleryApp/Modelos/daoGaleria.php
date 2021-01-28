<?php

// Entidades
require_once("./classes/classGaleria.php");
// Datos de la conexión a la base de datos
require_once("./conexion/Connection.php");

class DaoGaleria extends Conexion
{

    // Array de objetos Galeria
    public $Galerias = array();

    public function listar()
    {
        // vaciamos el array
        $this->Galerias = array();

        $query = "SELECT * FROM museo_galeria";
        $this->Query($query, array());

        foreach ($this->returnData as $row) {
            $galeria = new Galeria();

            $galeria->__SET("id_galeria", $row["id_galeria"]);
            $galeria->__SET("nombre_galeria", $row["nombre_galeria"]);
            $galeria->__SET("direccion", $row["direccion"]);
            $galeria->__SET("provincia", $row["provincia"]);
            $galeria->__SET("localidad", $row["localidad"]);
            $galeria->__SET("telefono", $row["telefono"]);
            $galeria->__SET("email", $row["email"]);

            $this->Galerias[] = $galeria;
        }
    }

    public function obtenerIdGaleria($nombre)
    {
        $query = "SELECT id_galeria FROM museo_galeria WHERE nombre_galeria = :nombre_galeria";

        $parameter = array(":nombre_galeria" => $nombre);
        
        $this->Query($query, $parameter);

        $galeria = new Galeria();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $galeria->__SET("id_galeria", $row["id_galeria"]);
            return $galeria;
        } else {
            return false;
        }
    }
    
    public function obtenerTlfGaleria($telefono)
    {
        $query = "SELECT id_galeria FROM museo_galeria WHERE telefono = :telefono";

        $parameter = array(":telefono" => $telefono);
        
        $this->Query($query, $parameter);

        $galeria = new Galeria();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $galeria->__SET("id_galeria", $row["id_galeria"]);
            return $galeria;
        } else {
            return false;
        }
    }

    public function obtenerGaleria($id)
    {
        $query = "SELECT * FROM museo_galeria WHERE id_galeria = :id_galeria";

        $parameter = array(":id_galeria" => $id);

        $this->Query($query, $parameter);

        $galeria = new Galeria();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $galeria->__SET("id_galeria", $row["id_galeria"]);
            $galeria->__SET("nombre_galeria", $row["nombre_galeria"]);
            $galeria->__SET("direccion", $row["direccion"]);
            $galeria->__SET("provincia", $row["provincia"]);
            $galeria->__SET("localidad", $row["localidad"]);
            $galeria->__SET("telefono", $row["telefono"]);
            $galeria->__SET("email", $row["email"]);
            return $galeria;
        } else {
            return false;
        }
    }

    public function insertar($galeria)
    {
        $query = "INSERT INTO museo_galeria (nombre_galeria, direccion, provincia, localidad, telefono, email)
        VALUES (:nombre_galeria, :direccion, :provincia, :localidad, :telefono, :email)";

        $parameter = array(
            ":nombre_galeria" => $galeria->__GET("nombre_galeria"),
            ":direccion" => $galeria->__GET("direccion"),
            ":provincia" => $galeria->__GET("provincia"),
            ":localidad" => $galeria->__GET("localidad"),
            ":telefono" => $galeria->__GET("telefono"),
            ":email" => $galeria->__GET("email")
        );
        $this->Query($query, $parameter);
    }

    public function actualizar($galeria)
    {
        $query = "UPDATE museo_galeria SET nombre_galeria=:nombre_galeria, direccion=:direccion, provincia=:provincia,
        localidad=:localidad, telefono=:telefono, email=:email WHERE id_galeria=:id_galeria";

        $parameter = array(
            ":nombre_galeria" => $galeria->__GET("nombre_galeria"),
            ":direccion" => $galeria->__GET("direccion"),
            ":provincia" => $galeria->__GET("provincia"),
            ":localidad" => $galeria->__GET("localidad"),
            ":telefono" => $galeria->__GET("telefono"),
            ":email" => $galeria->__GET("email"),
            ":id_galeria" => $galeria->__GET("id_galeria")
        );
        $this->Query($query, $parameter);
    }

    public function eliminar($id_galeria)
    {
        $query = "DELETE FROM museo_galeria WHERE id_galeria = :id_galeria";
        $parameter = array(":id_galeria"=>$id_galeria);
        $this->Query($query, $parameter);
    }
}
