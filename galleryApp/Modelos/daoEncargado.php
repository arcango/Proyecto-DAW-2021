<?php

// Entidades
require_once("./classes/classEncargado.php");
// Datos de la conexión a la base de datos
require_once("./conexion/Connection.php");

class DaoEncargado extends Conexion
{

    // Array de objetos Encargado
    public $Encargados = array();

    public function listar()
    {
        // vaciamos el array
        $this->Encargados = array();

        $query = "SELECT * FROM encargado";
        $this->Query($query, array());

        foreach ($this->returnData as $row) {
            $encargado = new Encargado();

            $encargado->__SET("id_encargado", $row["id_encargado"]);
            $encargado->__SET("encargado_id_galeria", $row["encargado_id_galeria"]);
            $encargado->__SET("nombre_encargado", $row["nombre_encargado"]);
            $encargado->__SET("nombre_usuario", $row["nombre_usuario"]);
            $encargado->__SET("password_usuario", $row["password_usuario"]);
            $encargado->__SET("email", $row["email"]);
            $encargado->__SET("activo", $row["activo"]);

            $this->Encargados[] = $encargado;
        }

    }

    public function obtenerEncargado($id)
    {
        $query = "SELECT * FROM encargado WHERE id_encargado = :id_encargado";

        $parameter = array(":id_encargado" => $id);

        $this->Query($query, $parameter);

        $encargado = new Encargado();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $encargado->__SET("id_encargado", $row["id_encargado"]);
            $encargado->__SET("encargado_id_galeria", $row["encargado_id_galeria"]);
            $encargado->__SET("nombre_encargado", $row["nombre_encargado"]);
            $encargado->__SET("nombre_usuario", $row["nombre_usuario"]);
            $encargado->__SET("password_usuario", $row["password_usuario"]);
            $encargado->__SET("email", $row["email"]);
            $encargado->__SET("activo", $row["activo"]);

            return $encargado;
        } else {
            return false;
        }
    }

    

    public function validarLogin($nombre_usuario, $password_usuario)
    {
        $query = "SELECT id_encargado, encargado_id_galeria, nombre_encargado, activo FROM encargado WHERE nombre_usuario = :nombre_usuario AND password_usuario = :password_usuario";

        $parameter = array(":nombre_usuario" => $nombre_usuario,
                            ":password_usuario" => $password_usuario );

        $this->Query($query, $parameter);

        $encargado = new Encargado();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $encargado->__SET("id_encargado", $row["id_encargado"]);
            $encargado->__SET("encargado_id_galeria", $row["encargado_id_galeria"]);
            $encargado->__SET("nombre_encargado", $row["nombre_encargado"]);
            $encargado->__SET("activo", $row["activo"]);
            
            return $encargado;
        } else {
            return false;
        }
    }

    public function obtenerNombreUsuario($nombre_usuario)
    {
        $query = "SELECT id_encargado FROM encargado WHERE nombre_usuario = :nombre_usuario";

        $parameter = array(":nombre_usuario" => $nombre_usuario);

        $this->Query($query, $parameter);

        $encargado = new Encargado();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $encargado->__SET("id_encargado", $row["id_encargado"]);
            
            return $encargado;
        } else {
            return false;
        }
    }

    public function insertar($encargado)
    {
        $query = "INSERT INTO encargado (encargado_id_galeria, nombre_encargado, nombre_usuario, password_usuario, email)
        VALUES (:encargado_id_galeria, :nombre_encargado, :nombre_usuario, :password_usuario, :email)";

        $parameter = array(
            ":encargado_id_galeria" => $encargado->__GET("encargado_id_galeria"),
            ":nombre_encargado" => $encargado->__GET("nombre_encargado"),
            ":nombre_usuario" => $encargado->__GET("nombre_usuario"),
            ":password_usuario" => $encargado->__GET("password_usuario"),
            ":email" => $encargado->__GET("email")
        );
        $this->Query($query, $parameter);
    }

    public function actualizar($encargado)
    {
        $query = "UPDATE encargado SET encargado_id_galeria=:encargado_id_galeria, nombre_encargado=:nombre_encargado, nombre_usuario=:nombre_usuario,
        password_usuario=:password_usuario, email=:email WHERE id_encargado=:id_encargado";

        $parameter = array(
            ":encargado_id_galeria" => $encargado->__GET("encargado_id_galeria"),
            ":nombre_encargado" => $encargado->__GET("nombre_encargado"),
            ":nombre_usuario" => $encargado->__GET("nombre_usuario"),
            ":password_usuario" => $encargado->__GET("password_usuario"),
            ":email" => $encargado->__GET("email"),
            ":id_encargado" => $encargado->__GET("id_encargado")
        );
        $this->Query($query, $parameter);
    }

    public function eliminar($id_encargado)
    {
        $queryEncargado = "DELETE FROM encargado WHERE id_encargado = :id_encargado";
        $parameter = array(":id_encargado"=>$id_encargado);
        $this->Query($queryEncargado, $parameter);
    }
}
