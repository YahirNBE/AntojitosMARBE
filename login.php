<?php
//Iniciar sesión
session_start();

include 'includes/conexion.php';


//Obtener filas del usuario que ingreso
$txtusuario = $_POST["txtusuario"];
$txtpassword = $_POST["txtpassword"];
$query = mysqli_query($conexion,"SELECT * FROM usuarios WHERE BINARY nom_usuario = '".$txtusuario."' AND BINARY pass_usuario='".$txtpassword."' AND activo_usuario=1");
$rows = mysqli_num_rows($query);

//Redirigir a la página correspondiente
if($rows == 1){
    $fila = mysqli_fetch_assoc($query);

    //Guardar datos de la sesión
    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['nom_usuario'] = $fila['nom_usuario'];
    $_SESSION['rol_usuario'] = $fila['rol_usuario'];

    //Redirigir según el rol del usuario
    if($fila['rol_usuario'] == 'Administrador'){
        header("Location: menuAdmin.php");
    }else if($fila['rol_usuario'] == 'Empleado'){
        header("Location: menuEmpleado.php");
    } else {
        header("Location: menuCliente.php");
    }
} else {
    echo "<script> alert('Usuario o contraseña erroneos.'); 
    window.location.href = 'login.html';</script>";
}

?>