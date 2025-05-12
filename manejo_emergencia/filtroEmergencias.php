<?php

include("../conex_bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que la variable 'filtro' esté presente
    if (isset($_POST['filtro'])) {
        $filtro = $_POST['filtro'];

        // Aquí procesas el filtro, dependiendo de lo que se haya seleccionado
        $Emergencia = [];

        if (strpos($filtro, 'filtroSemanaAtras') !== false) {
            // Filtrar por semana pasada (por ejemplo, filtroSemanaAtras_2025-03-28_2025-04-04)
            $fechas = explode('_', str_replace('filtroSemanaAtras_', '', $filtro));
            $fecha_inicio = $fechas[0];
            $fecha_fin = $fechas[1];
            
            $consultasqlSemanal = "SELECT * FROM emergencias_medicas WHERE DATE(fecha_emergencia) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";

            $resultadoBusquedaSemanal = mysqli_query($conexion, $consultasqlSemanal);

            while($row=$resultadoBusquedaSemanal->fetch_assoc()){ 

                    $Emergencia[] = [
                        'id_emergencia' => $row['id_emergencia'],
                        'id_cedula' => $row['id_paciente'],
                        'id_PacienteTemp' => $row['id_paciente_temp'],
                        'medicoUrgencias' => $row['medico_responsable'],
                        'idEnfermero' => $row['Id_enfermero'],
                        'tipo_emerg' => $row['tipo_emergencia'],
                        'fecha' => $row['fecha_emergencia'],
                        'gravedad' => $row['gravedad'],
                        'diagnostico' => $row['diagnostico'],
                        'estado_emergencia' => $row['estado_emergencia']
                    ];
            }

        } elseif (strpos($filtro, 'filtroMesAtras') !== false) {
            // Filtrar por mes pasado (por ejemplo, filtroMesAtras_2025-03-28_2025-04-04)
            $fechas = explode('_', str_replace('filtroMesAtras_', '', $filtro));
            $fecha_inicio = $fechas[0];
            $fecha_fin = $fechas[1];

            $consultaMensual = "SELECT * FROM emergencias_medicas WHERE DATE(fecha_emergencia) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";

            $resultadoBusquedaMonth = mysqli_query($conexion, $consultaMensual);

            while($row=$resultadoBusquedaMonth->fetch_assoc()){ 

                $Emergencia[] = [
                    'id_emergencia' => $row['id_emergencia'],
                    'id_cedula' => $row['id_paciente'],
                    'id_PacienteTemp' => $row['id_paciente_temp'],
                    'medicoUrgencias' => $row['medico_responsable'],
                    'idEnfermero' => $row['Id_enfermero'],
                    'tipo_emerg' => $row['tipo_emergencia'],
                    'fecha' => $row['fecha_emergencia'],
                    'gravedad' => $row['gravedad'],
                    'diagnostico' => $row['diagnostico'],
                    'estado_emergencia' => $row['estado_emergencia']
                ];
            }
            
        } elseif (strpos($filtro, 'filtroPorDia') !== false) {
            // Filtrar por citas del día
            $consultaDia = "SELECT * FROM emergencias_medicas WHERE  DATE(fecha_emergencia) = CURDATE()";

            $resultadoBusquedaDia = mysqli_query($conexion, $consultaDia);

            while($row=$resultadoBusquedaDia->fetch_assoc()){ 

                $Emergencia[] = [
                    'id_emergencia' => $row['id_emergencia'],
                    'id_cedula' => $row['id_paciente'],
                    'id_PacienteTemp' => $row['id_paciente_temp'],
                    'medicoUrgencias' => $row['medico_responsable'],
                    'idEnfermero' => $row['Id_enfermero'],
                    'tipo_emerg' => $row['tipo_emergencia'],
                    'fecha' => $row['fecha_emergencia'],
                    'gravedad' => $row['gravedad'],
                    'diagnostico' => $row['diagnostico'],
                    'estado_emergencia' => $row['estado_emergencia']
                ];
            }
        }

        // Retornar los resultados en formato JSON
        echo json_encode([
            'success' => true,
            'data' => $Emergencia
        ]);
    } else {
        // Si no se pasó el filtro
        echo json_encode([
            'success' => false,
            'error' => 'No se recibió el filtro.'
        ]);

    }
}