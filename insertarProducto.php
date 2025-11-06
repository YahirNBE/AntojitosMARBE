<?php
include 'includes/conexion.php';



//Obtener imagen
$foto_producto = $_FILES["foto_producto"]["tmp_name"];
$nombrefoto_producto = $_FILES["foto_producto"]["name"];
$tipofoto_producto = strtolower(pathinfo($nombrefoto_producto, PATHINFO_EXTENSION));
$nom_producto = $_POST["nom_producto"];
$desc_producto = $_POST["desc_producto"];
$precio_producto = $_POST["precio_producto"];


//Revisar que el formato de la imagen sea correcto
if ($tipofoto_producto == "jpg" or $tipofoto_producto == "jpeg" or $tipofoto_producto == "png") {

    //Insertar datos en la base de datos
    $registro = $conexion->query("INSERT INTO `productos`( `foto_producto`, `nom_producto`, `desc_producto`, `precio_producto`, `disponible_producto`) VALUES (' ','$nom_producto', '$desc_producto', $precio_producto,1);");
    $idRegistro = $conexion->insert_id;
    
    //Insertar ruta de la imagen en la base de datos
    $actualizarFoto = $conexion->query("UPDATE `productos` SET `foto_producto`='archivos/$idRegistro.$tipofoto_producto' WHERE `id_producto`='$idRegistro'");

    //Almacenar la imagen 
    if(move_uploaded_file($foto_producto,"archivos/$idRegistro.$tipofoto_producto")){
        echo "<script> window.location.href = 'submenuProductos.php';</script>";
    }else{
        echo "<script> alert('Error al almacenar imagen.'); 
    window.location.href = 'submenuProductos.php';</script>";
    }


} else {
    echo "<script> alert('Solo se aceptan formatos jpg, jpeg y png.'); 
    window.location.href = 'submenuProductos.php';</script>";
}

echo "<script>
    history.replaceState(null,null,location.pathname);
</script>";


?>

