<?php
include("../conex_bd.php");

if (!empty($_POST["idEditar"])) {

    // Sanitizar el ID
    $idEdit = isset($_POST['idEditar']) ? (int)$_POST['idEditar'] : 0;

    // Consulta SQL
    $getDatos = "SELECT dh.*, us.nombre, us.apellido, us.id, m.id_especialidad FROM disponibilidad_horarios dh 
                 JOIN medicos m ON dh.medico_relac = m.id_perfil 
                 LEFT JOIN usuarios us ON m.id_medico = us.id 
                 WHERE dh.id_disponibilidad = $idEdit";

    $resultDatos = mysqli_query($conexion, $getDatos);

    // Verificar si la consulta devolvió resultados
    if ($resultDatos && $fila = mysqli_fetch_assoc($resultDatos)) {
        // Asignación de los datos
        $idHorario = $fila["id_disponibilidad"];
        $id_especialidad = $fila['id_especialidad'];
        $cedulaMedico = $fila['id'];
        $idMedico = $fila['medico_relac'];
        $diaSemana = $fila['dia_semana'];
        $horaInicio = $fila["hora_inicio"];
        $horaFin = $fila["hora_fin"];
        $estado_disponibilidad = $fila['estado_disponibilidad'];

        // Devolver los datos en formato JSON
        echo json_encode(array(
            'id' => $idHorario,
            'id_esp' => $id_especialidad,
            'idMedico' => $idMedico,
            'cedulaMedico' => $cedulaMedico,
            'diaSemana' => $diaSemana,
            'horaInicio' => $horaInicio,
            'horaFin' => $horaFin,
            'disponibilidad' => $estado_disponibilidad
        ));
    } else {
        echo json_encode(array('error' => 'No se encontraron datos.'));
    }

} else {
    echo json_encode(array('error' => 'ID no proporcionado.'));
}

?>