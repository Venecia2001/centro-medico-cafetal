<?php

// Conexión a la base de datos
$mysqli = new mysqli("localhost", "jartigas", "root", "clinica");

// Verificar si hubo un error en la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Verificar que se haya enviado el parámetro specialty_id
if (isset($_GET['specialty_id'])) {
    $specialty_id = $_GET['specialty_id'];

    // Preparar la consulta para obtener médicos según la especialidad
    $stmt = $mysqli->prepare("SELECT u.id, u.nombre, u.apellido, m.id_perfil, m.foto_perfil FROM usuarios u JOIN medicos m ON m.id_medico = u.id WHERE m.id_especialidad = ? AND u.rol <> 5");
    if ($stmt) {
        $stmt->bind_param("i", $specialty_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $medicos = [];
        // Recorrer los resultados y almacenar solo los nombres de los médicos
        while ($row = $result->fetch_assoc()) {
            $medicos[] = ['nombre' => $row['nombre'], 'apellido' => $row['apellido'] ,'idPerfil' => $row['id_perfil'], 'id_medico' => $row['id'], "foto" => $row['foto_perfil']];
        }

        // Devolver los nombres en formato JSON
        echo json_encode($medicos);

        // Cerrar el statement
        $stmt->close();
    } else {
        echo json_encode([]); // En caso de error, devolver un array vacío
    }
} else {
    echo json_encode([]); // Si no se recibe el parámetro, devolver un array vacío
}

// Cerrar la conexión
$mysqli->close();


?>

