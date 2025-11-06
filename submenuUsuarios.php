<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antojitos MARBE</title>
    <link rel="stylesheet" href="css/usuarios.css">
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
    <label class="label-menu" for="menu"><img class="menu-icon" id="menuIcon" src="images/menu-iconBlanco.png" alt=""></label>
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


    <header class="header container">
        <h1>Usuarios</h1>
        <div class="buscador">
            <div class="buscador-form">
                <p>Buscador</p>
                <select id="filtro">
                    <option value="nom_usuario">Usuario</option>
                    <option value="nomcompleto_usuario">Nombre</option>
                    <option value="correo_usuario">Correo</option>
                    <option value="rol_usuario">Rol</option>
                </select>
                <input type="text" id="texto" placeholder="Escribe tu búsqueda...">
                <button id="buscar">
                    <img src="images/logo_lupa.png" style="width: 15px; height: 15px; margin: 1px 2px 0 2px;"
                        alt="Buscar">
                </button>
            </div>
        </div>
    </header>

    <div class="table container">
        <button class="btn-1" id="btnAbrirModal">
            <img src="images/logo_agregar.png" alt="">
            <p>Añadir Usuario</p>
        </button>
        <table width="100%">
            <thead>
                <tr>
                    <th>Nombre de usuario</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Rol</th>
                    <th>Fecha de registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="resultados">
                <?php
                // Cadena de conexión
                $hostname = "localhost";
                $username = "root";
                $password = "";
                $basedatosname = "antojitosmarbe";

                //Crear cadena conexión
                $conexion = mysqli_connect($hostname, $username, $password, $basedatosname);

                //Revisar conexión
                if (!$conexion) {
                    die("Error al conectar " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM usuarios WHERE activo_usuario=1";
                $result = mysqli_query($conexion, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $table = '';
                    while ($row = mysqli_fetch_array($result)) {
                        $table .= '
                        <tr>
                        <td>' . $row["nom_usuario"] . '</td>
                        <td>' . $row["nomcompleto_usuario"] . '</td>
                        <td>' . $row["correo_usuario"] . '</td>
                        <td>' . $row["tel_usuario"] . '</td>
                        <td>' . $row["direccion_usuario"] . '</td>
                        <td>' . $row["rol_usuario"] . '</td>
                        <td>' . $row["fecha_usuario"] . '</td>
                        <td>
                            <div class="buttons">
                                <button class="btn-2 btn-editar" data-editar="' . $row["nom_usuario"] . '">
                                    <img src="images/logo_editar.png" alt="">
                                </button>
                                <button class="btn-3 btn-eliminar" data-eliminar="' . $row["nom_usuario"] . '">
                                    <img src="images/logo_eliminar.png" alt="">
                                </button>
                            </div>
                        </td>
                        </tr>
                        ';
                    }
                    echo $table;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar -->
    <div id="modalAgregar" class="Ventana">
        <div class="Ventana-content">
            <span class="cerrar">&times;</span>
            <h2>Agregar Nuevo Usuario</h2>
            <form method="POST" action="insertarUsuario.php">
                <label>Nombre de usuario:</label>
                <input type="text" name="nom_usuario" required>
                <br>
                <label>Nombre completo:</label>
                <input type="text" name="nomcompleto" required>
                <br>
                <label>Teléfono:</label>
                <input type="text" name="telefono" required>
                <br>
                <label>Correo:</label>
                <input type="email" name="correo" required>
                <br>
                <label>Contraseña:</label>
                <input type="password" name="password" required>
                <br>
                <label>Confirmar contraseña:</label>
                <input type="password" name="password2" required>
                <br>
                <label>Dirección:</label>
                <input type="text" name="direccion" required>
                <br>
                <label>Rol:</label>
                <select name="rol_usuario" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Empleado">Empleado</option>
                    <option value="Cliente">Cliente</option>
                </select>
                <br>
                <button type="submit"><img src="images/logo_guardar.png" alt="">
                    <p>Guardar</p>
                </button>
            </form>
        </div>
    </div>


    <!-- Modal para editar -->
    <div id="modalEditar" class="Ventana">
        <div class="Ventana-content">
            <span class="cerrarEditar">&times;</span>
            <h2>Editar Usuario</h2>
            <form method="POST" action="editarUsuario.php">
                <label>Nombre de usuario:</label>
                <input type="text" name="nom_usuario" id="editar_nom_usuario" readonly>
                <br>
                <label>Nombre completo:</label>
                <input type="text" name="nomcompleto" id="editar_nomcompleto" required>
                <br>
                <label>Teléfono:</label>
                <input type="text" name="telefono" id="editar_telefono" required>
                <br>
                <label>Correo:</label>
                <input type="email" name="correo" id="editar_correo" required>
                <br>
                <label>Dirección:</label>
                <input type="text" name="direccion" id="editar_direccion" required>
                <br>
                <label>Rol:</label>
                <select name="rol_usuario" id="editar_rol" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Empleado">Empleado</option>
                    <option value="Cliente">Cliente</option>
                </select>
                <br>
                <button type="submit"><img src="images/logo_guardar.png" alt="">
                    <p>Guardar</p>
                </button>
            </form>
        </div>
    </div>



    <script>
        //Script de buscar 
        document.getElementById("buscar").addEventListener("click", function (e) {
            e.preventDefault(); // evita que recargue

            let filtro = document.getElementById("filtro").value;
            let texto = document.getElementById("texto").value;

            fetch("buscarUsuario.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "filtro=" + filtro + "&texto=" + encodeURIComponent(texto)
            })
                .then(res => res.text())
                .then(data => {
                    document.getElementById("resultados").innerHTML = data;
                });
        });
    </script>

    <script>
        //Script de agregar
        const modal = document.getElementById("modalAgregar");
        const btnAbrir = document.getElementById("btnAbrirModal");
        const btnCerrar = document.querySelector(".cerrar");

        // Abrir modal
        btnAbrir.onclick = () => modal.style.display = "flex";

        // Cerrar modal con la X
        btnCerrar.onclick = () => modal.style.display = "none";

        // Cerrar modal si se hace clic fuera
        window.onclick = (e) => {
            if (e.target == modal) modal.style.display = "none";
        }
    </script>

    <script>
        //Script de eliminar 
        document.addEventListener("click", function (e) {
            if (e.target.closest(".btn-eliminar")) {
                let boton = e.target.closest(".btn-eliminar");
                let usuario = boton.getAttribute("data-eliminar");

                if (confirm("¿Deseas eliminar al usuario '" + usuario + "'?")) {
                    fetch("eliminarUsuario.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "usuario=" + encodeURIComponent(usuario)
                    })
                        .then(res => res.text())
                        .then(respuesta => {
                            alert(respuesta);
                            location.reload(); // Recargar la tabla
                        });
                }
            }
        });
    </script>

    <script>
        //Script de editar 
        document.addEventListener("click", function (e) {
            if (e.target.closest(".btn-editar")) {
                let boton = e.target.closest(".btn-editar");
                let usuario = boton.getAttribute("data-editar");

                // Pedir datos al servidor
                fetch("obtenerUsuario.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "usuario=" + encodeURIComponent(usuario)
                })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.error) {
                            // Llenar formulario con los datos
                            document.getElementById("editar_nom_usuario").value = data.nom_usuario;
                            document.getElementById("editar_nomcompleto").value = data.nomcompleto_usuario;
                            document.getElementById("editar_telefono").value = data.tel_usuario;
                            document.getElementById("editar_correo").value = data.correo_usuario;
                            document.getElementById("editar_direccion").value = data.direccion_usuario;
                            document.getElementById("editar_rol").value = data.rol_usuario;

                            // Mostrar modal
                            document.getElementById("modalEditar").style.display = "flex";
                        } else {
                            alert(data.error);
                        }
                    });
            }
        });

        // Cerrar modal editar
        document.querySelector(".cerrarEditar").onclick = () => {
            document.getElementById("modalEditar").style.display = "none";
        };
    </script>

    <script>
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