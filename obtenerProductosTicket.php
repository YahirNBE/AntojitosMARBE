<?php
include 'includes/conexion.php';




$id_pedido = $_POST['idPedido'];


// Obtener productos



$lista_pedidos = "";
$sql = "SELECT
            pr.nom_producto,
            pr.precio_producto,
            dp.cantidad_detalle,
            p.total_pedido
        FROM detalle_pedido dp
        INNER JOIN productos pr ON pr.id_producto = dp.id_producto
        INNER JOIN pedidos p ON p.id_pedido = dp.id_pedido
        WHERE dp.id_pedido=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();
// Variables para calcular los extras
$precioSubtotal = 0;
$precioTotalPedido = 0;

while ($row = mysqli_fetch_array($result)) {
    $subtotalTicket = $row["cantidad_detalle"] * $row["precio_producto"];
    $precioSubtotal = $precioSubtotal + $subtotalTicket;
    $precioTotalPedido = $row["total_pedido"];

    $lista_pedidos = $lista_pedidos . "<tr>";
    $lista_pedidos = $lista_pedidos . "<td width='100px'>" . $row["cantidad_detalle"] . "</td><td width='250px'>" . $row["nom_producto"] . "</td><td width='100px'>$" . $row["precio_producto"] . "</td><td width='100px'>$" . $subtotalTicket . "</td>";
    $lista_pedidos = $lista_pedidos . "</tr>";
}

// Agregar a mis platillos los extras 
// tomando el total menos lo que se sumo
if($precioSubtotal<$precioTotalPedido){
    $lista_pedidos = $lista_pedidos . "<tr>";
    $lista_pedidos = $lista_pedidos . "<td width='100px'>1</td><td width='250px'>Extras</td><td width='100px'>$" . $precioTotalPedido-$precioSubtotal . "</td><td width='100px'>$" . $precioTotalPedido-$precioSubtotal . "</td>";
    $lista_pedidos = $lista_pedidos . "</tr>";
}


echo json_encode($lista_pedidos); // enviamos todo en JSON


?>