<?php
$conexion = new mysqli("localhost", "root", "", "antojitosmarbe");


$filtro = $_POST['filtro'] ?? "pe.estado_pedido";
$texto = $_POST['texto'] ?? "";

// Lista de columnas permitidas
$permitidos = ["pe.estado_pedido", "pe.entrega_pedido", "u.nomcompleto_usuario"];
if (!in_array($filtro, $permitidos)) {
    $filtro = "pe.estado_pedido";
}

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
        INNER JOIN usuarios u ON pe.id_usuario = u.id_usuario
        WHERE $filtro LIKE '%$texto%'";
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

} else {
    echo "<tr><td width='1200px' colspan='8'>No se encontraron resultados</td></tr>";
}

