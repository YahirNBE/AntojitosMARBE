<?php
include 'includes/conexion.php';



if (isset($_POST['nom_usuario'])) {
    $usuario = $_POST['nom_usuario'];
    $nombre = $_POST['nomcompleto'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $rol = $_POST['rol_usuario'];

    $sql = "UPDATE usuarios 
            SET nomcompleto_usuario = ?, tel_usuario = ?, correo_usuario = ?, direccion_usuario = ?, rol_usuario = ?
            WHERE BINARY nom_usuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss",  $nombre, $telefono, $correo, $direccion, $rol, $usuario);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario editado correctamente'); window.location.href='submenuUsuarios.php';</script>";
    } else {
        echo "<script>alert('Error al editar el usuario'); window.location.href='submenuUsuarios.php';</script>";
    }

    $stmt->close();
    $conexion->close();
}

?>
