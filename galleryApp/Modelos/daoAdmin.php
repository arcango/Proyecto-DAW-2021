<?php

require_once("./classes/classAdmin.php");

class DaoAdmin extends Conexion
{

    public function validarLogin($nombre, $password)
    {
        $query = "SELECT * FROM admin WHERE nombre = :nombre AND password = :password";

        $parameter = array(":nombre" => $nombre,
                            ":password" => $password);

        $this->Query($query, $parameter);

        $admin = new Admin();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $admin->__SET("nombre", $row["nombre"]);
            $admin->__SET("password", $row["password"]);

            return $admin;
        } else {
            return false;
        }
    }

}


?>