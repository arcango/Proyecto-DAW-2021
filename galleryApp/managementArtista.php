<?php session_start();

require('Modelos/daoArtista.php');

$errores = '';
try {
    $daoArtista = new DaoArtista('smizgltb_gallery_app');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ///////// datos de inserción de artista //////////////////7
    if(isset($_POST['insertar'])) {
        if (!empty($_POST['i_nombre'])) {
            $i_nombre = filter_var($_POST['i_nombre'], FILTER_SANITIZE_STRING);
            $i_nombre = trim(htmlspecialchars(stripslashes(strtolower($i_nombre))));
            $i_nombre = ucwords($i_nombre);
        } else {
            $errores .= '<li>Inserta el nombre de el o la Artista</li>';
        }

        if (!empty($_POST['i_pagina_personal'])) {
            $i_pagina_personal = filter_var($_POST['i_pagina_personal'], FILTER_SANITIZE_URL);
            if (!filter_var($i_pagina_personal, FILTER_VALIDATE_URL)) {
                $errores .= '<li>La dirección no es válida</li>';
            }
        } else {
            $errores .= '<li>Inserta la dirección de la galería</li>';
        }

        if (!empty($_POST['i_email'])) {
            $i_email = filter_var($_POST['i_email'], FILTER_SANITIZE_EMAIL);
    
            if (!filter_var($i_email, FILTER_VALIDATE_EMAIL)) {
                $errores .= '<li>Inserta un correo válido</li>';
            }
        } else {
            $errores .= '<li>Inserta el mail del usuario/a</li>';
        }

        if (!empty($_POST['i_telefono'])) {
            if (is_numeric($_POST['i_telefono']) && (strlen($_POST['i_telefono']) == 9)) {
                $i_telefono = filter_var($_POST['i_telefono'], FILTER_SANITIZE_NUMBER_INT);
                $i_telefono = trim(intval($i_telefono));
            } else {
                $errores .= '<li>Inserta un teléfono correcto</li>';
            }
        } else {
            $errores .= '<li>Inserta el teléfono de la galería</li>';
        }

        if (!empty($_POST['i_descripcion'])) {
            $i_descripcion = filter_var($_POST['i_descripcion'], FILTER_SANITIZE_STRING);
            $i_descripcion = trim(htmlspecialchars(stripslashes($i_descripcion)));
        } else {
            $errores .= '<li>Inserta la descripción del Artista</li>';
        }

        if (empty($i_nombre) || empty($i_pagina_personal) || empty($i_email) || 
        empty($i_telefono) || empty($i_descripcion)) {
            $errores .= '<li>Por favor, rellena todos los datos correctamente</li>';
        } else {
            $artista = new Artista();
            $artista->__SET("nombre_artista", $i_nombre);
            $artista->__SET("pagina_personal", $i_pagina_personal);
            $artista->__SET("email", $i_email);
            $artista->__SET("telefono", $i_telefono);
            $artista->__SET("descripcion", $i_descripcion);

            $daoArtista->insertar($artista);
            $daoArtista->CloseConnection();
            $daoArtista->__destruct();
            header('Location: managementArtista.php');
        }
    }

    if(isset($_POST['actualizar'])) {
        if(isset($_POST['check'])) {
            foreach ($_POST['check'] as $id) {

                $artista = new Artista();
                $artista->__SET("id_artista", $id);
                $artista->__SET("nombre_artista", $_POST["nombre$id"]);
                $artista->__SET("pagina_personal", $_POST["pagina_personal$id"]);
                $artista->__SET("email", $_POST["email$id"]);
                $artista->__SET("telefono", $_POST["telefono$id"]);
                $artista->__SET("descripcion", $_POST["descripcion$id"]);

                $daoArtista->actualizar($artista);
            }
            $daoArtista->CloseConnection();
            $daoArtista->__destruct();
            header('Location: managementArtista.php');
        } else {
            $errores = '<li>No has seleccionado ningún artista para actualizar</li>';
        }
    }

    if(isset($_POST['seleccionar'])) {
        if(isset($_POST['check'])) {
            $idArtistas = array();
            foreach ($_POST['check'] as $id) {
                $idArtistas[] = $id;
            }
            $_SESSION['id_artista'] = $idArtistas;
            header('Location: managementObras.php'); 
        } else {
            $errores = '<li>No has seleccionado ningún artista</li>';
        }
    }
}

if (isset($_SESSION['encargado']) && ($_SESSION['activo'] == 'si')) {
    require 'views/managementArtista.view.php';
} else {
    header('Location: index.php');
}
