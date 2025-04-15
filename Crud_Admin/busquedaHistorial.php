<?php

include("../conex_bd.php");

if (isset($_GET["search"])) {

    $searchTerm = $_GET['search'];
    $idMedicoSession = $_GET['idDoctor'];

    // $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    // $ = isset($_GET['']) ? $_GET['idMedicoSession'] : '';

    // $idDoctor = $_GET['idMedicoSession'];
    // $searchTerm = $_GET['search'];

    // Preparar la consulta SQL con marcadores de posición
    $sql = "SELECT hm.*, c.id_cita, c.id_medico, c.id_cliente, c.fecha, c.especialidad, cl_paciente.nombre AS nombre_paciente, cl_medico.nombre AS nombre_medico, e.nombre_esp FROM historial_medico hm JOIN citas c ON hm.id_cita = c.id_cita JOIN usuarios cl_paciente ON c.id_cliente = cl_paciente.id JOIN usuarios cl_medico ON c.id_medico = cl_medico.id JOIN especialidades e ON e.id_especialidad = c.especialidad WHERE c.id_medico = $idMedicoSession AND (cl_paciente.nombre  LIKE '%$searchTerm' OR c.id_cita LIKE '%$searchTerm%' );";

    $resultadoBusqueda = mysqli_query($conexion, $sql);

    if($resultadoBusqueda->num_rows > 0){

        $datosCitas = [];

        while ($row = $resultadoBusqueda->fetch_assoc()) {
            $datosCitas[] = [
                'id_cita' => $row['id_cita'],
                'nombrePaciente' => $row['nombre_paciente'],
                'nombreMedico' => $row['nombre_medico'],
                'nombreEsp' => $row['nombre_esp'],
                'fecha' => $row['fecha'],
                'diagnostico' => $row['diagnostico'],
                'tratamientoCita' => $row['tratamiento'],
                'pasosTratamiento' => $row['prescripcion'],
                'examanes' => $row['examenes_realizados']
            ];
        }

        $response = [
            'success' => true,
            'data' => $datosCitas,
            'message' => "Resultados encontrados en la base de datos."
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => "No se encontraron datos relacionados porque la consulta no devuelve mas de uno."
        ];
        echo json_encode($response);
    }
}else {
    $response = [
        'success' => false,
        'message' => "No se encontraron datos relacionados porque nisiquiera entra ."
    ];
    echo json_encode($response);
}




// if (isset($_GET["fechaCita"])) {

//     $fechaDeLaCita = $_GET['fechaCita'];
//     $idMedicoSession = $_GET['idDoctor'];

//     // Preparar la consulta SQL con marcadores de posición
//     $consultasql = "SELECT c.id_medico, c.id_cita, c1.nombre AS nombre_paciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE c.id_medico = $idMedicoSession AND c.fecha = $fechaDeLaCita";

//     $resultadoBusqueda = mysqli_query($conexion, $consultasql);

//     if($resultadoBusqueda->num_rows > 0){

//         $datosCitas = [];

//         while($row=$resultadoBusqueda->fetch_assoc()){ 

//             $datosCitas[] = [
//                 'id_cita' => $row['id_cita'],
//                 'nombrePaciente' => $row['nombre_paciente'],
//                 'nombreMedico' => $row['nombre_medico'],
//                 'nombreEsp' => $row['nombre_esp'],
//                 'fecha' => $row['fecha'],
//                 'hora' => $row['hora'],
//                 'estado' => $row['estado']
                
//             ];
//         }
//         $response = [
//             'success' => true,
//             'data' => $datosCitas,
//             'message' => "Resultados encontrados en la base de datos."
//         ];
//         echo json_encode($response);
//     } else {
//         $response = [
//             'success' => false,
//             'message' => "No se encontraron datos relacionados porque la consulta no devuelve mas de uno."
//         ];
//         echo json_encode($response);
//     }
// }else {
//     $response = [
//         'success' => false,
//         'message' => "No se encontraron datos relacionados porque nisiquiera entra ."
//     ];
//     echo json_encode($response);
// }



?>