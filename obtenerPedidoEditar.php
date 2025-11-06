<?php
include 'includes/conexion.php';



if (isset($_POST['idPedido'])) {
    $id_pedido = $_POST['idPedido'];
    $sql = "SELECT id_pedido, estado_pedido FROM pedidos WHERE id_pedido = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $id_pedido);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row); // enviamos todo en JSON
    } else {
        echo json_encode(["error" => "Pedido no encontrado"]);
    }
}
?>
