<?php
$conexion = new mysqli("localhost", "root", "", "antojitosmarbe");


$filtro = $_POST['filtro'] ?? "nom_usuario";
$texto = $_POST['texto'] ?? "";

// Lista de columnas permitidas
$permitidos = ["nom_producto", "desc_producto", "precio_producto"];
if (!in_array($filtro, $permitidos)) {
    $filtro = "nom_producto";
}



$sql = "SELECT * FROM productos WHERE disponible_producto=1 AND $filtro LIKE ?";
$stmt = $conexion->prepare($sql);
$busqueda = "%$texto%";
$stmt->bind_param("s", $busqueda);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $table = '';
    while ($row = $resultado->fetch_assoc()) {
        $table .= '
        <tr>
        <td width="110px"><img class="table-image" src="' . $row["foto_producto"] . '" alt="Imagen"></td>
        <td width="150px">' . $row["nom_producto"] . '</td>
        <td>' . $row["desc_producto"] . '</td>
        <td width="110px">$' . $row["precio_producto"] . '</td>
        <td width="100px">' . $row["fecha_producto"] . '</td>
        <td width="90px">
            <div class="buttons">
                <button class="btn-2 btn-editar" data-editar="' . $row["id_producto"] . '">
                    <img src="images/logo_editar.png" alt="">
                </button>
                <button class="btn-3 btn-eliminar" data-eliminar="' . $row["id_producto"] . '" data-nombre="' . $row["nom_producto"] . '">
                    <img src="images/logo_eliminar.png" alt="">
                </button>
            </div>
        </td>
        </tr>
                        ';
    }
    echo $table;
} else {
    echo "<tr><td width='1200px' colspan='8'>No se encontraron resultados</td></tr>";
}
