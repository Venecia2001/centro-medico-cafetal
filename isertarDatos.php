<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "conex_bd.php";

if(isset($_POST["registrar"])){

    if(!empty($_POST["nombre"]) and !empty($_POST["apellido"]) and !empty($_POST["telefono"]) and !empty($_POST["cedula"]) and !empty($_POST["email"]) and !empty($_POST["contraseña"]) ){

        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $cedula_id = $_POST["cedula"];
        $tlf = $_POST["telefono"];
        $email = $_POST["email"];
        $clave = $_POST["contraseña"];

        $nombreLower = strtolower($nombre);  // Convierte el nombre a minúsculas
        $apellidoLower = strtolower($apellido);  // Convierte el apellido a minúsculas


        $validacion = "SELECT COUNT(*) FROM usuarios WHERE correo = '$email' ";
        $resultValidacion = mysqli_query($conexion, $validacion);

        if ($resultValidacion) {
            $row = mysqli_fetch_assoc($resultValidacion);
            $total = $row['total'];

            if ($total > 0) {
                $_SESSION['error'] = "El correo electrónico ya está registrado. Por favor, elige otro.";
                header("Location: registroUsuarios.php");
                exit();
            }else{ 


                $consultaSql = "INSERT INTO usuarios(id,nombre,apellido,telefono,correo,contraseña) VALUES ('$cedula_id','$nombreLower','$apellidoLower','$tlf','$email','$clave')";
                $resultado = mysqli_query($conexion,$consultaSql);

                if($resultado) {
                        // Obtener el ID del usuario recién registrado
                        $usuario_id = mysqli_insert_id($conexion);  // Obtener el ID del último registro insertado
            
                        // Guardar los datos del usuario en la sesión
                        $_SESSION["usuario"]= $email;
                        $_SESSION['id'] = $usuario_id;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['apellido'] = $apellido;
                    
            
                        // Redirigir al usuario a su perfil o página principal
                        header("location:index.php");  // Cambia  por la página de destino que desees
                        exit;  // Asegura que no se ejecute más código después de la redirección
                    ?>
                    <h3 class="mensaje">te has registrado corectamente</h3>
                    <?php
                }else{
                    ?>
                    <h3 class="bad">ha ocurrido un error</h3>
                    <?php
                }
            }
        }

    }else{
        ?>
        <h3 class="bad">Debes llenar todos los campos</h3>
        <?php
    }
}

    if(isset($_POST["registrarMedicos"])){

        if(!empty($_POST["nombre"]) and !empty($_POST["apellido"]) and !empty($_POST["especialidad"]) and !empty($_POST["direccion"]) and !empty($_POST["telefono"]) and !empty($_POST["email"]) and !empty($_POST["cedula"]) ){


            $nombreMed = $_POST["nombre"];
            $apellidoMed = $_POST["apellido"];
            $especialidadMed = $_POST["especialidad"];
            $direccionMed = $_POST["direccion"];
            $telefonoMed = $_POST["telefono"];
            $correoMed = $_POST["email"];
            $cedulaMed = $_POST["cedula"];

            $nombreLowerMed = strtolower($nombreMed);  // Convierte el nombre a minúsculas
            $apellidoLowerMed = strtolower($apellidoMed);  // Convierte el apellido a minúsculas

           $consulta = "INSERT INTO `medicos`(`nombre`, `apellido`, `id_especialidad`, `direccion`, `telefono`, `correo_electronico`, `cedula`) VALUES ('$nombreLowerMed','$nombreLowerMed',$especialidadMed,'$direccionMed','$telefonoMed','$correoMed','$cedulaMed')";
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




        } else {
            ?>
                <h3 class="mensajeFallido">Debes llenar todos los campos</h3>
            <?php
        }    


    }

    if (isset($_POST["confirmarCita"])){

        $idUsurio = $_POST["nameUser"];
        $esp = $_POST["especialidad"];
        $medicos_esp = $_POST["medico_idTrue"];
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

        if ($resultadoSql) {
            $_SESSION['mensaje'] = '<p style="color: green; font-weight: bold;">✅ Su cita ha sido agendada correctamente.</p>';
        } else {
            $_SESSION['mensaje'] = '<p style="color: red; font-weight: bold;">❌ Ha ocurrido un error. Intente nuevamente.</p>';
        }
    
        header("Location: index.php");
        exit();

    }

    
    if (isset($_POST["perfilUsuario"])){

        $id_usurio = $_POST["id"];
        $cedula = $_POST["cedula"];
        $direccion = $_POST["direccion"];
        $fecha_nac = $_POST["fecha_nac"];
        $edad = $_POST["edad"];
        $genero = $_POST["genero"];
        $alergias = $_POST["alergias"];
        $ocupacion = $_POST["ocupacion"];
        $estudios = $_POST["educacion"];

        // $imagen_tem= $_FILES["Foto"]["tmp_name"];

        // move_uploaded_file($imagen_tem,"perfiles_img/".$foto_perfil);


        $consultaSql = "INSERT INTO perfil_usuario(`id_usuario`, `direccion`, `fecha_nacimiento`, `edad`, `genero`, `alergias`, `ocupacion`, `nivel_educacion`) VALUES ('$id_usurio','$direccion','$fecha_nac','$edad','$genero','$alergias','$ocupacion','$estudios')";

        
        $resultadoSql = mysqli_query($conexion,$consultaSql);

        if($resultadoSql){
            echo "su perfil se completo de manera correcta";
            header("location:perfil_usuario.php"); 
        }


    }

?>