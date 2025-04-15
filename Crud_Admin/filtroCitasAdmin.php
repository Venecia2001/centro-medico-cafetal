<?php

include("../conex_bd.php");

$datosCitas = [];

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['fecha'])) {

    $fecha = $input['fecha'];
    
    $consultasql = "SELECT c.id_medico, c.id_cita, c.fecha_creacion, c1.nombre AS nombre_paciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE c.fecha = '$fecha'";

    $resultadoBusqueda = mysqli_query($conexion, $consultasql);

    if($resultadoBusqueda->num_rows > 0){

        while($row=$resultadoBusqueda->fetch_assoc()){ 

            $datosCitas[] = [
                'id_cita' => $row['id_cita'],
                'nombrePaciente' => $row['nombre_paciente'],
                'nombreMedico' => $row['nombre_medico'],
                'nombreEsp' => $row['nombre_esp'],
                'fecha' => $row['fecha'],
                'hora' => $row['hora'],
                'fechaCreacion' => $row['fecha_creacion'],
                'estado' => $row['estado']
                
            ];
        }
        $response = [
            'success' => true,
            'data' => $datosCitas,
            'message' => "Resultados encontrados en la base de datos."
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => "No se encontraron datos relacionados porque la consulta no devuelve mas de uno."
        ];
        echo json_encode($response);
    }

} elseif (isset($input['start_date']) && isset($input['end_date'])) {
    // Filtra citas entre la fecha de inicio y fin (una semana)
    $start_date = $input['start_date'];
    $end_date = $input['end_date'];

    $consultasqlSemanal = "SELECT c.id_medico, c.fecha_creacion, c.id_cita, c1.nombre AS nombre_paciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE c.fecha BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY; ;";

    $resultadoBusquedaSemanal = mysqli_query($conexion, $consultasqlSemanal);

    if($resultadoBusquedaSemanal->num_rows > 0){

        while($row=$resultadoBusquedaSemanal->fetch_assoc()){ 

            $datosCitas[] = [
                'id_cita' => $row['id_cita'],
                'nombrePaciente' => $row['nombre_paciente'],
                'nombreMedico' => $row['nombre_medico'],
                'nombreEsp' => $row['nombre_esp'],
                'fecha' => $row['fecha'],
                'hora' => $row['hora'],
                'fechaCreacion' => $row['fecha_creacion'],
                'estado' => $row['estado']
                
            ];
        }
        $response = [
            'success' => true,
            'data' => $datosCitas,
            'message' => "Resultados encontrados en la base de datos."
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => "No se encontraron datos relacionados porque la consulta no devuelve mas de uno."
        ];
        echo json_encode($response);
    }

    
}





?>