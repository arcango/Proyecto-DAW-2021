<?php

class Obra {

    private $obra_id_artista;
    private $nombre;
    private $descripcion;
    private $descripcion_alt;
    private $imagen;

    public function __GET($propiedad) {
        return $this->$propiedad;
    }

    public function __SET($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}

?>