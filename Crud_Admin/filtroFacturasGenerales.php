<?php

include("../conex_bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que la variable 'filtro' esté presente
    if (isset($_POST['filtro'])) {
        $filtro = $_POST['filtro'];

        // Aquí procesas el filtro, dependiendo de lo que se haya seleccionado
        $datosFacturas = []; // Array donde se almacenarán las citas filtradas

        if (strpos($filtro, 'filtroSemanaAtras') !== false) {
            // Filtrar por semana pasada (por ejemplo, filtroSemanaAtras_2025-03-28_2025-04-04)
            $fechas = explode('_', str_replace('filtroSemanaAtras_', '', $filtro));
            $fecha_inicio = $fechas[0];
            $fecha_fin = $fechas[1];
            
            $consultasqlSemanal = "SELECT fac.*, em.id_paciente, em.id_paciente_temp FROM facturas fac LEFT JOIN emergencias_medicas em ON em.id_emergencia = fac.emergencia_medica_id WHERE DATE(fac.fecha_factura) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";

            $resultadoBusquedaSemanal = mysqli_query($conexion, $consultasqlSemanal);

            while($row=$resultadoBusquedaSemanal->fetch_assoc()){ 

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
                    'estadoFact' => $row['estado']
                ];
            }

        } elseif (strpos($filtro, 'filtroMesAtras') !== false) {
            // Filtrar por mes pasado (por ejemplo, filtroMesAtras_2025-03-28_2025-04-04)
            $fechas = explode('_', str_replace('filtroMesAtras_', '', $filtro));
            $fecha_inicio = $fechas[0];
            $fecha_fin = $fechas[1];

            $consultaMensual = "SELECT fac.*, em.id_paciente, em.id_paciente_temp FROM facturas fac LEFT JOIN emergencias_medicas em ON em.id_emergencia = fac.emergencia_medica_id WHERE DATE(fac.fecha_factura) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";

            $resultadoBusquedaMonth = mysqli_query($conexion, $consultaMensual);

            while($row=$resultadoBusquedaMonth->fetch_assoc()){ 

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
                    'estadoFact' => $row['estado']
                ];
            }
            
        } elseif (strpos($filtro, 'filtroPorDia') !== false) {
            // Filtrar por citas del día
            $consultaDia = "SELECT fac.*, em.id_paciente, em.id_paciente_temp FROM facturas fac LEFT JOIN emergencias_medicas em ON em.id_emergencia = fac.emergencia_medica_id WHERE  DATE(fac.fecha_factura) = CURDATE();";

            $resultadoBusquedaDia = mysqli_query($conexion, $consultaDia);

            while($row=$resultadoBusquedaDia->fetch_assoc()){ 

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
                    'estadoFact' => $row['estado']
                ];
            }
        }

        // Retornar los resultados en formato JSON
        echo json_encode([
            'success' => true,
            'data' => $datosFacturas
        ]);
    } else {
        // Si no se pasó el filtro
        echo json_encode([
            'success' => false,
            'error' => 'No se recibió el filtro.'
        ]);
    }
}