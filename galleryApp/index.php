<?php session_start();

require('Modelos/daoBusqueda.php');

$errores = '';
try {
    $daoBusqueda = new DaoBusqueda("");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
// $daoBusqueda->listarYPrintarArtistasRandom();
if (isset($_SESSION['encargado']) && ($_SESSION['encargado'] == 'admin')) {

    echo '<p><a href="admin.php">Administración de Encargados</a></p>';
} elseif (isset($_SESSION['encargado'])) {

    echo '<p><a href="managementArtista.php">Panel de introducción de Artistas y Obras</a></p>';
}
// fecha de hoy
$_SESSION['hoy'] = date("Y-m-d");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['provincia'] == "- Provincia -") {
        $_SESSION['provincia'] = '- Provincia -';
        $errores .= '<li>Ups! Parece que se te ha olvidado decirnos dónde estás</li>';
    } else {
        $_SESSION['provincia'] = $_POST['resultadoProvincia'];
        header('Location: index.php');
    }
}


require 'views/index.view.php';
