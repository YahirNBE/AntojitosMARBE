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
