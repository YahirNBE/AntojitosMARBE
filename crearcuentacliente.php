<?php
include 'includes/conexion.php';



//Obtener contraseñas del usuario 
$password = $_POST["password"];
$password2 = $_POST["password2"];

//Revisar que las contraseñas coincidan
if ($password != $password2) {
    echo "<script> alert('Las contraseñas no coinciden.'); 
    window.location.href = 'crearcuentacliente.html';</script>";
} else {
    $usuario = $_POST["usuario"];
    $nomcompleto = $_POST["nomcompleto"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];


    //Revisar que no haya alguien con el mismo nombre de usuario
    $queryprueba = mysqli_query($conexion, "SELECT * FROM usuarios WHERE BINARY nom_usuario='" . $usuario . "'");
    $rows = mysqli_num_rows($queryprueba);

    if ($rows >= 1) {
        echo "<script> alert('El nombre de usuario ya es utilizado por otra persona.'); 
    window.location.href = 'login.html';</script>";
    } else {
        //Realizar query en la base de datos
        $query = mysqli_query($conexion, "INSERT INTO `usuarios`(`nom_usuario`, `nomcompleto_usuario`, `correo_usuario`, `pass_usuario`, `tel_usuario`, `direccion_usuario`, `rol_usuario`,`activo_usuario`) VALUES ('" . $usuario . "','" . $nomcompleto . "','" . $correo . "','" . $password . "','" . $telefono . "','" . $direccion . "','Cliente',1) ");

        //Mostrar el mensaje correspondiente
        if ($query) {
            echo "<script>alert('Cuenta creada exitosamente'); window.location='login.html';</script>";
        } else {
            echo "<script>alert('Error al crear la cuenta: " . mysqli_error($conexion) . "');</script>";
        }

    }



}

?>