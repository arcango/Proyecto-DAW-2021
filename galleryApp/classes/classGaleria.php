<?php

class Galeria {

    private $nombre_galeria;
    private $direccion;
    private $localidad;
    private $provincia;
    private $telefono;
    private $email;

    public function __GET($propiedad) {
        return $this->$propiedad;
    }

    public function __SET($propiedad, $valor){
        $this->$propiedad=$valor;
    }
}

?>