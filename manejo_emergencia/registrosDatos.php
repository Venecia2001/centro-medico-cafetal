<?php

include("../conex_bd.php");

// if(isset($_POST["registroDeMedicamento"])){

//     $idEmergenciaMedica = $_POST["idEmergencia"];
//     $id_medicamento = $_POST["idMedicamento"];
//     $dosis = $_POST["dosisAdministrada"];
//     $presentacionMed = $_POST["presentacionMed"];
//     $AdministradoDurante = $_POST["AdministradoDurante"];
//     $observaciones = $_POST["observaciones"];

//     $sentencia = "INSERT INTO medicamentos_emergencia(`id_emergencia`, `medicamento_id`, `dosis`, `presentacion`, `observaciones`, `administrado_durante` ) VALUES ('$idEmergenciaMedica','$id_medicamento','$dosis','$presentacionMed','$observaciones', '$AdministradoDurante')";
//     $resultadoSentencia = mysqli_query($conexion,$sentencia);

//     if($resultadoSentencia) {

//         if($AdministradoDurante === "Hospitalizacion") {
//             header("Location: ../registrosHospitalizacion.php?id=" . $idEmergenciaMedica);
//         } else {
//             header("Location: ../registrosDeEmergencias.php?id=" . $idEmergenciaMedica);
//         }

//         // header("location:../registrosDeEmergencias.php?id=" . $idEmergenciaMedica);

//         
//     }else{
//        
//     }
    
// }

if(isset($_POST["registroDeMedicamento"])){

    $idEmergenciaMedica = $_POST["idEmergencia"];
    $id_medicamento = $_POST["idMedicamento"];
    $dosis = $_POST["dosisAdministrada"]; // en unidades (pastillas, ml, etc.)
    $presentacionMed = $_POST["presentacionMed"];
    $AdministradoDurante = $_POST["AdministradoDurante"];
    $observaciones = $_POST["observaciones"];

    // Insertar en medicamentos_emergencia
    $sentencia = "INSERT INTO medicamentos_emergencia(`id_emergencia`, `medicamento_id`, `dosis`, `presentacion`, `observaciones`, `administrado_durante`) 
                  VALUES ('$idEmergenciaMedica','$id_medicamento','$dosis','$presentacionMed','$observaciones', '$AdministradoDurante')";
    $resultadoSentencia = mysqli_query($conexion,$sentencia);

    // === NUEVA SECCIÓN: Registrar movimiento de inventario y actualizar stock ===
    if ($resultadoSentencia) {

        // Obtener unidades_por_caja del medicamento
        $consulta = "SELECT contenido_total FROM medicamentos WHERE medicamento_id = $id_medicamento";
        $resultado = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_assoc($resultado);
        $unidadesPorCaja = $fila['contenido_total'];

        // Calcular cajas equivalentes
        $cajasADescontar = $dosis / $unidadesPorCaja;

        // Registrar salida en movimientos_inventario
        $comentario = "Administración durante $AdministradoDurante";
        $fecha = date("Y-m-d");

        $movimientoSQL = "INSERT INTO movimientos_inventario (medicamento_id, tipo_movimiento, cantidad, fecha_movimiento, comentario)
                          VALUES ('$id_medicamento', 'Salida', '$dosis', '$fecha', '$comentario')";
        mysqli_query($conexion, $movimientoSQL);

        // Actualizar stock_actual
        $actualizarStock = "UPDATE medicamentos
                            SET stock_actual = stock_actual - $cajasADescontar
                            WHERE medicamento_id = $id_medicamento";
        mysqli_query($conexion, $actualizarStock);

        // Redireccionar
        if($AdministradoDurante === "Hospitalizacion") {
            header("Location: ../registrosHospitalizacion.php?id=" . $idEmergenciaMedica);
        } else {
            header("Location: ../registrosDeEmergencias.php?id=" . $idEmergenciaMedica);
        }

    } else {
        echo '<h3 class="mensajeFallido">Ha ocurrido un error</h3>';
    }
}





if(isset($_POST["registroDeServicio"])){

    $idEmergencia = $_POST["idEmergencia"];
    $id_servicio = $_POST["idServicio"];
    $descripcionServicios = $_POST["descripcionServicio"];
    $AdministradoDurante = $_POST["AdministradoDurante"];
    $fechaDeServicio = $_POST["fechaDeRegisto"];


    $obtenerPrecio = "SELECT precio_servicio FROM servicios WHERE id_servicio = $id_servicio";
    $resultadoPrecio = mysqli_query($conexion,$obtenerPrecio);

    while($datos= $resultadoPrecio->fetch_assoc()){

        $precioFinal = $datos['precio_servicio'];
    }

    $precioDeServicio = $precioFinal;

    $sentenciaServ = "INSERT INTO `servicios_emergencia`(`emergencia_medica_id`, `servicio_id`, `descripcion`, `costo`, `administrado_durante`, `fecha_servicio`) VALUES ('$idEmergencia','$id_servicio','$descripcionServicios','$precioDeServicio', '$AdministradoDurante','$fechaDeServicio')";
    $resultadoRegistro = mysqli_query($conexion,$sentenciaServ);

    if($resultadoRegistro) {

        if($AdministradoDurante === "Hospitalizacion") {
            header("Location: ../registrosHospitalizacion.php?id=" . $idEmergencia);
        } else {
            header("Location: ../registrosDeEmergencias.php?id=" . $idEmergencia);
        }

        // header("location:../registrosDeEmergencias.php?id=" . $idEmergencia);

        ?>
            <h3 id ="notice">Se realizo else registro corectamente</h3>
        <?php
    }else{
        ?>
            <h3 class="mensajeFallido">ha ocurrido un error</h3>
        <?php
    }
    
}



if(isset($_POST["newPacienteTemp"])){

    $cedulaTemp = $_POST["CedulaI"];
     $prefijoCI = $_POST['nacionalidadCi'];
    $nombreTemp = $_POST["newNombre"];
    $apellidoTemp = $_POST["newApellido"];
    $direccionTemp = $_POST["newdireccion"];
    $fechaNac = $_POST['fechaNac'];

    $tlf = $_POST["newTelefono"];
    $prefijoTlf = $_POST['prefijoTlf'];

    $prefijo = trim($prefijoTlf);
    $numero = trim($tlf);

    $telefonoCompleto = $prefijo . $numero;  // Resultado: "04121234567"

    $nombreLower = strtolower($nombreTemp);  // Convierte el nombre a minúsculas
    $apellidoLower = strtolower($apellidoTemp);  // Convierte el apellido a minúsculas

    $consulta = "INSERT INTO paciente_temp(nacionalidad, codigo_CI, nombre, apellido, fecha_nacimiento_temp, contactoDeEmergencias,direccion) VALUES ('$prefijoCI', '$cedulaTemp','$nombreLower','$apellidoLower','$fechaNac','$telefonoCompleto','$direccionTemp')";
    $resultadoTable = mysqli_query($conexion,$consulta);

    if($resultadoTable) {
        header("location:../seccionRecepcion.php");
    }else{
        ?>
            <h3 class="mensajeFallido">ha ocurrido un error</h3>
        <?php
    }
    
}



if(isset($_POST["idEmergencia"])){


    $tipoDeHabit = $_POST["tipoDeHacitacion"];


    $query = "
        SELECT th.tipo_habitacion, 
            (th.limite_camas - IFNULL(hc.camas_ocupadas, 0)) AS camas_disponibles
        FROM tipos_habitacion th
        LEFT JOIN (
            SELECT tipo_habitacion, COUNT(*) AS camas_ocupadas
            FROM hospitalizacion
            WHERE estado = 'En curso'
            GROUP BY tipo_habitacion
        ) hc ON th.tipo_habitacion = hc.tipo_habitacion
        WHERE th.tipo_habitacion = ?
    ";

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $tipoDeHabit);
    $stmt->execute();
    $result = $stmt->get_result();
    $camas_disponibles = $result->fetch_assoc();

    if ($camas_disponibles['camas_disponibles'] > 0) {


        $idEmergenciaHosp = $_POST["idEmergencia"];
        // $fechaDeIngreso = $_POST["fechaInicioHosp"];
        
        $numeroCama = $_POST["numeroCama"];
        $observaciones = $_POST["observacionesDeHosp"];

        $registroHosp = "INSERT INTO hospitalizacion(emergencia_medica_id, tipo_habitacion, numero_cama, observaciones_hosp) VALUES ('$idEmergenciaHosp','$tipoDeHabit','$numeroCama','$observaciones')";
        $resultadoRegistro = mysqli_query($conexion,$registroHosp);

        if ($resultadoRegistro) {
            // Redirigir si el registro fue exitoso
            // header("location:../registrosHospitalizacion.php?id=" . $idEmergenciaHosp);

            echo json_encode(['status' => 'success', 'idHosp' => $idEmergenciaHosp, 'message' => 'Hospitalización registrada con éxito.']);
        } else {
            // Enviar mensaje de error si el registro falló
            echo json_encode(['status' => 'error', 'message' => 'Ha ocurrido un error al registrar la hospitalización.']);
        }


    }else {
        // Si no hay camas disponibles, enviar un mensaje de error
        echo json_encode(['status' => 'error', 'message' => 'No hay camas disponibles para este tipo de habitación.']);
    }
    
}


if(isset($_POST["medicoResponsable"])){

    $id_paciente = !empty($_POST['idPaciente']) ? $_POST['idPaciente'] : NULL;  // Si está vacío, se asigna NULL
    $id_paciente_temp = !empty($_POST['idPacienteTemp']) ? $_POST['idPacienteTemp'] : NULL;  // Si está vacío, se asigna NULL

    $idmedicoResponsable = $_POST["medicoResponsable"];
    $enfermero_id = $_POST["EnfermeroResponsable"];

    $tipoEmergencia = $_POST["tipoEmerg"];
    $descripcionEmerg = $_POST["DescripcionEmerg"];
    // $fechaEmergencia = $_POST["fecha_emerg"];
    $gravedadEmergencia = $_POST["gravedadEmergencia"];
    // $diagnosticoEmerg = $_POST["diagnostico_emerg"];
    $estadoEmergencia = $_POST["estadoEmerg"];

    // Validar si ambos campos están vacíos
    if ($id_paciente === NULL && $id_paciente_temp === NULL) {
        die("Error: debe proporcionar un id de paciente o un id temporal.");
    }

    // Validar si ambos campos están llenos
    if ($id_paciente !== NULL && $id_paciente_temp !== NULL) {
        die("Error: no puede existir más de un identificador de paciente".$id_paciente." y ".$id_paciente_temp);
    }

    // Si la validación es exitosa, proceder con la inserción
    try {
    // Preparar la consulta SQL
        $sql = "INSERT INTO `emergencias_medicas`(`id_paciente`, `id_paciente_temp`, `medico_responsable`, `Id_enfermero`, `tipo_emergencia`, `descripcion`, `gravedad`, `estado_emergencia`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);
    
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        // Vincular los parámetros
        $stmt->bind_param("iiiissss", $id_paciente, $id_paciente_temp, $idmedicoResponsable, $enfermero_id, $tipoEmergencia, $descripcionEmerg, $gravedadEmergencia, $estadoEmergencia);
        
        // Ejecutar la consulta
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Emergencia registrada exitosamente!";
        } else {
            echo "Error al registrar la emergencia.";
        }

        // Cerrar la sentencia
        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    // $sentenciaSql = "INSERT INTO emergencias_medicas(id_paciente, id_paciente_temp,tipo_emergencia,descripcion,fecha_emergencia,gravedad,diagnostico,estado_emergencia) VALUES ('$idPaciente','$idPacienteTemp','$tipoEmergencia','$descripcionEmerg','$fechaEmergencia','$gravedadEmergencia','$diagnosticoEmerg','$estadoEmergencia')";
    // $resultadoEmergencia = mysqli_query($conexion,$sentenciaSql);
}




?>