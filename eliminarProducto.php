<?php
//Conectar base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "antojitosmarbe";
$conexion = mysqli_connect($host, $user, $password, $database);
if (!$conexion) {
    die("No hay conexión :" . mysqli_connect_error());
}


if (isset($_POST['idProducto'])) {
    $id_producto = $_POST['idProducto'];

    $sql = "UPDATE `productos` SET `disponible_producto`=0 WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $id_producto);

    if ($stmt->execute()) {
        echo "Producto eliminado correctamente";
    } else {
        echo "Error al eliminar el producto";
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "No se recibió el producto";
}
?>
