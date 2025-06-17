<?php
include("../conex_bd.php");

if (isset($_GET['id_emergencia'])) {
    $id_emergencia = $_GET['id_emergencia'];

    // Consulta a la base de datos
    $ConsultaSiHospitalizacion = "SELECT COUNT(*) as total FROM hospitalizacion WHERE emergencia_medica_id = $id_emergencia";
    $resultadoHosp = mysqli_query($conexion, $ConsultaSiHospitalizacion);

    $fila = $resultadoHosp->fetch_assoc();

    // Responder con un JSON
    if ($fila['total'] > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Hay registros de hospitalización.',
            'total' => $fila['total']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No hay registros de hospitalización.',
        ]);
    }
}
?>