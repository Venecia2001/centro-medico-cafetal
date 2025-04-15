<?php

include("../conex_bd.php");

if (isset($_GET['palabra_idCitas'])) {
    $palabraClave = $_GET['palabra_idCitas'];


    // Preparar la consulta para obtener médicos según la especialidad
    $consultaFacturasCts = "SELECT fac.*, cts.id_cliente FROM facturas_citas fac LEFT JOIN citas cts ON cts.id_cita = fac.id_cita WHERE fac.id_cita = $palabraClave";

    $resultBusqueda = mysqli_query($conexion, $consultaFacturasCts);

    if ($resultBusqueda->num_rows > 0) {

        // Crear un array para almacenar todos los resultados
        $datosFacturas = [];

        // Procesar todos los resultados
        while ($row = $resultBusqueda->fetch_assoc()) {
            // Para cada fila de resultados, agregamos la información en el array
            $datosFacturas[] = [
                'facturaId' => $row['id_factura_cita'],
                'idCita' => $row['id_cita'],
                'cedulaPac' => $row['id_cliente'],
                'fechaEmision' => $row['fecha_emision'],
                'montoTotal' => $row['monto_total'],
                'metodoPago' => $row['metodo_pago'],
                'estadoFact' => $row['estado_fact']
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