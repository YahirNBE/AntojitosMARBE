<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antojitos MARBE</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="css/historialPedidos.css">
    <link rel="stylesheet" href="css/plantillaTicket.css">
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
        <h1>Historial de pedidos</h1>
        <div class="buscador">
            <div class="buscador-form">
                <p>Buscador</p>
                <select id="filtro">
                    <option value="pe.estado_pedido">Estado</option>
                    <option value="pe.entrega_pedido">Entrega</option>
                    <option value="u.nomcompleto_usuario">Cliente</option>
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
        <div class="fechas">
            <p>Filtrar por fechas:</p>
            <label for="fecha_inicio">Desde:</label>
            <input type="date" id="fecha_inicio">

            <label for="fecha_fin">Hasta:</label>
            <input type="date" id="fecha_fin">
        </div>
        <div class="buttons-excel">
            <button class="btn-excel" id="btn-excel">
                <img src="images/logo_excel.png" alt="">
                <p>Excel</p>
            </button>
        </div>
        <table width="100%">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Entrega</th>
                    <th class="fila-pedido">Pedido</th>
                    <th>Extra</th>
                    <th>Cliente</th>
                    <th>Dirección</th>
                    <th>Total</th>
                    <th>Tiempo de pedido</th>
                    <th>Ticket</th>
                </tr>
            </thead>
            <tbody id="resultados">
                <?php
                include 'includes/conexion.php';


                // Consulta de datos de los pedidos
                $sql = "SELECT 
                            pe.id_pedido,
                            pe.estado_pedido,
                            pe.entrega_pedido,
                            pe.extra_pedido,
                            pe.total_pedido,
                            pe.fecha_pedido,
                            u.nomcompleto_usuario,
                            u.direccion_usuario
                        FROM pedidos pe
                        INNER JOIN usuarios u ON pe.id_usuario = u.id_usuario";
                $result = mysqli_query($conexion, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $table = '';
                    while ($row = mysqli_fetch_array($result)) {
                        $lista_pedidos = "<ul>";
                        $sql2 = "SELECT
	                                pr.nom_producto,
                                    pr.precio_producto,
                                    dp.cantidad_detalle
                                FROM detalle_pedido dp
                                INNER JOIN productos pr ON pr.id_producto = dp.id_producto
                                WHERE dp.id_pedido=" . $row["id_pedido"];
                        $result2 = mysqli_query($conexion, $sql2);

                        while ($row2 = mysqli_fetch_array($result2)) {
                            // $lista_pedidos = $lista_pedidos . "<li>" . $row2["nom_producto"] . " (" . $row2["cantidad_detalle"] . ") $" . $row2["precio_producto"] . "</li>";
                            $lista_pedidos = $lista_pedidos . "<li>" . $row2["cantidad_detalle"] . "x " . $row2["nom_producto"] . " $" . $row2["precio_producto"] . "</li>";
                        }

                        $lista_pedidos = $lista_pedidos . "</ul>";

                        $direccionEntrega = "";
                        if ($row["entrega_pedido"] == "Domicilio") {
                            $direccionEntrega = $row["direccion_usuario"];
                        } else {
                            $direccionEntrega = $row["entrega_pedido"];
                        }

                        $table .= '
                        <tr>
                        <td>' . $row["estado_pedido"] . '</td>
                        <td>' . $row["entrega_pedido"] . '</td>
                        <td>' . $lista_pedidos . '</td>
                        <td>' . $row["extra_pedido"] . '</td>
                        <td>' . $row["nomcompleto_usuario"] . '</td>
                        <td>' . $direccionEntrega . '</td>
                        <td>$' . $row["total_pedido"] . '</td>
                        <td>' . $row["fecha_pedido"] . '</td>
                        <td>
                            <div class="buttons">
                                <button class="btn-pdf" data-pdf="' . $row["id_pedido"] . '"
                                fecha-pdf="' . $row["fecha_pedido"] . '" total-pdf="' . $row["total_pedido"] . '" nombre-pdf="' . $row["nomcompleto_usuario"] . '">
                                    <img src="images/logo_descargar.png" alt="">
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

    <!-- Contenedor oculto para generar el PDF -->
    <div id="preview" style="display:none;">
        <div class="tickethoja">
            <!-- Imagen logo -->
            <div class="ticketimagen">
                <br><br>
                <p><img src="images/logo.jpeg" alt=""></p>
            </div>

            <div class="ticketcontainer">
                <div class="ticketinfo">
                    <p>Sucursal Mitras Poniente: Av Villa Corona 1159, Mitras Poniente, 66023 Villas del Poniente, N.L.
                    </p>
                    <p>Sucursal Real Cumbres : Real de Cumbres 704, Real Cumbres, 64346 Monterrey, N.L.</p>
                    <p>Teléfono: 81-8083-3708</p>
                    <br>
                </div>
            </div>

            <div class="ticketline">
                <p>-----------------------------------------------------------------
                </p>
            </div>

            <div class="ticketdate">
                <p><span id="fechaHora"></span></p>
                <p>Cliente: <span id="nombreCompleto"></span></p>
            </div>

            <div class="ticketline">
                <p>-----------------------------------------------------------------
                </p>
            </div>

            <div class="ticketcontainer">
                <div class="tickettableCenter">
                    <table class="tickethead">
                        <thead>
                            <tr>
                                <th width="100px">Cantidad</th>
                                <th width="250px">Platillo</th>
                                <th width="100px">Precio</th>
                                <th width="100px">Total</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="ticketline">
                <p>-----------------------------------------------------------------
                </p>
            </div>

            <div class="ticketcontainer">
                <div class="tickettableCenter">
                    <table class="ticketbody">

                        <!-- Agregar platillos del pedido -->
                        <!-- 
                        <tr>
                            <td width="100px">3</td>
                            <td width="250px">Platillo...</td>
                            <td width="100px">$100</td>
                            <td width="100px">$300</td>
                        </tr> 
                        -->
                        <tbody id="platillos"></tbody>

                    </table>
                </div>
            </div>

            <div class="ticketline">
                <p>-----------------------------------------------------------------
                </p>
            </div>

            <div class="ticketcontainer">
                <div class="tickettotal">
                    <p>IVA (16%): $<span id="impuestoIVA"></span></p>
                    <p class="tickettotalCompra"><strong>Total: $<span id="totalCompra"></span></strong></p>
                </div>
            </div>

            <div class="ticketline">
                <p>-----------------------------------------------------------------
                </p>
            </div>

            <div class="ticketcontainer">
                <div class="ticketbye">
                    <br><br>
                    <p>Gracias por su visita!</p>
                </div>
            </div>


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
            let nombreArchivo = `HistorialPedidos_${dia}-${mes}-${anio}.xls`;

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

            fetch("buscarHistorialPedido.php", {
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
        //Script de descargar ticket
        document.addEventListener("click", function (e) {
            if (e.target.closest(".btn-pdf")) {
                let boton = e.target.closest(".btn-pdf");
                let idpedido = boton.getAttribute("data-pdf");
                let fecha = boton.getAttribute("fecha-pdf");
                let total = boton.getAttribute("total-pdf");
                let nombreCompleto = boton.getAttribute("nombre-pdf");
                let listaProductos = "";

                // Pedir datos de los productos al servidor
                fetch("obtenerProductosTicket.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "idPedido=" + encodeURIComponent(idpedido)

                })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.error) {
                            //Lista de productos encontrados 
                            listaProductos = data;
                            // console.log(listaProductos);
                            // console.log(fecha);
                            // console.log(total);
                            // console.log(nombreCompleto);


                            // Llenar los campos para el pdf
                            document.getElementById("fechaHora").textContent = fecha;
                            document.getElementById("nombreCompleto").textContent = nombreCompleto;
                            document.getElementById("platillos").innerHTML = listaProductos;
                            // document.getElementById("impuestoIVA").textContent = total * 0.16;
                            document.getElementById("impuestoIVA").textContent = parseFloat(total * 0.16).toFixed(2);;
                            document.getElementById("totalCompra").textContent = total;



                            const preview = document.getElementById("preview");
                            preview.style.display = "block";
                            // preview.style.display = "initial";

                            const { jsPDF } = window.jspdf;
                            const pdf = new jsPDF('p', 'pt', 'a4');

                            html2canvas(preview.querySelector(".tickethoja"), { scale: 2 }).then(canvas => {
                                const img = canvas.toDataURL("image/png");
                                const width = pdf.internal.pageSize.getWidth();
                                const height = canvas.height * width / canvas.width;
                                pdf.addImage(img, 'PNG', 0, 0, width, height);

                                pdf.save(`Ticket_${fecha}.pdf`);

                                preview.style.display = "none";
                            });

                        } else {
                            alert(data.error);
                        }
                    });


            }

        });
    </script>

    <script>
        // Script de filtrar por fechas
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        // Detectar cambios en cualquiera de los dos campos
        fechaInicio.addEventListener('change', filtrarPorFechas);
        fechaFin.addEventListener('change', filtrarPorFechas);


        function filtrarPorFechas() {
            const inicio = fechaInicio.value;
            const fin = fechaFin.value;


            // Solo enviar si ambas fechas están seleccionadas
            if (inicio && fin) {
                fetch('buscarFechasHistorialPedido.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: "fecha_inicio=" + inicio + "&fecha_fin=" + fin
                })
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById("resultados").innerHTML = data;
                    });
            }
        }
    </script>


</body>

</html>