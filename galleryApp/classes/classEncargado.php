<?php

class Encargado {

    private $encargado_id_galeria;
    private $nombre_encargado;
    private $nombre_usuario;
    private $password_usuario;
    private $email;

    public function __GET($propiedad) {
        return $this->$propiedad;
    }

    public function __SET($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}

?>