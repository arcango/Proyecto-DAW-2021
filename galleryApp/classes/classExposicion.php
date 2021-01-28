<?php

class Exposicion {

    private $galeria_id_galeria;
    private $galeria_id_artista;
    private $nombre_exposicion;
    private $fecha_inicio;
    private $fecha_fin;
    private $cartel;

    public function __GET($propiedad) {
        return $this->$propiedad;
    }

    public function __SET($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}

?>