<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antojitos MARBE</title>
    <link rel="stylesheet" href="css/productos.css">
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
    <label class="label-menu" for="menu"><img class="menu-icon" src="images/menu-icon.png"
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
        <h1>Productos</h1>
        <div class="buscador">
            <div class="buscador-form">
                <p>Buscador</p>
                <select id="filtro">
                    <option value="nom_producto">Nombre</option>
                    <option value="desc_producto">Descripción</option>
                    <option value="precio_producto">Precio</option>
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
        <div class="buttons-excel">
            <button class="btn-1" id="btnAbrirModal">
                <img src="images/logo_agregar.png" alt="">
                <p>Añadir Producto</p>
            </button>
            <button class="btn-excel" id="btn-excel">
                <img src="images/logo_excel.png" alt="">
                <p>Excel</p>
            </button>
        </div>

        <table width="100%">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Fecha de registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="resultados">
                <?php
                include 'includes/conexion.php';



                $sql = "SELECT * FROM productos WHERE disponible_producto=1";
                $result = mysqli_query($conexion, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $table = '';
                    while ($row = mysqli_fetch_array($result)) {
                        $table .= '
                        <tr>
                        <td width="110px"><img class="table-image" src="' . $row["foto_producto"] . '" alt="Imagen"></td>
                        <td width="150px">' . $row["nom_producto"] . '</td>
                        <td>' . $row["desc_producto"] . '</td>
                        <td width="110px">$' . $row["precio_producto"] . '</td>
                        <td width="100px">' . $row["fecha_producto"] . '</td>
                        <td width="90px">
                            <div class="buttons">
                                <button class="btn-2 btn-editar" data-editar="' . $row["id_producto"] . '">
                                    <img src="images/logo_editar.png" alt="">
                                </button>
                                <button class="btn-3 btn-eliminar" data-eliminar="' . $row["id_producto"] . '" data-nombre="' . $row["nom_producto"] . '">
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
            <h2>Agregar Nuevo Producto</h2>
            <form method="POST" action="insertarProducto.php" enctype="multipart/form-data">
                <label>Imagen de producto:</label>
                <input class="inputImage" type="file" name="foto_producto" required>
                <br>
                <label>Nombre:</label>
                <input type="text" name="nom_producto" required>
                <br>
                <label>Descripción:</label>
                <input type="text" name="desc_producto" required>
                <br>
                <label>Precio:</label>
                <input type="number" name="precio_producto" required>
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
            <h2>Editar Producto</h2>
            <form method="POST" action="editarProducto.php" enctype="multipart/form-data">
                <label>Imagen de producto:</label>
                <input type="number" id="editar_id_producto" name="id_producto" hidden>
                <input class="inputImage" type="file" id="editar_foto_producto" name="foto_producto">
                <br>
                <label>Nombre:</label>
                <input type="text" id="editar_nom_producto" name="nom_producto" required>
                <br>
                <label>Descripción:</label>
                <input type="text" id="editar_desc_producto" name="desc_producto" required>
                <br>
                <label>Precio:</label>
                <input type="number" id="editar_precio_producto" name="precio_producto" required>
                <br>
                <button type="submit"><img src="images/logo_guardar.png" alt="">
                    <p>Guardar</p>
                </button>
            </form>
        </div>
    </div>

    <script>
        //Script de descargar Excel
        document.getElementById("btn-excel").addEventListener("click", function () {
            // Seleccionar la tabla
            let tabla = document.querySelector("table");

            // Crear un archivo Excel usando una tabla HTML
            let html = tabla.outerHTML;

            // Obtener fecha actual para el nombre del archivo
            let fecha = new Date();
            let dia = String(fecha.getDate()).padStart(2, '0');
            let mes = String(fecha.getMonth() + 1).padStart(2, '0');
            let anio = fecha.getFullYear();
            let nombreArchivo = `Productos_${dia}-${mes}-${anio}.xls`;

            // Crear un Blob con el contenido HTML de la tabla
            let blob = new Blob([`
            <html xmlns:x="urn:schemas-microsoft-com:office:excel">
            <head>
                <meta charset="UTF-8">
                <style>
                    table, th, td {
                        border: 1px solid black;
                        border-collapse: collapse;
                        text-align: center;
                    }
                    th {
                        background-color: #d9ead3;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                ${html}
            </body>
            </html>
        `], { type: "application/vnd.ms-excel" });

            // Crear enlace de descarga
            let enlace = document.createElement("a");
            enlace.href = URL.createObjectURL(blob);
            enlace.download = nombreArchivo;

            // Disparar la descarga
            enlace.click();

            // Liberar la URL del objeto
            URL.revokeObjectURL(enlace.href);
        });
    </script>



    <script>
        //Script de buscar
        document.getElementById("buscar").addEventListener("click", function (e) {
            e.preventDefault(); // evita que recargue

            let filtro = document.getElementById("filtro").value;
            let texto = document.getElementById("texto").value;

            fetch("buscarProducto.php", {
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
                let nomProducto = boton.getAttribute("data-nombre");
                let idProducto = boton.getAttribute("data-eliminar");

                if (confirm("¿Deseas eliminar el producto '" + nomProducto + "'?")) {
                    fetch("eliminarProducto.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "idProducto=" + encodeURIComponent(idProducto)
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
                let idProducto = boton.getAttribute("data-editar");
                // Pedir datos al servidor

                fetch("obtenerProducto.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "idProducto=" + encodeURIComponent(idProducto)
                })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.error) {
                            // Llenar formulario con los datos
                            // document.getElementById("editar_foto_producto").value = data.foto_producto;
                            document.getElementById("editar_id_producto").value = data.id_producto;
                            document.getElementById("editar_nom_producto").value = data.nom_producto;
                            document.getElementById("editar_desc_producto").value = data.desc_producto;
                            document.getElementById("editar_precio_producto").value = data.precio_producto;

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

</body>

</html>