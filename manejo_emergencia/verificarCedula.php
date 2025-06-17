<?php
include("../conex_bd.php");

header('Content-Type: application/json');

if (isset($_GET['cedula'])) {
    $cedula = intval($_GET['cedula']);

    $consulta = "SELECT COUNT(*) as total FROM usuarios WHERE id = $cedula";
    $resultado = mysqli_query($conexion, $consulta);
    $data = mysqli_fetch_assoc($resultado);

    echo json_encode(['encontrado' => $data['total'] > 0]);
} else {
    echo json_encode(['encontrado' => false]);
}
?>