<?php 


include("../conex_bd.php");


if(isset($_POST['registroHoras'])){

    $especialidad = $_POST['especialidad'];
    $doctorSelect = $_POST['medico'];
    $diaSelect = $_POST['dia'];
    $horaInico = $_POST['comienzoTurno'];
    $horaFin = $_POST['finTurno'];

    $consultaCita = "INSERT INTO `disponibilidad_horarios`(`medico_relac`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES ('$doctorSelect','$diaSelect','$horaInico','$horaFin')";
    $resultadoSql = mysqli_query($conexion,$consultaCita);

    if($resultadoSql) {
        header("location:../controlHorarios.php");
    }else{
        ?>
        <h3 class="mensajeFallido">ha ocurrido un error</h3>
        <?php
    }

}



?>