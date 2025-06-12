<?php 


include("../conex_bd.php");


if(isset($_POST['registroHoras'])){

    $rolDeMedico = $_POST['rolMedico'];
    $doctorSelect = $_POST['medico'];
    $diaSelect = $_POST['dia'];
    $horaInico = $_POST['comienzoTurno'];
    $horaFin = $_POST['finTurno'];

    $consultaCita = "INSERT INTO `disponibilidad_horarios`(`medico_relac`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES ('$doctorSelect','$diaSelect','$horaInico','$horaFin')";
    $resultadoSql = mysqli_query($conexion,$consultaCita);

    if($resultadoSql) {

        if($rolDeMedico == 5){
            header("location:../control_turnos.php");
        }else{
            header("location:../controlHorarios.php");
        }
        
    }else{
        ?>
        <h3 class="mensajeFallido">ha ocurrido un error</h3>
        <?php
    }

}



?>