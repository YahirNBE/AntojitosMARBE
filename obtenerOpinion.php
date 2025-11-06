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