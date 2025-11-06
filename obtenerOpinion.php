<?php
//Conectar base de datos
include 'includes/conexion.php';



if (isset($_POST['pedido'])) {
    $idPedido = $_POST['pedido'];
    $sql = "SELECT * FROM `opiniones` WHERE id_pedido = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPedido);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row); // enviamos todo en JSON
    }else{
        echo json_encode("Null");
    }
}
?>