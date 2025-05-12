<?php

    include("../conex_bd.php");

    if(!empty($_POST['diagnosticoCita'])){

        $idDeCita = $_POST['idDeCita'];
        $diagnostico = $_POST['diagnosticoCita'];
        $tratamiento = $_POST['tratamientoCita'];
        $indicaciones = $_POST['prescripcionCita'];
        $examanesRealizados = $_POST['examenesCita'];

        var_dump($idDeCita);
        var_dump($diagnostico);
        var_dump($tratamiento);
        var_dump($indicaciones);
        var_dump($examanesRealizados);

        $ResultadoCita = "INSERT INTO `historial_medico`(`id_cita`, `diagnostico`, `tratamiento`, `prescripcion`, `examenes_realizados`) VALUES ('$idDeCita','$diagnostico','$tratamiento','$indicaciones','$examanesRealizados')";
        $resultadosConsulta = mysqli_query($conexion, $ResultadoCita);

        if($resultadosConsulta){

            $estadoAct = "UPDATE citas SET estado = 'realizado' WHERE id_cita = (SELECT id_cita FROM historial_medico WHERE id_cita = $idDeCita)";
            $resulAct = mysqli_query($conexion,$estadoAct);

            header("location:../citasDeMedicos.php");
            
        }else{
            echo "no se realizaron actualizaciones";
        }
    }else{
        echo 'error al momento de registrar el resultado de la cita';
    }

    if(isset($_POST['registroHoras'])){

        $doctorSelect = $_POST['medico'];
        $diaSelect = $_POST['dia'];
        $horaInico = $_POST['comienzoTurno'];
        $horaFin = $_POST['finTurno'];
    
        $consultaCita = "INSERT INTO `disponibilidad_horarios`(`medico_relac`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES ('$doctorSelect','$diaSelect','$horaInico','$horaFin')";
        $resultadoSql = mysqli_query($conexion,$consultaCita);
    
        if($resultadoSql) {
            header("location:../controlHorarios_medicos.php");
        }else{
            ?>
            <h3 class="mensajeFallido">ha ocurrido un error</h3>
            <?php
        }
    
    }

    if(isset($_POST['editHorarios'])){
        
        $idDeHorario = $_POST['idHorarios'];
        $especialidad = $_POST['especialidad'];
        $doctorSelect = $_POST['medicoEdit'];
        $diaSelect = $_POST['diaEdit'];
        $horaInicio = $_POST['comienzoTurnoEdit'];
        $horaFin = $_POST['finTurnoEdit'];
        $disponibilidadSelect = $_POST['disponibilidadEdit'];


        $modificarSql= "UPDATE disponibilidad_horarios SET medico_relac='$doctorSelect',dia_semana='$diaSelect',hora_inicio='$horaInicio',hora_fin='$horaFin',estado_disponibilidad='$disponibilidadSelect' WHERE id_disponibilidad = $idDeHorario";
        $resultModificar = mysqli_query($conexion, $modificarSql);

        if($resultModificar){

            header("location:../controlHorarios.php");

        }
        
    }

    if(isset($_POST['editHorarios_medico'])){

        $idDeHorario = $_POST['idHorarios'];
        $diaSelect = $_POST['diaEdit'];
        $horaInicio = $_POST['finTurnoEdit'];
        $horaFin = $_POST['disponibilidadEdit'];
        $disponibilidadSelect = $_POST['disponibilidadEdit'];


        $modificarSql_medico= "UPDATE disponibilidad_horarios SET dia_semana='$diaSelect',hora_inicio='$horaInicio',hora_fin='$horaFin',estado_disponibilidad='$disponibilidadSelect' WHERE id_disponibilidad = $idDeHorario";
        $resultModificar_medico = mysqli_query($conexion, $modificarSql_medico);

        if($resultModificar_medico){

            header("location:../controlHorarios_medicos.php");

        }
        
    }



    // if (!empty($_POST["dia"]) && !empty($_POST["idMedico"])) {
    //     // Se recibieron los datos correctamente
    //     $diaSeleccionado = $_POST['dia'];
    //     $medicoSeleccionado = $_POST['idMedico'];
    
    //     // Consulta SQL
    //     $validacionSql = "SELECT * FROM disponibilidad_horarios WHERE medico_relac = $medicoSeleccionado AND dia_semana = $diaSeleccionado;";
    //     $resultValidacion = mysqli_query($conexion, $validacionSql);
    
    //     if ($resultValidacion->num_rows > 0) {
    //         $response = [
    //             'validacion' => false,
    //             'mensaje' => "Ya el médico tiene ocupado este día"
    //         ];
    //     } else {
    //         $response = [
    //             'validacion' => true,
    //             'mensaje' => "No hay inconvenientes"
    //         ];
    //     }
        
    //     echo json_encode($response);  // Asegúrate de que esto sea lo único que se imprime
    //     exit;
    // } else {
    //     $response = [
    //         'validacion' => false,
    //         'mensaje' => "Faltan las variables 'dia' o 'idMedico'"
    //     ];
    //     echo json_encode($response);
    //     exit;
    // }
    

?>