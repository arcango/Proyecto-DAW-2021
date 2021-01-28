<?php session_start();


if ((isset($_SESSION['encargado'])) && ($_SESSION['encargado'] == 'admin')) {
    header('Location: usuarios.php');
}
if (isset($_SESSION['encargado'])) {
    header('Location: navegacion.php');
}

require('Modelos/daoEncargado.php');
require('Modelos/daoAdmin.php');

$errores = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    if (!empty($_POST["nombre_usuario"])) {
        $nombre_usuario = filter_var(trim($_POST["nombre_usuario"]), FILTER_SANITIZE_STRING);
    }
    if (!empty($_POST["password"])) {
        $password = $_POST["password"];
        $password = hash('sha512', $password);
    }

    if (empty($nombre_usuario) || empty($password)) {
        $errores .= '<li>Rellena los datos</li>';
    } else {
        
        try {
            $daoEncargado = new DaoEncargado("gallery_app");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        try {
            $daoAdmin = new DaoAdmin("gallery_app");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        if ($resultado = $daoAdmin->validarLogin($nombre_usuario, $password)) {
            $_SESSION['encargado'] = $resultado->nombre;
            header('Location: usuarios.php');
        }
        
        if($resultado = $daoEncargado->validarLogin($nombre_usuario, $password)){
            $_SESSION['encargado'] = $resultado->nombre_encargado;
            $_SESSION['id_encargado'] = $resultado->id_encargado;
            $_SESSION['id_galeria'] = $resultado->encargado_id_galeria;
            header('Location: navegacion.php');
        } else {
            $errores .= '<li>Datos incorrectos o usuario no existe</li>';
        }
    }

}



require 'views/login.view.php';
