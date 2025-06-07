<?php

include("../conex_bd.php");

if(isset($_POST['EdicionCompleta'])){

$id_doctor = $_POST["id_doc"];
$nombreMed = $_POST['nombreM'];
$apellidoMed = $_POST['apellidoM'];
$correoMed = $_POST['correoMed'];
$ClaveMed = $_POST['ClaveMed'];
$rolId = $_POST['rolMedico'];

$tlf = $_POST["telefonoM"];
$prefijoTlf = $_POST['prefijoTlf'];

$prefijo = trim($prefijoTlf);
$numero = trim($tlf);

$telefonoCompleto = $prefijo . $numero;  // Resultado: "04121234567"

$especialidadMed = $_POST['especialidad'];
$direccionMed = $_POST['direccionMed'];
$estudiosUni = $_POST['estudios'];
$fechaNac = $_POST['fecha_nac'];
$experienciaPerfil = $_POST['experienciaMed'];

var_dump($ClaveMed);

try {
    // Iniciar una transacción
    $conexion->begin_transaction();

    // 1. Actualizar los datos del cliente en la tabla 'usuarios'
    $stmt_usuario = $conexion->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, correo = ?, fecha_nacimiento = ?, contraseña = ?, rol = ? WHERE id = ?");
    $stmt_usuario->bind_param("sssssssi", $nombreMed, $apellidoMed, $telefonoCompleto, $correoMed, $fechaNac, $ClaveMed, $rolId, $id_doctor);
    $stmt_usuario->execute();

    // 2. Actualizar los datos específicos del médico en la tabla 'medicos'
    $stmt_medico = $conexion->prepare("UPDATE medicos SET id_especialidad = ?, direccion = ?, titulación_academica = ?, perfil_experiencia = ? WHERE id_medico = ?");
    $stmt_medico->bind_param("isssi", $especialidadMed, $direccionMed, $estudiosUni, $experienciaPerfil, $id_doctor);
    $stmt_medico->execute();

    // Si todo salió bien, confirmar la transacción
    $conexion->commit();

    header("location:../seccionMedicos.php");

} catch (Exception $e) {
    // Si ocurre un error, deshacer la transacción
    $conexion->rollback();
    echo "Error: " . $e->getMessage();
}


}


if(isset($_POST['estadoAprovado'])){

    $idCita = $_POST['id_cita'];
    $estadoCita = $_POST['statusCita'];

    $consultaActualizar = "UPDATE citas SET estado = '$estadoCita' WHERE id_cita = $idCita";
    $resulAct = mysqli_query($conexion,$consultaActualizar);

    if($resulAct){

        header("location:../citasDeMedicos.php");
        
    }else{
        echo "no se realizaron actualizaciones";
    }

}


if(isset($_POST['estadoCancelado'])){

    $idCita = $_POST['id_cita'];
    $estadoCita = $_POST['statusCita'];

    $consultaActualizar = "UPDATE citas SET estado = '$estadoCita' WHERE id_cita = $idCita";
    $resulAct = mysqli_query($conexion,$consultaActualizar);

    if($resulAct){

        header("location:../citasDeMedicos.php");
        
    }else{
        echo "no se realizaron actualizaciones";
    }

}


if(isset($_POST['descripcionEnviada'])){

    $idMedico = $_POST['id_doc'];
    $experienciaDoc = $_POST['descripcionXp'];

    $consultaActualizar = "UPDATE medicos SET perfil_experiencia = '$experienciaDoc' WHERE id_medico = $idMedico";
    $resulAct = mysqli_query($conexion,$consultaActualizar);

    if($resulAct){

        header("location:../seccionMedicos.php");
        
    }else{
        echo "no se realizaron actualizaciones";
    }

}


?>