<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Open+Sans&family=Oswald&display=swap" rel="stylesheet">
    <script type="text/javascript" src="http://ipwg.site90.net/jquery-1.2.3.min.js"></script>
    <script type="text/javascript" src="http://ipwg.site90.net/thickbox_compressed.js"></script>
    <link rel="stylesheet" href="http://ipwg.site90.net/thickbox.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/estilos.css">
    <title>Administración de Exposiciones</title>
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
        </div>
        <div id="formularioExposiciones">
            <h1 class="titulo">Actualización e Inserción de Exposiciones</h1>
            <?php if (!empty($errores)) : ?>
                <div class="errores">
                    <ul>
                        <?php echo $errores; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <hr class="border">
            <h1 class="titulo">Exposiciones Actuales</h1>
            <h2 class="titulo">Formulario de Actualización</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" class="formularioExposiciones">
                <div class="contenedor-tabla">
                    <?php $daoExposicion->listarYPrintarExposicionDeGaleria($_SESSION['id_galeria']); ?>
                </div>
                <hr class="border">
                <h1 class="titulo">Formulario de creación de Exposición</h1>
                <h2 class="titulo">Vas a crear una exposición sobre <?php $daoArtista->obtenerNombreArtistas($_SESSION['id_artista']); ?> con la obra <?php $daoObra->obtenerNombreObra($_SESSION['id_obra']); ?></h2>
                <hr class="border">
                <table class="tabla">
                    <tr class="t-head">
                        <th>Nombre Exposicíon</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Finalización</th>
                        <th>Cartel</th>
                        <th>Descripción del Cartel</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="i_nombre_exposicion"></td>
                        <td><input type="date" name="i_fecha_inicio"></td>
                        <td><input type="date" name="i_fecha_fin"></td>
                        <td><input type="file" name="i_cartel"></td>
                        <td><input type="text" name="i_descripcion_cartel" </td>
                    </tr>
                    <tr class="t-head">
                        <th colspan="5">Texto de la Exposición</th>
                    </tr>
                    <tr>
                        <td colspan="5"><textarea name="i_texto_exposicion" rows="20" cols="130"></textarea></td>
                    </tr>
                </table>
                <hr class="border">
                <input type="submit" name="crear" value="Crear" class="submit-btn">
                <input type="submit" name="actualizar" value="Actualizar" class="submit-btn">
                <input type="submit" name="eliminar" value="Eliminar" class="submit-btn">
                <hr class="border">

            </form>
            <div id="modal">

            </div>
        </div>
    </div>

</body>

</html>