<?php

include("../conex_bd.php");

if(isset($_POST["registroDeMedicamento"])){

    $idEmergenciaMedica = $_POST["idEmergencia"];
    $id_medicamento = $_POST["idMedicamento"];
    $dosis = $_POST["dosisAdministrada"];
    $presentacionMed = $_POST["presentacionMed"];
    $AdministradoDurante = $_POST["AdministradoDurante"];
    $observaciones = $_POST["observaciones"];

    $sentencia = "INSERT INTO medicamentos_emergencia(`id_emergencia`, `medicamento_id`, `dosis`, `presentacion`, `observaciones`, `administrado_durante` ) VALUES ('$idEmergenciaMedica','$id_medicamento','$dosis','$presentacionMed','$observaciones', '$AdministradoDurante')";
    $resultadoSentencia = mysqli_query($conexion,$sentencia);

    if($resultadoSentencia) {

        if($AdministradoDurante === "Hospitalizacion") {
            header("Location: ../registrosHospitalizacion.php?id=" . $idEmergenciaMedica);
        } else {
            header("Location: ../registrosDeEmergencias.php?id=" . $idEmergenciaMedica);
        }

        // header("location:../registrosDeEmergencias.php?id=" . $idEmergenciaMedica);

        ?>
            <h3 id ="notice">Se realizo else registro corectamente</h3>
        <?php
    }else{
        ?>
            <h3 class="mensajeFallido">ha ocurrido un error</h3>
        <?php
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

if(isset($_POST["registrarHospitalizacion"])){

    $idEmergenciaHosp = $_POST["idEmergencia"];
    $fechaDeIngreso = $_POST["fechaInicioHosp"];
    $tipoDeHabit = $_POST["tipoDeHacitacion"];
    $numeroCama = $_POST["numeroCama"];
    $observaciones = $_POST["observacionesDeHosp"];

    $registroHosp = "INSERT INTO hospitalizacion(emergencia_medica_id, fecha_ingreso, tipo_habitacion, numero_cama, observaciones_hosp) VALUES ('$idEmergenciaHosp','$fechaDeIngreso','$tipoDeHabit','$numeroCama','$observaciones')";
    $resultadoRegistro = mysqli_query($conexion,$registroHosp);

    if($resultadoRegistro) {

        header("location:../registrosHospitalizacion.php?id=" . $idEmergenciaHosp);

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
    $nombreTemp = $_POST["newNombre"];
    $apellidoTemp = $_POST["newApellido"];
    $edad = $_POST["edad"];
    $telefonoTemp = $_POST["newTelefono"];
    $direccionTemp = $_POST["newdireccion"];

    $nombreLower = strtolower($nombreTemp);  // Convierte el nombre a minúsculas
    $apellidoLower = strtolower($apellidoTemp);  // Convierte el apellido a minúsculas

    $consulta = "INSERT INTO paciente_temp(codigo_CI, nombre, apellido, edad, contactoDeEmergencias,direccion) VALUES ('$cedulaTemp','$nombreLower','$apellidoLower','$edad','$telefonoTemp','$direccionTemp')";
    $resultadoTable = mysqli_query($conexion,$consulta);

    if($resultadoTable) {
        ?>
            <h3 id ="notice">Se realizo else registro corectamente</h3>
        <?php
    }else{
        ?>
            <h3 class="mensajeFallido">ha ocurrido un error</h3>
        <?php
    }
    
}

if(isset($_POST["registrarEmergencia"])){

    $id_paciente = !empty($_POST['idPaciente']) ? $_POST['idPaciente'] : NULL;  // Si está vacío, se asigna NULL
    $id_paciente_temp = !empty($_POST['idPacienteTemp']) ? $_POST['idPacienteTemp'] : NULL;  // Si está vacío, se asigna NULL

    $idmedicoResponsable = $_POST["medicoResponsable"];
    $enfermero_id = $_POST["EnfermeroResponsable"];

    $tipoEmergencia = $_POST["tipoEmerg"];
    $descripcionEmerg = $_POST["DescripcionEmerg"];
    $fechaEmergencia = $_POST["fecha_emerg"];
    $gravedadEmergencia = $_POST["gravedadEmergencia"];
    $diagnosticoEmerg = $_POST["diagnostico_emerg"];
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
        $sql = "INSERT INTO `emergencias_medicas`(`id_paciente`, `id_paciente_temp`, `medico_responsable`, `Id_enfermero`, `tipo_emergencia`, `descripcion`, `fecha_emergencia`, `gravedad`, `diagnostico`, `estado_emergencia`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);
    
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        // Vincular los parámetros
        $stmt->bind_param("iiiissssss", $id_paciente, $id_paciente_temp, $idmedicoResponsable, $enfermero_id, $tipoEmergencia, $descripcionEmerg, $fechaEmergencia, $gravedadEmergencia, $diagnosticoEmerg, $estadoEmergencia);
        
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