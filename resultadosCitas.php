<?php 

//  include "conex_bd.php";

// if(isset($_POST['getCita'])){

//     $idCita = $_POST['id_cita'];

//     $consultacita = "SELECT * FROM citas WHERE id_cita = $idCita";
//     $consulresult = mysqli_query($conexion,$consultacita);

//     while($data = $consulresult->fetch_array()){

//         $idMedico = $data['id_medico'];
//         $esp = $data['especialidad'];
//         $id_paciente = $data['id_cliente'];
//         $fechaCita = $data['fecha'];

//     }

// }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document12</title>
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
        <h1 class='tituloSeccion'>Diagnostico de citas</h1>

        <div class="datosPacientes">

            <div class="informacionDePaciente">
                
                <h3 class='tituloInterno'>Datos del Paciente</h3>

                <?php
                     include "conex_bd.php";

                    if(isset($_POST['getCita'])){

                        $idCita = $_POST['id_cita'];
                    
                        $consultacita = "SELECT * FROM citas WHERE id_cita = $idCita";
                        $consulresult = mysqli_query($conexion,$consultacita);
                    
                        while($data = $consulresult->fetch_array()){
                    
                            $idMedico = $data['id_medico'];
                            $esp = $data['especialidad'];
                            $id_paciente = $data['id_cliente'];
                            $fechaCita = $data['fecha'];
                    
                        }

                       
                    


                        $consultaMysql = "SELECT * FROM usuarios cl JOIN perfil_usuario pf ON cl.id = pf.id_usuario WHERE cl.id = $id_paciente";
                        $result= $conexion->query($consultaMysql);

                        while($datos=$result->fetch_object()){ 

                            // $nombrePaciente = $datos->nombre;
                            $fechaNacimiento = $datos->fecha_nacimiento;
                            $sexo = $datos->genero;
                            $alergias = $datos->alergias;
                            $ocupacion = $datos->ocupacion;
                            $educacion = $datos->nivel_educacion;
                            ?>

                        <div class="cajaTexto">
                            <label>Nombre: </label>
                            <span class="campoDeInformacion"> <?php echo $datos->nombre ?></span><br>
                        </div>
                        <div class="cajaTexto">
                            <label>Apellido: </label>
                            <span class="campoDeInformacion"> <?php echo $datos->apellido ?></span><br>
                        </div>
                        <div class="cajaTexto">
                            <label>Correo Electronico: </label>
                            <span class="campoDeInformacion"> <?php echo $datos->correo ?></span><br>
                        </div>
                        <div class="cajaTexto">
                            <label>Telefono: </label>
                            <span class="campoDeInformacion"> <?php echo $datos->telefono ?></span><br>
                        </div>
                        <div class="cajaTexto">
                            <label>Direccion: </label>
                            <span class="campoDeInformacion"> <?php echo $datos->direccion ?></span><br>
                        </div>
                        
                            <?php
                        }
                    }else{
                        echo "No se tiene la informacion necesaria para procesar el diagnostico";
                    }

                ?>

                <?php 

                if(isset($_POST['getCita'])){

                    ?>
                        <div class="cajaTexto">
                            <label>Fecha Nacimiento:</label>
                            <span class="campoDeInformacion"> <?php echo $fechaNacimiento ?></span><br>
                        </div>
                        <div class="cajaTexto">
                            <label>Sexo:</label>
                            <span class="campoDeInformacion"> <?php echo $sexo ?></span><br>
                        </div>
                        <div class="cajaTexto">
                            <label>alergias:</label>
                            <span class="campoDeInformacion"> <?php echo $alergias ?></span><br>
                        </div>
                        <div class="cajaTexto">
                            <label>Ocupacion:</label>
                            <span class="campoDeInformacion"> <?php echo $ocupacion ?></span><br>
                        </div>
                        <div class="cajaTexto">
                            <label>Nivel de Estudio:</label>
                            <span class="campoDeInformacion"> <?php echo $educacion ?></span><br>
                        </div>
                <?php    
                }else{
                    echo "No se tiene la informacion necesaria para procesar el diagnostico";
                }   
                ?>

            </div>

            
            <div class="informacionDePaciente" id='ultimasCitas'>

                <h3 class='tituloInterno'>Ultimas Citas Medicas</h3>


            <?php 
                include "conex_bd.php";

                if(isset($_POST['getCita'])){
            
                    $consultaHistorial = "SELECT hm.*, c.id_cita, c.id_medico, c.id_cliente, c.fecha, c.especialidad, cl_paciente.nombre AS nombre_paciente, cl_medico.nombre AS nombre_medico, e.nombre_esp FROM historial_medico hm JOIN citas c ON hm.id_cita = c.id_cita JOIN usuarios cl_paciente ON c.id_cliente = cl_paciente.id JOIN usuarios cl_medico ON c.id_medico = cl_medico.id JOIN especialidades e ON e.id_especialidad = c.especialidad WHERE c.id_cliente = $id_paciente ORDER BY c.fecha DESC LIMIT 5";
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
    
                    <div class='iten_citas'>
                        <div class='seccion' id='especialidad'> <div class='headCitas' id='headEspecialidad'><h3>Especialidad</h3></div> <span> <?php echo $nombre_esp ?> </span></div>
                        <div class='seccion' id='nombreMedico'> <div class='headCitas'><h3>Medico</h3></div> <span> <?php echo $doctorRes ?> </span></div>
                        <div class='seccion' id='fechaDeCIta'> <div class='headCitas'><h3>Fecha</h3></div> <span><?php echo $fecha ?> </span></div>
                        <div class='seccion' id='horaCita'> <div class='headCitas'><h3>Id de Cita</h3></div> <span><?php echo $id_citaHistorial   ?></span></div>
                        <div class='seccion' id='estadoCita'> <div class='headCitas' id='headEstado'><h3>Detalles</h3></div> 

                            <form  action='Crud_Admin/resultadoFinalCitas.php' id="form_editar_<?php echo $id_citaHistorial; ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idHistorialCita" value="<?php echo $id_citaHistorial; ?>">
                                    <button type="button" class="detallesCita" onclick="enviarFormulario(<?php echo $id_citaHistorial; ?>)">ver detalles</button>
                            </form>
                    
                        </div>
                    </div>
                    
                    <?php
                    }
                }else{
                    echo "No se tiene la informacion necesaria para procesar el diagnostico";
                }    
            
            ?>


                
            </div>

        </div>

        <div class="formResultadoCita">

            <div class="cabezearaDiagnostico">

                <div class="diagnosticoPaciente">

                    <?php 
                    include "conex_bd.php";

                    if(isset($_POST['getCita'])){

                        $citasSql = "SELECT c.id_medico, c.id_cita, c1.nombre AS nombre_paciente, c1.apellido AS apellido_paciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.nombre_esp WHERE c.id_cita = $idCita";
                        $result = mysqli_query($conexion, $citasSql);

                        while($datos=$result->fetch_object()){ 
                                
                        $nombreDePaciente = $datos->nombre_paciente;
                        $apellidoPaciente = $datos->apellido_paciente;
                        $nobreDeMedico = $datos->nombre_medico;
                        $fechaDelaCita = $datos->fecha;


                        }
                        
                        ?>
                        <div class="cajaTexto">
                            <label>Paciente:</label>
                            <span class="campoDeInformacion"> <?php echo $nombreDePaciente.' '.$apellidoPaciente ?></span><br>
                        </div>

                        <div class="cajaTexto">
                            <label>Medico:</label>
                            <span class="campoDeInformacion"> <?php echo $nobreDeMedico ?></span><br>
                        </div>
                        <?php
                    }else{
                        echo "No se tiene la informacion necesaria para procesar el diagnostico";
                    }

                    ?>
                </div>
                <div class="diagnosticofechaCita">

                    <?php
                        if(isset($_POST['getCita'])){

                    ?>

                        <div class="cajaTexto">
                            <label>Fecha:</label>
                            <span class="campoDeInformacion"> <?php echo $fechaDelaCita ?></span><br>
                        </div>

                        <div class="cajaTexto">
                            <label>id de Cita:</label>
                            <span class="campoDeInformacion"> <?php echo $idCita ?></span><br>
                        </div>

                    <?php
                    }else{
                        echo "No se tiene la informacion necesaria para procesar el diagnostico";  
                    }
                    ?>
                </div>

            </div>
            <?php
                    if(isset($_POST['getCita'])){ 

                    ?>

                <form action="Crud_Admin/resultadoFinalCitas.php" id="formDianostico" method="POST">

                    <div class='compartimentoForm'>

                        <input type="hidden" name="idDeCita" value="<?php echo $idCita ?>">

                        <div class='boxTextResult'>
                            <label for="diagnostico">Diagnostico</label>
                            <textarea name="diagnosticoCita" id="diagnostico" placeholder="escribe aqui el Diagnostico" required></textarea><br>
                        </div>
                        <div class='boxTextResult'>
                            <label for="tratamiento">Tratamiento</label>
                            <textarea name="tratamientoCita" id="tratamiento" placeholder="escribe aqui el Tratamiento" required></textarea><br>
                        </div>

                    </div>

                        <div class='compartimentoForm'>
                            <div class='boxTextResult'>
                                <label for="prescripciones">Prescripcion</label>
                                <textarea name="prescripcionCita" id="prescripciones"  placeholder="escribe aqui las prescripciones" required></textarea><br>
                            </div>
                            <div class='boxTextResult'>
                                <label for="examenesCita" >Examenes Realizados</label>
                                <input type="text" name="examenesCita" id='examenesCita'  placeholder="Examenes realizados" required><br>
                            </div>

                        <input type="submit" class='detallesCita' id="btnDiagnostico" name="registrarResultados" value="Guardar Resultado">
                    </div>
                </form>
            <?php
            }else{
                echo "No se tiene la informacion necesaria para procesar el diagnostico";  
            }
            ?>

        </div>

        <dialog id="modalDetallesHistorial">

            <div class ="cabezeraFactura">

                <h2>Datos Paciente</h2>

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

                            <ul class='resultadoCts'>
                                <li><h3>Diagnostico:</h3> <samp class='resulCts' id='DiagnosticoCita'></samp></li>
                                <li><h3>Tratamiento:</h3> <samp class='resulCts' id='tratamientoCita'></samp></li>
                                <li><h3>Prescripciones:</h3> <samp class='resulCts' id='prescripcionesCita'></samp></li>
                                <li><h3>Examanes :</h3> <samp class='resulCts' id='examenesCita'></samp></li>
                            </ul>
                    </div>
                
            </div>

        </dialog>

        </main>

        <dialog id="dialogSeguimiento">
                    <form method="dialog">
                        <button class="ModalClose"> X</button>
                    </form>
                <h2>Programar Cita de Seguimiento</h2>

            <form action="Crud_Admin/registrarCitaSeguimiento.php" method="POST">

                <label for="nombre">Cedula Paciente</label>
                <input type="text" name="id_paciente" value="<?php echo $id_paciente; ?>" require>
                <input type="hidden" name="id_medico" value="<?php echo $idMedico; ?>">
                <input type="hidden" name="id_especialidad" value="<?php echo $esp; ?>">

                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" required>

                <label for="hora">Hora:</label>
                <input type="time" name="horaSelecion" required>

                <button id="btnSeguimito" name = "confirmarCita" type="submit">Confirmar Cita</button>
            </form>
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

                            document.getElementById('nombrePac').innerHTML = data.nombre;
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

            // window.onload = function verificarCita() {

            //     var contenidoIdCita = document.getElementById('idcitaEnElHistorial').innerText;

            //     console.log(contenidoIdCita);

            //     const data = new FormData();
            //     data.append('id_cita', contenidoIdCita); // El id de la cita que se desea verificar

            //     // Hacer la solicitud POST usando fetch
            //     fetch('Crud_Admin/resultadoFinalCitas.php', {
            //         method: 'POST',
            //         body: data
            //     })
            //     .then(response => response.json()) // Parsear la respuesta como JSON
            //     .then(data => {
            //         // Manejar la respuesta del servidor
            //         if (data.success) {
            //             console.log('Éxito:', data.message);
            //             document.getElementById("btnDiagnostico").disabled = false; 
            //             // Aquí puedes habilitar o deshabilitar elementos del DOM según la respuesta
            //         } else {

            //             document.getElementById("btnDiagnostico").disabled = true;
            //             console.log('Error:', data.message);
            //             // Aquí puedes manejar el caso de error, como mostrar un mensaje al usuario
            //         }
            //     })
            //     .catch(error => {
            //         console.error('Error en la solicitud:', error);
            //         alert('Hubo un problema al verificar la cita.');
            //     });
            // }


            //    document.getElementById("btnDiagnostico").addEventListener("click", function(event) {
            //        event.preventDefault(); // Evita que el formulario se envíe inmediatamente

            //        let confirmacion = confirm("¿Desea programar una cita de seguimiento?");
        
            //        if (confirmacion) {
            //            document.getElementById("dialogSeguimiento").showModal();
            //        } else {
            //            document.getElementById("formDianostico").submit(); // Guarda solo el historial si no hay cita de seguimiento
            //        }
            //    });

            document.getElementById("btnDiagnostico").addEventListener("click", function(event) {
                event.preventDefault(); // Evita que el formulario se envíe inmediatamente

                let confirmacion = confirm("¿Desea programar una cita de seguimiento?");

                if (confirmacion) {
                    // Si el usuario quiere una cita de seguimiento, mostramos el modal
                    document.getElementById("dialogSeguimiento").showModal();
                } else {

                    const formulario = document.getElementById("formDianostico")
                    // Validar que los campos requeridos estén completos antes de enviar
                    if (formulario.checkValidity()) {
                        formulario.submit(); // Todo está bien, enviar
                    } else {
                        // Dispara los mensajes de validación nativos del navegador
                        formulario.reportValidity();
                    }
                }
            });

// Opcional: Si deseas manejar el cierre del modal y enviar el formulario después de decidir, puedes agregar otro evento para el modal

        document.getElementById("dialogSeguimientoCloseButton").addEventListener("click", function(event) {
            // Aquí puedes manejar el flujo posterior al cierre del modal, si es necesario
            document.getElementById("formDianostico").submit(); // Envía el formulario de historial si el modal se cierra
        });


        </script>

</body>
</html>