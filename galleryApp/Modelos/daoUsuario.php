<?php

// Entidades
require_once("./classes/classUsuario.php");
// Datos de la conexión a la base de datos
require_once("./conexion/Connection.php");

class DaoUsuario extends Conexion
{

    // Array de objetos Usuario
    public $Usuarios = array();

    public function listar()
    {
        // vaciamos el array
        $this->Usuarios = array();

        $query = "SELECT * FROM usuario";
        $this->Query($query, array());

        foreach ($this->returnData as $row) {
            $usuario = new Usuario();

            $usuario->__SET("id_usuario", $row["id_usuario"]);
            $usuario->__SET("nombre_usuario", $row["nombre_usuario"]);
            $usuario->__SET("email_usuario", $row["email_usuario"]);
            $usuario->__SET("mensaje_usuario", $row["mensaje_usuario"]);

            $this->Usuarios[] = $usuario;
        }
    }

    public function obtenerUsuario($id)
    {
        $query = "SELECT * FROM usuario WHERE id_usuario = :id_usuario";

        $parameter = array(":id_usuario" => $id);

        $this->Query($query, $parameter);

        $usuario = new Usuario();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $usuario->__SET("id_usuario", $row["id_usuario"]);
            $usuario->__SET("nombre_usuario", $row["nombre_usuario"]);
            $usuario->__SET("email_usuario", $row["email_usuario"]);
            $usuario->__SET("mensaje_usuario", $row["mensaje_usuario"]);
        }

        return $usuario;
    }

    public function insertar($usuario)
    {
        $query = "INSERT INTO usuario (nombre_usuario, email_usuario, mensaje_usuario)
        VALUES (:nombre_usuario, :email_usuario, :mensaje_usuario)";

        $parameter = array(
            ":nombre_usuario" => $usuario->__GET("nombre_usuario"),
            ":email_usuario" => $usuario->__GET("email_usuario"),
            ":mensaje_usuario" => $usuario->__GET("mensaje_usuario")
        );
        $this->Query($query, $parameter);
    }

    public function actualizar($usuario)
    {
        $query = "UPDATE usuario SET nombre_usuario=:nombre_usuario, email_usuario=:email_usuario, mensaje_usuario=:mensaje_usuario
        WHERE id_usuario=:id_usuario";

        $parameter = array(
            "id_usuario" => $usuario->__GET("id_usuario"),
            ":nombre_usuario" => $usuario->__GET("nombre_usuario"),
            ":email_usuario" => $usuario->__GET("email_usuario"),
            ":mensaje_usuario" => $usuario->__GET("mensaje_usuario")
        );
        $this->Query($query, $parameter);
    }

    public function eliminar($id_usuario)
    {
        $query = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
        $parameter = array(":id_usuario"=>$id_usuario);
        $this->Query($query, $parameter);
    }
}