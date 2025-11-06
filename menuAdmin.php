<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antojitos MARBE</title>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
    <?php
    session_start();
    // Verificar si está logueado
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: index.html"); 
        exit();
    }
    ?>

    <!-- HTML del menú de opciones  -->
    <input type="checkbox" id="menu" />
    <label class="label-menu" for="menu"><img class="menu-icon" src="images/menu-icon.png" alt=""></label>
    <navbar class="navbar">
        <div class="logo">
            <a href="menuAdmin.php">
                <img src="images/logo.jpeg" class="img-logo" alt="">
                <p>Antojitos MARBE</p>
            </a>
        </div>

        <div class="line"></div>

        <div class="submenu">
            <ul>
                <li>
                    <a href="submenuUsuarios.php">
                        <img src="images/logo_usuarios.png" class="icono" alt="">
                        <p>Usuarios</p>
                    </a>
                </li>
                <li>
                    <a href="submenuProductos.php">
                        <img src="images/logo_productos.png" class="icono" alt="">
                        <p>Productos</p>
                    </a>
                </li>
                <li>
                    <a href="submenuPedidos.php">
                        <img src="images/logo_pedidos.png" class="icono" alt="">
                        <p>Pedidos</p>
                    </a>
                </li>
                <li>
                    <a href="submenuHistorialPedidos.php">
                        <img src="images/logo_historialpedidos.png" class="icono" alt="">
                        <p>Historial Pedidos</p>
                    </a>
                </li>
                <li>
                    <a href="submenuOpiniones.php">
                        <img src="images/logo_opiniones.png" class="icono" alt="">
                        <p>Opiniones</p>
                    </a>
                </li>
                <li>
                    <a href="submenuConfiguracion.php">
                        <img src="images/logo_configuracion.png" class="icono" alt="">
                        <p>Configuración</p>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sign-out">
            <div class="line"></div>
            <a href="logout.php">
                <img src="images/logo_cerrarsesion.png" class="icono" alt="">
                <p>Cerrar sesión</p>
            </a>
            <div class="line"></div>
        </div>
    </navbar>
    <!-- HTML del menú de opciones  -->

    <header class="header">
        <div class="header-content container">
            <h1>Antojitos MARBE</h1>
            <p>Ven y disfruta de una buena calidad de alimentos como enchiladas, flautas, tacos, etc.</p>
            <div class="buttons">
                <a href="logout.php" class="button-1">Ordenar</a>
                <a href="#info-extra" class="button-1">Más información</a>
            </div>
        </div>
    </header>

    <section id="info-extra" class="nosotros">
        <div class="nosotros-1">
            <h2>Sobre nosotros</h2>
            <p>
                En <strong>Antojitos MARBE</strong> creemos que la buena comida mexicana es para disfrutarse en todo
                momento. Por eso, te
                ofrecemos una gran variedad de antojitos tradicionales como enchiladas, flautas, tacos y mucho más,
                siempre preparados con ingredientes frescos y de la mejor calidad.
            </p>
        </div>
        <div class="nosotros-2"></div>
    </section>
    <section class="nosotros">
        <div class="nosotros-3"></div>
        <div class="nosotros-1">
            <p>
                Nuestro compromiso es brindarte un sabor casero y auténtico que te haga sentir como en casa. Contamos
                con servicio a domicilio para que disfrutes de tus platillos favoritos sin salir de la comodidad de tu
                hogar.
                <br>
                Con sucursales en Mitras Poniente y Real de Cumbres, en Monterrey, seguimos creciendo gracias a la
                confianza de nuestros clientes, quienes nos motivan cada día a mantener la calidad y el buen servicio
                que nos caracteriza.
            </p>
        </div>
    </section>

    <main class="menu-productos">
        <p><img src="images/menu.jpeg" alt=""></p>
    </main>

    <section class="mapas">
        <h2>Ubicaciones</h2>
        <div class="mapas-content container">
            <div class="mapa1">
                <h3>Sucursal Mitras Poniente</h3>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d898.1758824838158!2d-100.43506547949576!3d25.780354288101844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x866290a17644e569%3A0x3828635e84f0b188!2sAv%20Villa%20Corona%201159%2C%20Mitras%20Poniente%2C%2066023%20Villas%20del%20Poniente%2C%20N.L.!5e0!3m2!1ses-419!2smx!4v1756081881509!5m2!1ses-419!2smx"
                    width="500" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="mapa1">
                <h3>Sucursal Real de Cumbres</h3>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3593.5154368348713!2d-100.4030584164582!3d25.75353331555991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8662972efe2b9687%3A0x1ee18555fff0466a!2sReal%20de%20Cumbres%20704%2C%20Real%20Cumbres%2C%2064346%20Monterrey%2C%20N.L.!5e0!3m2!1ses-419!2smx!4v1756081984402!5m2!1ses-419!2smx"
                    width="500" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content container">
            <ul>
                <li>
                    <img src="images/telefono-icono.png" alt="">
                    <p>81 8083 3708</p>
                </li>
                <li>
                    <img src="images/correo-icono.png" alt="">
                    <p>marbetrevi@icloud.com</p>
                </li>
                <li>
                    <a href="https://www.facebook.com/Antojitosmarbe" target="_blank">
                        <img src="images/facebook-icono.png" alt="">
                        <p>¡Visitanos en Facebook!</p>
                    </a>
                </li>
                <li>
                    <div class="line2"></div>
                </li>
                <li>
                    <p>Antojitos MARBE</p>
                </li>
            </ul>
        </div>
    </footer>

</body>

</html>