<?php

// Entidades
require_once("./classes/classExposicion.php");
require_once("./classes/classObra.php");
require_once("./classes/classArtista.php");
// Datos de la conexión a la base de datos
require_once("./conexion/Connection.php");

class DaoExposicion extends Conexion
{

    // Array de objetos Exposicion
    public $Exposiciones = array();
    public $Artistas = array();
    public $Obras = array();

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
            $exposicion->__SET("texto_exposicion", $row["texto_exposicion"]);

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
            $exposicion->__SET("texto_exposicion", $row["texto_exposicion"]);
        }

        return $exposicion;
    }

    public function listarYPrintarExposicionDeGaleria($id_galeria)
    {
        $queryExpo = "SELECT * FROM exposicion WHERE galeria_id_galeria = :galeria_id_galeria";
        $queryArtista = "SELECT * FROM artista a JOIN exposicion e ON a.id_artista = e.galeria_id_artista WHERE e.galeria_id_galeria = :galeria_id_galeria";
        $queryObra = "SELECT * FROM obra o JOIN exposicion e ON o.obra_id_artista = e.galeria_id_artista WHERE e.galeria_id_galeria = :galeria_id_galeria";

        $parameter = array(":galeria_id_galeria" => $id_galeria);

        $this->Query($queryExpo, $parameter);

        if (count($this->returnData) === 0) {
            echo '<h2>No tienes todavía ninguna exposición</h2>';
        } else {
            foreach($this->returnData as $row) {
                $exposicion = new Exposicion();

                $exposicion->__SET("id_exposicion", $row["id_exposicion"]);
                $exposicion->__SET("galeria_id_galeria", $row["galeria_id_galeria"]);
                $exposicion->__SET("galeria_id_artista", $row["galeria_id_artista"]);
                $exposicion->__SET("nombre_exposicion", $row["nombre_exposicion"]);
                $exposicion->__SET("fecha_inicio", $row["fecha_inicio"]);
                $exposicion->__SET("fecha_fin", $row["fecha_fin"]);
                $exposicion->__SET("cartel", $row["cartel"]);
                $exposicion->__SET("descripcion_cartel", $row["descripcion_cartel"]);
                $exposicion->__SET("texto_exposicion", $row["texto_exposicion"]);
            
                $this->Exposiciones[] = $exposicion;
            
            }
            
            $this->Query($queryArtista, $parameter);
            foreach($this->returnData as $row) {

                $artista = new Artista();

                $artista->__SET("id_artista", $row["id_artista"]);
                $artista->__SET("nombre_artista", $row["nombre_artista"]);
                $artista->__SET("pagina_personal", $row["pagina_personal"]);
                $artista->__SET("email", $row["email"]);
                $artista->__SET("telefono", $row["telefono"]);
                $artista->__SET("descripcion", $row["descripcion"]);

                $this->Artistas[] = $artista;
            }

            $this->Query($queryObra, $parameter);
            foreach($this->returnData as $row) {
                $obra = new Obra();

                $obra->__SET("id_obra", $row["id_obra"]);
                $obra->__SET("obra_id_artista", $row["obra_id_artista"]);
                $obra->__SET("nombre", $row["nombre"]);
                $obra->__SET("descripcion", $row["descripcion"]);
                $obra->__SET("descripcion_alt", $row["descripcion_alt"]);
                $obra->__SET("imagen", $row["imagen"]);

                $this->Obras[] = $obra;
            }

            $html = '';
            foreach($this->Exposiciones as $exposicion) {
            $html .= '<table class="tabla">';
            $html .= '<thead><tr><th >Selección</th><th>Id Exposición</th><th>Nombre Exposición</th><th>Fecha de Inicio</th><th>Fecha de Finalización</th><th>Cartel</th><th>Cambiar Cartel</th><th>Descripción del Cartel</th></tr></thead>';
                $id_expo = $exposicion->id_exposicion;
                $html .= "<tr><td><input type='checkbox' name='check[]' value='$id_expo' class='form-control'></td>";
                $html .= "<th>$id_expo</th>";
                $html .= "<td><input type='text' name='nombre_exposicion$id_expo' value='$exposicion->nombre_exposicion' class='form-control'></td>";
                $html .= "<td><input type='date' name='fecha_inicio$id_expo' value='$exposicion->fecha_inicio' class='form-control'></td>";
                $html .= "<td><input type='date' name='fecha_fin$id_expo' value='$exposicion->fecha_fin' class='form-control'></td>";
                $html .= "<th><a class='thickbox' href='carteles/$exposicion->cartel'><img style='max-width: 20%' src='carteles/$exposicion->cartel' href='$exposicion->descripcion_cartel'/></a></th>";
                $html .= "<td><input type='file' name='cartel$id_expo' value='$exposicion->cartel' class='form-control'></td>";
                $html .= "<td><input type='text' name='descripcion_cartel$id_expo' value='$exposicion->descripcion_cartel' class='form-control'></td></tr>";
                $html .= "<tr><th colspan='8'>Texto de la exposición</th></tr>";
                $html .= "<tr><td colspan='8'><textarea name='texto_exposicion$id_expo' value='$exposicion->texto_exposicion' rows='20' cols='100' class='form-control'></textarea></td></tr>";
                $html .= "</table>";
            }

            echo $html;



            
        }

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
            ":descripcion_cartel" =>$exposicion->__GET("descripcion_cartel"),
            ":texto_exposicion" =>$exposicion->__GET("texto_exposicion")
        );
        $this->Query($query, $parameter);
    }

    public function actualizar($exposicion)
    {
        $query = "UPDATE exposicion SET galeria_id_galeria=:galeria_id_galeria, nombre_exposicion=:nombre_exposicion, nombre_usuario=:nombre_usuario,
        fecha_inicio=:fecha_inicio, fecha_fin=:fecha_fin, cartel=:cartel, descripcion_cartel=:descripcion_cartel, texto_exposicion=:texto_exposicion WHERE id_exposicion=:id_exposicion";

        $parameter = array(
            ":galeria_id_galeria" => $exposicion->__GET("galeria_id_galeria"),
            ":galeria_id_artista" => $exposicion->__GET("galeria_id_artista"),
            ":nombre_exposicion" => $exposicion->__GET("nombre_exposicion"),
            ":fecha_inicio" => $exposicion->__GET("fecha_inicio"),
            ":fecha_fin" => $exposicion->__GET("fecha_fin"),
            ":cartel" => $exposicion->__GET("cartel"),
            ":descripcion_cartel" =>$exposicion->__GET("descripcion_cartel"),
            ":texto_exposicion" =>$exposicion->__GET("texto_exposicion"),
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
