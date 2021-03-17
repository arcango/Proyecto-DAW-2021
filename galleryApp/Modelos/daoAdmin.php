<?php

require_once("./classes/classAdmin.php");

require_once("./classes/classGaleria.php");
require_once("./classes/classEncargado.php");
require_once("./conexion/Connection.php");

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

    function listarEncargados()
    {

        $query = "SELECT e.id_encargado, e.nombre_encargado, e.activo, g.nombre_galeria
        FROM encargado e
        INNER JOIN museo_galeria g ON e.encargado_id_galeria = g.id_galeria";

        $this->Query($query, array());

        $html = '';
        $html .= '<table class="tabla">';
        $html .= '<thead class="t-head"><tr><th>Selección</th><th>Id Encargado</th><th>Nombre Encargado</th><th>Nombre Galería</th><th>Activo</th></tr></thead>';
        
        foreach ($this->returnData as $row) {
            $encargado = new Encargado();
            $galeria = new Galeria();
            
            $encargado->__SET("id_encargado", $row["id_encargado"]);
            $encargado->__SET("nombre_encargado", $row["nombre_encargado"]);
            $encargado->__SET("activo", $row["activo"]);
            $galeria->__SET("nombre_galeria", $row["nombre_galeria"]);
 
            $html .= "<tr><td class='td-check'><input type='checkbox' name='check[]' value='$encargado->id_encargado' class='form-control'></td>";
            $html .= "<th>$encargado->id_encargado</th><th>$encargado->nombre_encargado</th><th>$galeria->nombre_galeria</th><td><input type='text' name='activo$encargado->id_encargado' placeholder='$encargado->activo' class='form-control'></td></tr>";
            
        }
        $html .= "</table>";
        echo $html;
    }

}

?>