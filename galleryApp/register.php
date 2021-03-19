<?php session_start();


require('Modelos/daoGaleria.php');
require('Modelos/daoEncargado.php');

$errores = '';

// recogemos y validamos todos los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {



    //////////////// datos de la galería //////////////////
    if (!empty($_POST['nombre_galeria'])) {
        $nombre_galeria = filter_var($_POST['nombre_galeria'], FILTER_SANITIZE_STRING);
        $nombre_galeria = trim(htmlspecialchars(stripslashes(strtolower($nombre_galeria))));
        $nombre_galeria = ucwords($nombre_galeria);
    } else {
        $errores .= '<li>Inserta el nombre de la galería</li>';
    }
    if (!empty($_POST['direccion'])) {
        $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
        $direccion = trim(strtolower(ucwords($direccion)));
    } else {
        $errores .= '<li>Inserta la dirección de la galería</li>';
    }
    if (!empty($_POST['g_map'])) {
        $g_map = $_POST['g_map'];
    } else {
        $errores .= '<li>Inserta enlace de la galería</li>';
    }
    if (!empty($_POST['resultadoProvincia'])) {
        $provincia = filter_var($_POST['resultadoProvincia'], FILTER_SANITIZE_STRING);
        $provincia = trim(htmlspecialchars(stripslashes(strtolower($provincia))));
        $provincia = ucwords($provincia);
    } else {
        $errores .= '<li>Inserta la provincia</li>';
    }
    if (!empty($_POST['localidad'])) {
        $localidad = filter_var($_POST['localidad'], FILTER_SANITIZE_STRING);
        $localidad = trim(htmlspecialchars(stripslashes(strtolower($localidad))));
        $localidad = ucwords($localidad);
    } else {
        $errores .= '<li>Inserta la localidad</li>';
    }
    if (!empty($_POST['telefono'])) {
        if (is_numeric($_POST['telefono']) && (strlen($_POST['telefono']) == 9)) {
            $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
            $telefono = trim(intval($telefono));
        } else {
            $errores .= '<li>Inserta un teléfono correcto</li>';
        }
    } else {
        $errores .= '<li>Inserta el teléfono de la galería</li>';
    }
    if (!empty($_POST['email_galeria'])) {
        $email_galeria = filter_var($_POST['email_galeria'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email_galeria, FILTER_VALIDATE_EMAIL)) {
            $errores .= '<li>Inserta un correo válido</li>';
        }
    } else {
        $errores .= '<li>Inserta el mail de la galería</li>';
    }

    /////////////// datos del gerente ////////////////////////
    if (!empty($_POST["usuario"])) {
        $nombre_encargado = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
        $nombre_encargado = trim(htmlspecialchars(stripslashes(strtolower($nombre_encargado))));
        $nombre_encargado = ucwords($nombre_encargado);
    } else {
        $errores .= '<li>Inserta el nombre de el o la encargado/encargada</li>';
    }
    if (!empty($_POST["nombre_usuario"])) {
        $nombre_usuario = filter_var(trim($_POST["nombre_usuario"]), FILTER_SANITIZE_STRING);
    } else {
        $errores .= '<li>Inserta el nombre de usuario/a</li>';
    }
    if (!empty($_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores .= '<li>Inserta un correo válido</li>';
        }
    } else {
        $errores .= '<li>Inserta el mail del usuario/a</li>';
    }
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if ($password == $password2) {
        ///// Encriptamos la contraseña ///////
        $password = hash('sha512', $password);
        $password2 = hash('sha512', $password2);
    } else {
        $errores .= '<li>Las contraseñas no coinciden</li>';
    }

    ///////// Aseguramos que no hay campos vacíos y que el password ha sido introducido correctamente ///////////////
    if (
        ($password != $password2) ||
        (empty($nombre_galeria) || empty($direccion) || empty($provincia) || empty($g_map) ||
        empty($localidad) || empty($telefono) || empty($email_galeria) || empty($nombre_encargado) ||
        empty($nombre_usuario) || empty($email) || empty($password) || empty($password2)
    )) {
        $errores .= '<li>Por favor, rellena todos los datos correctamente</li>';
    } else {
        try {
            $daoGaleria = new DaoGaleria("smizgltb_gallery_app");
            $daoEncargado = new DaoEncargado("smizgltb_gallery_app");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
     
        if ($daoGaleria->obtenerTlfGaleria($telefono)) {
            $errores .= '<h2>¡La galería ya existe!</h2>';
        } elseif ($daoEncargado->obtenerNombreUsuario($nombre_usuario)) {
            $errores .= '<h2>¡El nombre de usuario ya existe!</h2>';
        } else {
            $galeria = new Galeria();
            $galeria->__SET("nombre_galeria", $nombre_galeria);
            $galeria->__SET("direccion", $direccion);
            $galeria->__SET("g_map", $g_map);
            $galeria->__SET("provincia", $provincia);
            $galeria->__SET("localidad", $localidad);
            $galeria->__SET("telefono", $telefono);
            $galeria->__SET("email", $email_galeria);

            $daoGaleria->insertar($galeria);
            $resultado = $daoGaleria->obtenerIdGaleria($nombre_galeria);
            $id_galeria = $resultado->id_galeria;

            $daoGaleria->CloseConnection();
            $daoGaleria->__destruct();

            $encargado = new Encargado();
            $encargado->__SET("encargado_id_galeria", $id_galeria);
            $encargado->__SET("nombre_encargado", $nombre_encargado);
            $encargado->__SET("nombre_usuario", $nombre_usuario);
            $encargado->__SET("email", $email);
            $encargado->__SET("password_usuario", $password);

            $daoEncargado->insertar($encargado);
            $daoEncargado->CloseConnection();
            $daoEncargado->__destruct();

            // $to = "$email";
            // $subject = 'Wellcome to GalleryApp';
            // $message = "Wellcome $nombre_encargado, this is your password: $password";
            // $headers = "From: gallery_app@gmail.com\r\n";
            // if (mail($to, $subject, $message, $headers)) {
            //    echo "SUCCESS";
            // } else {
            //    echo "ERROR";
            // }
            
            header('Location: admin.php');
        }
    }
}

require 'views/register.view.php';
