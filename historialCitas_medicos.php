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
            <a href="citasDeMedicos.php">citas medicas</a>
        </li>
        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="resultadosCitas.php">Diagnostico de Citas</a>
        </li>
        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="#">Historial de Citas</a>
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


    <main id='conedorHistoriasCitas'>

    <div class="citasRealizadas" id="citasRealizadasId">

                        <h2 class='tituloSeccion'>Historial Citas Realizadas</h2><br>

                        <div class="cuadroDeBusqueda">

                            <form id="searchForm">
                                <input type="hidden" name="idDeMedico" id="idDeDoctor" value="<?php echo $idMedicoSession ?>">
                                <input type="text" name="search" id="searchInput" placeholder="Buscar paciente o ID de cita">
                                <input type="submit" name="buscador" id="btnBuscador" value="Buscar">

                            </form>
                            
                        </div>


                    <div class="cuadroDeHistorial" id="seccionHistorial">


                        <div class='especioReportes'> 
                        <?php

                        include "conex_bd.php";



                        $consultaHistorial = "SELECT hm.*, c.id_cita, c.id_medico, c.id_cliente, c.fecha, c.especialidad, cl_paciente.nombre AS nombre_paciente, cl_paciente.apellido AS apellidoPaciente, cl_medico.nombre AS nombre_medico, e.nombre_esp FROM historial_medico hm JOIN citas c ON hm.id_cita = c.id_cita JOIN usuarios cl_paciente ON c.id_cliente = cl_paciente.id JOIN usuarios cl_medico ON c.id_medico = cl_medico.id JOIN especialidades e ON e.id_especialidad = c.especialidad WHERE c.id_medico = $idMedicoSession;";
                        $resultHistorial = mysqli_query($conexion,$consultaHistorial);
    
    
                        while($datos=$resultHistorial->fetch_array()){ 
                            // $id = $datos["id"];
                            // $nombre = $datos["nombre"];
                            // $apellido = $datos["apellido"];
                            // $telefono = $datos["telefono"];
                            $id_citaHistorial = $datos['id_cita'];
                            $fecha = $datos["fecha"];
                            $diagnos = $datos["diagnostico"];
                            $tratamiento = $datos["tratamiento"];
                            $prescripcion = $datos["prescripcion"];      
                            $examenes = $datos['examenes_realizados'];    
                            $doctorRes = $datos ['nombre_medico'];
                            $nombrePaciente = $datos['nombre_paciente'];
                            $apellidoPaciente = $datos['apellidoPaciente'];
                            $nombre_esp = $datos['nombre_esp'];
                        ?>
                        

                        <div class="reporteCita">

                            <div class='repoteHead'>
                                <h3>id_Cita: <?php echo $id_citaHistorial ?> </h3><br>
                            </div>
                            <div class='bodyReporte'>
                            <h3>Especialidad: <?php echo $nombre_esp ?> </h3><br>
                            <h3>fecha: <?php echo $fecha ?> </h3><br>
                            <h3>doctor: <?php echo $doctorRes ?> </h3><br>
                            <h3>paciente: <?php echo $nombrePaciente.' '.$apellidoPaciente ?> </h3><br>

                            <div class="divBtnDetalles">
                                <form  action='Crud_Admin/jsonDetallesCitas.php' id="form_editar_<?php echo $id_citaHistorial; ?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="idHistorialCita" value="<?php echo $id_citaHistorial; ?>">
                                        <button type="button" class="detallesCitaHistorial" onclick="enviarFormulario(<?php echo $id_citaHistorial; ?>)">Ver Detalles</button>
                                
                                </form>
                            </div>
                            </div>

                        </div>
                            <?php
                        }  
                        ?>
                     </div>

                    </div>
    

            </div>              

    </main>


    <dialog id="modalDetallesHistorial">

            <div class ="cabezeraFactura">

                <h2>Datos Historial</h2>

            </div>
            <div class="HistorialMedico">
                <form method="dialog">
                    <button class="btnClose"> X</button>
                </form>

                    <div class="infoIdentificacion">

                            <div class="contentDatos"  id="cajaTextPaciente">
                                <label for="">Nombre Paciente: </label>
                                <span id="nombrePac" class="datosHistorial"></span>
                            </div>   
                            <div class="contentDatos" id="cajaTextDoctor">
                                <label for="">Medico Responsable: Dr  </label>
                                <span id="nombreDoctor" class="datosHistorial" ></span>
                            </div>
                            <div class="contentDatos" id="cajaTextEsp">   
                                <label for="">Especialidad: </label>
                                <span id="especialidadHistorial" class="datosHistorial" ></span>
                            </div>
                            <div class="contentDatos"  id="cajaTextFecha">   
                                <label for="">Fecha: </label>
                                <span id="fechaCita" class="datosHistorial"></span>
                            </div> 
                            
                    </div>

                    <div class="datosDeDiagnostico">


                    <ul class='resultadoCts'>
                        <li><h3>Diagnostico:</h3> <samp class='resulCts' id='DiagnosticoCita'></samp></li>
                        <li><h3>Tratamiento:</h3> <samp class='resulCts' id='tratamientoCita'></samp></li>
                        <li><h3>Prescripciones:</h3> <samp class='resulCts' id='prescripcionesCita'></samp></li>
                        <li><h3>Examanes :</h3> <samp class='resulCts' id='examenesCita'></samp></li>
                    </ul>
                        
                                <!-- <div class="contentDatos"  id="cajaTextId"> 
                                    <label for="">N Cita: </label>
                                    <span id="idDeCita" class="datosHistorial"></span> 
                                </div>

                                <div class="contentDatos"  id="cajaTextId"> 
                                    <label for="">Diagnostico: </label>
                                    <span id="DiagnosticoCita" class="datosHistorial"></span> 
                                </div>

                                <div class="contentDatos"  id="cajaTextId"> 
                                    <label for="">Tratamiento: </label>
                                    <span id="tratamientoCita" class="datosHistorial"></span> 
                                </div>
                                <div class="contentDatos"  id="cajaTextId"> 
                                    <label for="">Prescripciones: </label>
                                    <span id="prescripcionesCita" class="datosHistorial"></span> 
                                </div>
                                <div class="contentDatos"  id="cajaTextId"> 
                                    <label for="">Examenes Realizados: </label>
                                    <span id="examenesCita" class="datosHistorial"></span> 
                                </div> -->
                    </div>
                
            </div>

        </dialog>


    <script>
                 
            function enviarFormulario(id) {
                    
                    let inputId = document.querySelector(`#form_editar_${id} input[name='idHistorialCita']`).value;

                    console.log(inputId)

                    // Realizamos la solicitud con fetch
                    fetch('Crud_Admin/jsonDetallesCitas.php', {
                    method: 'POST',  // Método de la solicitud
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'  // Tipo de contenido
                    },
                    body: `idCita=${encodeURIComponent(inputId)}`  // El cuerpo de la solicitud con el idEditar
                    })
                    .then(response => {
                        // Verificamos si la respuesta es exitosa
                        if (!response.ok) {
                            throw new Error('Error en la solicitud AJAX');
                        }
                        // Convertimos la respuesta en JSON
                        return response.json();
                    })
                    .then(data => {
                        // Si hay un error en los datos devueltos
                        if (data.error) {
                            alert(data.error);  // Si hay error, mostrarlo
                        }else {
                            // Si la respuesta es exitosa, hacer algo con los datos
                            console.log(data);  // Muestra los datos en la consola
                            // Actualizar los campos en la interfaz, por ejemplo:

                            document.getElementById('nombrePac').innerHTML = data.nombre+' '+data.apellidoPact;
                            document.getElementById('nombreDoctor').innerHTML = data.nombreMedico;
                            document.getElementById('fechaCita').innerHTML = data.fecha;
                            document.getElementById('especialidadHistorial').innerHTML = data.especialidad;
                            // document.getElementById('idDeCita').innerHTML = data.id;
                            document.getElementById('DiagnosticoCita').innerHTML = data.diagnostco;
                            document.getElementById('tratamientoCita').innerHTML = data.tratamiento;
                            document.getElementById('prescripcionesCita').innerHTML = data.presecciones;
                            document.getElementById('examenesCita').innerHTML = data.examenes;

                            const dialog = document.getElementById("modalDetallesHistorial");
                            dialog.showModal()
                            
                        }
                    })
                    .catch(error => {
                        // Si ocurre un error en cualquier parte del proceso
                        console.error('Error:', error);
                    });
    
    
    
            }

            document.getElementById('searchForm').addEventListener('submit', function(event) {
                event.preventDefault(); 

                let searchTerm = document.getElementById('searchInput').value;
                let idDoctor = document.getElementById('idDeDoctor').value;

                console.log(idDoctor);
                console.log(searchTerm);

                // Hacer la solicitud fetch al servidor
                fetch('Crud_Admin/busquedaHistorial.php?search=' + searchTerm + '&idDoctor=' + idDoctor)
                .then(response => {
                    // Verificar si la respuesta es exitosa (código de estado 200)
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json(); // Parsear la respuesta como JSON
                })
                .then(data => {
                    // Aquí es donde procesamos el JSON recibido

                    

                    const cuadroCitas = document.getElementById('seccionHistorial');
                    cuadroCitas.innerHTML = '';

                    if (data.success) {
                        console.log(data.data)

                        data.data.forEach(historial => {
                            
                            let codigoHtml = `

                                <div class="reporteCita">

                                    <div class='repoteHead'>
                                        <h3>id_Cita: ${historial.id_cita} </h3><br>
                                    </div>
                                    <div class='bodyReporte'>
                                        <h3>Especialidad:${historial.nombreEsp}  </h3><br>
                                        <h3>fecha: ${historial.fecha} </h3><br>
                                        <h3>doctor:${historial.nombreMedico} </h3><br>
                                        <h3>paciente: ${historial.nombrePaciente} ${historial.apellidoPaciente} </h3><br>

                                        <div class="divBtnDetalles">
                                            <form  action='Crud_Admin/jsonDetallesCitas.php' id="form_editar_${historial.id_cita}" method="POST" style="display:inline;">
                                                    <input type="hidden" name="idHistorialCita" value="${historial.id_cita}">
                                                    <button type="button" class="detallesCitaHistorial" onclick="enviarFormulario(${historial.id_cita})">Ver Detalles</button>
                                
                                            </form>
                                        </div>
                                     </div>

                                </div>

                            `

                            cuadroCitas.innerHTML += codigoHtml;
                            // Crear celdas para cada propiedad
                            // fila.innerHTML = `
                            //     <td>${medico.id_disponibilidad}</td>
                            //     <td>${medico.nombre}</td>
                            //     <td>${medico.apellido}</td>
                            //     <td>${medico.dia_semana}</td>
                            //     <td>${medico.hora_inicio}</td>
                            //     <td>${medico.hora_fin}</td>
                            //     <td>${medico.disponibilidad}</td>
                            // `;
                            
                            // // Agregar la fila al cuerpo de la tabla
                            // cuerpoTabla.appendChild(fila);
                        });

                        // Aquí puedes manejar los datos como lo desees
                    } else {
                        console.log(data.message); // Mensaje de error si no se encontraron datos
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });
                                

                // fetch(`Crud_Admin/busquedaHistorial.php?search=${searchTerm}`)
                //     .then(response => response.json())  // Convierte la respuesta en JSON
                //     .then(data => {

                //     const tableBody = document.getElementById('citasRealizadas')
                //     tableBody.innerHTML = '';

                //     if (data.success) {
                //             // Crear un primer option para "Seleccionar un médico"
                //             console.log(data);

                        
                //             // Iterar sobre los resultados y agregar filas a la tabla
                //             // data.data.forEach(medico => {
                //             //     // Crear una fila de la tabla
                //             //     // const fila = document.createElement('tr');
                                
                //             //     // Crear celdas para cada propiedad
                //             //     // fila.innerHTML = `
                //             //     //     <td>${medico.id_disponibilidad}</td>
                //             //     //     <td>${medico.nombre}</td>
                //             //     //     <td>${medico.apellido}</td>
                //             //     //     <td>${medico.dia_semana}</td>
                //             //     //     <td>${medico.hora_inicio}</td>
                //             //     //     <td>${medico.hora_fin}</td>
                //             //     //     <td>${medico.disponibilidad}</td>
                //             //     // `;
                                
                //             //     // // Agregar la fila al cuerpo de la tabla
                //             //     // cuerpoTabla.appendChild(fila);
                //             // });
                //     } else {

                //         console.log(data.message);
                //         // Si no hay resultados, mostrar un mensaje
                //         // let row = tableBody.insertRow();
                //         // row.innerHTML = '<td colspan="5">No se encontraron resultados</td>';
                //     }
                // })
                // .catch(error => {
                //     console.error('Error:', error);
        //         // });
        });



    </script>

 </body>
 </html>