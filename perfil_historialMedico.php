<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="longinCss.css">
</head>
<body>

    <?php  include "header.php";
    
        $id_usuario = $_SESSION["id"] ;
    
    ?>

    

    <div id='ContenedorPrincipal'>
        <h2>Historial Citas </h2>
    <section class="historialMedicoSeccion">
        
    <?php 
        include "conex_bd.php";
        $id_paciente = $_SESSION["id"] ;

        $consultaHistorial = "SELECT hm.*, c.id_cita AS idDeCita, c.id_medico, c.id_cliente, c.fecha, c.especialidad, us_paciente.nombre AS nombre_paciente, us_medico.nombre AS nombre_medico, us_medico.apellido AS apellidoMed, e.nombre_esp FROM historial_medico hm JOIN citas c ON hm.id_cita = c.id_cita JOIN usuarios us_paciente ON c.id_cliente = us_paciente.id JOIN usuarios us_medico ON c.id_medico = us_medico.id JOIN especialidades e ON e.id_especialidad = c.especialidad WHERE c.id_cliente = $id_paciente;";
        $resultHistorial = mysqli_query($conexion,$consultaHistorial);

        if(mysqli_num_rows($resultHistorial) > 0) { 

            while($datos=$resultHistorial->fetch_array()){ 
                // $id = $datos["id"];
                // $nombre = $datos["nombre"];
                // $apellido = $datos["apellido"];
                // $telefono = $datos["telefono"];
                $id_cita_historial = $datos['idDeCita'];
                $fecha = $datos["fecha"];
                $diagnos = $datos["diagnostico"];
                $tratamiento = $datos["tratamiento"];
                $prescripcion = $datos["prescripcion"];      
                $examenes = $datos['examenes_realizados'];    
                $doctorRes = $datos ['nombre_medico'];
                $nombrePaciente = $datos['nombre_paciente'];
                $nombre_esp = $datos['nombre_esp'];
                $apellidoDoctor = $datos['apellidoMed'];
            ?>

            <div class="reporteCitaHistorial">
                <div class='tituloReporteHistorial'><h3>Resumen de Cita</h3></div>
                <div class="reporteInterno">

                    <h3>Especialidad: <span> <?php echo $nombre_esp ?> </span> </h3><br>
                    <h3>Doctor: <span> <?php echo $doctorRes." ".$apellidoDoctor ?> </span> </h3><br>
                    <h3>Fecha:  <span> <?php echo $fecha ?> </span> </h3><br>
        
                    <form  action='Crud_Admin/jsonDetallesCitas.php' id="form_editar_<?php echo $id_cita_historial; ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="idHistorialCita" value="<?php echo $id_cita_historial; ?>">
                        <button type="button" id='btnDetallesCita' class="detallesCita" onclick="enviarFormulario(<?php echo $id_cita_historial; ?>)">Ver detalles</button>
                    </form>
                </div>

            </div>

            <?php
            }      
        }else{ ?>

            <div class="reporteCitaHistorialElse">
                <div class="reporteInterno">

                    <h3>Nota: <span> Aún no tienes citas en tu historial </span> </h3><br>
                </div>
            </div>


        <?php
        }
        ?>

    </section>


    <div class='espacioEmergencias'>

        <div class='head_head_proximas'>

            <h3>Historial de Emergencias Medicas</h3>
        </div>

        <?php 
            
            include("conex_bd.php");

            $consultaSql = "SELECT fac.factura_id, fac.emergencia_medica_id, fac.hospitalizacion_id, em.estado_emergencia, em.id_paciente, em.id_paciente_temp, em.medico_responsable, em.fecha_emergencia, em.tipo_emergencia, us_med.nombre, us_med.apellido FROM facturas fac LEFT JOIN emergencias_medicas em ON em.id_emergencia = fac.emergencia_medica_id LEFT JOIN usuarios us_med ON em.medico_responsable = us_med.id WHERE em.id_paciente = $id_usuario";
            $resultado = mysqli_query($conexion,$consultaSql);

            if(mysqli_num_rows($resultado) > 0) { 

                while ($fila = mysqli_fetch_assoc($resultado)) { ?>

                    <div class='iten_citas'>
                        <?php $idEmergencia = $fila['emergencia_medica_id'] ?>
                        <div class='seccion' id='especialidad'> <div class='headCitas' id='headEspecialidad'><h3>Medico</h3></div> <span> <?php echo $fila['nombre']." ".$fila['apellido'] ?> </span></div>
                        <div class='seccion' id='nombreDoctor'> <div class='headCitas'><h3>Motivo</h3></div> <span> <?php echo $fila['tipo_emergencia'] ?></span></div>
                        <div class='seccion' id='fechaDeCIta'> <div class='headCitas'><h3>Fecha</h3></div> <span> <?php echo $fila['fecha_emergencia'] ?> </span></div>
                        <div class='seccion' id='horaCita'> <div class='headCitas'><h3>Hospitalizacion</h3></div> <span> <?php  echo $fila['hospitalizacion_id'] ? $fila['hospitalizacion_id'] : 'No Necesito'; ?> </span></div>
                        <div class='seccion' id='horaCita'> <div class='headCitas'><h3>Estado</h3></div> <span> <?php echo $fila['estado_emergencia'] ?> </span></div>
                        <div class='seccion' id='estadoCita'> <div class='headCitas' id='headEstado'><h3>Detalles</h3></div> <span>
                        <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detalles_<?php echo                 $idEmergencia ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idEmergenciaMedica" value="<?php echo $idEmergencia?>">
                                    <button type="button" id='detallesEmergMed' class="detallesCita" onclick="enviarFormularioD(<?php echo $idEmergencia ?>)">Ver detalles</button>
                        </form>
                        </span></div>
                    </div>

                    <?php
                }

            }else{ ?>

                    <div class='iten_citas'>
                        <div class='seccion' id='especialidadElse'> <div class='headCitas' id='headEspecialidadElse'><h3>Registros</h3></div> <span> Afortunadamente no ha estado involucrado en ninguna emergencia medica</span></div>
        
                    </div>
                <?php
            }

        ?>

    </div>

    </div>





    <dialog id="dialogDetalles">
        <div class="contenidoFactura">

            <div class="seccionesFactura" id="datosGenerales">
                <div class ="cabezeraFactura">

                    <form method="dialog">
                        <button class="ModalClose"> X</button>
                    </form>

                    <div class="logoFactura">
                        <img src="imagenes/logo-removebg-preview (1).png" class="logotipo">
                        <p class="tituloPrincipal">Clínica San Pedro</p>
                    </div>
                    
                    <h2 class="tituloReporte">Reporte de Factura</h2>
                    <h3 class="fechaF">Fecha Emision:<p id="fechaFac"></p> </h3>
                </div>
                <div class="datosPaciente">

                    <div class="nobresResponsables">

                        <h4>Compañia: <span class="datoPrincipal">Clinica San Pedro</span> </h4><br>

                        <h4>id factura: <span class="datoPrincipal" id="id_factura_cita"></span> </h4><br>

                        <h4>Paciente: <span class="datoPrincipal" id="nombrePaciente"></span> </h4><br>

                        <h4>Cedula: <span class="datoPrincipal" id="CedulaPaciente"></span> </h4><br>

                    </div>

                    <div class="segurosResponsables">

                        <h4>Medico: <span class="datoPrincipal" id="medicoResponsable" >Dr. </span> </h4><br>

                        <h4>Especialidad: <span class="datoPrincipal" id="especialidadHistorial" > </span> </h4><br>

                        <h4>Proceso: <span class="datoPrincipal" id="diagnostico_emerg" >Consulta</span> </h4><br>

                        <div class ="estadoFacYpdf">
                            <h4>Estado : <span id="estado" class="datoPrincipal"></span> </h4><br>
                        </div>

                    </div>
                </div>
                
            </div>

            
            <div class="seccionesFactura" id="resultadoDeCita">
                <h2 id='titleResultado'>Resultados</h2>
                
                <ul class='resultadoCts'>
                    <li><h3>Diagnostico:</h3> <samp class='resulCts' id='diagnosticoCita'></samp></li>
                    <li><h3>Tratamiento:</h3> <samp class='resulCts' id='tratamientoCita'></samp></li>
                    <li><h3>Prescripciones:</h3> <samp class='resulCts' id='prescripcionesCita'></samp></li>
                    <li><h3>Examanes :</h3> <samp class='resulCts' id='examenesCita'></samp></li>
                </ul>


            </div>

        </div>

    </dialog>


    <dialog id="dialogDetallesFacturas">

        <div class="contenidoFactura">

            <div class="seccionesFactura" id="datosGeneralesEmergencia">
                <div class ="cabezeraFactura">

                    <form method="dialog">
                        <button id="cerrarDialog" class="ModalClose"> X</button>
                    </form>

                    <div class="logoFactura">
                        <img src="imagenes/logo-removebg-preview (1).png" class="logotipo">
                        <p id="tituloPrincipal">Clínica San Pedro</p>
                    </div>
                    
                    <h2 class="tituloReporte">Reporte Emergencia</h2>
                    <h3 class="fechaF">Fecha Emision:<p id="fechaEmerg"></p> </h3>
                </div>
                <div class="datosPaciente">

                    <div class="nobresResponsables">

                        <h4>Compañia: <span class="datoPrincipal">Clinica San Pedro</span> </h4><br>

                        <h4>Sucursal: <span class="datoPrincipal">Biscucuy</span> </h4><br>

                        <h4>Paciente: <span class="datoPrincipal" id="nombrePacienteDetl"></span> </h4><br>

                        <h4>Cedula: <span class="datoPrincipal" id="CedulaPacienteDetl"></span> </h4><br>

                        <h4>Codigo Emergencia: <span class="datoPrincipal" id="idEmergenciaDetl"></span> </h4><br>

                        <h4>Fecha de Ingreso: <span class="datoPrincipal" id="fechaIngresoDetl"></span> </h4><br>

                    </div>

                    <div class="segurosResponsables">

                        <h4>Fecha de Alta: <span class="datoPrincipal" id="fechaDeAlta">pendiente</span> </h4><br>

                        <h4>Medico: <span class="datoPrincipal" id="medicoResponsableDetl">Dr. </span> </h4><br>

                        <h4>Proceso: <span class="datoPrincipal" id="diagnostico_emergDetl">tratamiento</span> </h4><br>

                        <h4>Cama: <span class="datoPrincipal" id="numeroCama">12A:</span> </h4><br>

                        <h4>Empresa Aseguradora : <span class="datoPrincipal">Ninguna:</span> </h4><br>

                        <div class ="estadoFacYpdf">
                            <h4>Estado : <span id="estadoFactura" class="datoPrincipal"></span> </h4><br>
                            <!-- <button id="btnPdf" style="display: none;"> Generar Pdf</button> -->
                            <form action="manejo_emergencia/generarPdf.php" method="post">
                                <input type="hidden" id="codigoEmergencia" name="factura_id" value="">
                                <button type="submit"  id="btnPdf" style="display: none;">Generar Factura PDF</button>
                            </form>
                        </div>

                        


                    </div>
                </div>
                
            </div>

            
            <div class="seccionesFactura" id="datosEmergencia_hosp">
                <h2>Consumo General</h2>
                <table class='tablaSinColor'>
                    <thead>
                        <th>Tipo</th>
                        <th>Servicios</th>
                        <th>Importe</th>
                    </thead>
                    <tbody id="cuerpoTablaEmerg">
                        <tr><th>Emergencias</th></tr>
                        <tr>
                            <td id="idServicio" >Far1054</td>
                            <td id="nombreRayosX">Medicamentos</td>
                            <td id="costo_total_med" > 80</td>
                        </tr>
                    </tbody>
                </table>
                <table class='tablaSinColor'>
                    <thead class="theadHosp">
                        <th>Tipo</th>
                        <th>Servicios</th>
                        <th>Importe</th>
                    </thead>
                    <tbody id="cuerpoTablaHosp" >
                    <tr><th>Hospitalizacion</th></tr>
                     <tr>
                            <td style = "width: 37%;">0001</td>
                            <td  style = "width: 38%;">Estancia Hospitalaria</td>
                            <td id="costo_total_dias" ></td>
                        </tr>
                        <tr>
                            <td style = "width: 30%;" >FarH105</td>
                            <td  style = "width: 30%;">Medicamentos</td>
                            <td id="costo_total_hosp" ></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total:</td>
                            <td id="sumaTotal">0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            
            <div class="seccionesFactura" id="datosDesglosadosEmergencia">
                <h2>Costos Detallados</h2>

                <table id="desgloseMedicamentos" class='tablaSinColor'>
                    <thead>
                        <th>Codigo</th>
                        <th>Medicamenrto</th>
                        <th>Presentacion</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Precio Total</th>
                    </thead>
                    <tbody id="tbodyDetalles">
                        <tr></tr>
                    </tbody>
                </table>

            </div>
            
        </div>

    </dialog>

    <dialog id="DialogMetodoPago" class="dialogRegistrosNew">

            <div class="headerModel"> 
                <h2>Registro Metodo de Pago</h2>
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>
            </div>

        <div id="RegistroUsuarioNew">

            <h2>Ingresar Servicio</h2>
                <form action="manejo_emergencia/modificarRegistro.php"  method="post">

                    <input id ="idFactura" type="hidden" name="idFactura" value="">


                    <label for="nombre">Servicio Prestado</label>
                    <select name="selectPago" id="selectPago">
                        <option value="">Seleccione Metodo de Pago</option>
                        <option value='Efectivo'>Efectivo</option>
                        <option value='Tarjeta'>Tarjeta</option>
                        <option value='Transferencia'>Transferencia</option>
                        <option value='Otro'>Otro</option>
                       
                    </select><br>

                    <button type="submit" class="botonRegistro" id="botonRegistrarMed" name="actualizarMetodoPago">Registrar Metodo Pago</button>
                </form>
        </div>

    </dialog>








    <script>
        console.log("Hola, mundo!");
                
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

                            document.getElementById('nombrePaciente').innerHTML = data.nombre +" "+data.apellidoPact;
                            document.getElementById('medicoResponsable').innerHTML = data.nombreMedico+" "+data.apellidoDoctor;
                            document.getElementById('fechaFac').innerHTML = data.fecha;
                            document.getElementById('especialidadHistorial').innerHTML = data.especialidad;
                            document.getElementById('id_factura_cita').innerHTML = data.idCedula;
                            document.getElementById('CedulaPaciente').innerHTML = data.id;
                            document.getElementById('estado').innerHTML = data.estadoCts;

                            document.getElementById('diagnosticoCita').innerHTML = data.diagnostco;
                            document.getElementById('tratamientoCita').innerHTML = data.tratamiento;
                            document.getElementById('prescripcionesCita').innerHTML = data.presecciones;
                            document.getElementById('examenesCita').innerHTML = data.examenes;

                            const dialog = document.getElementById("dialogDetalles");
                            dialog.showModal()
                            
                        }
                    })
                    .catch(error => {
                        // Si ocurre un error en cualquier parte del proceso
                        console.error('Error:', error);
                    });
    
    
    
        }


        function enviarFormularioD(id) {
                    
                    let inputId = document.querySelector(`#form_detalles_${id} input[name='idEmergenciaMedica']`).value;

                    console.log(inputId)

                    // Realizamos la solicitud con fetch
                    fetch('manejo_emergencia/detallesDeEmergencias.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `idEmergencia=${encodeURIComponent(inputId)}`
                    })
                    .then(response => response.json()) // Convertir la respuesta a JSON
                    .then(data => {
                        if (!Array.isArray(data.data) || data.length === 0) {
                            console.error("No se encontraron datos.");
                            document.getElementById("errorMensaje").innerText = "No se encontraron datos.";
                            return;
                        }

                        console.log("Datos recibidos:", data);

                        // Extraer los datos de la emergencia desde el primer objeto
                        const emergencia = data.data[0];
                        const serviciosRayos = data.tratamientos[0];
                        const medTotal = data.totalMed[0];
                        // const hospTotal = data.totalHosp[0];
                        // const hospDias = data.estanciaHosp[0];
                        const hospTotal = data.totalHosp.length > 0 ? data.totalHosp[0] : 0;
                        const hospDias = data.estanciaHosp.length > 0 ? data.estanciaHosp[0] : 0;
                        const estadoFac = data.fechaFactura[0].estado;

                        console.log(emergencia);
                        console.log(serviciosRayos);
                        console.log(data.fechaFactura[0].fecha_factura);


                        document.getElementById("fechaEmerg").innerHTML = data.fechaFactura[0].fecha_factura;
                        let estadoFactura = document.getElementById("estadoFactura").innerHTML = data.fechaFactura[0].estado;

                        document.getElementById("idEmergenciaDetl").innerHTML = emergencia.id_emergencia;
                        document.getElementById("codigoEmergencia").value = emergencia.id_emergencia;
                        document.getElementById("medicoResponsableDetl").innerHTML = emergencia.nombre_medico+" "+emergencia.apellido_medico;
                        document.getElementById("diagnostico_emergDetl").innerHTML = emergencia.diagnostico;
                        document.getElementById("numeroCama").innerHTML = emergencia.numero_cama;
                        document.getElementById("fechaIngresoDetl").innerText = emergencia.fecha_emergencia;
                        document.getElementById("fechaDeAlta").innerText = emergencia.fecha_alta || "En Proceso";
                        // document.getElementById("estadoEmerg").innerText = emergencia.estado_emergencia;

                        // Mostrar el nombre del paciente registrado o temporal
                        document.getElementById("nombrePacienteDetl").innerText = 
                        emergencia.nombre && emergencia.apellido 
                        ? emergencia.nombre + " " + emergencia.apellido 
                        : emergencia.nombre_paciente_temporal + " " + emergencia.apellido_temporal;
                        document.getElementById("CedulaPacienteDetl").innerText = emergencia.id_paciente || emergencia.id_paciente_temp;
                        // //Limpiar la tabla antes de agregar nuevos datos

                        document.getElementById("costo_total_med").innerText = medTotal.total_costo;

                        let tablaServiciosEmerg = document.getElementById("cuerpoTablaEmerg");

                        // tablaServiciosEmerg.innerHTML = "";

                        // // Recorrer el array de medicamentos y agregarlos a la tabla
                        data.tratamientos.forEach(ser => {
                            let fila = `
                                <tr>
                                    <td>${ser.servicio_id}</td>
                                    <td>${ser.nombre_servicio}</td>
                                    <td class="costosSer">${ser.total_costo}</td>
                                </tr>
                            `;
                            tablaServiciosEmerg.innerHTML += fila;
                        });

                         // //costo total de todos los medicamentos durante la emergencia 

                         let tablaServiciosHosp = document.getElementById("cuerpoTablaHosp");
                        //  tablaServiciosHosp.innerHTML = "";

                         document.getElementById("costo_total_hosp").innerText = hospTotal.total_costo || "00";
                         document.getElementById("costo_total_dias").innerText = hospDias.costo_total || "00";;
                         document.getElementById("sumaTotal").innerHTML = data.fechaFactura[0].total_factura;

                         data.servDeHospitalizacion.forEach(serHosp => {
                            let fila = `
                                <tr>
                                    <td>${serHosp.servicio_id}</td>
                                    <td>${serHosp.nombre_servicio}</td>
                                    <td class="costosSer">${serHosp.total_costo}</td>
                                </tr>
                            `;
                            tablaServiciosHosp.innerHTML += fila;
                        });

                        const tablaDetalles = document.getElementById("tbodyDetalles")

                        tablaDetalles.innerHTML = "";

                        data.detallesMed.forEach(medicamentoDet => {
                            let fila = `
                                <tr>
                                    <td>${medicamentoDet.medicamento_id}</td>
                                    <td>${medicamentoDet.nombre_medicamento}</td>
                                    <td>${medicamentoDet.presentacion}</td>
                                    <td>${medicamentoDet.fecha_hora_administracion.split(" ")[0]}</td>
                                    <td>${medicamentoDet.dosis}</td>
                                    <td>${medicamentoDet.precio_unitario}</td>
                                    <td>${medicamentoDet.costo_total}</td>
                                </tr>
                            `;
                            tablaDetalles.innerHTML += fila;
                        });

                        const dialog = document.getElementById("dialogDetallesFacturas");
                        dialog.showModal()

                        const boton = document.getElementById('btnPdf');

                        console.log(estadoFac)

                        // Mostrar el botón solo si el estado es "pagada"
                        if (estadoFac === 'Pagado') {
                            boton.style.display = 'inline-block';
                        }

                    })
                    .catch(error => console.error("Error en la solicitud:", error));

                    const btnCerrar = document.getElementById('cerrarDialog');

                    btnCerrar.addEventListener('click', () => {
                        location.reload();     // Recarga la página para evitar erores en la visualizacion
                    });
                    
        }





    </script>
</body>
</html>



<?php include "footer.php";  ?>