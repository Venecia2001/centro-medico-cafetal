
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
                <a href="#">Facturacion Citas</a>
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

            <div>
                    <form action="Crud_Admin/barraBusqueda.php" method="POST" id="searchForm">
                        <input type="text" name="search" id="search" required>
                        <input type="submit" name="buscar" value="Buscar">
                        <p>Buscar por cedula paciente, id emergencia, id factura</p>
                    </form>
            </div>

           

        </div>
        <div  class="espacioDeFacturas">

            <h2>Facturas Citas Medicas </h2>
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
                <th>id_cita</th>
                <th>Cedula Paciente</th>
                <th>fecha Emision</th>
                <th>Costo total</th>
                <th>Metodo de Pago</th>
                <th>Estado Factura</th>
                <th>Registrar Metodo de pago</th>
                <th>Detalles</th>
            </thead>

            <tbody id='tablaFact'>

            <?php 
            
            include("conex_bd.php");

            $consultaSql = "SELECT fac.*, cts.id_cliente FROM facturas_citas fac LEFT JOIN citas cts ON cts.id_cita = fac.id_cita";
            $resultado = mysqli_query($conexion,$consultaSql);
            
            while($datos=$resultado->fetch_object()){

                ?>

                <tr>
                    <td><?php echo $datos->id_factura_cita ?> </td>    
                    <td><?php echo $datos->id_cita ?> </td>
                    <td><?php echo $datos->id_cliente ?> </td>
                    <td><?php echo $datos->fecha_emision ?> </td>
                    <td ><?php echo $datos->monto_total ?> </td>
                    <td ><?php echo $datos->metodo_pago ?> </td>
                    <td class='<?php echo $datos->estado_fact ?>'> <?php echo $datos->estado_fact ?> </td>
                    <td>
                        <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detallesFac_<?php echo $datos->id_factura_cita ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idFactura" value="<?php echo $datos->id_factura_cita ?>">
                                    <button type="button" class="detallesEmergencia" onclick="enviarMetodoPago(<?php echo $datos->id_factura_cita; ?>)">Registro Metodo Pago</button>
                        </form> 
                    </td>
                    <td>
                        <form  action='manejo_emergencia/detallesFacturasCitas.php' id="form_detalles_<?php echo $datos->id_cita ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idCita" value="<?php echo $datos->id_cita ?>">
                                    <button type="button" class="detallesEmergencia" onclick="enviarFormulario(<?php echo $datos->id_cita; ?>)">Ver detalles</button>
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
                    <h3 id="fechaF">Fecha Emision:<p id="fechaFac"></p> </h3>
                </div>
                <div class="datosPaciente">

                    <div class="nobresResponsables">

                        <h4>Compañia: <span class="datoPrincipal">Clinica San Pedro</span> </h4><br>

                        <h4>Sucursal: <span class="datoPrincipal">Biscucuy</span> </h4><br>

                        <h4>id factura: <span class="datoPrincipal" id="id_factura_cita"></span> </h4><br>

                        <h4>Paciente: <span class="datoPrincipal" id="nombrePaciente"></span> </h4><br>

                        <h4>Cedula: <span class="datoPrincipal" id="CedulaPaciente"></span> </h4><br>

                    </div>

                    <div class="segurosResponsables">

                        <h4>Medico: <span class="datoPrincipal" id="medicoResponsable" >Dr. </span> </h4><br>

                        <h4>Proceso: <span class="datoPrincipal" id="diagnostico_emerg" >Consulta</span> </h4><br>

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
                        <th>Especialidad</th>
                        <th>Importe</th>
                    </thead>
                    <tbody id="cuerpoTablaEmerg">
                        <tr>
                            <td id="idServicio" >Far1054</td>
                            <td id="consultaEsp"></td>
                            <td id="costo_total_esp" >$ </td>
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

                <button type="submit" class="botonRegistro" id="botonRegistrarMed" name="actualizarMetodoPagoCita">Registrar Metodo Pago</button>
            </form>
        </div>

    </dialog>

    <script> 

        function enviarFormulario(id) {
                    
                    let inputId = document.querySelector(`#form_detalles_${id} input[name='idCita']`).value;

                    console.log(inputId)

                    // Realizamos la solicitud con fetch
                    fetch('manejo_emergencia/detallesFacturasCitas.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `idCita=${encodeURIComponent(inputId)}`
                        })
                        .then(response => response.json()) // Convertir la respuesta a JSON
                        .then(data => {
                            if (!Array.isArray(data.data) || data.length === 0) {
                                console.error("No se encontraron datos.");
                                document.getElementById("errorMensaje").innerText = "No se encontraron datos.";
                                return;
                            }
                            console.log("Datos recibidos:", data);

                            const emergencia = data.data[0];


                        document.getElementById("fechaFac").innerHTML = emergencia.fecha_emision;
                        document.getElementById("id_factura_cita").innerHTML = emergencia.id_factura_cita;
                        document.getElementById("nombrePaciente").innerHTML = emergencia.nombre+" "+emergencia.apellido;
                        document.getElementById("medicoResponsable").innerHTML = emergencia.nombre_medico+" "+emergencia.apellido_medico;
                        document.getElementById("CedulaPaciente").innerHTML = emergencia.id_cliente;

                        document.getElementById("estadoFactura").innerHTML = emergencia.estado_fact;
                        document.getElementById("consultaEsp").innerHTML = emergencia.nombre_esp;
                        document.getElementById("costo_total_esp").innerHTML = emergencia.monto_total;
                        document.getElementById("sumaTotal").innerHTML = emergencia.monto_total;

                        const dialog = document.getElementById("dialogDetallesFacturas");
                        dialog.showModal()

                            
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
        
        }


        var barraBusqueda = document.getElementById('search');
        var cuerpoTabla = document.getElementById('tablaFact');

        
        
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault(); 

                var palabraClave = barraBusqueda.value;

                console.log(palabraClave)

                // Usar fetch para hacer la solicitud
                fetch('manejo_emergencia/busquedaFactCitas.php?palabra_idCitas=' + palabraClave )
                .then(res => res.text())
                .then(text => {
                 console.log('Respuesta cruda:', text); // Mira qué se está recibiendo realmente
                 const data = JSON.parse(text);
                    // Limpiamos el select de médicos
                    cuerpoTabla.innerHTML = '';

                    // Si hay médicos, los agregamos al select
                    if (data.success) {

                       console.log(data.data)

                       data.data.forEach(factura => {
                            // Crear una fila de la tabla
                            const fila = document.createElement('tr');
                            
                            // Crear celdas para cada propiedad
                            fila.innerHTML = `
                                <td>${factura.facturaId}</td>
                                <td>${factura.idCita}</td>
                                <td>${factura.cedulaPac}</td>
                                <td>${factura.fechaEmision}</td>
                                <td>${factura.montoTotal}</td>
                                <td>${factura.metodoPago}</td>
                                <td>${factura.estadoFact}</td>
                               <td>
                                    <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detallesFac_${factura.facturaId}" method="POST" style="display:inline;">
                                                <input type="hidden" name="idFactura" value="${factura.facturaId}">
                                                <button type="button" class="detallesEmergencia" onclick="enviarMetodoPago(${factura.facturaId})">Registro Metodo Pago</button>
                                    </form> 
                                </td>

                                <td>
                                    <form  action='manejo_emergencia/detallesFacturasCitas.php' id="form_detalles_${factura.idCita}" method="POST" style="display:inline;">
                                                <input type="hidden" name="idCita" value="${factura.idCita}">
                                                <button type="button" class="detallesEmergencia" onclick="enviarFormulario(${factura.idCita})">Ver detalles</button>
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
                    console.error("Error al cargar:", error);
                });
        });

        document.getElementById('seleccionarFechasCitas').addEventListener('change', function() {
            const filtro = this.value;

            console.log(filtro)
        
            // Si no hay valor seleccionado, no hacer nada
            if (!filtro) return;

            if(filtro === "totalCitas"){
                location.reload();            
            }

            // Crear los datos a enviar
            const formData = new FormData();
            formData.append('filtro', filtro);

            // Enviar los datos al servidor usando fetch
                fetch('Crud_Admin/filtroFacturasCitas.php', {
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

                    cuerpoTabla.innerHTML = '';

                    if (data.success) {

                        console.log(data.data)
                        if (data.data && data.data.length > 0) {
                            data.data.forEach(factura => {
                                // Crear una fila de la tabla
                                const fila = document.createElement('tr');
                                
                                // Crear celdas para cada propiedad
                                fila.innerHTML = `
                                    <td>${factura.facturaId}</td>
                                    <td>${factura.idCita}</td>
                                    <td>${factura.cedulaPac}</td>
                                    <td>${factura.fechaEmision}</td>
                                    <td>${factura.montoTotal}</td>
                                    <td>${factura.metodoPago}</td>
                                    <td>${factura.estadoFact}</td>
                                    <td>
                                        <form  action='manejo_emergencia/detallesDeEmergencia.php' id="form_detallesFac_${factura.facturaId}" method="POST" style="display:inline;">
                                                    <input type="hidden" name="idFactura" value="${factura.facturaId}">
                                                    <button type="button" class="detallesEmergencia" onclick="enviarMetodoPago(${factura.facturaId})">Registro Metodo Pago</button>
                                        </form> 
                                    </td>

                                    <td>
                                        <form  action='manejo_emergencia/detallesFacturasCitas.php' id="form_detalles_${factura.idCita}" method="POST" style="display:inline;">
                                                    <input type="hidden" name="idCita" value="${factura.idCita}">
                                                    <button type="button" class="detallesEmergencia" onclick="enviarFormulario(${factura.idCita})">Ver detalles</button>
                                        </form>
                                    </td>
                                    `;
                                
                                // Agregar la fila al cuerpo de la tabla
                                cuerpoTabla.appendChild(fila);
                            })
                        } else {
                                    // Si no hay datos o está vacío
                                    cuerpoTabla.innerHTML = "<tr><td colspan='12'>No se encontraron datos relacionados.</td></tr>";
                                }

                    } else {
                    cuerpoTabla.innerHTML = "<tr><td colspan='6'>No se encontraron datos relacionados.</td></tr>";
                    }
                    
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });
        });





    </script>
</body>
</html>