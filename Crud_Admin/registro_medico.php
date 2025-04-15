<?php 

include("../conex_bd.php");

if(isset($_POST['registroCompleto'])){

    $cedulaMed = $_POST['cedula'];
    $nombreMed = $_POST['nombreM'];
    $apellidoMed = $_POST['apellidoM'];
    $telefonoM = $_POST['telefonoM'];
    $correoMed = $_POST['correoMed'];
    $ClaveMed = $_POST['ClaveMed'];
    $rolId = $_POST['rolMedico'];

    $especialidadMed = $_POST['especialidad'];
    $direccionMed = $_POST['direccionMed'];
    $fechaNac = $_POST['fecha_nac'];


    try {
        // Iniciar una transacción
        $conexion->begin_transaction();
    
        // 1. Insertar el nuevo médico en la tabla 'usuarios'
        $stmt_usuario = $conexion->prepare("INSERT INTO usuarios (id, nombre, apellido, telefono, correo, contraseña, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_usuario->bind_param("isssssi", $cedulaMed, $nombreMed, $apellidoMed, $telefonoM, $correoMed, $ClaveMed, $rolId);
        $stmt_usuario->execute();
    
        // Obtener el ID del nuevo usuario insertado
        $id_usuario = $conexion->insert_id; // El último ID insertado
    
        // 2. Insertar los datos específicos del médico en la tabla 'medicos'
        $stmt_medico = $conexion->prepare("INSERT INTO medicos (id_medico, id_especialidad, direccion, fecha_nacimiento) VALUES (?, ?, ?, ?)");
        $stmt_medico->bind_param("iiss", $id_usuario, $especialidadMed, $direccionMed, $fechaNac);
        $stmt_medico->execute();
    
        // Si todo salió bien, confirmar la transacción
        $conexion->commit();
    
        echo "Médico registrado exitosamente.";
    
    } catch (Exception $e) {
        // Si ocurre un error, deshacer la transacción
        $conexion->rollback();
        echo "Error: " . $e->getMessage();
    }

}else{
    echo "no se ha cargado la indormacion";
}



if (!empty($_POST["idEditar"])) {

    $idEdit = $_POST['idEditar'];

    $consultaDatos = "SELECT cl.*, m.id_registro, m.id_especialidad, m.direccion, m.cedula, m.foto_perfil, m.fecha_nacimiento, e.nombre_esp AS nombre_especialidad FROM usuarios cl JOIN medicos m ON cl.id = m.id_registro JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE cl.id=$idEdit;";
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
    $cedulaE = $fila["cedula"];
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
        'cedula' => $cedulaE,
        'fecha_nac' => $fechaNac
    ));
} else {
    echo json_encode(array('error' => 'No se encontraron datos.'));
}


?>