<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Registro</title>
</head>

<body>
<div class="header">
        <div class="logo izquierda">
            <p class="titulo-gallery"><a href="./index.php"><img src="./logoGalleryApp/logoGalleryApp.png" class="logo-gallery">GalleryApp</a></p>
        </div>
    </div>
    <div class="contenedor">
        <h1 class="titulo">Contacta con nosotros</h1>
        <h2 class="titulo">Te contestaremos lo antes posible</h2>
        <hr class="border">

        <?php if (!empty($errores)) : ?>
            <div class="errores">
                <ul>
                    <?php echo $errores; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formularioUsuario" name="formularioUsuario">
         
            <div class="form-group">
                <i title="icono de usuario" alt="icono de usuario" class="icono izquierda fa fa-user"></i><input type="text" name="nombre_usuario" class="nombre_usuario" placeholder="Nombre de Usuario">
            </div>
            <div class="form-group">
                <i title="icono de sobre" alt="icono de sobre" class="icono izquierda fa fa-envelope-o"></i><input type="email" name="email" class="correo" placeholder="Correo Electrónico">
            </div>
            <div class="form-group">
            <textarea class="textarea-usuario" name="texto_usuario" style="height:200px" placeholder="¿En qué podemos ayudarte?"></textarea>
            </div>
            <div class="form-group">
            <input type="submit" name="enviar" value="Enviar" class="submit-btn">
            </div>

        </form>
    </div>
    <br>

</body>

</html>