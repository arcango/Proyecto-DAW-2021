<?php session_start();

require('Modelos/daoBusqueda.php');

$errores = '';
try {
    $daoBusqueda = new DaoBusqueda("");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$id_exposicion = trim(stripslashes(htmlspecialchars($_GET['id'])));
if ((isset($_GET['id'])) && ($_GET['id']) > 0) {
    // $post = $daoBusqueda->listarYPrintarExposicionesSingle($_GET['id']);
} else {
    header('Location: index.php');
}


require 'views/single-post.view.php';