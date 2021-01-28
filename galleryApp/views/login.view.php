
<!-- Página de acceso para los gerentes de los museos -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Usamos font-awesome para los iconos -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Iniciar Sesion</title>
</head>

<body>
    <div class="contenedor">
        <h1 class="titulo">Iniciar Sesión</h1>
        <hr class="border">
        <!-- hmlspecialchars nos permite asegurarnos de que no nos van a inyectar cógigo -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formulario" name="login">
            <div class="form-group">
                <i title="icono de usuario" alt="icono de usuario" class="icono izquierda fa fa-user"></i><input type="text" name="nombre_usuario" class="nombre_usuario" placeholder="Nombre de Usuario">
            </div>
            <div class="form-group">
                <i title="icono de candado" alt="icono de candado" class="icono izquierda fa fa-lock"></i><input type="password" name="password" class="password_btn" placeholder="Contraseña">
                <i title="botón de enviar" alt="botón de enviar"class="submit-btn fa fa-arrow-right" onclick="login.submit()"></i>
            </div>
            <!-- En caso de error, lo mostraremos como una lista -->
            <?php if(!empty($errores)): ?>
                <div class="errores">
                    <ul>
                        <?php echo $errores;?>
                    </ul>
                </div>
            <?php endif; ?>
        </form>

        <p class="texto-registrate">
            ¿Aún no tienes cuenta?
            <a href="register.php">Regístrate</a>
    </div>
</body>

</html>