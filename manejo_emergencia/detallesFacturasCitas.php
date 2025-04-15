<?php

include("../conex_bd.php");

// Asegurarse de que 'idCita' esté en la solicitud
if (!empty($_POST["idCita"])) {
    $idCita = $_POST['idCita'];

    // Consulta SQL corregida (eliminado monto_total duplicado)
    $consultaEmergenciaMed = "SELECT df.id_factura_cita, df.id_cita, df.fecha_emision, df.monto_total, df.estado_fact, 
                              ct.id_cliente, ct.id_medico, ct.especialidad, c.nombre, c.apellido, 
                              med.nombre AS nombre_medico, med.apellido AS apellido_medico, esp.nombre_esp
                              FROM facturas_citas df
                              LEFT JOIN citas ct ON df.id_cita = ct.id_cita
                              LEFT JOIN usuarios c ON ct.id_cliente = c.id
                              LEFT JOIN usuarios med ON ct.id_medico = med.id
                              LEFT JOIN especialidades esp ON ct.especialidad = esp.id_especialidad
                              WHERE df.id_cita = ?";

    $stmt = $conexion->prepare($consultaEmergenciaMed);
    $stmt->bind_param("i", $idCita);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $emergencia = $resultado->fetch_all(MYSQLI_ASSOC);

    // Si hay datos, enviar los resultados, sino enviar mensaje de error
    if (empty($emergencia)) {
        echo json_encode(["error" => "No se encontraron datos de cita."]);
    } else {
        echo json_encode(["data" => $emergencia], JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode(["error" => "No se proporcionó idCita."]);
}

?>

