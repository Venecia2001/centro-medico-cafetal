<?php

include("../conex_bd.php");

if(!empty($_POST["idCita"])) {

    $idCita = $_POST['idCita'];

    $consultaHistorial = "SELECT hm.*, c.id_cita, c.id_medico, c.id_cliente, c.fecha, c.especialidad, c.estado, cl_paciente.nombre AS nombre_paciente, cl_paciente.apellido AS apellidoPact, cl_paciente.id AS cedulaId, cl_medico.nombre AS nombre_medico, cl_medico.apellido, e.nombre_esp FROM historial_medico hm JOIN citas c ON hm.id_cita = c.id_cita JOIN usuarios cl_paciente ON c.id_cliente = cl_paciente.id JOIN usuarios cl_medico ON c.id_medico = cl_medico.id JOIN especialidades e ON e.id_especialidad = c.especialidad WHERE hm.id_cita = $idCita;";
    $resultHistorial = mysqli_query($conexion,$consultaHistorial);

    $fila= mysqli_fetch_assoc($resultHistorial);
        // $id = $datos["id"];
        // $nombre = $datos["nombre"];
        // $apellido = $datos["apellido"];
        // $telefono = $datos["telefono"];
    $id_citaHistorial = $fila['id_cita'];
    $idPaciente = $fila['cedulaId'];
    $apellidoPact = $fila['apellidoPact'];
    $fecha = $fila["fecha"];
    $diagnos = $fila["diagnostico"];
    $tratamiento = $fila["tratamiento"];
    $prescripcion = $fila["prescripcion"];      
    $examenes = $fila['examenes_realizados'];    
    $doctorRes = $fila['nombre_medico'];
    $apellidoDoctor = $fila['apellido'];
    $nombrePaciente = $fila['nombre_paciente'];
    $nombre_esp = $fila['nombre_esp'];
    $estadoCts = $fila['estado'];
    


    echo json_encode(array(
        'id' => $id_citaHistorial,
        'idCedula' => $idPaciente,
        'nombre' => $nombrePaciente,
        'apellidoPact' => $apellidoPact,
        'nombreMedico' => $doctorRes,
        'apellidoDoctor' => $apellidoDoctor,
        'diagnostco' => $diagnos,
        'tratamiento' => $tratamiento,
        'presecciones' => $prescripcion,
        'examenes' => $examenes,
        'fecha' => $fecha,
        'especialidad' => $nombre_esp,
        'estadoCts' => $estadoCts
    ));
} else {
    echo json_encode(array('error' => 'No se encontraron datos de historial.'));
}




?>