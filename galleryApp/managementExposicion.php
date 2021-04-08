<?php session_start();

require('Modelos/daoArtista.php');
require('Modelos/daoObra.php');
require('Modelos/daoExposicion.php');

$errores = '';
try {
    $daoArtista = new DaoArtista('');
    $daoObra = new DaoObra('');
    $daoExposicion = new DaoExposicion('');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['crear'])) {
        // print_r($_SESSION);
        // var_dump($_POST);
        // exit;
        // $daoExposicion->listarYPrintarExposicionDeGaleria($_SESSION['id_galeria']);
        if(isset($_POST['i_nombre_exposicion'])) {
            $i_nombre_exposicion = filter_var($_POST['i_nombre_exposicion'], FILTER_SANITIZE_STRING);
            $i_nombre_exposicion = trim(htmlspecialchars(stripslashes(strtolower($i_nombre_exposicion))));
            $i_nombre_exposicion = ucwords($i_nombre_exposicion);
        } else {
            $errores .= '<li>Inserta el nombre de la exposición</li>';
        }

        if(isset($_POST['i_fecha_inicio'])) {
            $i_fecha_inicio = $_POST['i_fecha_inicio'];
        }

        if(isset($_POST['i_fecha_fin'])) {
            $i_fecha_fin = $_POST['i_fecha_fin'];
        }

        if(isset($_POST['i_descripcion_cartel'])) {
            $i_descripcion_cartel = filter_var($_POST['i_descripcion_cartel'], FILTER_SANITIZE_STRING);
            $i_descripcion_cartel = trim(htmlspecialchars(stripslashes($i_descripcion_cartel)));
        } else {
            $errores .= '<li>Inserta la descripción del cartel</li>';
        }

        if(isset($_POST['i_texto_exposicion'])) {
            $i_texto_exposicion = filter_var($_POST['i_texto_exposicion'], FILTER_SANITIZE_STRING);
            $i_texto_exposicion = trim(htmlspecialchars(stripslashes($i_texto_exposicion)));
        } else {
            $errores .= '<li>Inserta el texto que acompañe al post</li>';
        }

        if(!empty($_FILES)) {
            $i_cartel = $_FILES['i_cartel']['name'];
            $check = @getimagesize($_FILES['i_cartel']['tmp_name']);
            if ($check !== false) {
                $carpeta_destino = 'carteles/';
                $archivo_subido = $carpeta_destino . $_FILES['i_cartel']['name'];
                move_uploaded_file($_FILES['i_cartel']['tmp_name'], $archivo_subido);
            }
        }
        if (empty($i_nombre_exposicion) || empty($i_fecha_inicio) || empty($i_fecha_fin) ||
        empty($i_descripcion_cartel) || empty($i_texto_exposicion)) {
            $errores .= '<li>Por favor, rellena todos los datos correctamente</li>';
        } else {
            $exposicion = new Exposicion();
            $exposicion->__SET("galeria_id_galeria", $_SESSION['id_galeria']);
            $exposicion->__SET("galeria_id_artista", $_SESSION['id_artista'][0]);
            $exposicion->__SET("nombre_exposicion", $i_nombre_exposicion);
            $exposicion->__SET("fecha_inicio", $i_fecha_inicio);
            $exposicion->__SET("fecha_fin", $i_fecha_fin);
            $exposicion->__SET("descripcion_cartel", $i_descripcion_cartel);
            $exposicion->__SET("texto_exposicion", $i_texto_exposicion);
            $exposicion->__SET("cartel", $i_cartel);

            $daoExposicion->insertar($exposicion);
            $daoExposicion->CloseConnection();
            $daoExposicion->__destruct();
            header('Location: managementExposicion.php');
        }
    }

    if (isset($_POST['actualizar'])) {
        if(empty($_POST['check'])) {
            $errores .= "<li>No se actualizó ningún elemento por no estar seleccionado</li>";
        } else {
            foreach ($_POST['check'] as $id_exposicion) {

                $exposicion = new Exposicion();
                $exposicion->__SET("id_exposicion", $id_exposicion);
                $exposicion->__SET("galeria_id_galeria", $_SESSION['id_galeria']);
                $exposicion->__SET("galeria_id_artista", $_SESSION['id_artista'][0]);
                $exposicion->__SET("nombre_exposicion", $_POST["nombre_exposicion$id_exposicion"]);
                $exposicion->__SET("fecha_inicio", $_POST["fecha_inicio$id_exposicion"]);
                $exposicion->__SET("fecha_fin", $_POST["fecha_fin$id_exposicion"]);
                $exposicion->__SET("descripcion_cartel", $_POST["descripcion_cartel$id_exposicion"]);
                $exposicion->__SET("texto_exposicion", $_POST["texto_exposicion$id_exposicion"]);
                if (!empty($_FILES["cartel$id_exposicion"]["name"])) {
                    $exposicion->__SET("cartel", $_FILES["cartel$id_exposicion"]["name"]);
                } else {
                    $exposicion->__SET("cartel", $_POST["cartelOculto$id_exposicion"]);
                }
                // print_r($exposicion);
                // exit;
                $daoExposicion->actualizar($exposicion);
            }
            $daoExposicion->CloseConnection();
            $daoExposicion->__destruct();
            header('Location: managementExposicion.php');
        }
    }

    if (isset($_POST['eliminar'])) {
        print_r($_POST['check']);
        if (empty($_POST['check'])) {
            $errores .= "<li>No se eliminó ningún elemento por no estar seleccionado</li>";
        } else {
            foreach ($_POST['check'] as $id) {

                $daoExposicion->eliminar($id);
            }
            $daoExposicion->CloseConnection();
            $daoExposicion->__destruct();
            header('Location: managementExposicion.php');
        }
    }
}

if (isset($_SESSION['encargado']) && ($_SESSION['activo'] == 'si')) {
    require 'views/managementExposicion.view.php';
} else {
    header('Location: index.php');
}

?>