<?php
include("../conex_bd.php");

if (!empty($_POST["idEditar"])) {

    $idEdit = $_POST['idEditar'];

    $consultaDatos = "SELECT cl.*, m.id_medico, m.id_especialidad, m.direccion, m.foto_perfil, m.fecha_nacimiento, e.nombre_esp AS nombre_especialidad FROM usuarios cl JOIN medicos m ON cl.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE cl.id=$idEdit;";
    $resultados = mysqli_query($conexion,$consultaDatos);

    $fila= mysqli_fetch_assoc($resultados);

    $idE = $fila["id"];
    $nombreE = $fila["nombre"];
    $apellidoE = $fila["apellido"];
    $telefonoE = $fila["telefono"];
    $correoE = $fila["correo"];
    $claveE = $fila["contraseña"];
    $rolE = $fila["rol"];
    $direccion = $fila["direccion"];
    $name_esp = $fila['nombre_especialidad'];
    $fechaNac = $fila["fecha_nacimiento"];

    echo json_encode(array(
        'id' => $idE,
        'nombre' => $nombreE,
        'apellido' => $apellidoE,
        'telefono' => $telefonoE,
        'correo' => $correoE,
        'clave' => $claveE,
        'rol' => $rolE,
        'nombre_esp' => $name_esp,
        'direccion' => $direccion,
        'fecha_nac' => $fechaNac
    ));
} else {
    echo json_encode(array('error' => 'No se encontraron datos.'));
}


if(isset($_POST['EdicionCompleta'])){

    $id_doctor = $_POST["id_doc"];
    $nombreMed = $_POST['nombreM'];
    $apellidoMed = $_POST['apellidoM'];
    $telefonoM = $_POST['telefonoM'];
    $correoMed = $_POST['correoMed'];
    $ClaveMed = $_POST['ClaveMed'];
    $rolId = $_POST['rolMedico'];
    $idCedula = $_POST['cedula'];

    $especialidadMed = $_POST['especialidad'];
    $direccionMed = $_POST['direccionMed'];
    $fechaNac = $_POST['fecha_nac'];

    try {
        // Iniciar una transacción
        $conexion->begin_transaction();
    
        // 1. Actualizar los datos del cliente en la tabla 'usuarios'
        $stmt_usuario = $conexion->prepare("UPDATE usuarios SET id = ?, nombre = ?, apellido = ?, telefono = ?, correo = ?, contraseña = ?, rol = ? WHERE id = ?");
        $stmt_usuario->bind_param("issssssi",$idCedula, $nombreMed, $apellidoMed, $telefonoM, $correoMed, $ClaveMed, $rolId, $id_doctor);
        $stmt_usuario->execute();
    
        // 2. Actualizar los datos específicos del médico en la tabla 'medicos'
        $stmt_medico = $conexion->prepare("UPDATE medicos SET id_especialidad = ?, direccion = ?, fecha_nacimiento = ? WHERE id_medico = ?");
        $stmt_medico->bind_param("issi", $especialidadMed, $direccionMed, $fechaNac, $id_doctor);
        $stmt_medico->execute();
    
        // Si todo salió bien, confirmar la transacción
        $conexion->commit();
    
        header("location:../controlMedicos.php");
    
    } catch (Exception $e) {
        // Si ocurre un error, deshacer la transacción
        $conexion->rollback();
        echo "Error: " . $e->getMessage();
    }


}

if(isset($_POST['eliminar'])){

    $id = $_POST["id"];
    
    $consulta2 = "DELETE FROM usuarios WHERE id='$id'";
    $consultaEnd = mysqli_query($conexion, $consulta2);

    if($consultaEnd){

        header("location:../controlMedicos.php");

    }
}




?>