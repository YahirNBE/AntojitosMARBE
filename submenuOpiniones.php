<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antojitos MARBE</title>
    <link rel="stylesheet" href="css/opiniones.css">
</head>

<body>
    <?php
    session_start();
    // Verificar si está logueado
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: index.html");
        exit();
    }
    $rol = $_SESSION['rol_usuario'];
    ?>

    <!-- HTML del menú de opciones  -->
    <input type="checkbox" id="menu" />
    <label class="label-menu" for="menu"><img class="menu-icon" id="menuIcon" src="images/menu-iconBlanco.png"
            alt=""></label>
    <navbar class="navbar">
        <div class="logo">
            <?php if ($rol == "Administrador") { ?>
                <a href="menuAdmin.php">
                    <img src="images/logo.jpeg" class="img-logo" alt="">
                    <p>Antojitos MARBE</p>
                </a>
            <?php } else { ?>
                <a href="menuEmpleado.php">
                    <img src="images/logo.jpeg" class="img-logo" alt="">
                    <p>Antojitos MARBE</p>
                </a>
            <?php } ?>
        </div>

        <div class="line"></div>

        <div class="submenu">
            <ul>
                <?php if ($rol == "Administrador") { ?>
                    <li>
                        <a href="submenuUsuarios.php">
                            <img src="images/logo_usuarios.png" class="icono" alt="">
                            <p>Usuarios</p>
                        </a>
                    </li>
                <?php } ?>
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
                <?php if ($rol == "Administrador") { ?>
                    <li>
                        <a href="submenuHistorialPedidos.php">
                            <img src="images/logo_historialpedidos.png" class="icono" alt="">
                            <p>Historial Pedidos</p>
                        </a>
                    </li>
                <?php } ?>
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

    <header class="header container">
        <h1>Opiniones</h1>
    </header>


    <!-- Mostrar productos disponibles -->
    <section class="menu-grid container">
        <!-- Tarjeta -->
        <!-- <div class="card">
            <div class="card_perfil">
                <img src="images/logo_userOpinion.png">
                <p>Yahir Nicolas Blanco Elizondo</p>
            </div>
            <div class="card_inf">
                <img src="images/logo_5e.png">
                <p>2025/09/15</p>
            </div>
            <p class="card_desc">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Mollitia est expedita
                voluptatibus neque! Quidem eveniet id nemo ipsam rerum voluptate quos dicta, perspiciatis ab nihil
                aut consequuntur illum nesciunt culpa.
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Mollitia est expedita
                voluptatibus neque! Quidem eveniet id nemo ipsam rerum voluptate quos dicta, perspiciatis ab nihil
                aut consequuntur illum nesciunt culpa.
            </p>
        </div> -->
        <?php
        include 'includes/conexion.php';



        $sql = "SELECT
                    u.nomcompleto_usuario,
                    p.calificacion_opinion,
                    p.fecha_opinion,
                    p.comentario_opinion
                FROM opiniones p
                INNER JOIN usuarios u ON u.id_usuario = p.id_usuario ";

        $result = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($result) > 0) {
            $card = '';
            while ($row = mysqli_fetch_array($result)) {
                $card .= '
                        <div class="card">
                            <div class="card_perfil">
                                <img src="images/logo_userOpinion.png">
                                <p>' . $row["nomcompleto_usuario"] . '</p>
                            </div>
                            <div class="card_inf">
                                <img src="images/logo_' . $row["calificacion_opinion"] . 'e.png">
                                <p>' . $row["fecha_opinion"] . '</p>
                            </div>
                            <p class="card_desc">
                            ' . $row["comentario_opinion"] . '
                            </p>
                        </div>  
                        ';
            }
            echo $card;
        }
        ?>
    </section>






    <script>
        //Script del menú hamburguesa
        const menuCheckbox = document.getElementById("menu");
        const menuIcon = document.getElementById("menuIcon");

        // Escucha cuando cambia el estado del checkbox
        menuCheckbox.addEventListener("change", function () {
            if (menuCheckbox.checked) {
                menuIcon.src = "images/menu-icon.png";
            } else {
                menuIcon.src = "images/menu-iconBlanco.png";
            }
        });
    </script>

</body>

</html>