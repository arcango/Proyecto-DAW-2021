<?php

// Entidades
require_once("./classes/classObra.php");
require_once("./classes/classArtista.php");
// Datos de la conexión a la base de datos
require_once("./conexion/Connection.php");

class DaoObra extends Conexion
{

    // Array de objetos Obra
    public $Obras = array();
    public $Artistas = array();

    public function listar()
    {
        // vaciamos el array
        $this->Obras = array();

        $query = "SELECT * FROM obra";
        $this->Query($query, array());

        foreach ($this->returnData as $row) {
            $obra = new Obra();

            $obra->__SET("id_obra", $row["id_obra"]);
            $obra->__SET("obra_id_artista", $row["obra_id_artista"]);
            $obra->__SET("nombre", $row["nombre"]);
            $obra->__SET("descripcion", $row["descripcion"]);
            $obra->__SET("descripcion_alt", $row["descripcion_alt"]);
            $obra->__SET("imagen", $row["imagen"]);

            $this->Obras[] = $obra;
        }

    }

    public function listarYPrintarObras($array) {

        // vaciamos el array
        $this->Obras = array();
        $this->Artistas = array();
  
        foreach($array as $id) {

            $query = "SELECT a.id_artista, a.nombre_artista, o.obra_id_artista, o.id_obra, o.nombre, 
            o.descripcion, o.descripcion_alt, o.imagen 
            FROM obra o
            INNER JOIN artista a
            ON o.obra_id_artista = a.id_artista
            WHERE id_artista = $id
            GROUP BY id_artista";
            $this->Query($query, array());  
            foreach ($this->returnData as $row) {
                $artista = new Artista();

                $artista->__SET("id_artista", $row["id_artista"]);
                $artista->__SET("nombre_artista", $row["nombre_artista"]);

                $this->Artistas[] = $artista;
            }

            $query2 = "SELECT a.id_artista, a.nombre_artista, o.obra_id_artista, o.id_obra, o.nombre, 
            o.descripcion, o.descripcion_alt, o.imagen 
            FROM obra o
            INNER JOIN artista a
            ON o.obra_id_artista = a.id_artista
            WHERE id_artista = $id";
            $this->Query($query2, array());
            
            foreach ($this->returnData as $row) {
        
                $obra = new Obra();

                $obra->__SET("id_obra", $row["id_obra"]);
                $obra->__SET("obra_id_artista", $row["obra_id_artista"]);
                $obra->__SET("nombre", $row["nombre"]);
                $obra->__SET("descripcion", $row["descripcion"]);
                $obra->__SET("descripcion_alt", $row["descripcion_alt"]);
                $obra->__SET("imagen", $row["imagen"]);

                $this->Obras[] = $obra;
                
            }
            
        }

        $html = '';
        $html .= '<h3 style="text-align: center">Pulsa sobre las imágenes para ampliar</h3></br>';
        $html .= '<table class="tabla">';
        $html .= '<thead><tr><th >Selección</th><th>Id Obra</th><th>Nombre Obra</th><th>Id Artista</th><th>Nombre Artista</th><th>Descripción</th><th>Descripción Alternativa</th><th>Imagen</th><th>Inserta Imagen</th></thead>';

        foreach($this->Obras as $obra) {
            $id_obra = $obra->id_obra;
            $html .= "<tr><td><input type='checkbox' name='check[]' value='$id_obra' class='form-control'></td>";
            $html .= "<th>$id_obra</th>";
            $html .= "<td><input type='text' name='nombre_obra$id_obra' value='$obra->nombre' class='form-control'></td>";
            
            foreach($this->Artistas as $artista) {
                if($artista->id_artista == $obra->obra_id_artista) {
                    $id_artista = $artista->id_artista;
                    $html .= "<input type='hidden' name='obra_id_artista$id_obra' value='$id_artista'>";
                    $html .= "<th>$id_artista</th>";
                    $html .= "<th>$artista->nombre_artista</th>";
                    $html .= "<td><textarea name='descripcion$id_obra' value='$obra->descripcion' class='form-control'>$obra->descripcion</textarea></td>";
                    $html .= "<td><input type='text' name='descripcion_alt$id_obra' value='$obra->descripcion_alt' class='form-control'></td>";
                    /* Esta línea trabaja junto a los scripts cargados para managementObras.view.php página para poder ampliar las fotos una vez se hace click en ellas
                    para poder ver mejor su contenido */
                    $html .= "<th><a class='thickbox' href='imagenesEsculturas/$obra->imagen'><img style='max-width: 20%' src='imagenesEsculturas/$obra->imagen' href='$obra->descripcion_alt'/></a></th>";
                    $html .= "<input type='hidden' name='imagen$id_obra' value='$obra->imagen'>";
                    $html .= "<td><input type='file' name='imagen$id_obra' value='$obra->imagen' class='form-control'></td>";
                }
            }
        }

        $html .= "<tr><th>Nueva Obra: </th>";
        $html .= "<th></th>";
        $html .= "<td><input type='text' name='i_nombre' class='form-control'></td>";
        $html .= "<td><input type='text' name='i_id_artista' class='form-control'></td>";
        $html .= "<th></th>";
        $html .= "<td><textarea name='i_descripcion' class='form-control'></textarea></td>";
        $html .= "<td><input type='text' name='i_descripcion_alt' class='form-control'></td>";
        $html .= "<td><input type='file' name='i_imagen' class='form-control'></td>";
        $html .= "</table>";
        echo $html;
       
    }

    public function obtenerObra($id)
    {
        $query = "SELECT * FROM obra WHERE id_obra = :id_obra";

        $parameter = array(":id_obra" => $id);

        $this->Query($query, $parameter);

        $obra = new Obra();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $obra->__SET("id_obra", $row["id_obra"]);
            $obra->__SET("obra_id_artista", $row["obra_id_artista"]);
            $obra->__SET("nombre", $row["nombre"]);
            $obra->__SET("descripcion", $row["descripcion"]);
            $obra->__SET("descripcion_alt", $row["descripcion_alt"]);
            $obra->__SET("imagen", $row["imagen"]);
        }

        return $obra;
    }

    public function obtenerNombreObra($array)
    {
        $this->Artistas = array();

        foreach($array as $id) {

            $query = "SELECT nombre FROM obra
            WHERE id_obra = $id";
            $this->Query($query, array());
            foreach ($this->returnData as $row) {
                $obra = new Obra();

                $obra->__SET("nombre", $row["nombre"]);
                
                $this->Obras[] = $obra;
            }
        }
        foreach ($this->Obras as $artista) {
            echo($obra->nombre);
        }
    }

    public function insertar($obra)
    {
        $query = "INSERT INTO obra (obra_id_artista, nombre, descripcion, descripcion_alt, imagen)
        VALUES (:obra_id_artista, :nombre, :descripcion, :descripcion_alt, :imagen)";

        $parameter = array(
            ":obra_id_artista" => $obra->__GET("obra_id_artista"),
            ":nombre" => $obra->__GET("nombre"),
            ":descripcion" => $obra->__GET("descripcion"),
            ":descripcion_alt" => $obra->__GET("descripcion_alt"),
            ":imagen" => $obra->__GET("imagen"),
        );
        $this->Query($query, $parameter);
    }

    public function actualizar($obra)
    {
        $query = "UPDATE obra SET obra_id_artista=:obra_id_artista, nombre=:nombre, descripcion=:descripcion,
        descripcion_alt=:descripcion_alt, imagen=:imagen WHERE id_obra=:id_obra";

        $parameter = array(
            ":obra_id_artista" => $obra->__GET("obra_id_artista"),
            ":nombre" => $obra->__GET("nombre"),
            ":descripcion" => $obra->__GET("descripcion"),
            ":descripcion_alt" => $obra->__GET("descripcion_alt"),
            ":imagen" => $obra->__GET("imagen"),
            ":id_obra" => $obra->__GET("id_obra")
        );
        $this->Query($query, $parameter);
    }

    public function eliminar($id_obra)
    {
        $query = "DELETE FROM obra WHERE id_obra = :id_obra";
        $parameter = array(":id_obra"=>$id_obra);
        $this->Query($query, $parameter);
    }

}