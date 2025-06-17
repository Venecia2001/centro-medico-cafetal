<?php

session_start(); // Iniciar sesión para almacenar errores entre recargas

include("../conex_bd.php");

// Verificar si el formulario ha sido enviado
if (isset($_POST['registroMedicamento'])) {

    // Recoger los datos del formulario
    $nombreMedicamento = mysqli_real_escape_string($conexion, $_POST['nombreMedicamento']);
    $presentacionMedicamento = mysqli_real_escape_string($conexion, $_POST['presentacionMedicamento']);
    $unidadMedida = mysqli_real_escape_string($conexion, $_POST['UnidadMedida']); // Deberías tener un nombre único para este select
    $stockMedicamento = mysqli_real_escape_string($conexion, $_POST['stockMedicamento']);
    $clasificacionMedicamento = mysqli_real_escape_string($conexion, $_POST['clasificacionMedicametos']);
    $fechaVencimiento = mysqli_real_escape_string($conexion, $_POST['fecha_vencimiento']);
    $contenidoCajaFrasco = mysqli_real_escape_string($conexion, $_POST['ContenidoCaja_Frasco']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);

    var_dump($presentacionMedicamento);

    // Validación básica (puedes agregar más validaciones si es necesario)
    if (empty($nombreMedicamento) || empty($presentacionMedicamento) || empty($unidadMedida) || empty($stockMedicamento) || empty($clasificacionMedicamento) || empty($fechaVencimiento) || empty($contenidoCajaFrasco) || empty($precio)) {
        echo "Todos los campos son obligatorios.";
    } else {
        // Preparar la consulta SQL para insertar los datos en la tabla "medicamentos"
        $consulta = "INSERT INTO medicamentos (nombre_medicamento, presentacion, unidad_medida, stock_actual, clasificacion, fecha_vencimiento, contenido_total, precio_caja_frasco)
                     VALUES ('$nombreMedicamento', '$presentacionMedicamento', '$unidadMedida', '$stockMedicamento', '$clasificacionMedicamento', '$fechaVencimiento', '$contenidoCajaFrasco', '$precio')";

        // Ejecutar la consulta
        if (mysqli_query($conexion, $consulta)) {

            header("location:../gestionMedicamentos.php");

        } else {
            echo "Error al registrar el medicamento: " . mysqli_error($conexion);
        }
    }
}


if (!empty($_POST["idEditar"])) {

    $idEdit = $_POST['idEditar'];
    
    
    $consultaDatos = "SELECT * FROM medicamentos WHERE medicamento_id=$idEdit";
    $resultados = mysqli_query($conexion,$consultaDatos);

    $fila= mysqli_fetch_assoc($resultados);

    $idmedicamento = $fila["medicamento_id"];
    $nombreMedicamento = $fila["nombre_medicamento"];
    $presentacionMed = $fila["presentacion"];
    $unidad_medida = $fila["unidad_medida"];
    $stock_actual = $fila["stock_actual"];
    $clasificacion = $fila["clasificacion"];
    $fecha_vencimiento = $fila["fecha_vencimiento"];
    $precio_unitario = $fila["precio_unitario"];
    $contenido_total = $fila["contenido_total"];
    $precio_caja_frasco = $fila["precio_caja_frasco"];

    echo json_encode(array(
        'id' => $idmedicamento,
        'nombre' => $nombreMedicamento,
        'presentacionMed' => $presentacionMed,
        'unidad_medida' => $unidad_medida,
        'stock_actual' => $stock_actual,
        'fecha_vencimiento' => $fecha_vencimiento,
        'clasificacion' =>$clasificacion,
        'contenido_total' =>$contenido_total,
        'precio_caja_frasco' => $precio_caja_frasco
    ));
} else {
    echo json_encode(array('error' => 'No se encontraron datos.'));
}


if(isset($_POST['editarMedicamento'])){

    $idmedicamento = $_POST["idMedicamento"];
    $nombreMedicamento = $_POST["nombreMedicamento"];
    $presentacionMed = $_POST["presentacionMedicamento"];
    $unidad_medida = $_POST["UnidadMedida"];
    $stock_actual = $_POST["stockMedicamento"];
    $clasificacion = $_POST["clasificacionMedicametos"];
    $fecha_vencimiento = $_POST["fecha_vencimiento"];
    $contenido_total = $_POST["ContenidoCaja_Frasco"];
    $precio_caja_frasco = $_POST["precio"];

    // Validación para evitar división por cero
    if ($contenido_total > 0) {
        $precio_unitario = $precio_caja_frasco / $contenido_total;
    } else {
        $precio_unitario = 0;
    }

    $consultaEditar ="UPDATE `medicamentos` SET `nombre_medicamento`='$nombreMedicamento',`presentacion`='$presentacionMed',`unidad_medida`='$unidad_medida',`stock_actual`='$stock_actual',`clasificacion`='$clasificacion',`fecha_vencimiento`='$fecha_vencimiento', `precio_unitario`='$precio_unitario',`contenido_total`='$contenido_total',`precio_caja_frasco`='$precio_caja_frasco' WHERE medicamento_id=$idmedicamento";

    $result_edit = mysqli_query($conexion,$consultaEditar);

    if($result_edit){

        header("location:../gestionMedicamentos.php");
        
    }else{
        echo "no se realizaron actualizaciones";
    }
}

// if(isset($_POST['eliminar'])){

//     $id = $_POST["idMedicamento"];
    
//     $consulta2 = "DELETE FROM medicamentos WHERE medicamento_id='$id'";
//     $consultaEnd = mysqli_query($conexion, $consulta2);

//     if($consultaEnd){

//         header("location:../gestionMedicamentos.php");

//     }
// }

if(isset($_POST['eliminar'])){

    $id = $_POST["idMedicamento"];

    // 1. Verificamos si el medicamento está siendo usado en medicamentos_emergencia
    $query = "SELECT COUNT(*) FROM medicamentos_emergencia WHERE medicamento_id = $id";
    $resultado = mysqli_query($conexion, $query);
    $enUso = mysqli_fetch_row($resultado)[0];

    if ($enUso > 0) {
        // 2. Si está en uso, se bloquea la eliminación y se muestra mensaje
        $_SESSION['errorMensaje'] = "⚠️ No se puede eliminar: el medicamento está asignado a una emergencia.";
         header("location:../gestionMedicamentos.php");
        exit();
    }

    // 3. Si no está en uso, se procede con la eliminación
    $eliminar = "DELETE FROM medicamentos WHERE medicamento_id = $id";
    $resultadoEliminar = mysqli_query($conexion, $eliminar);

    if ($resultadoEliminar) {
        $_SESSION['mensajeExito'] = "✅ Medicamento eliminado correctamente.";
    } else {
        $_SESSION['errorMensaje'] = "⚠️ Error al eliminar el medicamento.";
    }
    
    header("location:../gestionMedicamentos.php");
    exit();
}





if(isset($_POST['entradaNewMedicamentos'])){

    $idMedicamento = $_POST["idMedicamentoInv"];
    $movientoInventario = $_POST["movientoInventario"];
    $cantidad = $_POST['entradaDeMedicamentos'];
    $comentario = $_POST["comentarioMoviento"];

    $PrecioNuevoLote = $_POST["precioInv"];

    // 1. Insertar el movimiento en la tabla movimientos_inventario
        $sentenciaMovimiento = "
        INSERT INTO movimientos_inventario (medicamento_id, tipo_movimiento, cantidad, fecha_movimiento, comentario) 
        VALUES ('$idMedicamento', '$movientoInventario', '$cantidad', CURDATE(), '$comentario')
        ";
        $resultadoMovimiento = mysqli_query($conexion, $sentenciaMovimiento);

        // 2. Actualizar stock en la tabla medicamentos
        if ($movientoInventario == 'Entrada') {
        // Si es una entrada, sumamos al stock actual
        $updateStock = "
            UPDATE medicamentos 
            SET stock_actual = stock_actual + $cantidad
            WHERE medicamento_id = '$idMedicamento'
        ";
        } else {
        $updateStock = "
            UPDATE medicamentos 
            SET stock_actual = stock_actual - $cantidad
            WHERE medicamento_id = '$idMedicamento'
        ";
        }
        mysqli_query($conexion, $updateStock);

        // 3. Actualizar el precio unitario en la tabla medicamentos (si es necesario)
        $updatePrecio = "
        UPDATE medicamentos
        SET precio_unitario = '$PrecioNuevoLote'
        WHERE medicamento_id = '$idMedicamento'
        ";
        mysqli_query($conexion, $updatePrecio);



    if($resultadoMovimiento){

        header("location:../gestionMedicamentos.php");

    }
}





?>