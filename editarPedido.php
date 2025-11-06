<?php
include 'includes/conexion.php';



if (isset($_POST['id_pedido'])) {
    $id_pedido = $_POST['id_pedido'];
    $estado_pedido = $_POST['estado_pedido'];

    $sql = "UPDATE pedidos 
            SET estado_pedido = ?
            WHERE id_pedido = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si",  $estado_pedido, $id_pedido);

    if ($stmt->execute()) {
        echo "<script>alert('Pedido editado correctamente'); window.location.href='submenuPedidos.php';</script>";
    } else {
        echo "<script>alert('Error al editar el pedido'); window.location.href='submenuPedidos.php';</script>";
    }

    $stmt->close();
    $conexion->close();
}

?>