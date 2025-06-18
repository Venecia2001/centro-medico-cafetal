<?php

include("../conex_bd.php");

if (isset($_GET['palabra_id'])) {
    $palabraClave = $_GET['palabra_id'];


    // Preparar la consulta para obtener médicos según la especialidad
    $consultaBuscar = "SELECT fac.*, em.id_paciente, em.id_paciente_temp FROM facturas fac LEFT JOIN emergencias_medicas em ON em.id_emergencia = fac.emergencia_medica_id WHERE  fac.factura_id = $palabraClave OR
        em.id_paciente = $palabraClave OR
        em.id_paciente_temp = $palabraClave OR
        em.id_emergencia = $palabraClave ";

    $resultBusqueda = mysqli_query($conexion, $consultaBuscar);

    if ($resultBusqueda->num_rows > 0) {

        // Crear un array para almacenar todos los resultados
        $datosFacturas = [];

        // Procesar todos los resultados
        while ($row = $resultBusqueda->fetch_assoc()) {
            // Para cada fila de resultados, agregamos la información en el array
            $datosFacturas[] = [
                'facturaId' => $row['factura_id'],
                'cedulaPac' => $row['id_paciente'],
                'cedulaPacTemp' => $row['id_paciente_temp'],
                'idEmergencia' => $row['emergencia_medica_id'],
                'idHospitalizacion' => $row['hospitalizacion_id'],
                'fechaFactura' => $row['fecha_factura'],
                'totalMedicamentos' => $row['total_medicamentos'],
                'totalServicios' => $row['total_servicios'],
                'totalHosp' => $row['total_hospitalizacion'],
                'totalFact' => $row['total_factura'],
                'metodoPago' => $row['metodo_pago'],
                'estadoFact' => $row['estado'],
                'comprobante' => $row['comprobante']
            ];
        }

        // Responder con todos los resultados encontrados
        $response = [
            'success' => true,
            'data' => $datosFacturas,  // Aquí pasamos el array con todos los médicos
            'message' => "Resultados encontrados en la base de datos."
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => "No se encontraron datos relacionados."
        ];
        echo json_encode($response);
    }
} else {
    echo "<p>Por favor, ingresa un término de búsqueda.</p>";
}

?>