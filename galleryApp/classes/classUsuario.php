<?php

class Usuario {

    private $nombre_usuario;
    private $email_usuario;

    public function __GET($propiedad) {
        return $this->$propiedad;
    }

    public function __SET($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}


?>