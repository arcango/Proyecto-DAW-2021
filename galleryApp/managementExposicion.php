<?php session_start();

var_dump($_SESSION);
if (isset($_SESSION['encargado'])) {
    require 'views/managementExposicion.view.php';
} else {
    header('Location: index.php');
}
?>