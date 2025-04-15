<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stilosRecepcion.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

    <aside class="sidebar">
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
                <span class="material-symbols-outlined">notifications</span>
                <a href="inicioAdmin.php">Inicio</a>
            </li>
            
            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="seccionRecepcion.php">Emergencias Medicas</a>
            </li>

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="registrosDeEmergencias.php">Registros de Emergencias</a>
            </li>

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="seccionFacturacion.php">Facturacion</a>
            </li>

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="seccionFacturasCitas.php">Facturacion Citas</a>
            </li>

        
            </ul>

            </nav>

            <div class="sidebar__profile">
                <ul>
                    <li class ="item__profile">
                        <img src="imagenes/Modelo.jpg" alt="doctor" width="120px">
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
        <div class="cuadroGrande">
            <div class="divDeBusqueda">
                <label for="">Buscar Paciente</label>
                <input type="text">
            </div>

            <div class="cuadroRegistroTemoral">
                <h2>Registro</h2>
                <button id="btnRegistroNew"> + Agregar Nuevo Paciente</button>
            </div>
           
        </div>

        <div class="cuadroConDiv">

                <div class="cabezeraNewEmergencia">
                    <h2>Reportes de Emergencias</h2>

                    <button id="btnEmergencia"> + Agregar Emergencia</button>
                </div>

            <div class="cuadroEmergencias">

                <div class="reportesEmergencias">
                    <?php 
                    
                    include("conex_bd.php");

                    $consultaSql ="SELECT * FROM emergencias_medicas";
                    $resultConsulta = mysqli_query($conexion, $consultaSql);

                    if($resultConsulta){

                        while($datos=$resultConsulta->fetch_array()){
                            $id_emergencia= $datos["id_emergencia"];
                            $id_cedula= $datos["id_paciente"];
                            $id_PacienteTemp= $datos["id_paciente_temp"];
                            $tipo_emerg = $datos["tipo_emergencia"];
                            $descripcion = $datos["descripcion"];
                            $fecha_emerg = $datos["fecha_emergencia"];
                            $gravedad = $datos["gravedad"];
                            $diagnostico = $datos["diagnostico"];
                            $estado_emergencia = $datos["estado_emergencia"]; 

                        ?>
                        <div class="reporteEmerg">
                            <h2>Emergencia Medica: <?php echo $id_emergencia ?></h2>
                            <h3>Paciente: <?php echo $id_PacienteTemp." ".$id_cedula ?> </h3>
                            <h3>tipo de emergencia: <?php echo  $tipo_emerg ?></h3>
                            <h3>fecha:  <?php echo $fecha_emerg ?></h3>
                            <h3>Gravedad:  <?php echo $gravedad ?></h3>
                            <h3>Estado de emergencia: <?php echo $estado_emergencia ?></h3>

                            <!-- <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detalles_<?php echo $id_emergencia; ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idEmergenciaMedica" value="<?php echo $id_emergencia; ?>">
                                    <button type="button" class="detallesEmergencia" onclick="enviarFormulario(<?php echo $id_emergencia; ?>)">Ver detalles</button>
                            </form> -->

                            <div class="cajaDeBotones">

                                <a href="registrosDeEmergencias.php?id=<?php echo $id_emergencia; ?>" class="btnEnlace"> Detalles de Emergencia </a><br><br>

                                <?php

                                    $ConsultaSiHospitalizacion = "SELECT COUNT(*) as total FROM hospitalizacion WHERE emergencia_medica_id = $id_emergencia";
                                    $resultadoHosp = mysqli_query($conexion, $ConsultaSiHospitalizacion);

                                    $fila = $resultadoHosp->fetch_assoc();

                                    if ($fila['total'] > 0) {
                                        // Si hay registros, mostrar el enlace
                                        echo '<a href="registrosHospitalizacion.php?id=' . $id_emergencia . '" class="btnEnlace"> Datos de Hospitalización </a>';
                                    }

                                ?>
                            </div>
                    </div>
                    <?php
                
                    }
                }
                ?>
                <!-- <div class="reporteEmerg">
                    <h2>Emergencia Medica</h2>
                    <h3>paciente:</h3>
                    <h3>tipo de emergencia:</h3>
                    <h3>fecha</h3>
                    <h3>Estado de emergencia: En Proceso</h3>

                    <button class="btnEnlace"> Detalles</button>
                </div>

                <div class="reporteEmerg">
                    <h2>Emergencia Medica</h2>
                    <h3>paciente:</h3>
                    <h3>tipo de emergencia:</h3>
                    <h3>fecha</h3>
                    <h3>Estado de emergencia: En Proceso</h3>

                    <button class="btnEnlace">Detalles</button>
                </div>

                <div class="reporteEmerg">
                    <h2>Emergencia Medica</h2>
                    <h3>paciente:</h3>
                    <h3>tipo de emergencia:</h3>
                    <h3>fecha</h3>
                    <h3>Estado de emergencia: En Proceso</h3>

                    <button class="btnEnlace">Detalles</button>
                </div> -->
                </div> 

                <!-- <div class="reporteEmerg">
                    <h2>Emergencia Medica</h2>
                    <h3>paciente:</h3>
                    <h3>tipo de emergencia:</h3>
                    <h3>fecha</h3>
                    <h3>Estado de emergencia: En Proceso</h3>

                    <button>Crear Atención Médica</button>
                </div> -->
            </div>
        </div>


        <dialog class="DialogDeEmergencias">

            <div class="headerModel"> 
                <h2>Bienvenido!</h2>
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>
            </div>

            <div id="RegistroUsuario">

            <h2>Registrarse</h2>
            <form action="manejo_emergencia/registrosDatos.php"   method="POST">
                <label for="cedulaPaciente">Cedula Paciente(registrado)</label>
                <input id ="idPaciente" type="number" placeholder="Nombre" class="idPaciente" name="idPaciente">

                <label for="nombre">Cedula Paciente(No registrado)</label>
                <input id ="idPacienteTemp" type="number" placeholder="id de paciente"  name="idPacienteTemp">

                <label for="medicoResponsable">Medico Responsable</label>
                <select name="medicoResponsable" id="selectMedicoEmergencia">
                    <option value="">Seleciona Medico</option>
                    <?php 

                    
                    include("conex_bd.php");
                    
                    $consultaMedicosEmerg = "SELECT * FROM usuarios WHERE rol = 5";
                    $resultMeicosEmergencias = mysqli_query($conexion, $consultaMedicosEmerg);

                    if($resultMeicosEmergencias){
                    
                        while($datos=$resultMeicosEmergencias->fetch_array()){
                            $id_medicoEmerg= $datos["id"];
                            $nombreMedico= $datos["nombre"];
                            $apellidoMedico= $datos["apellido"];
                        ?>
                        <option value="<?php echo $id_medicoEmerg?>"> <?php echo $nombreMedico." ".$apellidoMedico ?> </option>
                         
                         <?php   
                        }
                    }
                    ?>

                </select><br>

                <label for="enfermeros">Enfermeros</label>
                <select name="EnfermeroResponsable" id="selectEnfermeroEmergencia">
                    <option value="">Seleciona Enfermero</option>
                    <?php 

                    $consultaEnfermeros = "SELECT * FROM personal_salud WHERE rol_personal = 'enfermero'";
                    $resulEfermerosEmergencias = mysqli_query($conexion, $consultaEnfermeros);

                    if($resulEfermerosEmergencias){
                    
                        while($datos=$resulEfermerosEmergencias->fetch_array()){
                            $id_EnfermeroEmerg= $datos["cedula_personal_salud"];
                            $nombreEnfermero= $datos["nombre"];
                            $apellidoEnfermero= $datos["apellido"];
                        ?>
                        <option value="<?php echo $id_EnfermeroEmerg?>"> <?php echo $nombreEnfermero." ".$apellidoEnfermero ?> </option>
                         
                         <?php   
                        }
                    }
                    ?>

                </select><br>


                <label for="tipoEmergencia">Tipo de Emergencia</label>
                <input id="tipoEmergencia" type="text" placeholder="tipo de Emergencia" name="tipoEmerg">

                <label for="tipoEmergencia">Descripcion de Emergencia</label>
                <input id="Descripcion" type="text" placeholder="Descripcion de Emergencia"  name="DescripcionEmerg">

                <label for="fecha">Fecha de Emergencia</label>
                <input id="fecha" type="datetime-local" placeholder="Telefono" name="fecha_emerg">

                <label for="gravedad">Gravedad</label>
                <select name="gravedadEmergencia" id="gravedad">
                    <option value="leve">Leve</option>
                    <option value="moderada">Moderada</option>
                    <option value="grave">Grave</option>
                </select>

                <label for="diagnostico">Diagnostico</label>
                <input id="diagnostico" type="text" placeholder="diagnostico" name="diagnostico_emerg">

                <label for="estatus">Estado de Emergencia</label>
                <select name="estadoEmerg" id="estatus">
                    <option value="En proceso">En proceso</option>
                    <option value="Resuelta">Resuelta</option>
                </select>

                <button type="submit" class="botonesLogin" id="btnRegistrarEmergencia" name="registrarEmergencia" >Registrar Emergencia</button>
            </form>

            <span class="resultado"> todos los campos son requedidos</span>

            </div>

        </dialog>

        <dialog class="DialogNewRegistros" >

            <div class="headerModel"> 
                <h2>Registro Nuevo Paciente</h2>
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>
            </div>

                <div id="RegistroUsuarioNew">

                    <h2>Ingresar Medico</h2>
                        <form action="manejo_emergencia/registrosDatos.php"  method="post">

                            <label for="nombre">Cedula</label>
                            <input id ="cedula" type="text" placeholder="cedula de Identidad" class="nombreClase"  name="CedulaI" value="">

                            <label for="nombre">Nombre</label>
                            <input id ="nombre" type="text" placeholder="Nombre" class="nombreClase"  name="newNombre" value="">

                            <label for="Apellido">Apellido</label>
                            <input id="apellido" type="text" placeholder="Apellido" class="apellido" name="newApellido" value="">

                            <label for="Edad">Edad</label>
                            <input id="Edad" type="number" placeholder="Edad " name="edad" value="" >

                            <label for="Telefono">contacto de emergencia </label>
                            <input id="telefono" type="text" placeholder="Telefono" name="newTelefono" value="">

                            <label for="direccion">direccion</label>
                            <input id="direccion" type="text" placeholder="direccion" name="newdireccion" value="" >

                            <button type="submit" class="botonesLogin" id="botonRegistrarse" name="newPacienteTemp">Guardar</button>
                        </form>

                    <span class="resultado"> todos los campos son requedidos</span>

                </div>

        </dialog>


        <dialog id="dialogDetallesEmerg">

            <div class="headerModel"> 
                <h2>Detalles de Emergencias Medicas</h2>
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>
            </div>

            <div class="datosEmergencias">

                <div class="seccionDatosEmerg">
                    
                    <h2>Detalles de la Emergencia</h2>


                    <p><strong>id Emergencia:</strong> <span id="idEmergencia">Cargando...</span></p>
                    <p><strong>Paciente:</strong> <span id="paciente">Cargando...</span></p>
                    <p><strong>Medico responsable:</strong> <span id="medicoResponsable">Cargando...</span></p>
                    <p><strong>Enfermero:</strong> <span id="enfermero">Cargando...</span></p>
                    <p><strong>tipo Emergencia:</strong> <span id="emergenciaTipo">Cargando...</span></p>
                    <p><strong>Descripcion</strong> <span id="descripcionMostrar">Cargando...</span></p>
                    <p><strong>Gravedad</strong> <span id="gravedadEmergencia">Cargando...</span></p>
                    <p><strong>Fecha:</strong> <span id="fechaEmergencia">Cargando...</span></p>
                    <p><strong>Diagnóstico:</strong> <span id="mostrarDiagnostico">Cargando...</span></p>
                    <p><strong>Estado de Emergencia:</strong> <span id="estadoEmerg">Cargando...</span></p>
                    
                </div>
                <div class="seccionMedicamentosAdministrados">
                    
                    <h2>Medicamentos Administrados</h2>

                    <table border="1">
                        <thead>
                            <tr>
                                <th>Medicamento</th>
                                <th>Presentación</th>
                                <th>Dosis</th>
                                <th>Observaciones</th>
                                <th>Costo Total</th>
                            </tr>
                        </thead>
                        <tbody id="tablaMedicamentos">
                            <tr><td colspan="5">Cargando datos...</td></tr>
                        </tbody>
                    </table>

                    <p id="errorMensaje" style="color:red;"></p>

                </div>


            </div>

        </dialog>

        
    </main>


    <script>

        const bottonEmergencia = document.getElementById("btnEmergencia")
        bottonEmergencia.addEventListener("click", openModal)

        const bottonNewRegistro = document.getElementById("btnRegistroNew")
        bottonNewRegistro.addEventListener("click", openModalRegistro)

        function openModal(){

            let dialogEmergencia = document.querySelector(".DialogDeEmergencias");
            dialogEmergencia.showModal();
        }

        function openModalRegistro(){

            let dialogEmergencia = document.querySelector(".DialogNewRegistros");
            dialogEmergencia.showModal();
        }

        // function enviarFormulario(id) {
                    
        //             let inputId = document.querySelector(`#form_detalles_${id} input[name='idEmergenciaMedica']`).value;

        //             console.log(inputId)

        //             // Realizamos la solicitud con fetch
        //             fetch('manejo_emergencia/detallesDeEmergencias.php', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/x-www-form-urlencoded'
        //             },
        //             body: `idEmergencia=${encodeURIComponent(inputId)}`
        //             })
        //             .then(response => response.json()) // Convertir la respuesta a JSON
        //             .then(data => {
        //                 if (!Array.isArray(data.data) || data.length === 0) {
        //                     console.error("No se encontraron datos.");
        //                     document.getElementById("errorMensaje").innerText = "No se encontraron datos.";
        //                     return;
        //                 }

        //                 console.log("Datos recibidos:", data);

        //                 // Extraer los datos de la emergencia desde el primer objeto
        //                 const emergencia = data.data[0];

        //                 console.log(emergencia);

        //                 document.getElementById("idEmergencia").innerHTML = emergencia.id_emergencia;
        //                 document.getElementById("medicoResponsable").innerHTML = emergencia.nombre_medico+" "+emergencia.apellido_medico;
        //                 document.getElementById("enfermero").innerHTML = emergencia.nombre_enfermero+" "+emergencia.apellido_enfermero;
        //                 document.getElementById("emergenciaTipo").innerHTML = emergencia.tipo_emergencia;
        //                 document.getElementById("descripcionMostrar").innerHTML = emergencia.descripcion;
        //                 document.getElementById("gravedadEmergencia").innerHTML = emergencia.gravedad;
        //                 document.getElementById("fechaEmergencia").innerText = emergencia.fecha_emergencia;
        //                 document.getElementById("mostrarDiagnostico").innerText = emergencia.diagnostico;
        //                 document.getElementById("estadoEmerg").innerText = emergencia.estado_emergencia;

        //                 // Mostrar el nombre del paciente registrado o temporal
        //                 document.getElementById("paciente").innerText = emergencia.nombre ?? emergencia.paciente_temporal;

        //                 //Limpiar la tabla antes de agregar nuevos datos
        //                 let tablaMedicamentos = document.getElementById("tablaMedicamentos");
        //                 tablaMedicamentos.innerHTML = "";

        //                 // Recorrer el array de medicamentos y agregarlos a la tabla
        //                 data.data.forEach(med => {
        //                     let fila = `
        //                         <tr>
        //                             <td>${med.nombre_medicamento}</td>
        //                             <td>${med.presentacion}</td>
        //                             <td>${med.dosis}</td>
        //                             <td>${med.observaciones}</td>
        //                             <td>$${parseFloat(med.costo_total).toFixed(2)}</td>
        //                         </tr>
        //                     `;
        //                     tablaMedicamentos.innerHTML += fila;
        //                 });

        //                 const dialog = document.getElementById("dialogDetallesEmerg");
        //                 dialog.showModal()

        //             })
        //             .catch(error => console.error("Error en la solicitud:", error));
    
        // }




    </script>

</body>
</html>