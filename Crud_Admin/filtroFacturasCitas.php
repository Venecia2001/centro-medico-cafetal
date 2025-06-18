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
            
            $consultasqlSemanal = "SELECT fac.*, cts.id_cliente FROM facturas_citas fac LEFT JOIN citas cts ON cts.id_cita = fac.id_cita WHERE DATE(fac.fecha_emision) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE(); ";

            $resultadoBusquedaSemanal = mysqli_query($conexion, $consultasqlSemanal);

            while($row=$resultadoBusquedaSemanal->fetch_assoc()){ 

                $datosFacturas[] = [
                    'facturaId' => $row['id_factura_cita'],
                    'idCita' => $row['id_cita'],
                    'cedulaPac' => $row['id_cliente'],
                    'fechaEmision' => $row['fecha_emision'],
                    'montoTotal' => $row['monto_total'],
                    'metodoPago' => $row['metodo_pago'],
                    'estadoFact' => $row['estado_fact'],
                    'comprobante' => $row['comprobante']
                ];
            }

        } elseif (strpos($filtro, 'filtroMesAtras_') !== false) {
            // Filtrar por mes pasado (por ejemplo, filtroMesAtras_2025-03-28_2025-04-04)
            $fechas = explode('_', str_replace('filtroMesAtras_', '', $filtro));
            $fecha_inicio = $fechas[0];
            $fecha_fin = $fechas[1];

            $consultaMensual = "SELECT fac.*, cts.id_cliente FROM facturas_citas fac LEFT JOIN citas cts ON cts.id_cita = fac.id_cita WHERE DATE(fac.fecha_emision) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";

            $resultadoBusquedaMonth = mysqli_query($conexion, $consultaMensual);

            while($row=$resultadoBusquedaMonth->fetch_assoc()){ 

                $datosFacturas[] = [
                    'facturaId' => $row['id_factura_cita'],
                    'idCita' => $row['id_cita'],
                    'cedulaPac' => $row['id_cliente'],
                    'fechaEmision' => $row['fecha_emision'],
                    'montoTotal' => $row['monto_total'],
                    'metodoPago' => $row['metodo_pago'],
                    'estadoFact' => $row['estado_fact'],
                    'comprobante' => $row['comprobante']
                ];
            }
            
        } elseif (strpos($filtro, 'filtroPorDia_') !== false) {
            // Filtrar por citas del día
            $consultaDia = "SELECT fac.*, cts.id_cliente FROM facturas_citas fac LEFT JOIN citas cts ON cts.id_cita = fac.id_cita WHERE DATE(fac.fecha_emision) = CURDATE();";

            $resultadoBusquedaDia = mysqli_query($conexion, $consultaDia);

            while($row=$resultadoBusquedaDia->fetch_assoc()){ 

                $datosFacturas[] = [
                    'facturaId' => $row['id_factura_cita'],
                    'idCita' => $row['id_cita'],
                    'cedulaPac' => $row['id_cliente'],
                    'fechaEmision' => $row['fecha_emision'],
                    'montoTotal' => $row['monto_total'],
                    'metodoPago' => $row['metodo_pago'],
                    'estadoFact' => $row['estado_fact'],
                    'comprobante' => $row['comprobante']
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
