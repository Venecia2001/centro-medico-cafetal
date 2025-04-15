<?php 

include("../conex_bd.php");

// if(!empty($_POST['idEditar'])){

//     $id_cita = $_POST["idEditar"];

//     $consultaCitas = "SELECT c.id_cita, m.nombre AS nombre_medico, cl.nombre, e.nombre_esp, c.fecha, c.hora, c.estado FROM citas c JOIN medicos m ON c.id_medico = m.id_medico
//             JOIN usuarios cl ON c.id_cliente = cl.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE id_cita = $id_cita;";
//     $resultConsulta = mysqli_query($conexion,$consultaCitas);

//     $datos = mysqli_fetch_assoc($resultConsulta);

//         $id_cita = $datos['id_cita'];
//         $nombrePaciete = $datos['nombre'];
//         $nombreMedico = $datos['nombre_medico'];
//         $nombreEsp = $datos['nombre_esp'];
//         $hora = $datos['hora'];
//         $fecha = $datos['fecha'];
//         $estatus = $datos["estado"];


//         echo json_encode(array(
//             'id' => $id_cita,
//             'nombrePaciente' => $nombrePaciete,
//             'nombre_medico' => $nombreMedico,
//             'especiaidad' => $nombreEsp,
//             'fecha' => $fecha,
//             'hora' => $hora,
//             'status' => $estatus
//         ));


// }else{
//     echo json_encode(array('error' => 'No se encontraron datos.'));

// }

if(isset($_POST['EditarCita'])){

    $id_cita = $_POST['idCita'];
    $nombreP = $_POST['nombrePac'];
    $medico_cita = $_POST['medicoCita'];
    $esp = $_POST['esp'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $estado = $_POST['estadoCita'];

    $consultaEditar = "UPDATE `citas` SET `especialidad`='',`id_medico`='[value-3]',`id_cliente`='[value-4]',`fecha`='[value-5]',`hora`='[value-6]',`estado`='[value-7]' WHERE 1";


}

if(isset($_POST['eliminarCita'])){

    $id = $_POST["id_cita"];

    $DeleteCita = "DELETE FROM citas WHERE id_cita = $id ";
    $resultado = mysqli_query($conexion, $DeleteCita);

    if($resultado){

        header("location:../controlDeCitas.php");

    }
}

if (isset($_POST["confirmarCita"])){

    $idUsurio = $_POST["nameUser"];
    $esp = $_POST["especialidad"];
    $medicos_esp = $_POST["idDoctorTrue"];
    $fechas = $_POST["fecha"];
    $horario = $_POST["horaSelecion"];


    // echo $nombre." ".$esp." ".$medicos_esp." ".$fechas." ".$horario;

    // $consultaCita = "INSERT INTO `citas`(`especialidad`, `id_medico`, `id_cliente`, `fecha`, `hora`) VALUES ('?','?','?','?','?')";
    // $stmt = $conexion->prepare($consultaCita);
    // $stmt->bind_param("iiiis", $idUsurio, $esp, $medicos_esp, $fechas, $horario);

    // if ($stmt->execute()) {
    //     echo "Cita insertada correctamente.";
    // } else {
    //     echo "Error al insertar la cita: " . $stmt->error;
    // }
    
    // Cerrar la declaración y la conexión
    // $stmt->close();
    // $conexion->close();

    $consultaCita = "INSERT INTO `citas`(`especialidad`, `id_medico`, `id_cliente`, `fecha`, `hora`) VALUES ('$esp','$medicos_esp','$idUsurio','$fechas','$horario')";
    $resultadoSql = mysqli_query($conexion,$consultaCita);

    if($resultadoSql) {
        header("location:../controlDeCitas.php");
    }else{
        ?>
        <h3 class="mensajeFallido">ha ocurrido un error</h3>
        <?php
    }

}




?>