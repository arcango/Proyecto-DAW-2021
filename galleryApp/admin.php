<?php session_start();


if ((isset($_SESSION['encargado'])) && ($_SESSION['encargado'] == 'admin')) {

    require('Modelos/daoGaleria.php');
    require('Modelos/daoEncargado.php');
    require('Modelos/daoAdmin.php');

    $errores = '';
    try {
        $daoEncargado = new DaoEncargado('');
        $daoGaleria = new DaoGaleria('');
        $daoAdmin = new DaoAdmin('');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['actualizarEncargado'])) {
            if (isset($_POST['check'])) {
                if (count($_POST['check']) != 1) {
                    $errores .= "<li>No se actualizó ningún elemento por tener seleccionado más de uno</li>";
                } else {
                    if (!empty($_POST["i_nombre_encargado"])) {
                        $nombre_encargado = filter_var($_POST['i_nombre_encargado'], FILTER_SANITIZE_STRING);
                        $nombre_encargado = trim(htmlspecialchars(stripslashes(strtolower($nombre_encargado))));
                        $nombre_encargado = ucwords($nombre_encargado);
                    } else {
                        $errores .= '<li>Inserta el nombre de el o la encargado/encargada</li>';
                    }
                    if (!empty($_POST["i_nombre_usuario"])) {
                        $nombre_usuario = filter_var(trim($_POST["i_nombre_usuario"]), FILTER_SANITIZE_STRING);
                    } else {
                        $errores .= '<li>Inserta el nombre de usuario/a</li>';
                    }
                    if (!empty($_POST['i_email'])) {
                        $email = filter_var($_POST['i_email'], FILTER_SANITIZE_EMAIL);

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errores .= '<li>Inserta un correo válido</li>';
                        }
                    } else {
                        $errores .= '<li>Inserta el mail del usuario/a</li>';
                    }
                    $password = $_POST['i_password'];
                    $password2 = $_POST['i_password2'];
                    if ($password == $password2) {
                        ///// Encriptamos la contraseña ///////
                        $password = hash('sha512', $password);
                        $password2 = hash('sha512', $password2);
                    } else {
                        $errores .= '<li>Las contraseñas no coinciden</li>';
                    }

                    ///////// Aseguramos que no hay campos vacíos y que el password ha sido introducido correctamente ///////////////
                    if (($password != $password2) ||
                        (empty($nombre_encargado) || empty($nombre_usuario) || empty($email)
                            || empty($password) || empty($password2))
                    ) {
                        $errores .= '<li>Por favor, rellena todos los datos correctamente</li>';
                    } else {

                        $id_encargado = $_POST['check'][0];
                        $encargado = new Encargado();

                        $encargado->__SET("id_encargado", $id_encargado);
                        $encargado->__SET("nombre_encargado", $nombre_encargado);
                        $encargado->__SET("nombre_usuario", $nombre_usuario);
                        $encargado->__SET("email", $email);
                        $encargado->__SET("password_usuario", $password);

                        $daoEncargado->actualizar($encargado);
                        $daoEncargado->CloseConnection();
                        $daoEncargado->__destruct();
                    }
                }
            }
        }

        if (isset($_POST['actualizarActividad'])) {
            if (isset($_POST['check'])) {
                foreach ($_POST['check'] as $id_encargado) {
                    $activo = $_POST["activo$id_encargado"];
                    if (($activo == "si") || ($activo == "no")) {
                        $activo = filter_var($activo, FILTER_SANITIZE_STRING);

                        $encargado = new Encargado();
                        $encargado->__SET("id_encargado", $id_encargado);
                        $encargado->__SET("activo", $activo);

                        $daoEncargado->actualizarActivo($encargado);
                        $daoEncargado->CloseConnection();
                        $daoEncargado->__destruct();
                        header('Location: admin.php');
                    } else {
                        $errores .= "<li>Los valores de la actividad tienen que ser 'si' o 'no' </li>";
                    }
                }
            } else {
                $errores .= "<li>No se actualizó ningún elemento por no estar seleccionado</li>";
            }
        }

        // En caso de necesitar en un futuro esta acción, sólo haría falta descomentarla y descomentar 
        // su botón en admin.view.php

        // if (isset($_POST['eliminarEncargado'])) {
        //     if (isset($_POST['check'])) {
        //         foreach ($_POST['check'] as $id) {
        //             $daoEncargado->eliminar($id);
        //         }
        //         $daoEncargado->CloseConnection();
        //         $daoEncargado->__destruct();
        //         header('Location: admin.php');
        //     } else {
        //         $errores .= "<li>No se eliminó ningún elemento por no estar seleccionado</li>";
        //     }
        // }
    }
} else {
    header('Location: index.php');
}
require('views/admin.view.php');
