<?php session_start();
if ((isset($_SESSION['encargado'])) && ($_SESSION['encargado'] == 'admin')) {
    header('Location: admin.php');
}
if ((isset($_SESSION['encargado'])) && ($_SESSION['activo'] == 'si')) {
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
            $daoEncargado = new DaoEncargado("");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        try {
            $daoAdmin = new DaoAdmin("");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        if ($resultado = $daoAdmin->validarLogin($nombre_usuario, $password)) {
            $_SESSION['encargado'] = $resultado->nombre;
            header('Location: admin.php');
        }

        // Validamos el login del encargado y nos aseguramos de que el administrador lo tenga
        // como "activo". En caso contrario, lo devuelve al Login y no le permite manipular
        // sus exposiciones. A la vez, estas no aparecen en la página principal
        if($resultado = $daoEncargado->validarLogin($nombre_usuario, $password)){
            $_SESSION['encargado'] = $resultado->nombre_encargado;
            $_SESSION['id_encargado'] = $resultado->id_encargado;
            $_SESSION['id_galeria'] = $resultado->encargado_id_galeria;
            $_SESSION['activo'] = $resultado->activo;
            if($_SESSION['activo'] == 'si') {
                header('Location: navegacion.php');
            } else {
                session_destroy();
                $_SESSION = array();
                header('Location: index.php');
            }
        } else {
            $errores .= '<li>Datos incorrectos o usuario no existe</li>';
        }
    }

}



require 'views/login.view.php';
