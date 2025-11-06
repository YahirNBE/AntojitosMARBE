<?php
session_start();
include 'includes/conexion.php';



$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$id = $_SESSION['id_usuario'];

$sql = "UPDATE usuarios SET nomcompleto_usuario = '$nombre', tel_usuario = '$telefono', correo_usuario = '$correo', direccion_usuario = '$direccion'
            WHERE id_usuario = $id";
// $result = mysqli_query($conexion, $sql);

if (mysqli_query($conexion, $sql)) {
    echo "<script> alert('Datos guardados correctamente.'); 
    window.location.href = 'submenuConfiguracion.php';</script>";
} else {
    echo "<script> alert('Error al almacenar los datos.'); 
    window.location.href = 'submenuConfiguracion.php';</script>";
}

?>