<?php  

include("../conex_bd.php");

if (isset($_GET['palabra_id'])) {
    $palabraClave = $_GET['palabra_id'];

 

    // Preparar la consulta para obtener médicos según la especialidad
    $consultaBuscar = "SELECT dh.*, cl.id, cl.nombre, cl.apellido, me.id_perfil FROM disponibilidad_horarios dh JOIN medicos me ON dh.medico_relac = me.id_perfil LEFT JOIN usuarios cl ON me.id_medico = cl.id WHERE 
    (
        -- Buscar por nombre o apellido con un solo término
        LOWER(cl.nombre) LIKE LOWER(CONCAT('%', '$palabraClave', '%')) OR 
        LOWER(cl.apellido) LIKE LOWER(CONCAT('%', '$palabraClave', '%')) OR 
        cl.id = '$palabraClave'
    )
    OR 
    (
        -- Si hay más de un término, buscar por nombre y apellido separados
        LENGTH('$palabraClave') - LENGTH(REPLACE('$palabraClave', ' ', '')) > 0 AND
        LOWER(cl.nombre) LIKE LOWER(CONCAT('%', SUBSTRING_INDEX('$palabraClave', ' ', 1), '%')) AND
        LOWER(cl.apellido) LIKE LOWER(CONCAT('%', SUBSTRING_INDEX('$palabraClave', ' ', -1), '%'))
    )";

    $resultBusqueda = mysqli_query($conexion, $consultaBuscar);



    if ($resultBusqueda->num_rows > 0) {

        // Crear un array para almacenar todos los resultados
        $medicos = [];

        // Procesar todos los resultados
        while ($row = $resultBusqueda->fetch_assoc()) {
            // Para cada fila de resultados, agregamos la información en el array
            $medicos[] = [
                'id_disponibilidad' => $row['id_disponibilidad'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'idCedula' => $row['id'],
                'dia_semana' => $row['dia_semana'],
                'hora_inicio' => $row['hora_inicio'],
                'hora_fin' => $row['hora_fin'],
                'disponibilidad' => $row['estado_disponibilidad']
            ];
        }

        // Responder con todos los resultados encontrados
        $response = [
            'success' => true,
            'data' => $medicos,  // Aquí pasamos el array con todos los médicos
            'message' => "Resultados encontrados en la base de datos."
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => "No se encontraron datos relacionados."
        ];
        echo json_encode($response);
    }
} else {
    echo "<p>Por favor, ingresa un término de búsqueda.</p>";
}


?>