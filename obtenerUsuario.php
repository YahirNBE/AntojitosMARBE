<?php
include 'includes/conexion.php';



if (isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
    $sql = "SELECT * FROM usuarios WHERE BINARY nom_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row); // enviamos todo en JSON
    } else {
        echo json_encode(["error" => "Usuario no encontrado"]);
    }
}
?>
