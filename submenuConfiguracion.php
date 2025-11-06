<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antojitos MARBE</title>
    <link rel="stylesheet" href="css/configuracion.css">
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
    <label class="label-menu" for="menu"><img class="menu-icon" id="menuIcon" src="images/menu-iconBlanco.png"></label>
    <navbar class="navbar">
        <div class="logo">
            <?php if ($rol == "Administrador") { ?>
                <a href="menuAdmin.php">
                    <img src="images/logo.jpeg" class="img-logo" alt="">
                    <p>Antojitos MARBE</p>
                </a>
            <?php } elseif ($rol == "Empleado") { ?>
                <a href="menuEmpleado.php">
                    <img src="images/logo.jpeg" class="img-logo" alt="">
                    <p>Antojitos MARBE</p>
                </a>
            <?php } else { ?>
                <a href="menuCliente.php">
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
                <?php } elseif ($rol == "Empleado") { ?>
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
                <?php } else { ?>
                    <li>
                        <a href="submenuOrdenar.php">
                            <img src="images/logo_pedidos.png" class="icono" alt="">
                            <p>Ordenar</p>
                        </a>
                    </li>
                    <li>
                        <a href="submenuHistorialOrdenes.php">
                            <img src="images/logo_historialpedidos.png" class="icono" alt="">
                            <p>Historial ordenes</p>
                        </a>
                    </li>
                    <li>
                        <a href="submenuConfiguracion.php">
                            <img src="images/logo_configuracion.png" class="icono" alt="">
                            <p>Configuración</p>
                        </a>
                    </li>
                <?php } ?>
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


    <br>
    <form method="POST" action="configuracion.php">
        <div class="table container">
            <div class="header">
                <img src="images/logo.jpeg" class="logo2" alt="">
                <h2>Configuración de cuenta</h2>
            </div>
            <p class="table-info">Gestiona tu perfil</p>
            <div class="perfil">
                <p class="perfil-text">Perfil</p>
                <label for="nombre">NOMBRE</label><br>
                <input id="nombre" name="nombre" type="text" placeholder="Nombre Completo" required>
                <br>
                <label for="correo">CORREO ELECTRÓNICO</label><br>
                <input id="correo" name="correo" type="text" placeholder="Correo Electrónico" required>
                <br>
                <label for="telefono">TELÉFONO</label><br>
                <input id="telefono" name="telefono" type="text" placeholder="Teléfono" required>
                <br>
                <label for="direccion">DIRECCIÓN</label><br>
                <input id="direccion" name="direccion" type="text" placeholder="Dirección" required>
                <br>
            </div>


            <div class="buttons">
                <?php if ($rol == "Administrador") { ?>
                    <a href="menuAdmin.php">
                        Cancelar
                    </a>
                <?php } elseif ($rol == "Empleado") { ?>
                    <a href="menuEmpleado.php">
                        Cancelar
                    </a>
                <?php } else { ?>
                    <a href="menuCliente.php">
                        Cancelar
                    </a>
                <?php } ?>
                <button>Guardar cambios</button>
            </div>
        </div>
    </form>

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

    <script>
        //Cargar datos del usuario para editarlos
        <?php
        // Cadena de conexión
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $basedatosname = "antojitosmarbe";
        $conexion = mysqli_connect($hostname, $username, $password, $basedatosname);
        if (!$conexion) {
            die("Error al conectar " . mysqli_connect_error());
        }

        $id = $_SESSION['id_usuario'];

        $sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
        $result = mysqli_query($conexion, $sql);

        while ($row = mysqli_fetch_array($result)) {
            echo 'document.getElementById("nombre").value = "'. $row["nomcompleto_usuario"] .'";';
            echo 'document.getElementById("correo").value = "'. $row["correo_usuario"] .'";';
            echo 'document.getElementById("telefono").value = "'. $row["tel_usuario"] .'";';
            echo 'document.getElementById("direccion").value = "'. $row["direccion_usuario"] .'";';
        }
        ?>

    </script>

</body>

</html>