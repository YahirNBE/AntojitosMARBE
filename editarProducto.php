<?php
include 'includes/conexion.php';



if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    //Obtener imagen anterior
    $query = "SELECT foto_producto FROM `productos` WHERE id_producto = ?";
    $statement = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($statement, "i", $id_producto);
    mysqli_stmt_execute($statement);
    $resultado = mysqli_stmt_get_result($statement);
    $fila = mysqli_fetch_assoc($resultado);
    $rutaAnterior = $fila['foto_producto'];


    //Obtener imagen nueva
    $foto_producto = $_FILES["foto_producto"]["tmp_name"];
    $nombrefoto_producto = $_FILES["foto_producto"]["name"];
    $tipofoto_producto = strtolower(pathinfo($nombrefoto_producto, PATHINFO_EXTENSION));


    //Si se recibe una imagen se cambia en nuestros archivos
    if (is_file($foto_producto)) {
        // Revisar formato del archivo
        if ($tipofoto_producto == "jpg" or $tipofoto_producto == "jpeg" or $tipofoto_producto == "png") {

            // Eliminar imagen anterior en los archivos
            $rutaNueva = "archivos/$id_producto.$tipofoto_producto";
            unlink($rutaAnterior);

            //Poner imagen nueva en los archivos y cambiarla en la base de datos
            if (move_uploaded_file($foto_producto, $rutaNueva)) {
                //Editar los datos en la base de datos
                $nom_producto = $_POST['nom_producto'];
                $desc_producto = $_POST['desc_producto'];
                $precio_producto = $_POST['precio_producto'];

                $sql = "UPDATE productos 
            SET foto_producto = ?,nom_producto = ?, desc_producto = ?, precio_producto = ?
            WHERE id_producto = ?";

                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("sssii",$rutaNueva, $nom_producto, $desc_producto, $precio_producto, $id_producto);

                if ($stmt->execute()) {
                    echo "<script>alert('Producto editado correctamente.'); window.location.href='submenuProductos.php';</script>";
                } else {
                    echo "<script>alert('Error al editar el producto.'); window.location.href='submenuProductos.php';</script>";
                }
                $stmt->close();
                $conexion->close();

            } else {
                echo "<script> alert('Error al guardar la imagen.'); 
                window.location.href = 'submenuProductos.php';</script>";
            }


        } else {
            echo "<script> alert('Solo se aceptan formatos jpg, jpeg y png.'); 
                window.location.href = 'submenuProductos.php';</script>";
        }
    } else {
        //Editar los datos en la base de datos
        $nom_producto = $_POST['nom_producto'];
        $desc_producto = $_POST['desc_producto'];
        $precio_producto = $_POST['precio_producto'];

        $sql = "UPDATE productos 
            SET nom_producto = ?, desc_producto = ?, precio_producto = ?
            WHERE id_producto = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssii", $nom_producto, $desc_producto, $precio_producto, $id_producto);

        if ($stmt->execute()) {
            echo "<script>alert('Producto editado correctamente.'); window.location.href='submenuProductos.php';</script>";
        } else {
            echo "<script>alert('Error al editar el producto.'); window.location.href='submenuProductos.php';</script>";
        }
        $stmt->close();
        $conexion->close();
    }


}

echo "<script>
    history.replaceState(null,null,location.pathname);
</script>";
?>