<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Open+Sans&family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Document</title>
</head>

<body>
    <div class="contenedor-management">
        <p class="botones_navegacion">
            <button class="boton-navegacion"><a href="cerrar.php">Cerrar Sesión</a></button>
        </p>
        <h1 class="titulo">Hola <?php echo $_SESSION['encargado']; ?></h1>
        <div class="botones_navegacion">
            <button class="boton-navegacion"><a href="index.php">Ir a la página principal</a></button>
            <button class="boton-navegacion"><a href="managementArtista.php">Administrar Artistas</a></button>
            <button class="boton-navegacion"><a href="managementObras.php">Administrar Obras</a></button>
        </div>
        <hr class="border">
    </div>
</body>

</html>