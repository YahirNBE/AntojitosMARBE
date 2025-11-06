<?php
include 'includes/conexion.php';




if (isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];

    // $sql = "DELETE FROM usuarios WHERE BINARY nom_usuario = ?";
    $sql = "UPDATE `usuarios` SET `activo_usuario`= 0 WHERE BINARY nom_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);

    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente";
    } else {
        echo "Error al eliminar el usuario";
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "No se recibió el usuario";
}
?>
