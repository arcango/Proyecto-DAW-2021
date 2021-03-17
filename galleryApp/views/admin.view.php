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
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Administración de Encargados</title>
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
        <?php if (!empty($errores)) : ?>
            <div class="errores">
                <ul>
                    <?php echo $errores; ?>
                </ul>
            </div>
        <?php endif; ?>
        <hr class="border">
        <h1 class="titulo">Actualización de Actividad</h1>
        <h2 class="titulo">Se pueden actualizar varios a la vez</h2>
        <div id="formularioEncargados">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formularioEncargados">
                <div class="contenedor-tabla">
                    <?php $daoAdmin->listarEncargados(); ?>
                </div>
                <hr class="border">
                <h1 class="titulo">Formulario de Actualización de Encargados</h1>
                <h2 class="titulo">Sólo se podrá actualizar uno a la vez</h2>
                <div class="contenedor-formulario-encargados">
                    <div class="form-group">
                        <i title="icono de usuario" alt="icono de usuario" class="icono izquierda fa fa-user"></i><input type="text" name="i_nombre_encargado" class="usuario" placeholder="Nombre y Apellidos">
                    </div>
                    <div class="form-group">
                        <i title="icono de usuario" alt="icono de usuario" class="icono izquierda fa fa-user"></i><input type="text" name="i_nombre_usuario" class="nombre_usuario" placeholder="Nombre de Usuario">
                    </div>
                    <div class="form-group">
                        <i title="icono de sobre" alt="icono de sobre" class="icono izquierda fa fa-envelope-o"></i><input type="email" name="i_email" class="correo" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <i title="icono de candado" alt="icono de candado" class="icono izquierda fa fa-lock"></i><input type="password" name="i_password" class="password" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <i title="icono de candado" alt="icono de candado" class="icono izquierda fa fa-lock"></i><input type="password" name="i_password2" class="password" placeholder="Repetir Contraseña">
                    </div>
                </div>
                <hr class="border">
                <input type="submit" name="actualizarEncargado" value="Actualizar Encargado" class="submit-btn">
                <input type="submit" name="actualizarActividad" value="Actualizar Actividad" class="submit-btn">
                <!-- <input type="submit" name="eliminarEncargado" value="Eliminar Encargado" class="submit-btn"> -->
                <hr class="border">

            </form>
        </div>
    </div>
</body>

</html>