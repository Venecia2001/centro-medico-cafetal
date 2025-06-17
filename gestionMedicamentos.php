<?php session_start(); ?>

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

            <!-- <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="registrosDeEmergencias.php">Registros de Emergencias</a>
            </li>

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="registrosHospitalizacion.php">Hospitalizacion</a>
            </li> -->

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="#">Gestion Medicamentos</a>
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

            <h1 class='tituloSeccion'>Gestion de Medicamentos</h1>

        <div class='panelDeControlMedicamentos'>
            
            <div class='buscadorMedicamento'>

                <form action="manejo_emergencia/verificarPaciente" method="POST" id="searchFormMedicamentos">
                    <input type="text" name="search" placeholder="Busca el medicamento por su id o nombre" id="searchMEdicamentos" required>
                    <input type="submit" name="buscar" class='btnRegistro_busq' value="Buscar"> 
                </form>

            </div>

            <div class='divBtnAgregar'>

            
                <button id='btnMedicamento'>Agregar Medicamento</button>

            </div>
           

        </div>

        
            <table id='tablaMedicamentos' border="1">
            <thead>
                <th>id medicamento</th>
                <th>Nombre</th>
                <th>Presentacion</th>
                <th>Unidad de Medida</th>
                <th>Stock Actual </th>
                <th>Clasificacion</th>
                <th>Fecha Vencimiento</th>
                <th>Precio Unitario </th>
                <th>Contenido total </th>
                <th>Precio Caja </th>
                <th>Editar</th>
                <th>Eliminar</th>
                <th>Reposición de inventario</th>
            </thead>

            <tbody id='tablaMedicamentosBody'>

            <?php
            
            include("conex_bd.php");

            $consultaSql = "SELECT * FROM `medicamentos` ";
            $resultado = mysqli_query($conexion,$consultaSql);
            
            while($datos=$resultado->fetch_object()){

                ?>

                <tr>
                    <td><?php echo $datos->medicamento_id ?> </td>
                    <td><?php echo $datos->nombre_medicamento?> </td>
                    <td><?php echo $datos->presentacion ?> </td>
                    <td> <?php echo $datos->unidad_medida?> </td>
                    <td><?php echo $datos->stock_actual ?> </td>
                    <td><?php echo $datos->clasificacion ?> </td>
                    <td ><?php echo $datos->fecha_vencimiento ?> </td>
                    <td ><?php echo $datos->precio_unitario ?> </td>
                    <td ><?php echo $datos->contenido_total ?> </td>
                    <td > <?php echo $datos->precio_caja_frasco ?> </td>
                    <td class='tdEditar'>
                        <!-- Formulario con botón para editar -->
                        <form id="form_editar_<?php echo $datos->medicamento_id; ?>" action="manejo_emergencia/crudMedicamentos.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idEditar" value="<?php echo $datos->medicamento_id; ?>">
                            <button type="button" class="linkEditar" onclick="enviarFormulario(<?php echo $datos->medicamento_id; ?>)"><span class="material-symbols-outlined">
edit
</span></button>
                        </form>
                    </td>
                    <?php echo "<td class='tdDelete'>
                        <form id='formEliminar".$datos->medicamento_id."' action='manejo_emergencia/crudMedicamentos.php' method='POST' onsubmit='return confirmarEliminacion()'>
                            <input type='hidden' name='idMedicamento' value='".$datos->medicamento_id."'>
                            <button type='submit' name='eliminar' class='delete'>
                                <span class='material-symbols-outlined'>delete</span>
                            </button>
                        </form>
                    </td>"; ?>
                     <td class='tdEditar'>
                        <!-- Formulario con botón para editar -->
                        <form id="form_reabastecimiento_<?php echo $datos->medicamento_id; ?>" action="manejo_emergencia/crudMedicamentos.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idParaInventario" value="<?php echo $datos->medicamento_id; ?>">
                            <button type="button" class="linkEditar" onclick="enviarFormularioInventario(<?php echo $datos->medicamento_id; ?>)"><span id='addInventario' class="material-symbols-outlined">
shopping_cart
</span>

                            </button>
                        </form>
                    </td> 
                    
                </tr>
                 
                <?php
            }    

            ?>

            </tbody>

            </table>

            <?php if (isset($_SESSION['mensajeExito'])): ?>
                <div class="alerta-exito">
                    <?= $_SESSION['mensajeExito'] ?>
                </div>
                <?php unset($_SESSION['mensajeExito']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['errorMensaje'])): ?>
                <div class="alerta-error">
                    <?php echo $_SESSION['errorMensaje'] ?>
                </div>
                <?php unset($_SESSION['errorMensaje']); ?>
            <?php endif; ?>


        </main>

        <dialog id='idDialogInventario'>

            <div class="headerModel"> 
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>

            </div>

            <div class="dialogRegistroMedicamentos">
                <h2>Registrar Medicamento</h2>
            <form action="manejo_emergencia/crudMedicamentos.php"   method="POST">

                <label for="MedicamentoName">Nombre de Medicamento </label>
                <input id ="MedicamentoName" type="text" placeholder="Nombre del Medicamento" name="nombreMedicamento" required>

                <label for="presentacionMedc">Presentacion</label>
                <select name="presentacionMedicamento" id="presentacionMedc" class='selectMedicamento' required>
                    <option value="">Selecione Presentacion</option>
                    <option value="Tableta">Tableta</option>
                    <option value="Ampolla">Ampolla</option>
                    <option value="Jarabe">Jarabe</option>
                </select>
        
                <label for="medicoResponsable">Unidad Medida</label>

                <select name="UnidadMedida" id="unidadMedidaMed" class='selectMedicamento' required>
                    <option value="">Selecione Unidad Medida</option>
                    <option value="mg">Miligramos</option>
                    <option value="g">Gramos</option>
                    <option value="mcg">Microgramos</option>
                     <option value="mL">Minilitros</option>
                     <option value="L">Litros</option>
                </select>
                
                <label for="stock">Stock Actual</label>
                <input type="number" id='stock_actual' name='stockMedicamento' min="0" required>

                <label for="clasificion">Clasificacion de Medicamento</label>
                <select name="clasificacionMedicametos" id="selectMedicoEmergencia" class='selectMedicamento' required>
                    <option value="">Seleciona Clasificacion</option>
                    <option value="Analgésicos">Analgésicos</option>
                    <option value="Antibióticos">Antibióticos</option>
                    <option value="Antihistamínicos">Antihistamínicos</option>
                    <option value="Antiinflamatorios">Antiinflamatorios</option>
                    <option value="Antihipertensivos">Antihipertensivos</option>
                    <option value="Broncodilatadores">Broncodilatadores</option>
                    <option value="Anticoagulantes">Anticoagulantes</option>
                    <option value="Relajantes musculares">Relajantes musculares</option>
                    <option value="Anticonvulsivos">Anticonvulsivos</option>
                    <option value="Protectores Gástricos">Protectores Gástricos</option>

                </select><br>

                <?php $hoy = date('Y-m-d'); ?>

                <label for="vencimiento ">fecha_vencimiento </label>
                <input type="date" id='vencimiento' name='fecha_vencimiento' min="<?= $hoy ?>" required>

                <label for="Contenido">Contenido por Caja/Frasco</label>
                <input id="Contenido" type="number" placeholder="Contenido"  name="ContenidoCaja_Frasco" min="0" required>

                <label for="tipoEmergencia">Precio</label>
                <input id="precio" type="number" placeholder="Precio" name="precio" step="0.01" min="0" required>

                <button type="submit" class="botonesLogin" id="btnRegistroMedicamento" name="registroMedicamento" >Registrar Medicamento</button>
            </form>

            </div>

        </dialog>

        <dialog class="DialogDeEmergencias" id="DialogEdicion">

            <div class="formularios">

                <div class="headerModel"> 
                    <form method="dialog">
                    <button class="ModalClose"> X</button>
                    </form>
                </div>

                <div class="dialogRegistroMedicamentos">

                    <form action="manejo_emergencia/crudMedicamentos.php"   method="POST">

                        <h2>Modificar Medicamento</h2>

                        <input type="hidden" id='idMedicamentoEdit' name='idMedicamento'>

                        <label for="MedicamentoName">Nombre de Medicamento </label>
                        <input id ="MedicamentoNameEdit" type="text" placeholder="Nombre del Medicamento" name="nombreMedicamento" required>

                        <label for="presentacionMedc">Presentacion</label>
                        <select name="presentacionMedicamento" id="presentacionMedcEdit" class='selectMedicamento' required>
                            <option value="">Selecione Presentacion</option>
                            <option value="Tableta">Tableta</option>
                            <option value="Ampolla">Ampolla</option>
                            <option value="Jarabe">Jarabe</option>
                        </select>
                
                        <label for="medicoResponsable">Unidad Medida</label>

                        <select name="UnidadMedida" id="unidadMedidaMedEdit" class='selectMedicamento' required>
                            <option value="">Selecione Unidad Medida</option>
                            <option value="mg">Miligramos</option>
                            <option value="g">Gramos</option>
                            <option value="mcg">Microgramos</option>
                            <option value="mL">Minilitros</option>
                            <option value="L">Litros</option>
                        </select>
                        
                        <label for="stock">Stock Actual</label>
                        <input type="number" id='stock_actualEdit' name='stockMedicamento' min="0" step="0.01" required>

                        <label for="clasificion">Clasificacion de Medicamento</label>
                        <select name="clasificacionMedicametos" id="clasificacionEdit" class='selectMedicamento' required>
                            <option value="">Seleciona Clasificacion</option>
                            <option value="Analgésicos">Analgésicos</option>
                            <option value="Antibióticos">Antibióticos</option>
                            <option value="Antihistamínicos">Antihistamínicos</option>
                            <option value="Antiinflamatorios">Antiinflamatorios</option>
                            <option value="Antihipertensivos">Antihipertensivos</option>
                            <option value="Broncodilatadores">Broncodilatadores</option>
                            <option value="Anticoagulantes">Anticoagulantes</option>
                            <option value="Relajantes musculares">Relajantes musculares</option>
                            <option value="Anticonvulsivos">Anticonvulsivos</option>
                            <option value="Protectores Gástricos">Protectores Gástricos</option>

                        </select><br>

                        <?php $hoy = date('Y-m-d'); ?>

                        <label for="vencimiento ">fecha_vencimiento </label>
                        <input type="date" id='vencimientoEdit' name='fecha_vencimiento' min="<?= $hoy ?>" required>

                        <label for="Contenido">Contenido por Caja/Frasco</label>
                        <input id="ContenidoEdit" type="number" placeholder="Contenido"  name="ContenidoCaja_Frasco" min="0" required>

                        <label for="tipoEmergencia">Precio</label>
                        <input id="precioEdit" type="number" placeholder="Precio" name="precio" step="0.01" min="0" required>

                        <button type="submit" class="botonesLogin" id="btnEditarMedicamento" name="editarMedicamento" >Editar Medicamento</button>
                    </form>

                </div>

            </div>
        </dialog>

        <dialog id="DialogMovimientoInventario">

            <div class="formularios">

                <div class="headerModel"> 
                    <form method="dialog">
                    <button class="ModalClose"> X</button>
                    </form>
                </div>

                <div class="dialogRegistroMedicamentos">

                    <h2>Ingresar Medicamento</h2>

                    <form action="manejo_emergencia/crudMedicamentos.php"   method="POST">

                        <input type="hidden" id='idMedicamentoInventario' name='idMedicamentoInv'>

                        <label for="stockAct ">Stock Actual</label>
                        <input type="number" id='stockAct' name='' readonly>

                        <input type="hidden" id='tipoMovimiento' value='Entrada' name='movientoInventario'>

                        <label for="tipoEmergencia">Precio</label>
                        <input id="precioInventario" type="number" placeholder="Precio" name="precioInv" step="0.01" min="0" required>

                        <label for="reabastecimientoInv">Numero de Cajas/frascos</label>
                        <input id="reabastecimientoInv" type="number" placeholder="Contenido" name="entradaDeMedicamentos" min="0" required>

                        <label for="Comentario">Comentario</label>
                        <input id="Comentario" type="text" placeholder="Descripcion de operacion" name="comentarioMoviento" required>

                        <button type="submit" class="botonesLogin" id="entradaInventario" name="entradaNewMedicamentos" >Actualizar Medicamento</button>
                    </form>

                </div>

            </div>
        </dialog>



        <script>

        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar este medicamento?");
        }
            
        const botonNewMedicamento = document.getElementById('btnMedicamento')
        botonNewMedicamento.addEventListener("click", openFormCita)

        function openFormCita(){

            const formInterno = document.getElementById("idDialogInventario");
            formInterno.showModal();
            
        }

        function enviarFormulario(id) {
            
            var inputId = document.querySelector(`#form_editar_${id} input[name='idEditar']`).value;

            console.log(inputId)

            // Realizamos la solicitud con fetch
            fetch('manejo_emergencia/crudMedicamentos.php', {
            method: 'POST',  // Método de la solicitud
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'  // Tipo de contenido
            },
            body: `idEditar=${encodeURIComponent(inputId)}`  // El cuerpo de la solicitud con el idEditar
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
                    document.getElementById('idMedicamentoEdit').value = data.id;
                    document.getElementById('MedicamentoNameEdit').value = data.nombre;
                    document.getElementById('presentacionMedcEdit').value = data.presentacionMed;
                    document.getElementById('unidadMedidaMedEdit').value = data.unidad_medida;
                    document.getElementById('stock_actualEdit').value = data.stock_actual;
                    document.getElementById('clasificacionEdit').value = data.clasificacion;
                    document.getElementById('vencimientoEdit').value = data.fecha_vencimiento;
                    document.getElementById('ContenidoEdit').value = data.contenido_total;
                    document.getElementById('precioEdit').value = data.precio_caja_frasco;
                    
                }

                const dialogEdit = document.getElementById("DialogEdicion");
                dialogEdit.showModal();
            })
            .catch(error => {
                // Si ocurre un error en cualquier parte del proceso
                console.error('Error:', error);
            });
        
        
        
        }


        function enviarFormularioInventario(id) {
            
            var inputId = document.querySelector(`#form_reabastecimiento_${id} input[name='idParaInventario']`).value;

            console.log(inputId)

            // Realizamos la solicitud con fetch
            fetch('manejo_emergencia/crudMedicamentos.php', {
            method: 'POST',  // Método de la solicitud
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'  // Tipo de contenido
            },
            body: `idEditar=${encodeURIComponent(inputId)}`  // El cuerpo de la solicitud con el idEditar
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
                    document.getElementById('idMedicamentoInventario').value = data.id;
                    document.getElementById('stockAct').value = data.stock_actual;
                    document.getElementById('precioInventario').value = data.precio_caja_frasco;
                    // document.getElementById('unidadMedidaMedEdit').value = data.unidad_medida;
                    
                    
                }

                const dialogEdit = document.getElementById("DialogMovimientoInventario");
                dialogEdit.showModal();
            })
            .catch(error => {
                // Si ocurre un error en cualquier parte del proceso
                console.error('Error:', error);
            });
        
        }

        var barraBusqueda = document.getElementById('searchMEdicamentos');

        document.getElementById('searchFormMedicamentos').addEventListener('submit', function(event) {
            event.preventDefault();

            let contenedorMedicamento = document.getElementById('tablaMedicamentosBody');

            var palabraClave = barraBusqueda.value;
            console.log(palabraClave)

            // Usar fetch para hacer la solicitud
            fetch('manejo_emergencia/buscarMedicamento.php?palabra_id='+ palabraClave)
                .then(response => response.json())  // Procesamos la respuesta como JSON
                .then(data => {
                        // Limpiamos el select de médicos
                        contenedorMedicamento.innerHTML = '';

                        // Si hay médicos, los agregamos al select
                        if (data.success) {
                            // Crear un primer option para "Seleccionar un médico"
                            console.log(data);

                        
                            data.data.forEach(medicamento => {
                                // Crear una fila de la tabla

                                const fila = document.createElement('tr');

                                fila.innerHTML = `
                                
                                    <td> ${medicamento.medicamento_id} </td>
                                    <td> ${medicamento.nombre} </td>
                                    <td> ${medicamento.presentacion}</td>
                                    <td> ${medicamento.unidadMedida} </td>
                                    <td> ${medicamento.stock} </td>
                                    <td>${medicamento.clasificacionMed} </td>
                                    <td >${medicamento.fechaV} </td>
                                    <td >${medicamento.precioUnitario} </td>
                                    <td >${medicamento.contenidoTotal} </td>
                                    <td > ${medicamento.precioCaja} </td>
                                    <td class='tdEditar'>
                                        <!-- Formulario con botón para editar -->
                                        <form id="form_editar_${medicamento.medicamento_id}" action="manejo_emergencia/crudMedicamentos.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="idEditar" value="${medicamento.medicamento_id}">
                                            <button type="button" class="linkEditar" onclick="enviarFormulario(${medicamento.medicamento_id})"><span class="material-symbols-outlined">
edit
</span></button>
                                        </form>
                                    </td>
                                    <td>
                                        <form id='formEliminar${medicamento.medicamento_id}' action='manejo_emergencia/crudMedicamentos.php' method='POST' onsubmit='return confirmarEliminacion()'>
                                            <input type='hidden' name='idMedicamento' value='${medicamento.medicamento_id}'>
                                            <button type='submit' name='eliminar' class='delete'>
                                                <span class='material-symbols-outlined'>delete</span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class='tdEditar'>
                                        <!-- Formulario con botón para editar -->
                                        <form id="form_reabastecimiento_${medicamento.medicamento_id}" action="manejo_emergencia/crudMedicamentos.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="idParaInventario" value="${medicamento.medicamento_id}">
                                            <button type="button" class="linkEditar" onclick="enviarFormularioInventario(${medicamento.medicamento_id})"><span id='addInventario' class="material-symbols-outlined">
shopping_cart
</span>

                                            </button>
                                        </form>
                                    </td> 
                                `;


                                contenedorMedicamento.appendChild(fila);

                            });
                        
                        } else {
                            contenedorMedicamento.innerHTML = "<tr><td colspan='14'>No se encontraron datos relacionados.</td></tr>";
                        }
                    })
                    .catch(error => {
                        console.error("Error al cargar los médicos:", error);
                    });
        });

        </script>

</body>
</html>