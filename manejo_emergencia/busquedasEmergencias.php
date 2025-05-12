<?php  

include("../conex_bd.php");

if (isset($_GET['palabra_id'])) {
    $palabraClave = $_GET['palabra_id'];

 

    // Preparar la consulta para obtener médicos según la especialidad
    $consultaBuscar = "SELECT * FROM emergencias_medicas WHERE 
        -- Buscar por nombre o apellido con un solo término
        id_emergencia = $palabraClave OR 
        id_paciente = $palabraClave OR
        id_paciente_temp = $palabraClave";

    $resultBusqueda = mysqli_query($conexion, $consultaBuscar);



    if ($resultBusqueda->num_rows > 0) {

        // Crear un array para almacenar todos los resultados
        $Emergencia = [];

        // Procesar todos los resultados
        while ($row = $resultBusqueda->fetch_assoc()) {
            // Para cada fila de resultados, agregamos la información en el array
            $Emergencia[] = [
                'id_emergencia' => $row['id_emergencia'],
                'id_cedula' => $row['id_paciente'],
                'id_PacienteTemp' => $row['id_paciente_temp'],
                'medicoUrgencias' => $row['medico_responsable'],
                'idEnfermero' => $row['Id_enfermero'],
                'tipo_emerg' => $row['tipo_emergencia'],
                'fecha' => $row['fecha_emergencia'],
                'gravedad' => $row['gravedad'],
                'diagnostico' => $row['diagnostico'],
                'estado_emergencia' => $row['estado_emergencia']
            ];
        }

        // Responder con todos los resultados encontrados
        $response = [
            'success' => true,
            'data' => $Emergencia,  // Aquí pasamos el array con todos los médicos
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