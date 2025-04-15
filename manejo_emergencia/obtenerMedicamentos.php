<?php 

include("../conex_bd.php");

if (isset($_GET['clasificacion_id'])) {
    $clasificacion_id = $_GET['clasificacion_id'];

    // Preparar la consulta para obtener médicos según la especialidad
    $stmt = $conexion->prepare("SELECT medicamento_id, nombre_medicamento FROM medicamentos WHERE clasificacion = ?");
    if ($stmt) {
        $stmt->bind_param("s", $clasificacion_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $medicamentos = [];
        // Recorrer los resultados y almacenar solo los nombres de los médicos
        while ($row = $result->fetch_assoc()) {
            $medicamentos[] = ['nombre' => $row['nombre_medicamento'],'id_medicamento' => $row['medicamento_id']];
        }

        // Devolver los nombres en formato JSON
        echo json_encode($medicamentos);

        // Cerrar el statement
        $stmt->close();
    } else {
        echo json_encode([]); // En caso de error, devolver un array vacío
    }
} else {
    echo json_encode(["no esta llegando nada en esata monda"]); // Si no se recibe el parámetro, devolver un array vacío
}

// Cerrar la conexión
$conexion->close();


?>