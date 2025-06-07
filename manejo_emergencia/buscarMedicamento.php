<?php  

include("../conex_bd.php");

if (isset($_GET['palabra_id'])) {
    $palabraClave = $_GET['palabra_id'];

 
    $consultaBuscar = "SELECT * FROM `medicamentos`  WHERE 
        -- Buscar por nombre o apellido con un solo término
        medicamento_id = '$palabraClave' OR 
        nombre_medicamento LIKE '%$palabraClave%'";

    $resultBusqueda = mysqli_query($conexion, $consultaBuscar);


    if ($resultBusqueda->num_rows > 0) {

        // Crear un array para almacenar todos los resultados
        $medicamentos = [];

        // Procesar todos los resultados
        while ($row = $resultBusqueda->fetch_assoc()) {
            // Para cada fila de resultados, agregamos la información en el array
            $medicamentos[] = [
                'medicamento_id' => $row['medicamento_id'],
                'nombre' => $row['nombre_medicamento'],
                'presentacion' => $row['presentacion'],
                'unidadMedida' => $row['unidad_medida'],
                'stock' => $row['stock_actual'],
                'clasificacionMed' => $row['clasificacion'],
                'fechaV' => $row['fecha_vencimiento'],
                'precioUnitario' => $row['precio_unitario'],
                'contenidoTotal' => $row['contenido_total'],
                'precioCaja' => $row['precio_caja_frasco']
            ];
        }

        // Responder con todos los resultados encontrados
        $response = [
            'success' => true,
            'data' => $medicamentos,  // Aquí pasamos el array con todos los médicos
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