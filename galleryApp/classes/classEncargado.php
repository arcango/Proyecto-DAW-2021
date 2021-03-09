<?php

class Encargado {

    private $id_encargado;
    private $encargado_id_galeria;
    private $nombre_encargado;
    private $nombre_usuario;
    private $password_usuario;
    private $email;
    private $activo;

    public function __GET($propiedad) {
        return $this->$propiedad;
    }

    public function __SET($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}

?>