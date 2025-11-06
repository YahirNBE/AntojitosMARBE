<?php
// conexion.php
$host = "localhost";
$user = "root";
$password = "";
$database = "antojitosmarbe";

// Crear la conexión
$conexion = mysqli_connect($host,$user,$password,$database);

// Verificar conexión
if(!$conexion){
    die("No hay conexión :".mysqli_connect_error());
}
?>
