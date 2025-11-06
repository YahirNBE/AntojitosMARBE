<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antojitos MARBE</title>
    <link rel="stylesheet" href="css/ordenar.css">
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
    <label class="label-menu" for="menu"><img class="menu-icon" id="menuIcon" src="images/menu-iconBlanco.png"
            alt=""></label>
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



    <header class="topbar container">
        <div class="brand">
            <img src="images/logo.jpeg" alt="" class="logo2">
            <h1>Antojitos MARBE</h1>
        </div>
        <p class="subtitle">Menú para pedidos</p>
    </header>


    <!-- Mostrar productos disponibles -->
    <section class="menu-grid container" aria-label="Menú de Antojitos">
        <!-- Tarjeta -->
        <!-- <div class="card">
            <img class="card_img" src="images/antojitos.png" alt="Comida">
            <div class="card_content">
                <h2 class="card_title">aa Nombre del producto aa </h2>
                <p class="card_desc">Descripción xdxdañs asdlf añklsdjf ñlkasj dfñlkasj d lñfkjasñlkd fjlkldfñlaks
                    djfñlkas jdfñlkaj sñdlkf jaslkñdf jñlaksdjfñlaks djfxdxdxdxdxdd</p>
                <div class="card_price">$100</div>
                <div class="card_controls">
                    <label class="check">
                        <input type="checkbox" name="">
                        <p>Añadir</p>
                    </label>
                    <label class="qty">
                        Cantidad
                        <input type="number" name="" min="1" value="1">
                    </label>

                </div>
            </div>
        </div> -->
        <?php
        include 'includes/conexion.php';



        $sql = "SELECT * FROM productos WHERE disponible_producto=1";
        $result = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($result) > 0) {
            $card = '';
            while ($row = mysqli_fetch_array($result)) {
                $card .= '
                            <div class="card">
                                <img class="card_img" src="' . $row["foto_producto"] . '" alt="Comida">
                                <div class="card_content">
                                    <h2 class="card_title">' . $row["nom_producto"] . '</h2>
                                    <p class="card_desc">' . $row["desc_producto"] . '</p>
                                    <div class="card_price">$' . $row["precio_producto"] . '</div>
                                 <div class="card_controls">
                                        <label class="check">
                                            <input type="checkbox" name="checkbox_id_' . $row["id_producto"] . '">
                                            <p>Añadir</p>
                                        </label>
                                        <label class="qty">
                                            Cantidad
                                            <input type="number" name="cantidad_id_' . $row["id_producto"] . '" min="1" value="1">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        ';
            }
            echo $card;
        }
        ?>
    </section>

    <!-- Extra como queso, aguacate y tortillas -->
    <section class="extras container">
        <h3>Extras</h3>
        <div class="extras_row">
            <label class="check">
                <input type="checkbox" name="extra_queso" id="extra_queso"> Queso extra (+$10)
            </label>
            <label class="check">
                <input type="checkbox" name="extra_aguacate" id="extra_aguacate"> Aguacate (+$10)
            </label>
            <label class="check">
                <input type="checkbox" name="extra_tortillas" id="extra_tortillas"> Tortillas extra (+$10)
            </label>
        </div>
    </section>

    <!-- Requerimientos extra que requiera -->
    <section class="extras container">
        <h3>Algún extra que requiera</h3>
        <textarea name="requisito_extra" rows="4" cols="40" id="requisito_extra"></textarea>
    </section>


    <section class="pedido container">
        <!-- Forma de entrega -->
        <fieldset class="entrega">
            <legend>Forma de entrega</legend>
            <div class="entrega_options">
                <label class="radio-pill">
                    <input type="radio" id="recoger_input" name="entrega" value="recoger" checked>
                    <span>Recoger en sucursal</span>
                </label>
                <label class="radio-pill">
                    <input type="radio" id="entregar_input" name="entrega" value="domicilio">
                    <span>A domicilio</span>
                </label>
            </div>
            <!-- Dirección solo si es a domicilio -->
            <div class="direccion-row" id="direccion-row">
                <div class="direccion-content">
                    <p><strong>Dirección de entrega:</strong>
                        <?php
                        include 'includes/conexion.php';


                        $id = $_SESSION['id_usuario'];
                        $sql = "SELECT direccion_usuario FROM usuarios WHERE id_usuario=" . $id;
                        $result = mysqli_query($conexion, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $direccion = '';
                            while ($row = mysqli_fetch_array($result)) {
                                $direccion = $row["direccion_usuario"];
                            }
                            echo $direccion;
                        }
                        ?>
                    </p>
                </div>
            </div>

            <!-- Sucursal  -->
            <div class="sucursal-row" id="sucursal-row">
                <div class="sucursal-content">
                    <p>Escoge una sucursal para recoger:</p>
                    <button id="mitras">Mitras Poniente</button>
                    <button id="realCumbres">Real de Cumbres</button>
                </div>
            </div>
        </fieldset>
        <button class="btn-primary" id="btn-modal">Enviar pedido</button>

    </section>

    <!-- Modal de resumen -->
    <div id="modalEnviar" class="Ventana">
        <div class="Ventana-content">
            <span class="cerrar">&times;</span>
            <h2>Resumen del pedido:</h2>
            <div id="resumenPedido"></div>
            <button id="btn-enviar">
                Enviar pedido
            </button>
        </div>
    </div>


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
        //Script de los checkbox de la forma de entrega
        const entregarCheckbox = document.getElementById("entregar_input");
        const recogerCheckbox = document.getElementById("recoger_input");
        tipoentregar = "Recoger";

        // Escucha cuando cambia el estado del checkbox
        entregarCheckbox.addEventListener("change", function () {
            if (entregarCheckbox.checked) {
                tipoentregar = "Domicilio";
                document.getElementById("direccion-row").style.display = "grid";
                document.getElementById("sucursal-row").style.display = "none";
            }
        });

        recogerCheckbox.addEventListener("change", function () {
            if (recogerCheckbox.checked) {
                tipoentregar = "Recoger";
                document.getElementById("sucursal-row").style.display = "grid";
                document.getElementById("direccion-row").style.display = "none";
            }
        });

        const mitras = document.getElementById("mitras");
        const realCumbres = document.getElementById("realCumbres");
        mitras.onclick = () => {
            tipoentregar = "RecogerMitras";
            mitras.style.backgroundColor = "#210802";
            realCumbres.style.backgroundColor = "#ed7d35";
        }
        realCumbres.onclick = () => {
            tipoentregar = "RecogerRealCumbres";
            realCumbres.style.backgroundColor = "#210802";
            mitras.style.backgroundColor = "#ed7d35";
        }
    </script>

    <script>
        //Script del resumen del modal
        const modal = document.getElementById("modalEnviar");
        const btnAbrir = document.getElementById("btn-modal");
        const btnCerrar = document.querySelector(".cerrar");
        const resumenDiv = document.getElementById("resumenPedido");

        // Abrir modal con resumen
        btnAbrir.onclick = () => {
            // 1. Recolectar productos seleccionados
            const productos = [];
            let total = 0;
            document.querySelectorAll("input[type=checkbox][name^='checkbox_id_']").forEach(chk => {
                if (chk.checked) {
                    const id = chk.name.replace("checkbox_id_", "");
                    const nombre = chk.closest(".card_content").querySelector(".card_title").innerText;
                    const precioTexto = chk.closest(".card_content").querySelector(".card_price").innerText;
                    const precio = parseFloat(precioTexto.replace("$", "").trim());
                    const cantidadInput = document.querySelector(`input[name='cantidad_id_${id}']`);
                    const cantidad = cantidadInput ? parseInt(cantidadInput.value) : 1;

                    const subtotal = precio * cantidad;
                    total += subtotal;

                    productos.push({ nombre: nombre, precio: precio, cantidad: cantidad, subtotal: subtotal });
                }
            });

            // 2. Recolectar extras
            const extras = [];
            if (document.getElementById("extra_queso").checked) {
                extras.push("Queso extra (+$10)");
                total += 10;
            }
            if (document.getElementById("extra_aguacate").checked) {
                extras.push("Aguacate (+$10)");
                total += 10;
            }
            if (document.getElementById("extra_tortillas").checked) {
                extras.push("Tortillas extra (+$10)");
                total += 10;
            }

            // 3. Comentario
            const comentario = document.getElementById("requisito_extra").value;

            // 4. Forma de entrega
            entrega = tipoentregar;
            if (entrega == "Domicilio") {
                extras.push("Cargo por envío (+$30)");
                total += 30;
            } else if (entrega == "RecogerMitras") {
                entrega = "Recoger en Mitras Poniente";
            } else if (entrega == "RecogerRealCumbres") {
                entrega = "Recoger en Real de Cumbres";
            }

            // 5. Construir resumen en texto
            let resumen = `Forma de entrega: ${entrega}\n\nPedido:\n`;
            if (productos.length === 0) {
                resumen += "⚠️ Ningún producto seleccionado\n";
            } else {
                productos.forEach(p => {
                    resumen += `${p.cantidad}x ${p.nombre} $${p.precio} = $${p.subtotal}\n`;
                });
            }

            resumen += "\nExtras:\n";
            if (extras.length === 0) {
                resumen += "Ninguno\n";
            } else {
                extras.forEach(e => resumen += `+ ${e}\n`);
            }

            if (comentario.trim() !== "") {
                resumen += `\nRequerimientos extra:\n"${comentario}"\n`;
            }

            resumen += `\nTotal: $${total}`;

            // 6. Mostrar en modal
            resumenDiv.textContent = resumen;

            // Mostrar modal
            modal.style.display = "flex";
        };

        // Cerrar modal con la X
        btnCerrar.onclick = () => modal.style.display = "none";

        // Cerrar modal si se hace clic fuera
        window.onclick = (e) => {
            if (e.target == modal) modal.style.display = "none";
        }
    </script>


    <script>
        //Script de enviar a ordenarCliente.php
        document.getElementById("btn-enviar").addEventListener("click", function () {
            if (confirm("¿Desea hacer el pedido?")) {
                const productos = [];
                let total = 0;
                let cantidadInvalida = false;

                // 1. Recolectar productos
                document.querySelectorAll("input[type=checkbox][name^='checkbox_id_']").forEach(chk => {
                    if (chk.checked) {
                        const id = chk.name.replace("checkbox_id_", "");
                        const nombre = chk.closest(".card_content").querySelector(".card_title").innerText;
                        const precioTexto = chk.closest(".card_content").querySelector(".card_price").innerText;
                        const precio = parseFloat(precioTexto.replace("$", "").trim());
                        const cantidadInput = document.querySelector(`input[name='cantidad_id_${id}']`);
                        const cantidad = cantidadInput ? parseInt(cantidadInput.value) : 1;

                        if (isNaN(cantidad) || cantidad < 1) {
                            cantidadInvalida = true;
                        }

                        total += precio * cantidad;

                        productos.push({
                            id: id,
                            cantidad: cantidad
                        });
                        // productos.push({
                        //     id: id,
                        //     nombre: nombre,
                        //     precio: precio,
                        //     cantidad: cantidad,
                        //     subtotal: subtotal
                        // });
                    }
                });

                // Validación 1: debe seleccionar un producto
                if (productos.length === 0) {
                    alert("Debe seleccionar al menos un producto.");
                    return;
                }

                // Validación 2: cantidad válida
                if (cantidadInvalida) {
                    alert("Debe escoger una cantidad válida (>=1).");
                    return;
                }

                // Validación 3: sucursal
                if (tipoentregar == "Recoger") {
                    alert("Al recoger en sucursal se debe indicar en cual sucursal desea recoger su pedido.");
                    return;
                }

                // 2. Recolectar extras
                const extras = [];
                if (document.getElementById("extra_queso").checked) {
                    extras.push({ nombre: "Queso extra", precio: 10 });
                    total += 10;
                }
                if (document.getElementById("extra_aguacate").checked) {
                    extras.push({ nombre: "Aguacate", precio: 10 });
                    total += 10;
                }
                if (document.getElementById("extra_tortillas").checked) {
                    extras.push({ nombre: "Tortillas extra", precio: 10 });
                    total += 10;
                }

                // 3. Comentario
                const comentario = document.getElementById("requisito_extra").value;

                // 4. Forma de entrega
                entrega = tipoentregar;
                if (entrega == "Domicilio") {
                    extras.push({ nombre: "Cargo por envío", precio: 30 });
                    total += 30;
                } else if (entrega == "RecogerMitras") {
                    entrega = "Recoger en Mitras Poniente";
                } else if (entrega == "RecogerRealCumbres") {
                    entrega = "Recoger en Real de Cumbres";
                }

                // 5. Enviar con fetch a ordenarCliente.php
                fetch("ordenarCliente.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        productos: productos,
                        extras: extras,
                        comentario: comentario,
                        entrega: entrega,
                        total: total
                    })
                })
                    .then(res => res.text())
                    .then(data => {
                        alert("Pedido enviado correctamente ");
                        console.log("Pedido:", data);
                        document.getElementById("modalEnviar").style.display = "none";
                    })
                    .catch(err => {
                        console.error("Error:", err);
                        alert("Hubo un error al enviar el pedido ");
                    });
            }
        });
    </script>





</body>

</html>