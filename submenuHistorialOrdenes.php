<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antojitos MARBE</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="css/historialOrdenes.css">
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
    ?>

    <!-- HTML del menú de opciones  -->
    <input type="checkbox" id="menu" />
    <label class="label-menu" for="menu"><img class="menu-icon" id="menuIcon" src="images/menu-iconBlanco.png"></label>
    <navbar class="navbar">
        <div class="logo">
            <a href="menuCliente.php">
                <img src="images/logo.jpeg" class="img-logo" alt="">
                <p>Antojitos MARBE</p>
            </a>
        </div>

        <div class="line"></div>

        <div class="submenu">
            <ul>
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
        <h1>Historial de ordenes</h1>
    </header>

    <div class="table container">
        <table width="100%">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Entrega</th>
                    <th class="fila-pedido">Pedido</th>
                    <th>Extra</th>
                    <th>Dirección</th>
                    <th>Total</th>
                    <th>Tiempo de pedido</th>
                    <th class="fila-opinionTicket">Opinión y ticket</th>
                </tr>
            </thead>
            <tbody>
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
                $idUsuario = $_SESSION['id_usuario'];


                // Consulta de datos de los pedidos
                $sql = "SELECT 
                            pe.id_pedido,
                            pe.estado_pedido,
                            pe.entrega_pedido,
                            pe.extra_pedido,
                            pe.total_pedido,
                            pe.fecha_pedido,
                            u.direccion_usuario,
                            u.nomcompleto_usuario
                        FROM pedidos pe
                        INNER JOIN usuarios u ON pe.id_usuario = u.id_usuario
                        WHERE u.id_usuario=$idUsuario ORDER BY pe.fecha_pedido DESC";
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
                        <td>' . $direccionEntrega . '</td>
                        <td><strong>$' . $row["total_pedido"] . '</strong></td>
                        <td>' . $row["fecha_pedido"] . '</td>
                        <td>
                            <div class="buttons">
                                <button class="btn-1 btn-opinion" data-opinion="' . $row["id_pedido"] . '">
                                    <img src="images/logo_opinion.png" alt="">
                                </button>
                                <button class="btn-2 btn-pdf" data-pdf="' . $row["id_pedido"] . '"
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


    <!-- Modal para calificar y comentar -->
    <div id="modalComentar" class="Ventana">
        <div class="Ventana-content">
            <span class="cerrarComentar">&times;</span>
            <h2>Comentar experiencia</h2>
            <form>

                <!-- Área de comentario -->
                <textarea id="comentario" placeholder="Escribe tu comentario aquí..."></textarea>
                <br>

                <!-- Estrellas -->
                <label>Calificación:</label>
                <div id="rating">
                    <img src="images/logo_estrellaLlena.png" data-value="1" class="estrella" width="40">
                    <img src="images/logo_estrellaLlena.png" data-value="2" class="estrella" width="40">
                    <img src="images/logo_estrellaLlena.png" data-value="3" class="estrella" width="40">
                    <img src="images/logo_estrellaLlena.png" data-value="4" class="estrella" width="40">
                    <img src="images/logo_estrellaLlena.png" data-value="5" class="estrella" width="40">
                </div>


                <button onclick="guardarComentario()"><img src="images/logo_guardar.png" alt="">
                    <p>Guardar</p>
                </button>
            </form>
        </div>
    </div>

    <script>
        //Script de modal opinion 
        let idpedido = 0;
        let estrellas = document.querySelectorAll(".estrella");
        let calificacion = 5;

        document.addEventListener("click", function (e) {
            if (e.target.closest(".btn-opinion")) {
                let boton = e.target.closest(".btn-opinion");
                idpedido = boton.getAttribute("data-opinion");

                // Pedir datos al servidor
                fetch("obtenerOpinion.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "pedido=" + encodeURIComponent(idpedido)
                })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.error) {
                            if (data == "Null") {
                                // Significa que no hay un comentario aun
                                document.getElementById("comentario").value = "";
                            } else {
                                // Llenar formulario con los datos
                                document.getElementById("comentario").value = data.comentario_opinion;
                                estrellas.forEach(e => {
                                    if (e.getAttribute("data-value") <= data.calificacion_opinion) {
                                        e.style.opacity = "1";
                                        e.src = "images/logo_estrellaLlena.png";
                                    } else {
                                        e.style.opacity = "0.4";
                                        e.src = "images/logo_estrellaVacia.png";
                                    }
                                });
                                calificacion = data.calificacion_opinion;
                            }

                            // Mostrar modal
                            document.getElementById("modalComentar").style.display = "flex";
                        } else {
                            alert(data.error);
                        }
                    });
            }
        });

        // Cerrar modal opinion
        document.querySelector(".cerrarComentar").onclick = () => {
            document.getElementById("comentario").value = "";
            estrellas.forEach(e => e.src = "images/logo_estrellaLlena.png");
            estrellas.forEach(e => e.style.opacity = "1");
            calificacion = 5;
            document.getElementById("modalComentar").style.display = "none";
        };

        //Script de evento listener de estrellas
        estrellas.forEach(estrella => {
            estrella.addEventListener("click", () => {
                calificacion = estrella.getAttribute("data-value");

                // Resaltar hasta la estrella seleccionada
                estrellas.forEach(e => {
                    if (e.getAttribute("data-value") <= calificacion) {
                        e.style.opacity = "1";
                        e.src = "images/logo_estrellaLlena.png";
                    } else {
                        e.style.opacity = "0.4";
                        e.src = "images/logo_estrellaVacia.png";
                    }
                });
            });
        });

        function guardarComentario() {
            let comentario = document.getElementById("comentario").value;

            if (comentario == "") {
                alert("Por favor escribe un comentario valido.");
                return;
            }

            // Enviar con fetch
            fetch("insertarOpinion.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    pedido: idpedido,
                    comentario: comentario,
                    calificacion: calificacion
                })
            })
                .then(res => res.text()) // primero como texto para depurar
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        alert("El servidor no devolvió JSON válido");
                        return;
                    }

                    if (!data.error) {
                        // alert("¡Opinión guardada correctamente!");
                    } else {
                        alert(data.error);
                    }
                })

        }
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