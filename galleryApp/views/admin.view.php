<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Open+Sans&family=Oswald&display=swap" rel="stylesheet">
    <script type="text/javascript" src="http://ipwg.site90.net/jquery-1.2.3.min.js"></script>
    <script type="text/javascript" src="http://ipwg.site90.net/thickbox_compressed.js"></script>
    <link rel="stylesheet" href="http://ipwg.site90.net/thickbox.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/estilos.css">
    <title>Document</title>
</head>
<body>
    <div class="contenedor-management">
        <p class="botones_navegacion">
            <button class="boton-navegacion"><a href="cerrar.php">Cerrar Sesión</a></button>
        </p>
        <h1 class="titulo">Administración de Encargados</h1>
        <div class="botones_navegacion">
        
            <button class="boton-navegacion"><a href="register.php">Registrar Nuevo Usuario</a></button>
        
            <button class="boton-navegacion"><a href="index.php">Ir a la página principal</a></button>
        </div>
        <hr class="border">
        <div id="formularioEncargados">
        <?php if (!empty($errores)) : ?>
            <div class="errores">
                <ul>
                    <?php echo $errores; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formularioEncargados">
            <?php $daoAdmin->listarEncargados(); ?>
            <hr class="border">
            <input type="submit" name="actualizar" value="Actualizar" class="submit-btn">
            <input type="submit" name="eliminar" value="Eliminar" class="submit-btn">
            <hr class="border">
            
        </form>
        </div>
    </div>
</body>
</html>