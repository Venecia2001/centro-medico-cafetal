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
                <a href="#">Facturacion</a>
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

    <main id="contenedorCentral">

        <div class="panelDeBusqueda">

            <div>
                <H2>Facturas</H2>
            </div>

            <div class='divBuscar'>
                <form action="Crud_Admin/barraBusqueda.php" method="POST" id="searchForm">
                        <input type="text" name="search" id="search" required>
                        <input type="submit" name="buscar" value="Buscar">
                        <p>Buscar por cedula paciente, id emergencia, id factura</p>
                    </form>
            </div>

           

        </div>
        <div  class="espacioDeFacturas">

            <h2>Facturas Generadas </h2>
            
            <div class="filtroCitas">
                <?php
                    $current_date = date('Y-m-d'); // Fecha actual
                    $one_week_later = date('Y-m-d', strtotime('+1 week')); // Fecha una semana más adelante
                    $one_week_before = date('Y-m-d', strtotime('-1 week')); // Fecha una semana atrás
                    $one_month_before = date('Y-m-d', strtotime('-1 month')); // Fecha un mes atrás
                ?>
                <form action="" method="POST" id="formulario_filtro">
                    <select name="filtro" id="seleccionarFechasCitas">
                        <option value="">Seleccione Fecha</option>
                        <option value="filtroPorDia_<?php echo $current_date ?>">Citas del día</option>
                        <option value="filtroSemanaAtras_<?php echo $one_week_before . '_' . $current_date ?>">Citas de la semana pasada</option> <!-- Semana pasada -->
                        <option value="filtroMesAtras_<?php echo $one_month_before . '_' . $current_date ?>">Citas del mes pasado</option> <!-- Mes pasado -->
                        <option value="totalCitas">Todas las citas</option>
                    </select>
                </form>
            </div>
            <table border="1">
            <thead>
                <th>id_factura</th>
                <th>Cedula Paciente</th>
                <th>Emergencia_id</th>
                <th>Hospitalizacion_id</th>
                <th>Fecha Factura</th>
                <th>Total Medicamentos</th>
                <th>Total Servicios</th>
                <th>Total Costos</th>
                <th>Metodo de Pago</th>
                <th>Estado</th>
                <th>Registrar Metodo de pago</th>
                <th>Detalles</th>
            </thead>

            <tbody id='tablaFact'>

            <?php 
            
            include("conex_bd.php");

            $consultaSql = "SELECT fac.*, em.id_paciente, em.id_paciente_temp FROM facturas fac LEFT JOIN emergencias_medicas em ON em.id_emergencia = fac.emergencia_medica_id";
            $resultado = mysqli_query($conexion,$consultaSql);
            
            while($datos=$resultado->fetch_object()){

                ?>

                <tr>
                    <td><?php echo $datos->factura_id  ?> </td>
                    <td><?php echo $datos->id_paciente.''.$datos->id_paciente_temp?> </td>
                    <td><?php echo $datos->emergencia_medica_id  ?> </td>
                    <td> <?php echo $datos->hospitalizacion_id ?: 'No Hospitalizado'; ?> </td>
                    <td><?php echo $datos->fecha_factura ?> </td>
                    <td><?php echo $datos->total_medicamentos ?> </td>
                    <td ><?php echo $datos->total_servicios ?> </td>
                    <td ><?php echo $datos->total_factura ?> </td>
                    <td ><?php echo $datos->metodo_pago ?> </td>
                    <td class='<?php echo $datos->estado ?>'> <?php echo $datos->estado ?> </td>
                    <td>
                        <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detallesFac_<?php echo $datos->factura_id ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idFactura" value="<?php echo $datos->factura_id ?>">
                                    <button type="button" class="detallesEmergencia" onclick="enviarMetodoPago(<?php echo $datos->factura_id; ?>)">Registro Metodo Pago</button>
                        </form> 
                    </td>
                    <td>
                        <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detalles_<?php echo $datos->emergencia_medica_id ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idEmergenciaMedica" value="<?php echo $datos->emergencia_medica_id ?>">
                                    <button type="button" class="detallesEmergencia" onclick="enviarFormulario(<?php echo $datos->emergencia_medica_id; ?>)">Ver detalles</button>
                        </form>
                    </td>
                </tr>   
                <?php
            }    

            ?>

            </tbody>

            </table>
            
        </div>
        


    </main>

    <dialog id="dialogDetallesFacturas">

        <div class="contenidoFactura">

            <div class="seccionesFactura" id="datosGenerales">
                <div class ="cabezeraFactura">

                    <form method="dialog">
                        <button id = "cerrarDialogo" class="ModalClose"> X</button>
                    </form>

                    <div id="logo">
                        <img src="imagenes/logo-removebg-preview (1).png" class="logotipo">
                        <p id="tituloPrincipal">Clínica San Pedro</p>
                    </div>
                    
                    <h2 id="tituloReporte">Reporte de Factura</h2>
                    <h3 id="fechaF">Fechas:<p id="fechaFac"></p> </h3>
                </div>
                <div class="datosPaciente">

                    <div class="nobresResponsables">

                        <h4>Compañia: <span class="datoPrincipal">Clinica San Pedro</span> </h4><br>
                        <h4>Sucursal: <span class="datoPrincipal">Biscucuy</span> </h4><br>

                        <h4>Paciente: <span class="datoPrincipal" id="nombrePaciente"></span> </h4><br>

                        <h4>Cedula: <span class="datoPrincipal" id="CedulaPaciente"></span> </h4><br>

                        <h4>Codigo Emergencia: <span class="datoPrincipal" id="idEmergencia"></span> </h4><br>

                        <h4>Fecha de Ingreso: <span class="datoPrincipal" id="fechaIngreso"></span> </h4><br>

                    </div>

                    <div class="segurosResponsables">

                        <h4>Fecha de Alta: <span class="datoPrincipal" id="fechaDeAlta">pendiente</span> </h4><br>

                        <h4>Medico: <span class="datoPrincipal" id="medicoResponsable" >Dr. </span> </h4><br>

                        <h4>Proceso: <span class="datoPrincipal" id="diagnostico_emerg" >tratamiento</span> </h4><br>

                        <h4>Cama: <span class="datoPrincipal" id="nCama" >12A:</span> </h4><br>

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
                <table>
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
                <table>
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

                <table id="desgloseMedicamentos">
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
        function enviarFormulario(id) {
                    
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


                        document.getElementById("fechaFac").innerHTML = data.fechaFactura[0].fecha_factura;
                        let estadoFactura = document.getElementById("estadoFactura").innerHTML = data.fechaFactura[0].estado;

                        document.getElementById("idEmergencia").innerHTML = emergencia.id_emergencia;
                        document.getElementById("codigoEmergencia").value = emergencia.id_emergencia;
                        document.getElementById("medicoResponsable").innerHTML = emergencia.nombre_medico+" "+emergencia.apellido_medico;
                        document.getElementById("diagnostico_emerg").innerHTML = emergencia.diagnostico;
                        document.getElementById("nCama").innerHTML = emergencia.numero_cama;
                        document.getElementById("fechaIngreso").innerText = emergencia.fecha_emergencia;
                        document.getElementById("fechaDeAlta").innerText = emergencia.fecha_alta || "No se ha dado de alta";
                        // document.getElementById("estadoEmerg").innerText = emergencia.estado_emergencia;

                        // Mostrar el nombre del paciente registrado o temporal
                        document.getElementById("nombrePaciente").innerText = 
                        emergencia.nombre && emergencia.apellido 
                        ? emergencia.nombre + " " + emergencia.apellido 
                        : emergencia.nombre_paciente_temporal + " " + emergencia.apellido_temporal;
                        document.getElementById("CedulaPaciente").innerText = emergencia.id_paciente || emergencia.id_paciente_temp;
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

                    const btnCerrar = document.getElementById('cerrarDialogo');

                    btnCerrar.addEventListener('click', () => {
                        location.reload();     // Recarga la página para evitar erores en la visualizacion
                    });
                    
        }


        function enviarMetodoPago(id) {
                    
                    let inputIdFactura = document.querySelector(`#form_detallesFac_${id} input[name='idFactura']`).value;

                    console.log(inputIdFactura)

                    document.getElementById("idFactura").value = inputIdFactura;

                    const dialog = document.getElementById("DialogMetodoPago");
                    dialog.showModal(); 


                    // Realizamos la solicitud con fetch
                    // fetch('manejo_emergencia/detallesDeEmergencias.php', {
                    // method: 'POST',
                    // headers: {
                    //     'Content-Type': 'application/x-www-form-urlencoded'
                    // },
                    // body: `idEmergencia=${encodeURIComponent(inputId)}`
                    // })
                    // .then(response => response.json()) // Convertir la respuesta a JSON
                    // .then(data => {
                    //     if (!Array.isArray(data.data) || data.length === 0) {
                    //         console.error("No se encontraron datos.");
                    //         document.getElementById("errorMensaje").innerText = "No se encontraron datos.";
                    //         return;
                    // }
                    
                    // }
        }

        // Cuando se cambia la especialidad

            // Si se seleccionó una especialidad
            
        // Obtener el campo de barraBusqueda y tbody
        var barraBusqueda = document.getElementById('search');
        var cuerpoTabla = document.getElementById('tablaFact');

        
        
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault(); 

                var palabraClave = barraBusqueda.value;

                console.log(palabraClave)

                // Si se seleccionó una especialidad
                // Usar fetch para hacer la solicitud
                fetch('manejo_emergencia/busquedaFacturas.php?palabra_id=' + palabraClave )
                .then(response => response.json())  // Procesamos la respuesta como JSON
                .then(data => {
                    // Limpiamos el select de médicos
                    cuerpoTabla.innerHTML = '';

                    // Si hay médicos, los agregamos al select
                    if (data.success) {

                        data.data.forEach(factura => {
                            // Crear una fila de la tabla
                            const fila = document.createElement('tr');
                            
                            // Crear celdas para cada propiedad
                            fila.innerHTML = `
                                <td>${factura.facturaId}</td>
                                <td>${factura.cedulaPac || factura.cedulaPacTemp}</td>
                                <td>${factura.idEmergencia}</td>
                                <td>${factura.idHospitalizacion}</td>
                                <td>${factura.fechaFactura}</td>
                                <td>${factura.totalMedicamentos}</td>
                                <td>${factura.totalServicios}</td>
                                <td>${factura.totalFact}</td>
                                <td>${factura.metodoPago}</td>
                                <td>${factura.estadoFact}</td>
                                <td>
                                     <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detallesFac_${factura.facturaId}" method="POST" style="display:inline;">
                                        <input type="hidden" name="idFactura" value="${factura.facturaId}">
                                        <button type="button" class="detallesEmergencia" onclick="enviarMetodoPago(${factura.facturaId})">Registro Metodo Pago</button>
                                    </form> 
                                </td>

                                <td> 
                                    <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detalles_${factura.idEmergencia}" method="POST" style="display:inline;">
                                        <input type="hidden" name="idEmergenciaMedica" value="${factura.idEmergencia}">
                                        <button type="button" class="detallesEmergencia" onclick="enviarFormulario(${factura.idEmergencia})">Ver detalles</button>
                                    </form>
                                </td>
                                `;
                            
                            // Agregar la fila al cuerpo de la tabla
                            cuerpoTabla.appendChild(fila);
                        });
                  
                    } else {
                        cuerpoTabla.innerHTML = "<tr><td colspan='6'>No se encontraron datos relacionados.</td></tr>";
                    }
                })
                .catch(error => {
                    console.error("Error al cargar los médicos:", error);
                });
        });


        document.getElementById('seleccionarFechasCitas').addEventListener('change', function() {
            const filtro = this.value;
        
            // Si no hay valor seleccionado, no hacer nada
            if (!filtro) return;

            if(filtro === "totalCitas"){
                location.reload();            
            }

            // Crear los datos a enviar
            const formData = new FormData();
            formData.append('filtro', filtro);

            // Enviar los datos al servidor usando fetch
                fetch('Crud_Admin/filtroFacturasGenerales.php', {
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

                        cuerpoTabla.innerHTML = '';
                        console.log(data.data)

                        if (data.data && data.data.length > 0) {
                            data.data.forEach(factura => {

                            const fila = document.createElement('tr');
                                
                                // Crear celdas para cada propiedad
                                fila.innerHTML = `
                                    <td>${factura.facturaId}</td>
                                    <td>${factura.cedulaPac || factura.cedulaPacTemp}</td>
                                    <td>${factura.idEmergencia}</td>
                                    <td>${factura.idHospitalizacion ? factura.idHospitalizacion : 'No Hospitalizado'}</td>
                                    <td>${factura.fechaFactura}</td>
                                    <td>${factura.totalMedicamentos}</td>
                                    <td>${factura.totalServicios}</td>
                                    <td>${factura.totalFact}</td>
                                    <td>${factura.metodoPago}</td>
                                    <td>${factura.estadoFact}</td>
                                    <td>
                                        <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detallesFac_${factura.facturaId}" method="POST" style="display:inline;">
                                            <input type="hidden" name="idFactura" value="${factura.facturaId}">
                                            <button type="button" class="detallesEmergencia" onclick="enviarMetodoPago(${factura.facturaId})">Registro Metodo Pago</button>
                                        </form> 
                                    </td>

                                    <td> 
                                        <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detalles_${factura.idEmergencia}" method="POST" style="display:inline;">
                                            <input type="hidden" name="idEmergenciaMedica" value="${factura.idEmergencia}">
                                            <button type="button" class="detallesEmergencia" onclick="enviarFormulario(${factura.idEmergencia})">Ver detalles</button>
                                        </form>
                                    </td>
                                    `;
                                
                                    // Agregar la fila al cuerpo de la tabla
                                    cuerpoTabla.appendChild(fila);
                                });
                            } else {
                                // Si no hay datos o está vacío
                                cuerpoTabla.innerHTML = "<tr><td colspan='12'>No se encontraron datos relacionados.</td></tr>";
                            }
                        // Aquí puedes manejar los datos como lo desees
                    } else {
                        cuerpoTabla.innerHTML = "<tr><td colspan='12'>No se encontraron datos relacionados.</td></tr>";
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });
        });


    </script>
</body>
</html>