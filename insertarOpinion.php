<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["error" => "No se recibieron datos"]);
    exit;
}
include 'includes/conexion.php';


if (!$conexion) {
    echo json_encode(["success" => false, "error" => "Error de conexión"]);
    exit;
}

session_start();
$idUsuario = $_SESSION['id_usuario'];
$idPedido = $data["pedido"];
$comentario = $data["comentario"];
$calificacion = $data["calificacion"];

// Insertar en tabla (ajusta los nombres de tabla y campos)
$sql = "DELETE FROM `opiniones` WHERE id_pedido = $idPedido;";
$eliminarOpinion = mysqli_query($conexion,$sql);

$sql = "INSERT INTO `opiniones`(`id_usuario`, `id_pedido`, `comentario_opinion`, `calificacion_opinion`) VALUES ($idUsuario,$idPedido,'$comentario',$calificacion)";
$subirOpinion = mysqli_query($conexion,$sql);



echo json_encode(["success" => true]);


?>