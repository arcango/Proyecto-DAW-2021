<?php session_start();



require('Modelos/daoUsuario.php');

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['nombre_usuario'] )) {
        $nombre_usuario = filter_var($_POST['nombre_usuario'], FILTER_SANITIZE_STRING);
        $nombre_usuario = trim(htmlspecialchars(stripslashes(strtolower($nombre_usuario))));
        $nombre_usuario = ucwords($nombre_usuario);
    } else {
        $errores .= '<li>No puedes dejar el nombre vacío</li>';
    }
    if (!empty($_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores .= '<li>Inserta un correo válido</li>';
        }
    } else {
        $errores .= '<li>Inserta tu mail</li>';
    }
    if(isset($_POST['texto_usuario'])) {
        $texto_usuario = filter_var($_POST['texto_usuario'], FILTER_SANITIZE_STRING);
        $texto_usuario = trim(htmlspecialchars(stripslashes($texto_usuario)));
    } else {
        $errores .= '<li>Introduce el motivo del mensaje</li>';
    }

    if(!empty($nombre_usuario) && !empty($email) && !empty($texto_usuario)) {
        try {
            $daoUsuario = new DaoUsuario("gallery_app");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $usuario = new Usuario();
        $usuario->__SET("nombre_usuario", $nombre_usuario);
        $usuario->__SET("email_usuario", $email);
        $usuario->__SET("mensaje_usuario", $texto_usuario);

        $daoUsuario->insertar($usuario);
        
        $daoUsuario->CloseConnection();
        $daoUsuario->__destruct();

        header('Location: success.php');
    }

}

   


require 'views/contacto.view.php';



?>