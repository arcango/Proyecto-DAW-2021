<?php
require_once("./classes/classObra.php");
require_once("./classes/classArtista.php");
require_once("./classes/classGaleria.php");
require_once("./classes/classExposicion.php");
require_once("./conexion/Connection.php");

class DaoBusqueda extends Conexion
{

    public $Obra = array();
    public $Artista = array();
    public $Galeria = array();
    public $Exposicion = array();


    public function listarYPrintarExposicionesBlog($provincia)
    {
        $html = '';


        $hoy = $_SESSION['hoy'];
        $parameter = array(":provincia" => $provincia);
        $this->Obra = array();
        $this->Artista = array();
        $this->Galeria = array();
        $this->Exposicion = array();
        // $hoy = date("Y-m-d");

        $query = "SELECT SQL_CALC_FOUND_ROWS g.nombre_galeria, g.direccion, g.localidad, g.provincia,
            g.telefono, g.g_map, e.id_exposicion, e.nombre_exposicion, e.fecha_inicio, e.fecha_fin, e.cartel,
            e.descripcion_cartel,e.texto_exposicion
            FROM museo_galeria g
            INNER JOIN exposicion e
            ON g.id_galeria = e.galeria_id_galeria
            WHERE g.provincia = :provincia
            AND e.fecha_fin > '$hoy'
            ORDER BY e.fecha_inicio";

        $parameter = array(":provincia" => $provincia);

        $this->Query($query, $parameter);
        foreach ($this->returnData as $row) {
            $exposicion = new Exposicion();

            $exposicion->__SET("id_exposicion", $row["id_exposicion"]);
            $exposicion->__SET("nombre_exposicion", $row["nombre_exposicion"]);
            $exposicion->__SET("fecha_inicio", $row["fecha_inicio"]);
            $exposicion->__SET("fecha_fin", $row["fecha_fin"]);
            $exposicion->__SET("cartel", $row["cartel"]);
            $exposicion->__SET("descripcion_cartel", $row["descripcion_cartel"]);

            $this->Exposicion[] = $exposicion;
        }
        foreach ($this->Exposicion as $exposicion) {
            $html .= "<div class='post'>";
            $html .= "<article>";
            $html .= "<h2 class='titulopost'><a href='single-post.php?id=$exposicion->id_exposicion'>$exposicion->nombre_exposicion</a></h2>";
            $html .= "<p class='fecha'>$exposicion->fecha_inicio - $exposicion->fecha_fin</p>";
            $html .= "<div class='thumb'>";
            $html .= "<a href='single-post.php?id=$exposicion->id_exposicion'>";
            $html .= "<img src='./carteles/$exposicion->cartel' alt='$exposicion->descripcion_cartel'>";
            $html .= "</a>";
            $html .= "</div>";
            $html .= "</article>";
            $html .= "</div>";
        }
        echo $html;
    }
    public function listarYPrintarExposicionesSingle($id)
    {
        $html = '';

        $hoy = $_SESSION['hoy'];
        $parameter = array(":id" => $id);
        $this->Obra = array();
        $this->Artista = array();
        $this->Galeria = array();
        $this->Exposicion = array();
        $hoy = date("Y-m-d");

        $query = "SELECT SQL_CALC_FOUND_ROWS g.nombre_galeria, g.direccion, g.localidad, g.provincia,
            g.telefono, g.g_map, e.id_exposicion, e.nombre_exposicion, e.fecha_inicio, e.fecha_fin, e.cartel,
            e.descripcion_cartel,e.texto_exposicion, a.nombre_artista, a.pagina_personal,
            o.nombre, o.descripcion, o.descripcion_alt, o.imagen
            FROM museo_galeria g
            INNER JOIN exposicion e
            ON g.id_galeria = e.galeria_id_galeria
            INNER JOIN artista a
            ON e.galeria_id_artista = a.id_artista
            INNER JOIN obra o
            ON a.id_artista = o.obra_id_artista
            WHERE e.id_exposicion = :id_exposicion
            AND e.fecha_fin > '$hoy'
            LIMIT 1";


        $parameter = array(":id_exposicion" => $id);

        $this->Query($query, $parameter);
        foreach ($this->returnData as $row) {
            $galeria = new Galeria();

            $galeria->__SET("nombre_galeria", $row["nombre_galeria"]);
            $galeria->__SET("direccion", $row["direccion"]);
            $galeria->__SET("localidad", $row["localidad"]);
            $galeria->__SET("provincia", $row["provincia"]);
            $galeria->__SET("telefono", $row["telefono"]);
            $galeria->__SET("g_map", $row["g_map"]);

            $this->Galeria[] = $galeria;

            $artista = new Artista();

            $artista->__SET("nombre_artista", $row["nombre_artista"]);
            $artista->__SET("pagina_personal", $row["pagina_personal"]);

            $this->Artista[] = $artista;

            $obra = new Obra();

            $obra->__SET("nombre", $row["nombre"]);
            $obra->__SET("descripcion", $row["descripcion"]);
            $obra->__SET("descripcion_alt", $row["descripcion_alt"]);
            $obra->__SET("imagen", $row["imagen"]);

            $this->Obra[] = $obra;

            $exposicion = new Exposicion();

            $exposicion->__SET("id_exposicion", $row["id_exposicion"]);
            $exposicion->__SET("nombre_exposicion", $row["nombre_exposicion"]);
            $exposicion->__SET("fecha_inicio", $row["fecha_inicio"]);
            $exposicion->__SET("fecha_fin", $row["fecha_fin"]);
            $exposicion->__SET("cartel", $row["cartel"]);
            $exposicion->__SET("descripcion_cartel", $row["descripcion_cartel"]);
            $exposicion->__SET("texto_exposicion", $row["texto_exposicion"]);

            $this->Exposicion[] = $exposicion;
        }


        // No genera problemas porque sólo hay un resultado de cada uno y están
        // relacionados
        foreach ($this->Galeria as $galeria) {
            foreach ($this->Artista as $artista) {
                foreach ($this->Obra as $obra) {
                    foreach ($this->Exposicion as $exposicion) {

                        $html .= "<div class='post-blog'>";
                        $html .= "<article>";
                        $html .= "<h2 class='titulopost-blog'>$exposicion->nombre_exposicion</h2>";
                        $html .= "<p class='fecha'>$exposicion->fecha_inicio - $exposicion->fecha_fin</p>";
                        $html .= "<div class='thumb-blog'>";
                        $html .= "<a class='thickbox' href='./carteles/$exposicion->cartel'>";
                        $html .= "<img src='./carteles/$exposicion->cartel' alt='$exposicion->descripcion_cartel'>";
                        $html .= "</a>";
                        $html .= "<p class='extracto-blog'>$exposicion->texto_exposicion</p>";
                        $html .= "</div>";
                        $html .= "<br>";
                        $html .= "<div class='autorobra-blog>";
                        $html .= "<a class='thickbox' href='./imagenesEsculturas/$obra->imagen'>";
                        $html .= "<img class='thumbobra' src='./imagenesEsculturas/$obra->imagen' alt='$obra->descripcion_alt' />";
                        $html .= "</a>";
                        $html .= "<h2 class='titulopost-blog'><a class='enlaceautor' href='$artista->pagina_personal'>$artista->nombre_artista</a></h2>";
                        $html .= "</div>";
                        $html .= "<hr>";
                        $html .= "<div class='galeria-blog'>";
                        $html .= "<p class='nombre-galeria'>$galeria->nombre_galeria</p>";
                        $html .= "<p class='telefono-galeria'>Tlfn: $galeria->telefono</p>";
                        $html .= "<p class='direccion-galeria'>Dirección: $galeria->direccion / $galeria->localidad / $galeria->provincia</p>";
                        $html .= "</div>";
                        $html .= "<div class='mapa'>$galeria->g_map</div>";
                        $html .= "</article>";
                        $html .= "<br>";
                        $html .= "</div>";
                        
                    }
                }
            }
        }

        echo $html;
    }

    public function listarYPrintarArtistasRandom()
    {
        $html = '';

        $queryRandom = "SELECT id_artista FROM artista";
        $this->Query($queryRandom, array());
        $random = count($this->returnData);
        

        for ($i = 0; $i <= 2; $i++) {
            $this->Artista = array();
            $this->Obra = array();
            $random = random_int(1, $random);
            
            $query = "SELECT a.nombre_artista, a.pagina_personal, o.imagen, o.descripcion_alt
            FROM artista a 
            INNER JOIN obra o 
            ON a.id_artista = o.obra_id_artista
            WHERE id_artista = $random
            LIMIT 1";

            $this->Query($query, array());
          
            foreach ($this->returnData as $row) {
                $artista = new Artista();

                $artista->__SET("nombre_artista", $row['nombre_artista']);
                $artista->__SET("pagina_personal", $row['pagina_personal']);
                $this->Artista[] = $artista;
                
                $obra = new Obra();

                $obra->__SET("imagen", $row['imagen']);
                $obra->__SET("descripcion_alt", $row['descripcion_alt']);
                $this->Obra[] = $obra;

                foreach ($this->Artista as $artista) {
                    foreach ($this->Obra as $obra) {
                        $html .= "<div class='galeria-artistas'>";
                        $html .= "<a target='_blank' href='$artista->pagina_personal'>";
                        $html .= "<img src='imagenesEsculturas/$obra->imagen' alt='$obra->descripcion_alt' width='600' height='400'>";
                        $html .= "</a>";
                        $html .= "<div class='desc'>$artista->nombre_artista</div>";
                        $html .= "</div>";
                    }
                }
            }
            echo $html;
            $html = '';
        }
    }
}
