<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Open+Sans&family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Administración de Artistas</title>
</head>

<body>
    <div class="contenedor-management">
        <p class="botones_navegacion">
            <button class="boton-navegacion"><a href="cerrar.php">Cerrar Sesión</a></button>
        </p>

        <h1 class="titulo">Hola <?php echo $_SESSION['encargado']; ?></h1>
        <div class="botones_navegacion">
            <button class="boton-navegacion"><a href="index.php">Ir a la página principal</a></button>
            <!-- <button class="boton-navegacion"><a href="managementArtista.php">Administrar Artistas</a></button> -->
            <!-- <button class="boton-navegacion"><a href="managementObras.php">Administrar Obras</a></button> -->
        </div>
        <hr class="border">
        <div id="formularioArtistas">
            <?php if (!empty($errores)) : ?>
                <div class="errores">
                    <ul>
                        <?php echo $errores; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <h1 class="titulo">Selección, Actualización e Inserción de Artistas</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formularioArtistas">
                <div class="contenedor-tabla">
                    <?php $daoArtista->listarYPrintarArtistas(); ?>
                </div>
                <hr class="border">
                <input type="submit" name="seleccionar" value="Seleccionar" class="submit-btn">
                <input type="submit" name="actualizar" value="Actualizar" class="submit-btn">
                <input type="submit" name="insertar" value="Insertar" class="submit-btn">
                <hr class="border">

            </form>
        </div>
    </div>

</body>

</html>