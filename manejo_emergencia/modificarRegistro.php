<?php 

session_start(); // Iniciar sesión para almacenar errores entre recargas

include("../conex_bd.php");

if(!empty($_POST["idEmergencia"])) {

    $idEmergencia = $_POST['idEmergencia'];

    $codigoSql = "SELECT * FROM emergencias_medicas WHERE id_emergencia = $idEmergencia";
    $resultCodigo = mysqli_query($conexion, $codigoSql);

    $datosEmergencia = [];

    while($datos = $resultCodigo->fetch_assoc()){
        $datosEmergencia[] = [
            'diagnostico' => $datos['diagnostico'],
            'descripcionEmerg' => $datos['descripcion'],
            'estadoDeEmergencia' => $datos['estado_emergencia']
        ];
    }

    echo json_encode($datosEmergencia);
    
 
} else {
    echo json_encode([]); // En caso de error, devolver un array vacío
}

if (isset($_POST["ActualizarEmergencia"])) {
   
    $idEmergenciaMedica = mysqli_real_escape_string($conexion, $_POST["idEmergencia"]);
    $diagnostico = mysqli_real_escape_string($conexion, $_POST["posibleDiagnostico"]);
    $descripcionEmerg = mysqli_real_escape_string($conexion, $_POST["descripcionAct"]);
    $estadoActual = mysqli_real_escape_string($conexion, $_POST["estadoActual"]);

    $sentenciaModificar = "UPDATE emergencias_medicas 
                           SET diagnostico = '$diagnostico', 
                               descripcion = '$descripcionEmerg', 
                               estado_emergencia = '$estadoActual' 
                           WHERE id_emergencia = '$idEmergenciaMedica'";

    // Habilitar manejo de errores en MySQLi
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $resultadoSentenciaM = mysqli_query($conexion, $sentenciaModificar);

        $_SESSION['mensajeExito'] = "✅ La emergencia médica #$idEmergenciaMedica ha sido finalizada correctamente y se ha generado la Factura correspondiente.";
        header("location:../registrosDeEmergencias.php?id=" . $idEmergenciaMedica);
        exit();
    } catch (mysqli_sql_exception $e) {
        // Guardar error en la sesión
        $_SESSION['errorMensaje'] = "⚠️ Error: en la Actualizacion " . $e->getMessage();
        
        // Redirigir de vuelta a registrosDeEmergencias.php manteniendo el ID
        header("Location: ../registrosDeEmergencias.php?id=" . $idEmergenciaMedica);
        exit();
    }
}

if(isset($_POST['ActualizarHosp'])){

    $idEmergenciaMedica =  $_POST["idEmergencia"];
    $observcionesHospitalizacion = $_POST["observacionesDeHosp"];
    $fechaDeAlta = $_POST["fechaAltaMedica"];
    $estadoHospitalizacion = $_POST["estadoActualHosp"];


    $consultaAct = "UPDATE `hospitalizacion` SET `fecha_alta`='$fechaDeAlta',`observaciones_hosp`='$observcionesHospitalizacion',`estado`='$estadoHospitalizacion' WHERE emergencia_medica_id = $idEmergenciaMedica";
    $resultadoConsultaAct = mysqli_query($conexion, $consultaAct);

    // Si la hospitalización se finaliza, actualizar la emergencia médica
    if ($resultadoConsultaAct && $estadoHospitalizacion === "Finalizado") {
        $consultaActualizarEmergencia = "UPDATE emergencias_medicas 
                                         SET estado_emergencia = 'Finalizado' 
                                         WHERE id_emergencia = $idEmergenciaMedica";
        mysqli_query($conexion, $consultaActualizarEmergencia);
    }

    // Redirigir o mostrar mensaje de éxito
    header("Location:../registrosHospitalizacion.php?id=$idEmergenciaMedica");
    exit();

}

if(isset($_POST['actualizarMetodoPago'])){

    $idFactura =  $_POST["idFactura"];
    $metodoDePago = mysqli_real_escape_string($conexion, $_POST['selectPago']);

    // var_dump($metodoDePago);

    $consultaSql = "UPDATE facturas SET metodo_pago = '$metodoDePago', estado = 'Pagado' WHERE factura_id = $idFactura";
    $resultadoSql = mysqli_query($conexion, $consultaSql);

    if($resultadoSql){

        header("Location:../seccionFacturacion.php");

    }
}

if(isset($_POST['actualizarMetodoPagoCita'])){

    $idFactura =  $_POST["idFactura"];
    $metodoDePago = mysqli_real_escape_string($conexion, $_POST['selectPago']);

    // var_dump($metodoDePago);

    $consultaSql = "UPDATE facturas_citas SET metodo_pago = '$metodoDePago', estado_fact  = 'pagada' WHERE id_factura_cita = $idFactura";
    $resultadoSql = mysqli_query($conexion, $consultaSql);

    if($resultadoSql){

        header("Location:../seccionFacturasCitas.php");

    }
}

?>