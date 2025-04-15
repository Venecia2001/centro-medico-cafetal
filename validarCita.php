<?php

include('conex_bd.php'); // Conexión a la base de datos

// Obtener los días disponibles del cliente (debe ser un array JSON)
$diasSemana = json_decode($_POST['diasSemana']); // Decodificamos el JSON enviado desde JavaScript
$fechaSeleccionada = $_POST['fecha']; // Fecha seleccionada enviada desde el cliente
$idMedico = $_POST['idMedico'];

// Creamos un objeto DateTime para analizar la fecha seleccionada
$fecha = new DateTime($fechaSeleccionada);
$diaSemana = $fecha->format('N'); // Día de la semana (1 = Lunes, 7 = Domingo)

// Validar si el día de la semana está en los días disponibles
// if (!in_array($diaSemana, $diasSemana)) {
//     echo "La fecha seleccionada no está disponible para citas. El médico solo atiende los lunes, miércoles y viernes.";
//     exit();
// }
// echo "La fecha seleccionada es válida para agendar una cita.";

    $sqlhoras = "SELECT hora_inicio, hora_fin FROM disponibilidad_horarios WHERE medico_relac = ? AND dia_semana = ?";
    $stmt = $conexion->prepare($sqlhoras);
    $stmt->bind_param("ii", $idMedico, $diaSemana);
    $stmt->execute();
    $rangoHoras = $stmt->get_result(); // Obtiene un objeto mysqli_result

    if ($dias = $rangoHoras->fetch_object()) {
        $horaInicio = $dias->hora_inicio;
        $horaFin = $dias->hora_fin;
    }





if (!in_array($diaSemana, $diasSemana)) {
    
    echo json_encode([
        'valido' =>false,
        'message' => "Fecha no es válida el doctor esta diponible los dias $diasSemana[0]",
        'diaSemana' => $diaSemana,
        'horaDeInicio' => $horaInicio,
        'horaDeCierre' => $horaFin
    ]);
}else{

    echo json_encode([
        'valido' => true,
        'message' => 'Fecha Disponible',
        'diaSemana' => $diaSemana,
        'horaDeInicio' => $horaInicio,
        'horaDeCierre' => $horaFin
    ]);
}


?>