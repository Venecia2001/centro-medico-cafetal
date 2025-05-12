<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document1</title>
    <link rel="stylesheet" href="interfazMedico.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>

<aside class="sidebar">

    <?php
        session_start();

        // if (empty($_SESSION["usuario"])) {
        //     header("location:login.php");
        //     exit();
        // }

        // echo "bienvenid@".$_SESSION["nombre"]." ".$_SESSION["apellido"]." ".$_SESSION["id"];

        $idMedicoSession = $_SESSION["id"];

    ?>


        <form action="" class= "sidebar__form">
            <input type="checkbox" id="open_menu">
            <label for="open_menu" class="material-symbols-outlined">close</label>
            <label class="material-symbols-outlined open-button" for="open_menu">double_arrow</label>
        </form>
        <picture class= "sidebar__picture">
            <img src="imagenes/logo-removebg-preview (1).png" alt="logo" width ="150px">
        </picture>

        <nav class= "sidebar__nav" >
        
        <ul>

        <li class="sidebar__item">
            <span class="material-symbols-outlined">Person</span>
            <a href="seccionMedicos.php">Perfil</a>
        </li>
        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="#">citas medicas</a>
        </li>
        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="resultadosCitas.php">Diagnostico de Citas</a>
        </li>
        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="historialCitas_medicos.php">Historial de Citas</a>
        </li>
        <li class="sidebar__item">
            <span class="material-symbols-outlined">Schedule</span>
            <a href="controlHorarios_medicos.php">Horarios</a>
        </li>
       
        </ul>

        </nav>

        <div class="sidebar__profile">
            <ul>
                <li class ="item__profile">
                    <?php 

                    include "conex_bd.php";
                    
                    $consultaPerfil = "SELECT foto_perfil FROM medicos WHERE id_medico = $idMedicoSession";
                    $resultConsulta = mysqli_query($conexion, $consultaPerfil);
                    
                    while($data = $resultConsulta->fetch_array()){

                        $fotoPerfil = $data['foto_perfil'];

                    }
                    
                    ?> 

                    <img width="100" src="uploads/.<?php echo $fotoPerfil ?>" alt="fotoPerfil">
                    <!-- <img src="imagenes/doctor07.jpg" alt="doctor" width="120px"> -->
                    <span class= "profile-option">mi perfil</span>
                </li>
                <li  class="sidebar__item">
                    <span class="material-symbols-outlined">logout</span>
                    <span><a href="cerrar.php" id="cerrarSesion">cerrar sesion</a></span>
                </li>

            </ul>

        </div>
    </aside>

    <main>

            <h2 class='tituloSeccion'>Gestion de Citas</h2>

            <div class="contenidoCitasPendientes">

                <div class="contadorCitas">

                    <div class="citasPendientes caja">
                        <h2>Citas Pendientes</h2>
                        <?php
                        
                        $numeroCitasPendientes = "SELECT  COUNT(Id_medico) AS cantidad, estado FROM citas WHERE id_medico = $idMedicoSession && estado = 'aprobado'";
                        $resultCantidad = mysqli_query($conexion,$numeroCitasPendientes);

                        $fila= mysqli_fetch_assoc($resultCantidad);

                        $cantidadPendiente = $fila['cantidad']

                        ?>
                        <div class='cifraCita'>
                            <span class='numeroCita'><?php echo $cantidadPendiente ?></span>
                        </div>
                    </div>

                    

                    
                    <div class="citasConfirmadas caja">
                        <h2>Citas Realizdas</h2>

                        <?php
                        
                        $numeroCitasResueltas = "SELECT  COUNT(Id_medico) AS cantidad, estado FROM citas WHERE id_medico = $idMedicoSession && estado = 'realizado'";
                        $resultCantidadConcretas = mysqli_query($conexion,$numeroCitasResueltas);

                        $fila= mysqli_fetch_assoc($resultCantidadConcretas);

                        $cantidadConfirm = $fila['cantidad']

                        ?>
                        <div class='cifraCita'>
                            <span class='numeroCita'><?php echo $cantidadConfirm ?></span>
                        </div>
                    </div>

                </div>
                        <div class="filtroCitas">
                            <?php
                                $current_date = date('Y-m-d');
                            ?>
                            <form action="" method ="POST" id="formulario_filtro">
                                <select name="filtro" id="seleccionarFechasCitas">
                                    <option value="">Seleccione Fecha</option>
                                    <option value="<?php echo $current_date ?>">Citas del dia</option>
                                    <option value="fitrarSenama">Citas de la semana</option>
                                    <option value="citasTotales">Todas las Citas</option>
                                </select>
                            </form>
                        
                        </div>

                <div class="cuadroCitas">

                   <table id='tablequotes'>
                         
                        <thead>
                            <th>Id_cita</th>
                            <th>Paciente</th>
                            <th>Medico</th>
                            <th>especialidad</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estatus</th>
                            <th>cancelar</th>
                            <th>Resultado</th>
                        </thead>
                        <tbody id="bodyTable">
                        <?php 
                            
                            include "conex_bd.php";

                            $citasSql = "SELECT c.id_medico, c.id_cita, c1.nombre AS nombre_paciente, c1.apellido AS apellidoPaciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE c.id_medico = $idMedicoSession AND c.fecha BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY;";
                            $result = mysqli_query($conexion, $citasSql);

                            while($datos=$result->fetch_object()){ 
                                
                                $id_cita = $datos->id_cita; 
                                ?>

                                <tr class='filaCita'>
                                    <td><?php echo $datos->id_cita ?> </td>
                                    <td><?php echo $datos->nombre_paciente.' '.$datos->apellidoPaciente ?> </td>
                                    <td> Dr.<?php echo $datos->nombre_medico ?> </td>
                                    <td><?php echo $datos->nombre_esp ?> </td>
                                    <td><?php echo $datos->fecha ?> </td>
                                    <td ><?php echo $datos->hora ?> </td>
                                    <td class='estadoCita <?php echo $datos->estado ?>'> <?php echo $datos->estado ?> </td>
                                    <input type="hidden" value='<?php echo $idMedicoSession?>' id='idDeDoctor'>

                                    <?php echo "<td> 
                                                    
                                                    <form  id='formCancelar' action='Crud_Admin/datosMedicos.php' method ='POST'>
                                                        <input type='hidden' name='id_cita' value='".$datos->id_cita."'>
                                                        <input type='hidden' name='statusCita' value='cancelado'>
                                                        <button type='submit' name='estadoCancelado' class='cancelar btnTable'>cancelar Cita</button>
                                                    </form>
                                                </td>";?>
                                    <?php echo "<td> 
                                                    
                                                    <form  id='formResultado' action='resultadosCitas.php' method ='POST'>
                                                        <input type='hidden' name='id_cita' value='".$datos->id_cita."'>
                                                        <button type='submit' name='getCita' class='resultCita btnTable'>generar Resultado</button>
                                                    </form>
                                                </td>";?>
                                </tr>

                                <?php
                            }
                            
                            ?>

                        </tbody>
                    </table><br>
                </div>

            </div>

            
    </main>

    
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Seleccionamos todas las filas de la tabla dentro de tbody
            const filasCitas = document.querySelectorAll('#bodyTable .filaCita');

            filasCitas.forEach(fila => {
                // Obtener el estado de la cita (ubicado en la clase "estadoCita")
                const estado = fila.querySelector('.estadoCita').textContent.trim();

                // Si el estado es "realizado", deshabilitamos el botón en esa fila
                if (estado === 'realizado') {
                    // Encontrar el botón "Generar Resultado" en esa fila
                    const botonGenerarResultado = fila.querySelector('.resultCita');

                    // Deshabilitar el botón
                    botonGenerarResultado.disabled = true;

                    // Opcional: agregar una clase para cambiar el estilo del botón deshabilitado
                    botonGenerarResultado.classList.add('disabled');

                    console.log(`El botón de la cita ${fila.querySelector('td').textContent} ha sido deshabilitado porque el estado es "realizado".`);
                }
            });
        });

        document.getElementById('seleccionarFechasCitas').addEventListener('change', function() {
            // Obtener el valor seleccionado
            const filtroValue = this.value;

            if(filtroValue === "fitrarSenama"){
                location.reload();            
            }

            let idDoctor = document.getElementById('idDeDoctor').value;

            console.log(filtroValue);
            console.log(idDoctor);

            // Verificar si se seleccionó una opción válida
            if (filtroValue !== "") {
                // Enviar el valor seleccionado usando Fetch
                fetch('Crud_Admin/filtroFechasCitas.php?fechaCita=' + filtroValue + '&idDoctor=' + idDoctor)
                .then(response => {
                    // Verificar si la respuesta es exitosa (código de estado 200)
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json(); // Parsear la respuesta como JSON
                })
                .then(data => {

                    let contenedorCitas = document.getElementById("bodyTable");
                    // Aquí es donde procesamos el JSON recibido

                    contenedorCitas.innerHTML = '';

                    // const cuadroCitas = document.getElementById('seccionHistorial');
                    // cuadroCitas.innerHTML = '';

                    if (data.success) {
                        console.log(data.data)

                   

                        data.data.forEach(cita => {

                            const fila = document.createElement('tr');
                                              
                            // Crear celdas para cada propiedad
                            fila.innerHTML = `
                                <td >${cita.id_cita}</td>
                                <td>${cita.nombrePaciente} ${cita.apellidoPaciente} </td>
                                <td>${cita.nombreMedico}</td>
                                <td>${cita.nombreEsp}</td>
                                <td>${cita.fecha}</td>
                                <td>${cita.hora}</td>
                                <td class="estadoCita ${cita.estado}">${cita.estado}</td>
                                <td> 
                                    <form  id='formCancelar' action='Crud_Admin/datosMedicos.php' method ='POST'>
                                            <input type='hidden' name='id_cita' value='${cita.id_cita}'>
                                            <input type='hidden' name='statusCita' value='cancelado'>
                                            <button type='submit' name='estadoCancelado' class='cancelar btnTable'>cancelar Cita</button>
                                    </form>
                                </td>
                                <td> 
                                    <form  id='formResultado' action='resultadosCitas.php' method ='POST'>
                                            <input type='hidden' name='id_cita' value='${cita.id_cita}'>
                                            <button type='submit' name='getCita' class='resultCita btnTable'>generar Resultado</button>
                                    </form>
                                </td>
                                
                            `;
                            
                            // Agregar la fila al cuerpo de la tabla
                            contenedorCitas.appendChild(fila);

                            if (cita.estado === "realizado") {
                                const botonGenerarResultado = fila.querySelector('.resultCita');
                                botonGenerarResultado.disabled = true;  // Deshabilitamos solo el botón de esta fila
                                botonGenerarResultado.classList.add('disabled');  // Opcional: agregar una clase para cambiar el estilo
                            }


                        });

                        
                        // Aquí puedes manejar los datos como lo desees
                    } else {
                        contenedorCitas.innerHTML = "<tr><td colspan='10'>No se encontraron datos relacionados.</td></tr>";
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });
            } else {
                // Si no se selecciona una opción válida, puedes hacer algo (opcional)
                console.log('No se ha seleccionado una opción válida.');
            }
        });




    </script>
</body>
</html>