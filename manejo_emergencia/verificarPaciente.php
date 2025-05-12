<?php

include("../conex_bd.php");

if (isset($_GET['palabra_id'])) {
    $palabraClave = $_GET['palabra_id'];

 

    // Preparar la consulta para obtener médicos según la especialidad
    $consultaBuscar = "SELECT * FROM usuarios WHERE 
    (
        -- Buscar por nombre o apellido con un solo término
        LOWER(nombre) LIKE LOWER(CONCAT('%', '$palabraClave', '%')) OR 
        LOWER(apellido) LIKE LOWER(CONCAT('%', '$palabraClave', '%')) OR 
        id = '$palabraClave'
    )
    OR 
    (
        -- Si hay más de un término, buscar por nombre y apellido separados
        LENGTH('$palabraClave') - LENGTH(REPLACE('$palabraClave', ' ', '')) > 0 AND
        LOWER(nombre) LIKE LOWER(CONCAT('%', SUBSTRING_INDEX('$palabraClave', ' ', 1), '%')) AND
        LOWER(apellido) LIKE LOWER(CONCAT('%', SUBSTRING_INDEX('$palabraClave', ' ', -1), '%'))
    )";

    $resultBusqueda = mysqli_query($conexion, $consultaBuscar);


    if ($resultBusqueda->num_rows > 0) {

        // Crear un array para almacenar todos los resultados
        $paciente = [];

        // Procesar todos los resultados
        while ($row = $resultBusqueda->fetch_assoc()) {
            // Para cada fila de resultados, agregamos la información en el array
            $paciente[] = [
                'cedula' => $row['id'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido']
            ];
            $nombreCompleto = $row['nombre'] . ' ' . $row['apellido'];
        }

        // Responder con todos los resultados encontrados
        $response = [
            'success' => true,
            'data' => $paciente,  // Aquí pasamos el array con todos los médicos
            'message' => "El paciente $nombreCompleto, Se encuentra registrado en nuesta plataforma, debes usar la cedula como refencia para una nueva emergencia "
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'data' => [],
            'message' => "No se encontraron datos relacionados."
        ];
        echo json_encode($response);
    }
} else {
    echo "<p>Por favor, ingresa un término de búsqueda.</p>";
}

?>