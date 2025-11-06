<?php
include 'includes/conexion.php';



if (isset($_POST['idProducto'])) {
    $id_producto = $_POST['idProducto'];
    $sql = "SELECT id_producto,nom_producto,desc_producto,precio_producto FROM `productos` WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row); // enviamos todo en JSON
    } else {
        echo json_encode(["error" => "Producto no encontrado"]);
    }
}
?>
