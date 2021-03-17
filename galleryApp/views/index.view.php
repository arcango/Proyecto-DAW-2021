<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, 
        initial-scale=1.0 maximum-scale=1.0, minimum-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Open+Sans&family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <title>GalleryApp</title>
</head>

<body>
    <header>
        <div class="contenedor">
            <div class="logo izquierda">
                <p class="titulo-gallery"><a href="./index.php"><img src="./logoGalleryApp/logoGalleryApp.png" class="logo-gallery">GalleryApp</a></p>
            </div>
        </div>
    </header>
    <div class="derecha">
        <form name="busqueda" class="buscar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <input type="text" name="busqueda" placeholder="Buscar">
            <button type="submit" class="icono fa fa-search"></button>
        </form>
    </div>
</body>

</html>