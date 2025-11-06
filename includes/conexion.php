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


// Prueba de conexión a github con la tablet para ver si funciona correctamente
// no se que más hacer 


?>
