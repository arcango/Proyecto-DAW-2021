<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, 
        initial-scale=1.0 maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <script type="text/javascript" src="http://ipwg.site90.net/jquery-1.2.3.min.js"></script>
    <script type="text/javascript" src="http://ipwg.site90.net/thickbox_compressed.js"></script>
    <link rel="stylesheet" href="http://ipwg.site90.net/thickbox.css" type="text/css" media="screen" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Open+Sans&family=Oswald&display=swap" rel="stylesheet">

    <title>GalleryApp</title>
</head>
<body>
<div class="header">
        <div class="logo izquierda">
            <p class="titulo-gallery"><a href="./index.php"><img src="./logoGalleryApp/logoGalleryApp.png" class="logo-gallery">GalleryApp</a></p>
        </div>
    </div>
<?php 
$id_exposicion = trim(stripslashes(htmlspecialchars($_GET['id'])));
if ((isset($_GET['id'])) && ($_GET['id']) > 0) {
    $daoBusqueda->listarYPrintarExposicionesSingle($id_exposicion);
} else {
    header('Location: index.php');
}
  ?>
  <br>
<div class="pie">
        <h2><a href="contacto.php">Contacta con nosotros</a></h2>
    </div>
</body>
</html>