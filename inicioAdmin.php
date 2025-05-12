<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="interfazAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

    <?php include "sideba_admin.php" ?>

    <main> 
        <h1 class='tituloSeccion'>Bienvenido Jhoan!</h1>


    <div class="Panel">

        <div class="Panel__item">
            <a href="#" id="tarjPaciente" class="tarjeta">
            <div class="titlePanel"> <p>Pacientes</p></div>
            <div class="contenido">
                    
                <div class="Texto"> <p>Total Pacientes</p></div>
                <div class="numerosBd">

                    <?php 
                    
                    include "conex_bd.php";

                    $getDatos ="SELECT COUNT(nombre) AS cantidad FROM usuarios WHERE rol = 3";
                    $result = mysqli_query($conexion, $getDatos);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroUsuarios = $fila['cantidad'];

                    ?>


                    <span id="numPacientes"> <?php echo $numeroUsuarios ?></span>
                </div>
            </div>
            


            </a>
        </div>

        <div class="Panel__item">
             <a href="#" id="tarjMedicos" class="tarjeta">
                <div class="titlePanel"> <p>Medicos</p></div>

                <?php 
                    include "conex_bd.php";

                    $getDatosMed ="SELECT COUNT(nombre) AS cantidad FROM usuarios WHERE rol IN (2, 5)";
                    $result = mysqli_query($conexion, $getDatosMed);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroMedicos = $fila['cantidad'];
                    ?>
                <div class="contenido">

                    <div class="Texto"> <p>Total Medicos</p></div>
                    <div class="numerosBd"> <span id="numPacientes"><?php echo $numeroMedicos ?></span></div>
                </div>

             </a>
            
        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjCitas" class="tarjeta">
                <div class="titlePanel"> <p>Especialides</p></div>
                <?php 

                    $getDatosEsp ="SELECT COUNT(nombre_esp) AS cantidad FROM especialidades";
                    $result = mysqli_query($conexion, $getDatosEsp);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroEspecialidades = $fila['cantidad'];
                ?>
                <div class="contenido">
                    <div class="Texto"> <p>Total </p></div>
                    <div class="numerosBd"> <span id="numPacientes"><?php echo $numeroEspecialidades ?></span></div>
                </div>
            </a>
        
        </div>

        <div class="Panel__item">
             <a href="#" id="tarjHorarios" class="tarjeta">
                <div class="titlePanel"> <p>Citas Medicas</p></div>
                <div class="contenido">

                <?php 

                    $getCitas ="SELECT COUNT(id_cita) AS cantidad FROM citas";
                    $result = mysqli_query($conexion, $getCitas);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroCitas = $fila['cantidad'];
                ?>

                    <div class="Texto"> <p>Total Citas</p></div>
                    <div class="numerosBd"> <span id="numPacientes"><?php echo $numeroCitas ?></span></div>
                </div>

             </a>
            
        
        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjEstadisticas" class="tarjeta">
                <div class="titlePanel"> <p>Emergencias</p></div>
                <div class="contenido">

                <?php 

                    $getEmergencias = "SELECT COUNT(id_emergencia) AS cantidad FROM emergencias_medicas";
                    $result = mysqli_query($conexion, $getEmergencias);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroEmergencias = $fila['cantidad'];
                ?>

                
                
                    <div class="Texto"> <p>Emergencia atendidas</p></div>
                    <div class="numerosBd"> <span id="numPacientes"><?php echo $numeroEmergencias ?></span></div>
                </div>

            </a>

        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjNoSeSabe" class="tarjeta">
                <div class="titlePanel"> <p>Estadistica</p></div>
                <div class="contenido">

                <?php 

                    $citasCompletadas = "SELECT COUNT(*) AS total_citas, SUM(CASE WHEN estado = 'realizado' THEN 1 ELSE 0 END) AS citas_realizadas, ROUND( (SUM(CASE WHEN estado = 'realizado' THEN 1 ELSE 0 END) * 100.0) / COUNT(*), 2 ) AS porcentaje_realizadas FROM citas";
                    $result = mysqli_query($conexion, $citasCompletadas);

                    $fila= mysqli_fetch_assoc($result);

                    $porcentajeCitas = $fila['porcentaje_realizadas'];
                ?>
                    <div class="Texto"> <p>Citas Completadas</p></div>
                    <div class="numerosBd"> <span id="numPacientes"><?php echo $porcentajeCitas ?>%</span></div>
                </div>

            </a>
    
        </div>

    </div>

    </main>
    

</body>
</html>   