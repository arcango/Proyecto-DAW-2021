<!-- Página de acceso para los gerentes de los museos -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Usamos font-awesome para los iconos -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <script type="text/javascript" src="./js/scriptCargaProvinciaLocalidad.js"></script>
    <title>Registro</title>
</head>

<body>
    <div class="contenedor">
        <p class="botones_navegacion">
            <button class="boton-navegacion"><a href="cerrar.php">Cerrar Sesión</a></button>
        </p>
        <h1 class="titulo">Registro</h1>
        <p class="botones_navegacion">
            <button class="boton-navegacion"><a href="index.php">Ir a la página principal</a></button>
            <button class="boton-navegacion"><a href="admin.php">Gestionar Encargados</a></button>
            <button class="boton-navegacion"><a href="listaUsuarios.php">Administrar Usuarios</a></button>
        </p>
        <br>
        <hr class="border">

        <!-- hmlspecialchars nos permite asegurarnos de que no nos van a inyectar cógigo -->

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formulario" name="login">
            <div class="form-group">
                <i title="icono de institución" alt="icono de institución" class="icono izquierda fa fa-university"></i><input type="text" name="nombre_galeria" class="nombre_galeria" placeholder="Nombre del Museo o Galería">
            </div>
            <div class="form-group">
                <i title="icono de dirección" alt="icono de dirección" class="icono izquierda fa fa-address-book-o"></i><input type="text" name="direccion" class="direccion" placeholder="Direccion">
            </div>
            <div class="form-group">
                <i title="icono de dirección" alt="icono de dirección" class="icono izquierda fa fa-address-book-o"></i><input type="text" name="g_map" class="g_map" placeholder="Enlace de Google Maps">
            </div>
            <div class="form-group">
                <i title="icono de marcador" alt="icono de marcador" class="icono izquierda fa fa-map-marker"></i><select style="height: 38px; font-size: 14px" id="provincia" name="provincia" class="provincia" placeholder="Selecciona Provincia">
                    <option>

                    </option>
                </select>
            </div>
            <div class="form-group">
                <i title="icono de marcador" alt="icono de marcador" class="icono izquierda fa fa-map-marker"></i><select style="height: 38px; font-size: 14px" id="municipio" name="localidad" class="localidad" placeholder="Selecciona Localidad">
                    <option>

                    </option>
                </select>
            </div>
            <div class="form-group">
                <i title="icono de teléfono" alt="icono de teléfono" class="icono izquierda fa fa-phone"></i><input type="numeric" name="telefono" class="telefono" placeholder="Teléfono">
            </div>
            <div class="form-group">
                <i title="icono de sobre" alt="icono de sobre" class="icono izquierda fa fa-envelope-o"></i><input type="email" name="email_galeria" class="correo_galeria" placeholder="Email de la Galería">
            </div>
            <hr class="border">
            <div class="form-group">
                <i title="icono de usuario" alt="icono de usuario" class="icono izquierda fa fa-user"></i><input type="text" name="usuario" class="usuario" placeholder="Nombre y Apellidos">
            </div>
            <div class="form-group">
                <i title="icono de usuario" alt="icono de usuario" class="icono izquierda fa fa-user"></i><input type="text" name="nombre_usuario" class="nombre_usuario" placeholder="Nombre de Usuario">
            </div>
            <div class="form-group">
                <i title="icono de sobre" alt="icono de sobre" class="icono izquierda fa fa-envelope-o"></i><input type="email" name="email" class="correo" placeholder="Email">
            </div>
            <div class="form-group">
                <i title="icono de candado" alt="icono de candado" class="icono izquierda fa fa-lock"></i><input type="password" name="password" class="password" placeholder="Contraseña">
            </div>
            <div class="form-group">
                <i title="icono de candado" alt="icono de candado" class="icono izquierda fa fa-lock"></i><input type="password" name="password2" class="password_btn" placeholder="Repetir Contraseña">
                <i title="botón de enviar" alt="botón de enviar" class="submit-btn fa fa-arrow-right" onclick="login.submit()"></i>
            </div>

            <!-- este campo me sirve para obtener el resultado de texto del campo "provincia" que es un option que se vale de su value para cargar asíncronamente el JSON de los municipios -->

            <input type="hidden" id="resultadoProvincia" name="resultadoProvincia">

            <?php if (!empty($errores)) : ?>
                <div class="errores">
                    <ul>
                        <?php echo $errores; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <br>

</body>

</html>