<?php session_start();

if (isset($_SESSION['encargado']) && ($_SESSION['encargado'] == 'admin')) {

    echo '<p><a href="admin.php">Administración de Encargados</a></p>';

} elseif (isset($_SESSION['encargado'])) {

    echo '<p><a href="managementArtista.php">Panel de introducción de Artistas y Obras</a></p>';

}


require 'views/index.view.php';


?>
