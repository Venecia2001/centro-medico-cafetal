<?php

include("../conex_bd.php");


// if(!empty($_POST["dia"])){

//     $diaSelecionado = $_POST['dia'];
//     $medicoSeleccionado = $_POST['idMedico'];

//     $validacionSql = "SELECT * FROM disponibilidad_horarios WHERE medico_relac = $medicoSeleccionado AND dia_semana = $diaSelecionado ";
//     $resultValidacion = mysqli_query($conexion,$validacionSql);

//     if($resultValidacion->num_rows > 0){

//         $response = [
//             "validacion" => false,
//             "mensaje" => "Ya el medico que intenta registrar tiene ocupado este dia"
//         ];

//         echo json_encode($response);

//     }else{
//         $response = [
//             "validacion" => true,
//             "mensaje" => "no hay inconvenientes"
//         ];

//         echo json_encode($response);

//     }


// }else{
//     $response = [
//         "mensaje" => "no hay estan iciciando las varibles"
//     ];

//     echo json_encode($response);

// }    


if (!empty($_POST["dia"])) {
    // Se recibieron los datos correctamente
    $diaSeleccionado = $_POST['dia'];
    $medicoSeleccionado = $_POST['id_medico'];


    // Consulta SQL
    $validacionSql = "SELECT * FROM disponibilidad_horarios WHERE medico_relac = $medicoSeleccionado AND dia_semana = $diaSeleccionado;";
    $resultValidacion = mysqli_query($conexion, $validacionSql);

    if ($resultValidacion->num_rows > 0) {
        $response = [
            'validacion' => false,
            'mensaje' => "Ya el médico tiene ocupado este día"
        ];
    } else {
        $response = [
            'validacion' => true,
            'mensaje' => "No hay inconvenientes"
        ];
    }
    
    echo json_encode($response);  // Asegúrate de que esto sea lo único que se imprime
    exit;
}
//else {
//     $response = [
//         'validacion' => false,
//         'mensaje' => "Faltan las variables 'dia' o 'idMedico o no esta llegando a la funcion correcta'"
//     ];
//     echo json_encode($response);
//     exit;
// }




// if(isset($_POST['registroHoras'])){

//     $especialidad = $_POST['especialidad'];
//     $doctorSelect = $_POST['medico'];
//     $diaSelect = $_POST['dia'];
//     $horaInico = $_POST['comienzoTurno'];
//     $horaFin = $_POST['finTurno'];

//     $consultaCita = "INSERT INTO `disponibilidad_horarios`(`medico_relac`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES ('$doctorSelect','$diaSelect','$horaInico','$horaFin')";
//     $resultadoSql = mysqli_query($conexion,$consultaCita);

//     if($resultadoSql) {
//         header("location:../controlHorarios.php");
//     }else{
//         ?>
//         <h3 class="mensajeFallido">ha ocurrido un error</h3>
//         <?php
//     }

// }
                           
if(isset($_POST['eliminarHorario'])){

    $idDelete= $_POST['id'];

    $consulta2 = "DELETE FROM disponibilidad_horarios WHERE id_disponibilidad='$idDelete'";
    $consultaEnd = mysqli_query($conexion, $consulta2);

    if($consultaEnd){

        header("location:../controlHorarios.php");
    }
}

if(isset($_POST['eliminarHorario_medico'])){

    $idDelete= $_POST['id'];

    $consulta2 = "DELETE FROM disponibilidad_horarios WHERE id_disponibilidad='$idDelete'";
    $consultaEnd = mysqli_query($conexion, $consulta2);

    if($consultaEnd){

        header("location:../controlHorarios_medicos.php");
    }
}

?>