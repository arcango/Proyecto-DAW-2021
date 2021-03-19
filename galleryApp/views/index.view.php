<?php require 'header.php'; ?>
<body>
    <div class="header">
        <div class="logo izquierda">
            <p class="titulo-gallery"><a href="./index.php"><img src="./logoGalleryApp/logoGalleryApp.png" class="logo-gallery">GalleryApp</a></p>
        </div>
    </div>
    <p class="pregunta">¿Dónde estás?</p>
    <?php if (!empty($errores)) : ?>
        <div class="errores">
            <ul>
                <?php echo $errores; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div id="imagen">
        <div class="formbuscador">
            <form name="busqueda" class="formularioBusqueda" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="buscador buscadorP">
                    <select style="height: 38px; font-size: 14px" id="provincia" name="provincia" class="provincia">
                        <option>

                        </option>
                    </select>

                    <button type="submit" class="icono fa fa-search"></button>

                </div>

                <input type="hidden" id="resultadoProvincia" name="resultadoProvincia">
                <input type="hidden" id="resultadoLocalidad" name="resultadoLocalidad">
            </form>
        </div>
    </div>
    <?php if ((isset($_SESSION['provincia'])) && ($_SESSION['provincia']) != '- Provincia -') $daoBusqueda->listarYPrintarExposicionesBlog($_SESSION['provincia']) ?>
    
    <div class="artistas">
        
        <h1>Artistas</h1>
    
        <?php $daoBusqueda->listarYPrintarArtistasRandom(); ?>
    </div>
    </div>
    <div class="pie">
        <h2><a href="contacto.php">Contacta con nosotros</a></h2>
    </div>
</body>

</html>