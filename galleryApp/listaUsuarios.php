<?php session_start();

require('Modelos/daoUsuario.php');

try {
    $daoUsuario = new DaoUsuario('smizgltb_gallery_app');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$errores = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eliminarUsuario'])) {
        if (isset($_POST['check'])) {
            foreach ($_POST['check'] as $id) {
                $daoUsuario->eliminar($id);
            }
            $daoUsuario->CloseConnection();
            $daoUsuario->__destruct();
            header('Location: listaUsuarios.php');
        } else {
            $errores .= "<li>No se eliminó ningún elemento por no estar seleccionado</li>";
        }
    }
}

if (isset($_SESSION['encargado'])) {
    require('views/listaUsuarios.view.php');
}
