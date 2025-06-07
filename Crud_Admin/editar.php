<?php 

include("../conex_bd.php");


if(isset($_POST["registrar"])){

    if(!empty($_POST["nombre"]) and !empty($_POST["apellido"]) and !empty($_POST["telefono"]) and !empty($_POST["email"]) and !empty($_POST["contraseña"]) and !empty($_POST["rolR"]) ){
        
        $cedulaId = $_POST["cedulaUser"];
        $prefijoCI = $_POST['nacionalidadCi'];

        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];

        $tlf = $_POST["telefono"];
        $prefijoTlf = $_POST['prefijoTlf'];

        $prefijo = trim($prefijoTlf);
        $numero = trim($tlf);

        $telefonoCompleto = $prefijo . $numero;  // Resultado: "04121234567"

        $email = $_POST["email"];
        $fecha_nac = $_POST['fecha_nacimientoNew'];
        $clave = $_POST["contraseña"];
        $rol = $_POST['rolR'];

        $consultaSql = "INSERT INTO usuarios(id,nacionalidad,nombre,apellido,telefono,correo,fecha_nacimiento,contraseña,rol) VALUES ('$cedulaId','$prefijoCI','$nombre','$apellido','$telefonoCompleto','$email', '$fecha_nac', '$clave','$rol')";
        $resultado = mysqli_query($conexion,$consultaSql);

        if($resultado) {
            header("location:../seccionAdmin.php");
        }else{
            ?>
            <h3 class="bad">ha ocurrido un error</h3>
            <?php
        }

    }else{
        ?>
        <h3 class="bad">Debes llenar todos los campos</h3>
        <?php
    }
}



if(isset($_POST['eliminar'])){ 

    $id = $_POST["id"];
    
    $consulta2 = "DELETE FROM usuarios WHERE id='$id'";
    $consultaEnd = mysqli_query($conexion, $consulta2);

    if($consultaEnd){

        header("location:../seccionAdmin.php");

    }
}


if (!empty($_POST["idEditar"])) {

    $idEdit = $_POST['idEditar'];
    
    
    $consultaDatos = "SELECT * FROM usuarios WHERE id=$idEdit";
    $resultados = mysqli_query($conexion,$consultaDatos);

    $fila= mysqli_fetch_assoc($resultados);

    $idE = $fila["id"];
    $nombreE = $fila["nombre"];
    $apellidoE = $fila["apellido"];
    $telefonoE = $fila["telefono"];
    $correoE = $fila["correo"];
    $fechaNacimiento = $fila['fecha_nacimiento'];
    $claveE = $fila["contraseña"];
    $rolE = $fila["rol"];

    $prefijo = substr($telefonoE, 0, 4);         // primeros 4 dígitos
    $numeroSinPrefijo = substr($telefonoE, 4);   // el resto del número

    echo json_encode(array(
        'id' => $idE,
        'nombre' => $nombreE,
        'apellido' => $apellidoE,
        'telefono' => $telefonoE,
        'prefijo' => $prefijo,
        'numeroSinPrefijo' => $numeroSinPrefijo,
        'correo' => $correoE,
        'fechaNac' => $fechaNacimiento,
        'clave' => $claveE,
        'rol' => $rolE
    ));
} else {
    echo json_encode(array('error' => 'No se encontraron datos.'));
}

if(isset($_POST['editar'])){

    $id_user = $_POST['id_user'];
    $newNombre = $_POST['newNombre'];
    $newApellido = $_POST['newApellido'];
    $newCorreo = $_POST['newEmail'];
    $fecha_nacEdit = $_POST['fecha_nacimientoEdit'];

    $newClave = $_POST['newClave'];
    $newrol = $_POST['newRol'];

    $tlf = $_POST["newTelefono"];
    $prefijoTlf = $_POST['prefijoTlf'];

        $prefijo = trim($prefijoTlf);
        $numero = trim($tlf);

        $telefonoCompleto = $prefijo . $numero;  // Resultado: "04121234567"

    $consultaEditar =" UPDATE `usuarios` SET `nombre`='$newNombre',`apellido`='$newApellido',`telefono`='$telefonoCompleto',`correo`='$newCorreo', `fecha_nacimiento` = '$fecha_nacEdit', `contraseña`='$newClave',`rol`='$newrol' WHERE id=$id_user";

    $result_edit = mysqli_query($conexion,$consultaEditar);

    if($result_edit){

        header("location:../seccionAdmin.php");
        
    }else{
        echo "no se realizaron actualizaciones";
    }
}

if(isset($_POST['editarDatosPersonales'])){

    $id_paciente = $_POST["id_user"];
    $nombre = $_POST['newNombre'];
    $apellido = $_POST['newApellido'];
    $correo = $_POST['newEmail'];

    $telefono = $_POST['newTelefono'];
    $prefijoTlf = $_POST['prefijoTlf'];

        $prefijo = trim($prefijoTlf);
        $numero = trim($telefono);

    $telefonoCompleto = $prefijo . $numero;  // Resultado: "04121234567"

    $fechaNac = $_POST['fecha_nacEdit'];
    $altura = $_POST['alturaEdit'];
    $peso = $_POST['pesoKgEdit'];
    $enfermedades = $_POST['enfermedadesEdit'];
    $sexoPaciente = $_POST['generoEdit'];
    $direccion = $_POST['direccionEdit'];
    $alergias = $_POST['alergiasEdit'];
    $ocupacion = $_POST['ocupacionEditar'];
    $eduacionNivel = $_POST['educacionEditar'];

    try {
        // Iniciar una transacción
        $conexion->begin_transaction();
    
        // 1. Actualizar los datos del cliente en la tabla 'usuarios'
        $stmt_usuario = $conexion->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, correo = ? WHERE id = ?");
        $stmt_usuario->bind_param("ssssi", $nombre, $apellido, $telefonoCompleto, $correo, $id_paciente);
        $stmt_usuario->execute();
    
        // 2. Actualizar los datos específicos del médico en la tabla 'medicos'
        $stmt_perfil = $conexion->prepare("UPDATE perfil_usuario SET direccion = ?, genero = ?, altura = ?, peso = ?, condiciones_medicas = ?, alergias = ?, ocupacion = ?, nivel_educacion = ?  WHERE id_usuario = ?");
        $stmt_perfil->bind_param("ssiissssi", $direccion, $sexoPaciente, $altura, $peso, $enfermedades, $alergias, $ocupacion, $eduacionNivel, $id_paciente);
        $stmt_perfil->execute();
    
        // Si todo salió bien, confirmar la transacción
        $conexion->commit();
        
        header("location:../perfil_usuario.php");
        
    } catch (Exception $e) {
        // Si ocurre un error, deshacer la transacción
        $conexion->rollback();
        echo "Error: " . $e->getMessage();
    }
}

?>