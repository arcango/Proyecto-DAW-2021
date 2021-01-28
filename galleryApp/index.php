<?php session_start();
if (isset($_SESSION['encargado'])) {
    echo '<p><a href="managementArtista.php">Panel de introducción de Artistas</a></p>';
    echo '<p><a href="managementObras.php">Panel de introducción de Obras</a></p>';
}
require 'views/index.view.php';


?>
