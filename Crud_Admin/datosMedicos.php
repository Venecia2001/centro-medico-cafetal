<?php

include("../conex_bd.php");

if(isset($_POST['EdicionCompleta'])){

$id_doctor = $_POST["id_doc"];
$nombreMed = $_POST['nombreM'];
$apellidoMed = $_POST['apellidoM'];
$telefonoM = $_POST['telefonoM'];
$correoMed = $_POST['correoMed'];
$ClaveMed = $_POST['ClaveMed'];
$rolId = $_POST['rolMedico'];

$especialidadMed = $_POST['especialidad'];
$direccionMed = $_POST['direccionMed'];
$cedulaMed = $_POST['cedula'];
$fechaNac = $_POST['fecha_nac'];

try {
    // Iniciar una transacción
    $conexion->begin_transaction();

    // 1. Actualizar los datos del cliente en la tabla 'usuarios'
    $stmt_usuario = $conexion->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, correo = ?, contraseña = ?, rol = ? WHERE id = ?");
    $stmt_usuario->bind_param("ssssssi", $nombreMed, $apellidoMed, $telefonoM, $correoMed, $ClaveMed, $rolId, $id_doctor);
    $stmt_usuario->execute();

    // 2. Actualizar los datos específicos del médico en la tabla 'medicos'
    $stmt_medico = $conexion->prepare("UPDATE medicos SET id_especialidad = ?, direccion = ?, cedula = ?, fecha_nacimiento = ? WHERE id_medico = ?");
    $stmt_medico->bind_param("isssi", $especialidadMed, $direccionMed, $cedulaMed, $fechaNac, $id_doctor);
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



?>