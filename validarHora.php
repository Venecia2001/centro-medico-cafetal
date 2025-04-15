<?php
include('conex_bd.php'); // Conexión a la base de datos

if (isset($_POST['numeroDeDia']) && isset($_POST['medicoId']) && isset($_POST['horaSeleccionada']) && isset($_POST['fechaSelecionada']) && isset($_POST['horaInicio']) && isset($_POST['horaDeCierre'])) {
    $Ndia = $_POST['numeroDeDia'];
    $idMedico = $_POST['medicoId'];
    $horaSeleccionada = $_POST['horaSeleccionada'];
    $fechaSeleccionada = $_POST['fechaSelecionada'];
    $comienzoTurno = $_POST['horaInicio'];
    $finTurno = $_POST['horaDeCierre'];
    $fechaHora = new DateTime($horaSeleccionada);

    // $hora = $fechaHora->format('H');

    // if (!($hora < $comienzoTurno || $hora >= $finTurnoin)) {


        // $fecha_formateada = $fechaHora->format('Y-m-d'); // Formato de fecha (YYYY-MM-DD)
        $hora_formateada = $fechaHora->format('H:i:s'); // Formato de hora (HH:MM:SS)
        // Verificar si ya existe una cita para la fecha y hora seleccionada

        // Verificar si ya hay una cita para esa fecha y hora
        $sql = "SELECT * FROM citas WHERE fecha = ? AND hora = ? AND id_medico = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssi", $fechaSeleccionada, $hora_formateada, $idMedico);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si ya existe una cita para ese horario
            $response = [
                'success' => false,
                'horaInicio' => $comienzoTurno,
                'horaFin' => $finTurno,
                'message' => "Ya existe una cita para esta fecha y hora. El horario disponible para el médico es de: $comienzoTurno a $finTurno."
            ];
            echo json_encode($response);
        } else {
            // Si no existe una cita, la hora está disponible
            $response = [
                'success' => true,
                'horaInicio' => $comienzoTurno,
                'horaFin' => $finTurno,
                'message' => "La hora seleccionada está disponible. El horario para el médico es de: $comienzoTurno a $finTurno."
            ];

            echo json_encode($response);
        }
    // } else {
    //     // Si la hora seleccionada no está dentro del rango de disponibilidad
    //     $response = [
    //         'success' => false,
    //         'horaInicio' => $comienzoTurno,
    //         'horaFin' => $finTurno,
    //         'message' => "La hora seleccionada no está disponible. El horario para el médico es de: $comienzoTurno a $finTurno."
    //     ];
    // }

    // Devolver la respuesta en formato JSON
    
}else{
    echo "no hay datos ando mal de datos";
}





    // if (!($hora < $horaInicio || $hora >= $horaFin)) {
           
    //         $response = [
    //             'success' => true,
    //             'horaInicio' => $horaInicio,
    //             'horaFin' => $horaFin,
    //             'message' => "La hora selecionada esta disponibles, el horario para el médico es de : $horaInicio a $horaFin."
    //         ];
    //         // exit();
    //     // Crear un array con los datos que queremos enviar como respuesta
    // } else {
    //     // Si no se encuentran horas disponibles para el médico en ese día, enviamos un mensaje de error
    //     $response = [
    //         'success' => false,
    //         'horaInicio' => $horaInicio,
    //         'horaFin' => $horaFin,
    //         'message' => "la hora seleccionada no esta diponible: el horario para el médico es de: $horaInicio a $horaFin"
    //     ];
    // }

    // echo json_encode($response);






?>