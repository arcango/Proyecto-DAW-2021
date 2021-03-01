<?php session_start();

require('Modelos/daoArtista.php');
require('Modelos/daoObra.php');


$errores = '';
try {
    $daoObra = new DaoObra('gallery_app');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // exit;
    /////////// datos de inserción de la obra ////////////////
    if (isset($_POST['insertar'])) {
        if (!empty($_POST['i_nombre'])) {
            $i_nombre = filter_var($_POST['i_nombre'], FILTER_SANITIZE_STRING);
            $i_nombre = trim(htmlspecialchars(stripslashes(strtolower($i_nombre))));
            $i_nombre = ucwords($i_nombre);
        } else {
            $errores .= '<li>Inserta el nombre de el o la Artista</li>';
        }

        if (!empty($_POST['i_id_artista'])) {
            if (is_numeric($_POST['i_id_artista']) && (strlen($_POST['i_id_artista']) > 0)) {
                $i_id_artista = filter_var($_POST['i_id_artista'], FILTER_SANITIZE_NUMBER_INT);
                $i_id_artista = trim(intval($i_id_artista));
            } else {
                $errores .= '<li>Inserta un teléfono correcto</li>';
            }
        } else {
            $errores .= '<li>Inserta el teléfono de la galería</li>';
        }

        if (!empty($_POST['i_descripcion'])) {
            $i_descripcion = filter_var($_POST['i_descripcion'], FILTER_SANITIZE_STRING);
            $i_descripcion = trim(htmlspecialchars($i_descripcion));
        } else {
            $errores .= '<li>Inserta el nombre de el o la Artista</li>';
        }

        if (!empty($_POST['i_descripcion_alt'])) {
            $i_descripcion_alt = filter_var($_POST['i_descripcion_alt'], FILTER_SANITIZE_STRING);
            $i_descripcion_alt = trim(htmlspecialchars($i_descripcion_alt));
        } else {
            $errores .= '<li>Inserta el nombre de el o la Artista</li>';
        }

        if(!empty($_FILES)) {
            // La arroba antes de la función getimagesize es para que no nos salte un posible error de tipo notice
            // en caso de no ser una imagen, la función nos devolverá false
            $i_imagen = $_FILES['i_imagen']['name'];
            $check = @getimagesize($_FILES['i_imagen']['tmp_name']);
            if ($check !== false) {
                $carpeta_destino = 'imagenesEsculturas/';
                $archivo_subido = $carpeta_destino . $_FILES['i_imagen']['name'];
                move_uploaded_file($_FILES['i_imagen']['tmp_name'], $archivo_subido);
            }
        }

        if (empty($i_nombre) || empty($i_id_artista) || empty($i_descripcion) || 
        empty($i_descripcion_alt)) {
            $errores .= '<li>Por favor, rellena todos los datos correctamente</li>';
        } else {
            $obra = new Obra();
            $obra->__SET("nombre", $i_nombre);
            $obra->__SET("obra_id_artista", $i_id_artista);
            $obra->__SET("descripcion", $i_descripcion);
            $obra->__SET("descripcion_alt", $i_descripcion_alt);
            $obra->__SET("imagen", $i_imagen);

            $daoObra->insertar($obra);
            $daoObra->CloseConnection();
            $daoObra->__destruct();
            header('Location: managementObras.php');
        }
    }

    if(isset($_POST['actualizar'])) {
        if(empty($_POST['check'])) {
            $errores .= "<li>No se actualizó ningún elemento por no estar seleccionado</li>";
        } else {
            foreach ($_POST['check'] as $id_obra) {

                $obra = new Obra();
                $obra->__SET("id_obra", $id_obra);
                $obra->__SET("obra_id_artista", $_POST["obra_id_artista$id_obra"]);
                $obra->__SET("nombre", $_POST["nombre_obra$id_obra"]);
                $obra->__SET("descripcion", $_POST["descripcion$id_obra"]);
                $obra->__SET("descripcion_alt", $_POST["descripcion_alt$id_obra"]);
                if (!empty($_FILES["imagen$id_obra"]['name'])){
                    $obra->__SET("imagen", $_FILES["imagen$id_obra"]['name']);
                } else {
                    $obra->__SET("imagen", $_POST["imagen$id_obra"]);
                }

                $daoObra->actualizar($obra);
            }
            $daoObra->CloseConnection();
            $daoObra->__destruct();
            header('Location: managementObras.php');
        }
    }

    if (isset($_POST['eliminar'])) {
        if (empty($_POST['check'])) {
            $errores .= "<li>No se eliminó ningún elemento por no estar seleccionado</li>";
        } else { 
            foreach ($_POST['check'] as $id) {

                $daoObra->eliminar($id);
            }
            $daoObra->CloseConnection();
            $daoObra->__destruct();
            header('Location: managementObras.php');
        }
    }

    if(isset($_POST['seleccionar'])) {
        if (count($_SESSION['id_artista']) <= 1) {
            if(isset($_POST['check'])) {
                $idObra = array();
                foreach ($_POST['check'] as $id) {
                    $idObra[] = $id;
                }
                    $_SESSION['id_obra'] = $idObra;
                    header('Location: managementExposicion.php'); 
            } else {
                $errores = '<li>No has seleccionado ninguna obra</li>';
            }
        } else {
            $errores = '<li>No puedes seleccionar más de un artista para formar una exposición</li>';
        }
    }
    
    
}

if (isset($_SESSION['encargado']) && ($_SESSION['activo'] == 'si')) {
    require 'views/managementObras.view.php';
} else {
    header('Location: index.php');
}
