<?php
include 'includes/conexion.php';




if (isset($_POST['idPedido'])) {
    $id_pedido = $_POST['idPedido'];
    //Revisar el estado del pedido
    $sql = "SELECT estado_pedido FROM pedidos WHERE id_pedido = $id_pedido";
    $result = mysqli_query($conexion, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if ($row["estado_pedido"] != "Terminado") {
            echo "No se puede eliminar este pedido debido a que su estado no es 'Terminado'.";
        } else {
            $sql2 = "UPDATE `pedidos` SET `disponible_pedido`=0 WHERE id_pedido = ?";
            $stmt = $conexion->prepare($sql2);
            $stmt->bind_param("i", $id_pedido);

            if ($stmt->execute()) {
                echo "Pedido eliminado correctamente";
            } else {
                echo "Error al eliminar el pedido";
            }

            $stmt->close();
            $conexion->close();
        }
    }
} else {
    echo "No se recibió el pedido";
}
?>