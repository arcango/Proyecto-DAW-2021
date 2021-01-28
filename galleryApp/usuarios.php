<?php session_start();


if ($_SESSION['encargado'] == 'admin') {

    require('Modelos/daoUsuario.php');
    require('Modelos/daoExposicion.php');
    
    try {
        $daoUsuario = new DaoUsuario("gallery_app");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }



    require 'views/usuarios.view.php';
}


?>