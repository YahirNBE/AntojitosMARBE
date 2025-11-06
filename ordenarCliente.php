<?php
include 'includes/conexion.php';



//Iniciar sesión para mi usuario cliente
session_start();
$idusuario = $_SESSION['id_usuario'];

//Recibir datos tipo JSON
$data = json_decode(file_get_contents("php://input"), true);


$productos = $data["productos"];
$extras = $data["extras"];
$comentario = $data["comentario"];
$entrega = $data["entrega"];
$total = $data["total"];

$listaExtra = "";

if ($comentario != "") {
    if (empty($extras)) {
        $listaExtra = $comentario;
    } else {
        $listaExtra = $comentario;
        foreach ($extras as $e) {
            $nombreExtra = $e["nombre"];
            $precioExtra = $e["precio"];
            $listaExtra = $listaExtra . ", " . $nombreExtra . " ($" . $precioExtra . ")";
        }
    }
} else {
    if (empty($extras)) {
        $listaExtra = "No hay extras.";
    } else {
        $i = 1;
        foreach ($extras as $e) {
            if ($i == 1) {
                $nombreExtra = $e["nombre"];
                $precioExtra = $e["precio"];
                $listaExtra = $nombreExtra . " ($" . $precioExtra . ")";
                $i = 2;
            } else {
                $nombreExtra = $e["nombre"];
                $precioExtra = $e["precio"];
                $listaExtra = $listaExtra . ", " . $nombreExtra . " ($" . $precioExtra . ")";
            }
        }
    }

}




//Guardar y recibir id en tabla 'pedidos'
$sql = "INSERT INTO `pedidos`(`id_usuario`, `total_pedido`, `estado_pedido`, `extra_pedido`, `entrega_pedido`, `disponible_pedido`) 
VALUES ($idusuario,$total,'Recibido','$listaExtra','$entrega',1)";
if (mysqli_query($conexion, $sql)) {
    $idPedido = mysqli_insert_id($conexion); // Obtener el último ID
} else {
    echo "Error: " . mysqli_error($conexion);
}

//Guardar en 'detalle_pedido'
foreach ($productos as $p) {
    $id_producto = $p["id"];
    $cantidad = $p["cantidad"];
    // Insert en detalle de la orden

    $sql2 = "INSERT INTO `detalle_pedido`( `id_pedido`, `id_producto`, `cantidad_detalle`)
 VALUES ($idPedido,$id_producto,$cantidad )";
    if (!mysqli_query($conexion, $sql2)) {
        echo "Error: " . mysqli_error($conexion);
    }
}



//Imprimir datos recibidos
echo "Pedido recibido";
?>