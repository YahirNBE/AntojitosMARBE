<?php
include 'includes/conexion.php';



$filtro = $_POST['filtro'] ?? "nom_usuario";
$texto = $_POST['texto'] ?? "";

// Lista de columnas permitidas
$permitidos = ["nom_usuario", "nomcompleto_usuario", "correo_usuario", "rol_usuario"];
if (!in_array($filtro, $permitidos)) {
    $filtro = "nom_usuario";
}

$sql = "SELECT * FROM usuarios WHERE $filtro LIKE ?";
$stmt = $conexion->prepare($sql);
$busqueda = "%$texto%";
$stmt->bind_param("s", $busqueda);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo "
        <tr>
            <td>{$row['nom_usuario']}</td>
            <td>{$row['nomcompleto_usuario']}</td>
            <td>{$row['correo_usuario']}</td>
            <td>{$row['tel_usuario']}</td>
            <td>{$row['direccion_usuario']}</td>
            <td>{$row['rol_usuario']}</td>
            <td>{$row['fecha_usuario']}</td>
            <td>
                <div class='buttons'>
                    <button class='btn-2 btn-editar' data-editar='{$row['nom_usuario']}'>
                        <img src='images/logo_editar.png'>
                    </button>
                    <button class='btn-3 btn-eliminar' data-eliminar='{$row['nom_usuario']}'>
                        <img src='images/logo_eliminar.png'>
                    </button>
                </div>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td width='1200px' colspan='8'>No se encontraron resultados</td></tr>";
}
