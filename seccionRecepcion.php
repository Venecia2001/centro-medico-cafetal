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
                <a href="seccionRecepcion.php">Emergencias Medicas</a>
            </li>

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="registrosDeEmergencias.php">Registros de Emergencias</a>
            </li>

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="registrosHospitalizacion.php">Hospitalizacion</a>
            </li>

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="gestionMedicamentos.php">Gestion Medicamentos</a>
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
        <h2>Gestion de Emergencias Medicas</h2>
        <div class="cuadroGrande">

            <div class="divDeBusqueda">
                <div class='clasecabezera'>
                    <h2>Buscar Paciente</h2>

                </div>
               
                <form action="manejo_emergencia/verificarPaciente" method="POST" id="searchFormPaciente">
                    <input type="text" name="search" placeholder="Escribe aquí, busca por nombre apellido o cedula" id="search" required>
                    <input type="submit" name="buscar" class='btnRegistro_busq' value="Buscar"> 
                </form>

                <div id='cajaDeTexto'> <span id='mensajeVerificarPaciente' > </span> </div>


                <div id='divPacienteTemp'>
                    <label for="rt">Registro Temporal</label>
                    <button class='btnRegistro_busq' id="btnRegistroNew">Paciente Temporal</button>
                </div> 
                
            </div> 

            <div class="cuadroRegistroTemoral">

                <div class='espacioInt camasDisponibles'>
                    <div class="clasecabezera">
                        <h2>Camas Disponibles</h2>
                    </div>

                    <div class='bodyDisponibilidad'>

                        <table id='datosHospitalizacion'>
                            <thead>
                                <th>Tipo de Habitacion</th>
                                <th>Camas Ocupadas</th>
                                <th>Camas totales</th>
                            </thead>
                            <tbody>
                                <?php

                                    include "conex_bd.php";

                                    $consulta = "SELECT th.tipo_habitacion, th.limite_camas, COUNT(hosp.tipo_habitacion) AS camas_ocupadas FROM tipos_habitacion th LEFT JOIN hospitalizacion hosp ON hosp.tipo_habitacion = th.tipo_habitacion AND hosp.estado = 'En curso' GROUP BY th.tipo_habitacion, th.limite_camas; ";
                                    $resultado = mysqli_query($conexion,$consulta);

                                    while($datos=$resultado->fetch_object()){ ?>

                                        <tr>
                                            <td> <?php echo $datos->tipo_habitacion ?> </td>
                                            <td> <?php echo $datos->camas_ocupadas ?> </td>
                                            <td> <?php echo $datos->limite_camas ?> </td>
                                        </tr>


                                        <?php
                                    }
                                ?>
                            </tbody>

                        </table>

                    </div>

                    
                </div>

                <div class='espacioInt newEmergencia'>
                    <div class="clasecabezera">
                        <h2>Nueva Emergencias</h2>
                    </div>

                    <div class='cajaBoton'>

                        <button id="btnEmergencia">Agregar Emergencia</button>

                    </div>

                    
                </div>

            </div>
           
        </div>
        <div class='divBusquedaYfitros'>

        <div class='divBusqueda'>
            <form action="Crud_Admin/barraBusqueda.php" method="POST" id="searchFormEmergencia">
                <input type="text" name="search" placeholder="Escribe aquí, busca por nombre apellido o cedula" id="searchEmerg" required>
                <input type="submit" name="buscar" class='btnBuscarEmergencia' id='btnBuscarEmerg' value="Buscar">
            </form>
        </div>

        <div class='divFiltro'>
        <div class="filtroCitas">
                <?php
                    $current_date = date('Y-m-d'); // Fecha actual
                    $one_week_before = date('Y-m-d', strtotime('-1 week')); // Fecha una semana atrás
                    $one_month_before = date('Y-m-d', strtotime('-1 month')); // Fecha un mes atrás
                ?>
                <form action="" method="POST" id="formulario_filtro">
                    <select name="filtro" id="seleccionarEmergencias">
                        <option value="">Seleccione Fecha</option>
                        <option value="filtroPorDia_<?php echo $current_date ?>">Emergencias del día</option>
                        <option value="filtroSemanaAtras_<?php echo $one_week_before . '_' . $current_date ?>">Emergencias de la semana pasada</option> <!-- Semana pasada -->
                        <option value="filtroMesAtras_<?php echo $one_month_before . '_' . $current_date ?>">Emergencias del mes pasado</option> <!-- Mes pasado -->
                        <option value="totalEmergencia">Todas las Emergencias</option>
                    </select>
                </form>
            </div>
        </div>


        </div>

        <div class="cuadroConDiv">

                

            <div class="cuadroEmergencias">

                <div class="reportesEmergencias" id='contenedorReportes'>
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
                            <div class='headReporte'> <h2>Emergencia Medica: <?php echo $id_emergencia ?></h2>  </div>
                            <div class='bodyReporte'>
                            
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
                                            echo '<a href="registrosHospitalizacion.php?id=' . $id_emergencia . '" class="btnEnlace"> Detalles de Hospitalización </a>';
                                        }

                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                
                    }
                }
                ?>
                
            </div>
        </div>


        <dialog class="DialogDeEmergencias">

            <div class="headerModel"> 
                <h2>Registrar Emergencia</h2>
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>
            </div>

            <div id="RegistroUsuario">
            <form action="manejo_emergencia/registrosDatos.php"   method="POST">
                <label for="cedulaPaciente">Cedula Paciente(registrado)</label>
                <input id ="idPaciente" type="number" placeholder="Cedula Paciente Registrado" class="idPaciente" name="idPaciente">

                <label for="nombre">Cedula Paciente(No registrado)</label>
                <input id ="idPacienteTemp" type="number" placeholder="Cedula Paciente Temporal"  name="idPacienteTemp">

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

                            <label for="Telefono">Contacto de Emergencia </label>
                            <input id="telefono" type="text" placeholder="Telefono" name="newTelefono" value="">

                            <label for="direccion">Direccion</label>
                            <input id="direccion" type="text" placeholder="direccion" name="newdireccion" value="" >

                            <button type="submit" class="botonesLogin" id="botonRegistrarse" name="newPacienteTemp">Guardar</button>
                        </form>

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
        const mensajeVerificacion = document.getElementById('mensajeVerificarPaciente');
        const divPacienteTemp = document.getElementById('divPacienteTemp');
        var barraBusqueda = document.getElementById('search');

        document.getElementById('searchFormPaciente').addEventListener('submit', function(event) {
            event.preventDefault(); 

                var palabraClave = barraBusqueda.value;

                console.log(palabraClave)

                // Si se seleccionó una especialidad
                // Usar fetch para hacer la solicitud
                fetch('manejo_emergencia/verificarPaciente.php?palabra_id=' + palabraClave )
                .then(response => response.json())  // Procesamos la respuesta como JSON
                .then(data => {
                    // Limpiamos el select de médicos
                    
                    // Si hay médicos, los agregamos al select
                    if (data.success) {
                        // Crear un primer option para "Seleccionar un médico"
                        console.log(data);

                        mensajeVerificacion.innerHTML = data.message

                    
                        // Iterar sobre los resultados y agregar filas a la tabla
                        // data.data.forEach(medico => {
                        //     // Crear una fila de la tabla
                        //     console.log(data)
                        // });
                  
                    } else {
                        mensajeVerificacion.innerHTML = "El paciente no se cuentra rgistrado, debe registrarlo temporalmente en la plataforma para asocialo a una nueva emergencia.";

                        divPacienteTemp.style.display = 'block';
                        
                    }
                })
                .catch(error => {
                    console.error("Error al cargar los pacientes:", error);
                });
        });

        document.getElementById('searchFormEmergencia').addEventListener('submit', function(event) {
            event.preventDefault();

            let barraBusqueda = document.getElementById('searchEmerg');
            let contenedorTarjetas = document.getElementById('contenedorReportes');

            // barraBusqueda.innerHtml = inputFiltrar.value

            var palabraClave = barraBusqueda.value;
            console.log(palabraClave)

            // Si se seleccionó una especialidad
            // Usar fetch para hacer la solicitud
            fetch('manejo_emergencia/busquedasEmergencias.php?palabra_id='+ palabraClave)
                .then(response => response.json())  // Procesamos la respuesta como JSON
                .then(data => {
                        // Limpiamos el select de médicos
                        contenedorTarjetas.innerHTML = '';

                        // Si hay médicos, los agregamos al select
                        if (data.success) {
                            // Crear un primer option para "Seleccionar un médico"
                            console.log(data);

                        
                            data.data.forEach(emerg => {
                                // Crear una fila de la tabla

                                contenedorTarjetas.innerHTML += `
                                <div class="reporteEmerg">
                                    <div class='headReporte'> <h2>Emergencia Medica: ${emerg.id_emergencia}</h2>  </div>
                                    <div class='bodyReporte'>
                            
                                        <h3>Paciente: ${emerg.id_cedula ? emerg.id_cedula : ''} 
                                            ${emerg.id_PacienteTemp ? emerg.id_PacienteTemp : ''} 
                                        </h3>
                                        <h3>tipo de emergencia: ${emerg.tipo_emerg}</h3>
                                        <h3>fecha: ${emerg.fecha}</h3>
                                        <h3>Gravedad: ${emerg.gravedad}</h3>
                                        <h3>Estado de emergencia: ${emerg.estado_emergencia}</h3>

                                        <div class="cajaDeBotones">

                                            <a href="registrosDeEmergencias.php?id=${emerg.id_emergencia}" class="btnEnlace"> Detalles de Emergencia </a><br><br>

                                        </div>
                                    </div>
                                </div>
                                    `;


                                    fetch(`manejo_emergencia/verificacionHospitalizacion.php?id_emergencia=${emerg.id_emergencia}`)
                                    .then(response => response.json())  // Parseamos la respuesta como JSON
                                    .then(data => {
                                        if (data.success) {
                                            // Si hay hospitalización, agregamos el enlace de "Detalles de Hospitalización" dinámicamente
                                            const contenedor = document.querySelectorAll('.reporteEmerg .bodyReporte .cajaDeBotones')[contenedorTarjetas.children.length - 1];

                                            // Crear el enlace
                                            const enlace = document.createElement('a');
                                            enlace.href = `registrosHospitalizacion.php?id=${emerg.id_emergencia}`;
                                            enlace.classList.add('btnEnlace');
                                            enlace.textContent = 'Detalles de Hospitalización';

                                            // Agregar el enlace al contenedor correspondiente
                                            contenedor.appendChild(enlace);
                                        } else {
                                            console.log('No hay registros de hospitalización');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error al hacer la solicitud:', error);
                                    });
                            });
                        
                        } else {
                            // cuerpoTabla.innerHTML = "<tr><td colspan='6'>No se encontraron datos relacionados.</td></tr>";
                        }
                    })
                    .catch(error => {
                        console.error("Error al cargar los médicos:", error);
                    });
        });



        document.getElementById('seleccionarEmergencias').addEventListener('change', function() {
            const filtro = this.value;

            console.log(filtro)
        
            // Si no hay valor seleccionado, no hacer nada
            if (!filtro) return;

            if(filtro === "totalEmergencia"){
                location.reload();            
            }

            let contenedorTarjetas = document.getElementById('contenedorReportes');

            // Crear los datos a enviar
            const formData = new FormData();
            formData.append('filtro', filtro);

            // Enviar los datos al servidor usando fetch
                fetch('manejo_emergencia/filtroEmergencias.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    // Verificar si la respuesta es exitosa (código de estado 200)
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json(); // Parsear la respuesta como JSON
                })
                .then(data => {


                    if (data.success) {

                        contenedorTarjetas.innerHTML = '';
                        console.log(data.data)

                        if (data.data && data.data.length > 0) {
                                data.data.forEach(emerg => {
                                    // Crear una fila de la tabla

                                    contenedorTarjetas.innerHTML += `
                                    <div class="reporteEmerg">
                                        <div class='headReporte'> <h2>Emergencia Medica: ${emerg.id_emergencia}</h2>  </div>
                                        <div class='bodyReporte'>
                                
                                            <h3>Paciente: ${emerg.id_cedula ? emerg.id_cedula : ''} 
                                                ${emerg.id_PacienteTemp ? emerg.id_PacienteTemp : ''} 
                                            </h3>
                                            <h3>tipo de emergencia: ${emerg.tipo_emerg}</h3>
                                            <h3>fecha: ${emerg.fecha}</h3>
                                            <h3>Gravedad: ${emerg.gravedad}</h3>
                                            <h3>Estado de emergencia: ${emerg.estado_emergencia}</h3>

                                            <div class="cajaDeBotones">

                                                <a href="registrosDeEmergencias.php?id=${emerg.id_emergencia}" class="btnEnlace"> Detalles de Emergencia </a><br><br>

                                            </div>
                                        </div>
                                    </div>
                                        `;


                                    fetch(`manejo_emergencia/verificacionHospitalizacion.php?id_emergencia=${emerg.id_emergencia}`)
                                    .then(response => response.json())  // Parseamos la respuesta como JSON
                                    .then(data => {
                                        if (data.success) {
                                            // Si hay hospitalización, agregamos el enlace de "Detalles de Hospitalización" dinámicamente
                                            const contenedor = document.querySelectorAll('.reporteEmerg .bodyReporte .cajaDeBotones')[contenedorTarjetas.children.length - 1];

                                            // Crear el enlace
                                            const enlace = document.createElement('a');
                                            enlace.href = `registrosHospitalizacion.php?id=${emerg.id_emergencia}`;
                                            enlace.classList.add('btnEnlace');
                                            enlace.textContent = 'Detalles de Hospitalización';

                                            // Agregar el enlace al contenedor correspondiente
                                            contenedor.appendChild(enlace);
                                        } else {
                                            console.log('No hay registros de hospitalización');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error al hacer la solicitud:', error);
                                    });
                                });
                            } else {
                                // Si no hay datos o está vacío
                                contenedorTarjetas.innerHTML = "No existen registros en este lapso de tiempo";
                            }
                        // Aquí puedes manejar los datos como lo desees
                    } else {
                        // cuerpoTabla.innerHTML = "<tr><td colspan='12'>No se encontraron datos relacionados.</td></tr>";
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });
        });




    </script>

</body>
</html>