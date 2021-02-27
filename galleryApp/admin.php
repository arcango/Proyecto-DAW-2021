<?php session_start();

require('Modelos/daoAdmin.php');

$errores = '';
try {
    $daoAdmin = new DaoAdmin('gallery_app');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (isset($_SESSION['encargado'])) {
    require('views/admin.view.php');
}