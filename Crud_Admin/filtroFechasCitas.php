<?php 

    include("../conex_bd.php");

    if (isset($_GET["fechaCita"])) {

        $fechaDeLaCita = $_GET['fechaCita'];
        $idMedicoSession = $_GET['idDoctor'];

        $datosCitas = [];


        if($fechaDeLaCita == 'citasTotales'){

            $consultasqlTodas = "SELECT c.id_medico, c.id_cita, c1.nombre AS nombre_paciente, c1.apellido AS apellido_paciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE c.id_medico = $idMedicoSession";

            $resultadoBusquedaTodas = mysqli_query($conexion, $consultasqlTodas);

            if($resultadoBusquedaTodas->num_rows > 0){

                $datosCitas = [];

                while($row=$resultadoBusquedaTodas->fetch_assoc()){ 

                    $datosCitas[] = [
                        'id_cita' => $row['id_cita'],
                        'nombrePaciente' => $row['nombre_paciente'],
                        'apellidoPaciente' => $row['apellido_paciente'],
                        'nombreMedico' => $row['nombre_medico'],
                        'nombreEsp' => $row['nombre_esp'],
                        'fecha' => $row['fecha'],
                        'hora' => $row['hora'],
                        'estado' => $row['estado']
                        
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


        }else{

            // Preparar la consulta SQL con marcadores de posición
            $consultasql = "SELECT c.id_medico, c.id_cita, c1.nombre AS nombre_paciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE c.id_medico = $idMedicoSession AND c.fecha = '$fechaDeLaCita'";

            $resultadoBusqueda = mysqli_query($conexion, $consultasql);

            if($resultadoBusqueda->num_rows > 0){

                $datosCitas = [];

                while($row=$resultadoBusqueda->fetch_assoc()){ 

                    $datosCitas[] = [
                        'id_cita' => $row['id_cita'],
                        'nombrePaciente' => $row['nombre_paciente'],
                        'nombreMedico' => $row['nombre_medico'],
                        'nombreEsp' => $row['nombre_esp'],
                        'fecha' => $row['fecha'],
                        'hora' => $row['hora'],
                        'estado' => $row['estado']
                        
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
        }
    }else {
        $response = [
            'success' => false,
            'message' => "No se encontraron datos relacionados porque nisiquiera entra ."
        ];
        echo json_encode($response);
    }

?>