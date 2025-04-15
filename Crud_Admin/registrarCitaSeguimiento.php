<?php

include("../conex_bd.php");

if (isset($_POST["confirmarCita"])){

    $idUsurio = $_POST["id_paciente"];
    $esp = $_POST["id_especialidad"];
    $medicos_esp = $_POST["id_medico"];
    $fechas = $_POST["fecha"];
    $horario = $_POST["horaSelecion"];

    $consultaCita = "INSERT INTO `citas`(`especialidad`, `id_medico`, `id_cliente`, `fecha`, `hora`) VALUES ('$esp','$medicos_esp','$idUsurio','$fechas','$horario')";
    $resultadoSql = mysqli_query($conexion,$consultaCita);

    if ($resultadoSql) {
        header("Location:../citasDeMedicos.php");
        $_SESSION['mensaje'] = '<p style="color: green; font-weight: bold;">✅ Su cita ha sido agendada correctamente.</p>';
    } else {
        $_SESSION['mensaje'] = '<p style="color: red; font-weight: bold;">❌ Ha ocurrido un error. Intente nuevamente.</p>';
    }

    
    exit();

}



?>