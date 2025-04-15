<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="longinCss.css">
</head>
<body>

    <?php  include "header.php"; ?>

    <h2>historial medico </h2>

    <section class="historialMedico">


    <div class="reporteCita">
        <div class="reporteInterno">

            <h3 class ="itenHistorial">Especialidad: Traumatologia</h3><br>
            <h3 class ="itenHistorial">doctor: Juan Gutierres </h3><br>
            <h3 class ="itenHistorial">paciente: Eduar</h3><br>
            <h3 class ="itenHistorial">fecha: 11/11/24 </h3><br>
            <h3 class ="itenHistorial">diagnostico:  tienen una coltada en el pie por causa de un hongo del bosque</h3><br>
            <h3 class ="itenHistorial">tratamiento: cremas varias alguna servira </h3><br>
            <h3 class ="itenHistorial">Prescripciones: : aplicar cada dos horas por 145 dias</h3><br>
            <h3 class ="itenHistorial">exames realidos: placa de rayos equis</h3><br>
        </div>
    </div>

    <div class="reporteCita">
        <div class="reporteInterno">

            <h3>Especialidad</h3><br>
            <h3>doctor </h3><br>
            <h3>paciente:</h3><br>
            <h3>fecha: </h3><br>
            <h3>diagnostico:</h3><br>
            <h3>tratamiento:</h3><br>
            <h3>Prescripciones:</h3><br>
            <h3>exames realidos:</h3><br>
        </div>
    </div>

    <div class="reporteCita">
        <div class="reporteInterno">

            <h3>Especialidad</h3><br>
            <h3>doctor </h3><br>
            <h3>paciente:</h3><br>
            <h3>fecha: </h3><br>
            <h3>diagnostico:</h3><br>
            <h3>tratamiento:</h3><br>
            <h3>Prescripciones:</h3><br>
            <h3>exames realidos:</h3><br>
        </div>
    </div>

    <?php 
        include "conex_bd.php";
        $id_paciente = $_SESSION["id"] ;

        $consultaHistorial = "SELECT hm.*, c.id_cita, c.id_medico, c.id_cliente, c.fecha, c.especialidad, us_paciente.nombre AS nombre_paciente, us_medico.nombre AS nombre_medico, e.nombre_esp FROM historial_medico hm JOIN citas c ON hm.id_cita = c.id_cita JOIN usuarios us_paciente ON c.id_cliente = us_paciente.id JOIN usuarios us_medico ON c.id_medico = us_medico.id JOIN especialidades e ON e.id_especialidad = c.especialidad WHERE c.id_cliente = $id_paciente;";
        $resultHistorial = mysqli_query($conexion,$consultaHistorial);


            while($datos=$resultHistorial->fetch_array()){ 
                // $id = $datos["id"];
                // $nombre = $datos["nombre"];
                // $apellido = $datos["apellido"];
                // $telefono = $datos["telefono"];
                $fecha = $datos["fecha"];
                $diagnos = $datos["diagnostico"];
                $tratamiento = $datos["tratamiento"];
                $prescripcion = $datos["prescripcion"];      
                $examenes = $datos['examenes_realizados'];    
                $doctorRes = $datos ['nombre_medico'];
                $nombrePaciente = $datos['nombre_paciente'];
                $nombre_esp = $datos['nombre_esp'];
            ?>

            <div class="reporteCita">
                <div class="reporteInterno">
                    <h3>Especialidad: <?php echo $nombre_esp ?> </h3><br>
                    <h3>doctor: <?php echo $doctorRes ?> </h3><br>
                    <h3>paciente: <?php echo $nombrePaciente ?> </h3><br>
                    <h3>fecha: <?php echo $fecha ?> </h3><br>
                    <h3>diagnostico: <?php echo $diagnos?></h3><br>
                    <h3>tratamiento: <?php echo $tratamiento ?></h3><br>
                    <h3>Prescripciones: <?php echo $prescripcion ?></h3><br>
                    <h3>exames realidos: <?php echo $examenes ?></h3><br>
                </div>
            </div>

        <?php
        }      
        
        ?>

    </section>
</body>
</html>



<?php include "footer.php";  ?>