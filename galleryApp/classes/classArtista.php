<?php

class Artista {

    private $nombre_artista;
    private $pagina_personal;
    private $email;
    private $telefono;
    private $descripcion;

    public function __GET($propiedad) {
        return $this->$propiedad;
    }

    public function __SET($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}

?>