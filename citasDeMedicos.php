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

            <div class="contenidoCitasPendientes">

                <div class="contadorCitas">

                    <div class="citasPendientes caja">
                        <h2>Citas Pendientes</h2>
                        
                        <?php
                        
                        $numeroCitasPendientes = "SELECT  COUNT(Id_medico) AS cantidad, estado FROM citas WHERE id_medico = 20 && estado = 'pendiente'";
                        $resultCantidad = mysqli_query($conexion,$numeroCitasPendientes);

                        $fila= mysqli_fetch_assoc($resultCantidad);

                        $cantidadPendiente = $fila['cantidad']

                        ?>

                        <h3><?php echo $cantidadPendiente ?></h3>
                    </div>

                    
                    <div class="citasConfirmadas caja">
                        <h2>Citas confirmadas</h2>

                        <h3>3</h3>
                    </div>

                </div>




                <h1>sus citas pendientes son___son___son</h1>

                <div class="cuadroCitas">

                <div class="filtroCitas">
                    <?php
                        $current_date = date('Y-m-d');
                    ?>
                    <form action="" method ="POST" id="formulario_filtro">
                        <select name="filtro" id="seleccionarFechasCitas">
                            <option value="">Seleccione Fecha</option>
                            <option value="<?php echo $current_date ?>">Citas del dia</option>
                            <option value="fitrarSenama">Citas de la semana</option>
                        </select>
                    </form>
                   
                </div>

                    <table>
                        <thead>
                            <th>Id_cita</th>
                            <th>Paciente</th>
                            <th>Medico</th>
                            <th>especialidad</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estatus</th>
                            <th>confirmar</th>
                            <th>cancelar</th>
                            <th>generar Resultado</th>
                        </thead>
                        <tbody id="bodyTable">
                        <?php 
                            
                            include "conex_bd.php";

                            $citasSql = "SELECT c.id_medico, c.id_cita, c1.nombre AS nombre_paciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE c.id_medico = $idMedicoSession AND c.fecha BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY;";
                            $result = mysqli_query($conexion, $citasSql);

                            while($datos=$result->fetch_object()){ 
                                
                                $id_cita = $datos->id_cita; 
                                ?>

                                <tr>
                                    <td><?php echo $datos->id_cita ?> </td>
                                    <td><?php echo $datos->nombre_paciente ?> </td>
                                    <td> Dr.<?php echo $datos->nombre_medico ?> </td>
                                    <td><?php echo $datos->nombre_esp ?> </td>
                                    <td><?php echo $datos->fecha ?> </td>
                                    <td ><?php echo $datos->hora ?> </td>
                                    <td class='<?php echo $datos->estado ?>'> <?php echo $datos->estado ?> </td>
                                    <?php echo "<td>
                                                    
                                                    <form  id='formAceptar' action='Crud_Admin/datosMedicos.php' method ='POST'>
                                                        <input type='hidden' name='id_cita' value='".$datos->id_cita."'>
                                                        <input type='hidden' name='statusCita' value='aprobado'>
                                                        <button type='submit' name='estadoAprovado' class='aprobar'>Confirmar Cita</button>
                                                    </form>
                                                </td>";?>

                                    <?php echo "<td> 
                                                    
                                                    <form  id='formCancelar' action='Crud_Admin/datosMedicos.php' method ='POST'>
                                                        <input type='hidden' name='id_cita' value='".$datos->id_cita."'>
                                                        <input type='hidden' name='statusCita' value='cancelado'>
                                                        <button type='submit' name='estadoCancelado' class='cancelar'>cancelar Cita</button>
                                                    </form>
                                                </td>";?>
                                    <?php echo "<td> 
                                                    
                                                    <form  id='formResultado' action='resultadosCitas.php' method ='POST'>
                                                        <input type='hidden' name='id_cita' value='".$datos->id_cita."'>
                                                        <button type='submit' name='getCita' class='resultCita'>generar Resultado</button>
                                                    </form>
                                                </td>";?>
                                </tr>

                                <?php
                            }
                            
                            ?>

                        </tbody>
                    </table><br><br>
                </div>

            </div>

            <div class="citasRealizadas" id="citasRealizadasId">
                        <h2>Histodial Citas Realizadas</h2><br><br>

                        <div class="cuadroDeBusqueda">

                            <form id="searchForm">
                                <label for="">Busqueda por id De cita y nombre del paciente</label><br>
                                <label for="">Buscar</label>
                                <input type="hidden" name="idDeMedico" id="idDeDoctor" value="<?php echo $idMedicoSession ?>">
                                <input type="text" name="search" id="searchInput" placeholder="Buscar paciente o ID de cita">
                                <input type="submit" name="buscador" id="btnBuscador" value="Buscar">

                            </form>
                            
                        </div>


                    <div class="cuadroDeHistorial" id="seccionHistorial">

                        <?php

                        include "conex_bd.php";



                        $consultaHistorial = "SELECT hm.*, c.id_cita, c.id_medico, c.id_cliente, c.fecha, c.especialidad, cl_paciente.nombre AS nombre_paciente, cl_medico.nombre AS nombre_medico, e.nombre_esp FROM historial_medico hm JOIN citas c ON hm.id_cita = c.id_cita JOIN usuarios cl_paciente ON c.id_cliente = cl_paciente.id JOIN usuarios cl_medico ON c.id_medico = cl_medico.id JOIN especialidades e ON e.id_especialidad = c.especialidad WHERE c.id_medico = $idMedicoSession;";
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
                            $nombre_esp = $datos['nombre_esp'];
                        ?>
                        

                        <div class="reporteCita">

                            <h3>id_Cita: <?php echo $id_citaHistorial ?> </h3><br>
                            <h3>Especialidad: <?php echo $nombre_esp ?> </h3><br>
                            <h3>fecha: <?php echo $fecha ?> </h3><br>
                            <h3>doctor: <?php echo $doctorRes ?> </h3><br>
                            <h3>paciente: <?php echo $nombrePaciente ?> </h3><br>
                            <h3>diagnostico: <?php echo $diagnos?></h3><br>

                            <form  action='Crud_Admin/resultadoFinalCitas.php' id="form_editar_<?php echo $id_citaHistorial; ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idHistorialCita" value="<?php echo $id_citaHistorial; ?>">
                                    <button type="button" class="detallesCita" onclick="enviarFormulario(<?php echo $id_citaHistorial; ?>)">ver detalles</button>
                            </form>

                        </div>
                            <?php
                        }  
                        ?>
                    </div>
    

            </div>
        </main>

        <dialog id="modalDetallesHistorial">
            <h2>Datos Paciente</h2>
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
                        
                            <div class="contentDatos"  id="cajaTextId"> 
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
                            </div>
                    </div>
                
            </div>

        </dialog>



        <script>

            
    function enviarFormulario(id) {
                    
                    let inputId = document.querySelector(`#form_editar_${id} input[name='idHistorialCita']`).value;

                    console.log(inputId)

                    // Realizamos la solicitud con fetch
                    fetch('Crud_Admin/resultadoFinalCitas.php', {
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

                            document.getElementById('nombrePac').innerHTML = data.nombre;
                            document.getElementById('nombreDoctor').innerHTML = data.nombreMedico;
                            document.getElementById('fechaCita').innerHTML = data.fecha;
                            document.getElementById('especialidadHistorial').innerHTML = data.especialidad;
                            document.getElementById('idDeCita').innerHTML = data.id;
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

                                    <h3>id_Cita: ${historial.id_cita} </h3><br>
                                    <h3>Especialidad: ${historial.nombreEsp} </h3><br>
                                    <h3>fecha: ${historial.fecha}</h3><br>
                                    <h3>doctor: ${historial.nombreMedico} </h3><br>
                                    <h3>paciente: ${historial.nombrePaciente} </h3><br>
                                    <h3>diagnostico: ${historial.diagnostico}</h3><br>

                                    <form  action='Crud_Admin/resultadoFinalCitas.php' id="form_editar_${historial.id_cita}" method="POST" style="display:inline;">
                                            <input type="hidden" name="idHistorialCita" value="${historial.id_cita}">
                                            <button type="button" class="detallesCita" onclick="enviarFormulario(${historial.id_cita})">ver detalles</button>
                                    </form>

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
                                <td>${cita.nombrePaciente}</td>
                                <td>${cita.nombreMedico}</td>
                                <td>${cita.nombreEsp}</td>
                                <td>${cita.fecha}</td>
                                <td>${cita.hora}</td>
                                <td class="${cita.estado}">${cita.estado}</td>
                                <td> 
                                    <form  id='formAceptar' action='Crud_Admin/datosMedicos.php' method ='POST'>
                                        <input type='hidden' name='id_cita' value='${cita.id_cita}'>
                                        <input type='hidden' name='statusCita' value='aprobado'>
                                        <button type='submit' name='estadoAprovado' class='aprobar'>Confirmar Cita</button>
                                    </form>
                                </td>
                                <td> 
                                    <form  id='formCancelar' action='Crud_Admin/datosMedicos.php' method ='POST'>
                                            <input type='hidden' name='id_cita' value='${cita.id_cita}'>
                                            <input type='hidden' name='statusCita' value='cancelado'>
                                            <button type='submit' name='estadoCancelado' class='cancelar'>cancelar Cita</button>
                                    </form>
                                </td>
                                <td> 
                                    <form  id='formResultado' action='resultadosCitas.php' method ='POST'>
                                            <input type='hidden' name='id_cita' value='${cita.id_cita}'>
                                            <button type='submit' name='getCita' class='resultCita'>generar Resultado</button>
                                    </form>
                                </td>
                                
                            `;
                            
                            // Agregar la fila al cuerpo de la tabla
                            contenedorCitas.appendChild(fila);
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