<?php

include('conex_bd.php'); // Conexión a la base de datos

if (isset($_POST['medico_id'])) {
    $medicoId = $_POST['medico_id'];
    $diasSemana = [];


    $sql = "SELECT * FROM disponibilidad_horarios WHERE medico_relac = ? AND estado_disponibilidad = 'Disponible';";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $medicoId);
    $stmt->execute();
    $horario = $stmt->get_result(); // Obtiene un objeto mysqli_result

    while($dias=$horario->fetch_object()) {

        $diasSemana[] = $dias->dia_semana;
    //    echo $horasInicio = $dias->hora_inicio;
    }

    echo json_encode($diasSemana);
} else {
    // Si no se recibe el id del médico, se puede devolver un mensaje de error
    echo json_encode(["error" => "No se proporcionó el id del médico"]);
}

?>