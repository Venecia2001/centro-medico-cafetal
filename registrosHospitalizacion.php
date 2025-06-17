<?php 

include("conex_bd.php");

if(!empty($_GET["id"])) {

    $idEmergencia = $_GET['id'];

    $consultaHospitalizacionMed = "SELECT
    hosp.hospitalizacion_id,
    hosp.emergencia_medica_id, 
    hosp.fecha_ingreso,
    hosp.fecha_alta,
    hosp.tipo_habitacion,
    hosp.numero_cama,
    hosp.observaciones_hosp,
    hosp.costo_por_dia,
    hosp.estado,
    -- Datos de emergencia detonante--
    em.id_paciente,
    em.id_paciente_temp,
    -- Datos del paciente
    c.nombre AS paciente_registrado,
    pt.nombre AS paciente_temporal,
    -- Datos del médico y enfermero
    med.nombre AS nombre_medico,
    med.apellido AS apellido_medico,
    ps.nombre AS nombre_enfermero,
    ps.apellido AS apellido_enfermero,
    -- Medicamentos administrados en la emergencia
    me.medicamento_emergencia_id,
    m.nombre_medicamento,
    me.presentacion,
    me.dosis,
    me.observaciones,
    me.administrado_durante,
    me.costo_total
    FROM hospitalizacion hosp
    -- emergencia medica
    LEFT JOIN emergencias_medicas em ON em.id_emergencia = hosp.emergencia_medica_id
    -- Pacientes registrados
    LEFT JOIN usuarios c ON em.id_paciente = c.id
    -- Pacientes temporales
    LEFT JOIN paciente_temp pt ON em.id_paciente_temp = pt.codigo_CI
    -- Médico responsable
    LEFT JOIN usuarios med ON em.medico_responsable = med.id
    -- Enfermero responsable
    LEFT JOIN personal_salud ps ON em.Id_enfermero = ps.cedula_personal_salud 
    -- Medicamentos administrados durante la emergencia
    LEFT JOIN medicamentos_emergencia me ON em.id_emergencia = me.id_emergencia
    LEFT JOIN medicamentos m ON me.medicamento_id = m.medicamento_id
    WHERE em.id_emergencia = ?";

    $stmt = $conexion->prepare($consultaHospitalizacionMed);
    $stmt->bind_param("i", $idEmergencia);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $datosHospitalizacion = null;
    $medicamentos = [];

    while ($fila = $resultado->fetch_assoc()) {
        // Si $datosEmergencia es null, almacena los datos generales de la emergencia
        if ($datosHospitalizacion === null) {
            $datosHospitalizacion = [
                "idDeEmergencia" => $fila['emergencia_medica_id'],
                "idRegistroHosp" => $fila['hospitalizacion_id'],
                "fechaIngreso" => $fila['fecha_ingreso'],
                "idPaciente" => $fila['id_paciente'],
                "fechaAltaMedica" => $fila['fecha_alta'],
                "tipoHabitacion" => $fila['tipo_habitacion'],
                "numeroDeCama" => $fila['numero_cama'],
                "observacionesHosp" => $fila['observaciones_hosp'],
                "costoPorDia" => $fila['costo_por_dia'],
                "estadoHosp" => $fila['estado'],
                "nombrePaciente" => $fila['paciente_registrado'] ?: $fila['paciente_temporal'],
                "nombreMedico" => $fila['nombre_medico'] . " " . $fila['apellido_medico'],
                "nombreEnfermero" => $fila['nombre_enfermero'] . " " . $fila['apellido_enfermero']
            ];
        }

        if (!empty($fila['nombre_medicamento'])) {
            $medicamentos[] = [
                "medicamento_emergencia_id" => $fila['medicamento_emergencia_id'],
                "nombre" => $fila['nombre_medicamento'],
                "presentacion" => $fila['presentacion'],
                "dosis" => $fila['dosis'],
                "observaciones" => $fila['observaciones'],
                "esenarioAdministracion" => $fila['administrado_durante'],
                "costoTotal" => $fila['costo_total']
            ];
        }

    }
 
    $stmt->close();
}
?>

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
<!-- 
            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="registrosDeEmergencias.php">Registros de Emergencias</a>
            </li>

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="#">Hospitalizacion</a>
            </li> -->

            <li class="sidebar__item">
                <span class="material-symbols-outlined">notifications</span>
                <a href="gestionMedicamentos.php">Gestion Medicamentos</a>
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

    <main id="contenedorCentralRegistros">

        <div class="DatosGeneralesEmerg">

            <div class='headAreas'>
                
                    <h2 class='titulosAreas'>Datos de la Hospitalizacion</h2>

            </div>

            <div class='bodyDeCuadro'>

            
                <div class='contendorInfo'>


                    <p><strong>id Hospitalizacion:</strong> <span id="idDeHosp"><?php echo htmlspecialchars($datosHospitalizacion['idRegistroHosp']); ?></span></p>
                    <p><strong>id Emergencia:</strong> <span id="idEmergencia"><?php echo htmlspecialchars($datosHospitalizacion['idDeEmergencia']); ?></span></p>

                    <p><strong>Paciente:</strong> <span id="paciente"><?php echo htmlspecialchars($datosHospitalizacion['nombrePaciente']); ?></span></p>
                    <p><strong>Medico responsable:</strong> <span id="medicoResponsable"><?php echo htmlspecialchars($datosHospitalizacion['nombreMedico']); ?></span></p>
                    <p><strong>Enfermero:</strong> <span id="enfermero"><?php echo  htmlspecialchars($datosHospitalizacion['nombreEnfermero']);?></span></p>

                    <p><strong>Fecha de Ingreso:</strong> <span id="fechaIngreso"> <?php echo  htmlspecialchars($datosHospitalizacion['fechaIngreso']);?> </span></p>
                    <p><strong>Fecha de Alta</strong> <span id="fechaAlta"> <?php echo !empty($datosHospitalizacion['fechaAltaMedica']) ? htmlspecialchars($datosHospitalizacion['fechaAltaMedica']) : "Pendiente"; ?> </span></p>
                    

                    
                
                    <?php
                        // Verificar el estado de la hospitalización
                        $estadoEmergencia = $datosHospitalizacion['estadoHosp'];
                        $deshabilitar = ($estadoEmergencia === 'Finalizado') ? 'disabled title="No se pueden editar registros finalizados."' : '';
                        ?>
                

                    
                        <button id="actualizarDatosHosp" class="btnNewRegistros" <?php echo $deshabilitar; ?>>
                            Actualizar Datos
                        </button>
                </div>

                <div class='contendorInfo'>

                    <p ><strong>Tipo de Habitacion:</strong> <span id="tipoHabitacion"><?php echo  htmlspecialchars($datosHospitalizacion['tipoHabitacion']);?></span></p>

                    <div class='contenedorObservaciones'>

                        <p ><strong>observaciones:</strong> <span id="textoObservaciones"> <?php echo !empty($datosHospitalizacion['observacionesHosp']) ? htmlspecialchars($datosHospitalizacion['observacionesHosp']) : "Pendiente"; ?> </span></p>

                    </div>

                    <p id="pFechaHosp"><strong>Numero de cama:</strong> <span id="numeroHabitacion"> <?php echo  htmlspecialchars($datosHospitalizacion['numeroDeCama']);?> </span></p>
                    <p id="pGravedadHosp"><strong>Costo por dia</strong> <span id=""> $<?php echo  htmlspecialchars($datosHospitalizacion['costoPorDia']);?></span></p>
                    <p id="pEstadoHosp"><strong>Estado de Hospitalizacion:</strong> <span id="estado"> <?php echo  htmlspecialchars($datosHospitalizacion['estadoHosp']);?> </span></p>

                </div>
            </div>
            
        </div>

        <div  class="espaciosDeRegistros">

            <div class="areaDeMedicamentos">


                <div class='headAreas'>
                
                    <h2 class='titulosAreas'>Medicamentos</h2>

                     <?php
                            if ($estadoEmergencia == 'Finalizado') {
                                // Si la emergencia está finalizada, mostrar "No"
                                echo '<button id="addMedicina" class="btnNewRegistros" style="display: none;">Agregar Medicamento </button>';
                            } else {
                                // Si la emergencia no ha finalizado, mostrar el botón
                                echo '<button id="addMedicina" class="btnNewRegistros">Agregar Medicamento</button>';
                            }
                        ?>

                </div>

                <div class='bodyDeCuadro'>
                    <?php if (!empty($medicamentos)): ?>
                        <table class='tablasEmergencias'>
                            <thead>
                                <tr>
                                    <th>Medicamento</th>
                                    <th>Presentación</th>
                                    <th>Dosis</th>
                                    <th>Observaciones</th>
                                    <th>Costo Total</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="tablaMedicamentos">
                                <?php
                                $medicamentosIdUnicos = []; // Almacena solo servicios con IDs únicos

                                // foreach ($medicamentos as $medUni) {
                                //     if (!in_array($medUni['medicamento_emergencia_id'], array_column($medicamentosIdUnicos, 'medicamento_emergencia_id'))) {
                                //         $medicamentosIdUnicos[] = $medUni;
                                //     }
                                // }

                                foreach ($medicamentos as $medUni) {
                                    // Verifica si el medicamento no está repetido y si es de tipo 'Emergencia'
                                    if (
                                        !in_array($medUni['medicamento_emergencia_id'], array_column($medicamentosIdUnicos, 'medicamento_emergencia_id')) 
                                        && $medUni['esenarioAdministracion'] === 'Hospitalizacion'
                                    ) {
                                        $medicamentosIdUnicos[] = $medUni;
                                    }
                                }

                                ?>
                                <?php foreach ($medicamentosIdUnicos as $med): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($med['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($med['presentacion']); ?></td>
                                        <td><?php echo htmlspecialchars($med['dosis']); ?></td>
                                        <td><?php echo htmlspecialchars($med['observaciones']); ?></td>
                                        <td><?php echo htmlspecialchars($med['costoTotal']); ?></td>
                                       <td> 
                                            <form id="formEliminar" action="manejo_emergencia/registrosHospitalizacion.php" method="POST">
                                                <input id="esenarioAplicacion" type="hidden" name="AdministradoDurante" value="Hospitalizacion">
                                                <input type="hidden" name="idEmergencia" value="<?php echo $idEmergencia; ?>">
                                                <input type="hidden" name="id" value="<?php echo $med['medicamento_emergencia_id']; ?>">

                                                <button type="submit" name="eliminarMedicamento" class="deleteMed"
                                                    <?php echo ($estadoEmergencia === 'Finalizado') ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''; ?>>
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <p>No se administraron medicamentos.</p>
                        <?php endif; ?>
                </div>
            </div>

            <div class="areaDeServicios">
                
                <div class='headAreas'>
                
                    <h2 class='titulosAreas'>Servicios</h2>

                        <?php
                            if ($estadoEmergencia == 'Finalizado') {
                                // Si la emergencia está finalizada, mostrar "No"
                                echo '<button id="addServicio" class="btnNewRegistros" style="display: none;">Agregar Servicio</button>';
                            } else {
                                // Si la emergencia no ha finalizado, mostrar el botón
                                echo '<button id="addServicio" class="btnNewRegistros">Agregar Servicio</button>';
                            }
                        ?>

                </div>

                <div class='bodyDeCuadro'>
                    <?php 
                    $selectServicios = "SELECT sm.*, s.nombre_servicio FROM servicios_emergencia sm 
                                        LEFT JOIN servicios s ON sm.servicio_id = s.id_servicio 
                                        WHERE sm.administrado_durante = 'Hospitalizacion' AND emergencia_medica_id = $idEmergencia";
                    $resultSelect = mysqli_query($conexion, $selectServicios);
                    ?>

                    <?php if (mysqli_num_rows($resultSelect) > 0): ?>
                        <table class='tablasEmergencias'>
                            <thead>
                                <tr>
                                    <th>id_servicio</th>
                                    <th>Nombre</th>
                                    <th>descripcion</th>
                                    <th>fecha</th>
                                    <th>Costo Total</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="tablaMedicamentos">
                                <?php while ($fila = $resultSelect->fetch_assoc()): 
                                    $id_servicio_unico = $fila['servicio_emergencia_id'];
                                    $id_servicio = $fila['servicio_id'];
                                    $nombreServicio = $fila['nombre_servicio'];
                                    $descripcion = $fila['descripcion'];
                                    $costo = $fila['costo'];
                                    $fecha_servicio = $fila['fecha_servicio'];
                                ?>
                                    <tr>
                                        <td><?php echo $id_servicio ?></td>
                                        <td><?php echo $nombreServicio ?></td>
                                        <td><?php echo $descripcion ?></td>
                                        <td><?php echo $fecha_servicio ?></td>
                                        <td><?php echo $costo ?></td>
                                        <td> 
                                            <form id='formEliminar' action='manejo_emergencia/registrosHospitalizacion.php' method='POST'>
                                                <input type='hidden' name='AdministradoDurante' value='Hospitalizacion'>
                                                <input type='hidden' name='idEmergencia' value='<?php echo $idEmergencia; ?>'>
                                                <input type='hidden' name='id' value='<?php echo $id_servicio_unico; ?>'>
                                                <button type='submit' name='eliminarServicio' class='deleteMed'
                                                    <?php echo ($estadoEmergencia === 'Finalizado') ? "disabled style='opacity: 0.5; cursor: not-allowed;'" : ""; ?>>
                                                    <span class='material-symbols-outlined'>delete</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No se solicitaron servicios.</p>
                    <?php endif; ?>
                </div>

                
            </div>
        


    </main>


        <dialog id="DialogNewMedicamentos" class="dialogRegistrosNew">

            <div class="headerModel"> 
                
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>
            </div>

            <div id="RegistroUsuarioNew" class="dialogRegistros">

                <h2>Ingresar Medicamentos</h2>
                    <form action="manejo_emergencia/registrosDatos.php"  method="post">

                        <input id ="idEmergencia" type="hidden" name="idEmergencia" value="<?php echo $idEmergencia  ?>">

                        <input id ="esenarioAplicacion" type="hidden" name="AdministradoDurante" value="Hospitalizacion">

                        <label for="nombre">categoria de medicamento</label>
                        <select name="NombreCtegoria" id="categoriaMedicamento" class="selectMedicamento" required>
                            <option value="">Elija la categoria</option>
                            <?php 
                            
                            $getClasificacion = "SELECT DISTINCT clasificacion FROM medicamentos WHERE clasificacion IS NOT NULL AND clasificacion != ''";
                            $clasificacionGet = mysqli_query($conexion, $getClasificacion);

                            while($datos= $clasificacionGet->fetch_assoc()){ ?>

                                <option value="<?php echo $datos['clasificacion'] ?>"><?php echo $datos['clasificacion'] ?></option>

                                <?php
                            }

                            ?>
                        </select><br>

                        <label for="nombre">Medicamento Administrado</label>
                        <select name="idMedicamento" id="selectMedicamento" class="selectMedicamento" required>
                            <option value="">Elija el medicamento</option>
                            <?php 
                            
                            $getMedicamento = "SELECT medicamento_id, nombre_medicamento FROM medicamentos";
                            $resultadoGet = mysqli_query($conexion, $getMedicamento);

                            while($datos= $resultadoGet->fetch_assoc()){ ?>

                                <option value="<?php echo $datos['medicamento_id'] ?>"><?php echo $datos['nombre_medicamento'] ?></option>

                                <?php
                            }

                            ?>
                        </select><br>
                        


                        <label for="dosis">Dosis</label>
                        <input id="dosis" type="number" placeholder="Dosis Administrada" class="dosis" name="dosisAdministrada" min="0" required><br>

                        <label for="Presentacion">Presentacion de Medicamento</label>
                        <select name="presentacionMed" id="presentacion" id="categoriaMedicamento" class="selectMedicamento" required>
                                <option value="">Presentacion</option>
                                <option value="Tableta">Tableta</option>
                                <option value="Ampolla">Ampolla</option>
                                <option value="Jarabe">Jarabe</option>
                                <option value="Solución Inyectable">Solución Inyectable</option>
                                <option value="Crema">Crema</option>
                                <option value="Ampolla">Ampolla</option>
                                <option value="Otros">Otros</option>

                        </select><br>

                        <label for="observaciones">Observaciones</label>
                        <input id="observaciones" type="text" placeholder="observaciones" name="observaciones" required>

                        <button type="submit" class="botonRegistroDual" id="botonRegistrarMed" name="registroDeMedicamento">Registrar</button>
                    </form>
            </div>

        </dialog>

        <dialog id="DialogNewServicio" class="dialogRegistrosNew">

            <div class="headerModel"> 
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>
            </div>

                <div id="RegistroUsuarioNew">

                    <h2>Ingresar Servicio</h2>
                    <form action="manejo_emergencia/registrosDatos.php"  method="post">

                        <input id ="idEmergencia" type="hidden" name="idEmergencia" value="<?php echo $idEmergencia ?>">

                        <input id ="esenarioAplicacion" type="hidden" name="AdministradoDurante" value="Hospitalizacion">

                        <label for="nombre">Servicio Prestado</label>
                        <select name="idServicio" id="selectServ" class='selectMedicamento' required>
                            <option value="">Seleccione el servicio</option>
                            <?php 
                            
                            $getServicio = "SELECT id_servicio, nombre_servicio FROM servicios";
                            $resultadoServ = mysqli_query($conexion, $getServicio);

                            if($resultadoServ){

                                while($datos= $resultadoServ->fetch_assoc()){ ?>

                                    <option value="<?php echo $datos['id_servicio'] ?>"><?php echo $datos['nombre_servicio'] ?></option>

                                    <?php
                                }
                            }else{ ?>
                                <p>No se incluyo el uso de Servicios</p>
                            
                             <?php
                            }
                            ?>
                        </select><br>

                        <label for="dosis">Descripcion</label>
                        <input id="descripcion" type="text" placeholder="Descripcion" class="descripciones" name="descripcionServicio" required><br>

                        <label for="fechaDeregisto">Fecha y Hora</label>
                        <input id="Fecha" type="datetime-local" name="fechaDeRegisto" required><br>

                        <button type="submit" class="botonRegistroDual" id="botonRegistrarMed" name="registroDeServicio">Registrar</button>
                    </form>

                </div>

        </dialog>


    <dialog id="DialogActualizarEmerg" class="dialogRegistrosNew">

            <div class="headerModel"> 
                <form method="dialog">
                <button class="ModalClose">X</button>
                </form>
            </div>

        <div id="RegistroUsuarioNew">

            <h2>Actualizar Datos Hospitalizacion</h2>
                <form action="manejo_emergencia/modificarRegistro.php"  method="post" id='formDatosHospitalizacion'>

                    <input id ="idEmergencia"  type="hidden" name="idEmergencia" value="<?php echo $idEmergencia?>">

                    <input type="hidden" id="fechaIngresoEdit" value="<?php echo date('Y-m-d\TH:i', strtotime($datosHospitalizacion['fechaIngreso'])); ?>">

                    <label for="diagnostico">Observaciones</label>
                    <input type="text" id="observacionesHosp" class='requerido' placeholder="Observaciones" name ="observacionesDeHosp">

                    <label for="FechaAlta">Fecha De Alta</label>
                    <input id="FechaAltaEdit" class='requerido' type="datetime-local" name="fechaAltaMedica"><br>

                    <label for="estadoDeHospitalizacion">Estado de Hospitalizacion</label>
                    <select name="estadoActualHosp" id="estadoDeHospitalizacion" class='selectMedicamento requerido' >
                        <option value=" ">Selecciona Estado</option>
                        <option value="En proceso">En Proceso</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                    <p>Nota: Una vez que se marca la hospitalización como finalizada, la factura correspondiente se genera automáticamente. </p>

                    <button type="submit" class="botonRegistroDual" id="botonRegistrarMed" name="ActualizarHosp">Actualizar Datos</button>
                    <p id="mensajeError" class="mensaje-error" style="color:red;"></p>
                </form>

        </div>

    </dialog>



    <script>

            document.addEventListener("DOMContentLoaded", function () {
                const form = document.getElementById("formDatosHospitalizacion");
                const mensajeError = document.getElementById("mensajeError");

                form.addEventListener("submit", function (e) {
                    mensajeError.textContent = ""; // Limpiar mensajes anteriores

                    const camposRequeridos = form.querySelectorAll(".requerido");
                    const fechaAlta = document.getElementById("FechaAltaEdit").value;
                    const fechaIngreso = document.getElementById("fechaIngresoEdit").value;

                    let camposIncompletos = false;

                    camposRequeridos.forEach(function (campo) {
                        if (!campo.value.trim()) {
                            camposIncompletos = true;
                            campo.classList.add("campo-invalido");
                        } else {
                            campo.classList.remove("campo-invalido");
                        }
                    });

                    if (camposIncompletos) {
                        mensajeError.textContent = "Por favor completa todos los campos requeridos.";
                        e.preventDefault();
                        return;
                    }

                    if (!fechaAlta) {
                        mensajeError.textContent = "Por favor ingresa la fecha de alta.";
                        e.preventDefault();
                        return;
                    }

                    if (new Date(fechaAlta) < new Date(fechaIngreso)) {
                        mensajeError.textContent = "La fecha de alta no puede ser anterior a la fecha de ingreso.";
                        e.preventDefault();
                        return;
                    }

                    const ahora = new Date();
                    const fechaMaxima = new Date();
                    fechaMaxima.setDate(ahora.getDate() + 1);
                    fechaMaxima.setHours(0, 0, 0, 0);

                    const fechaAltaDate = new Date(fechaAlta);

                    if (fechaAltaDate > fechaMaxima) {
                        mensajeError.textContent = "La fecha de alta no puede estar más allá del día siguiente.";
                        e.preventDefault();
                        return;
                    }
                });
            });


            document.addEventListener("DOMContentLoaded", function() {
                // Obtener el campo de especialidades y médicos
                var clasificacionMed = document.getElementById('categoriaMedicamento');
                var medicamentoSelect = document.getElementById('selectMedicamento');

                // Cuando se cambia la categoria
                clasificacionMed.addEventListener('change', function() {
                var clasificacionNombre = clasificacionMed.value;

                if (clasificacionNombre) {
                    // Usar fetch para hacer la solicitud
                    fetch('manejo_emergencia/obtenerMedicamentos.php?clasificacion_id=' + clasificacionNombre)
                    .then(response => response.json())  // Procesamos la respuesta como JSON
                    .then(data => {
                        // Limpiamos el select de médicos
                        medicamentoSelect.innerHTML = '';

                        // Si hay médicos, los agregamos al select
                        if (data.length > 0) {
                            // Crear un primer option para "Seleccionar un médico"
                            var defaultOption = document.createElement('option');
                            defaultOption.value = '';
                            defaultOption.textContent = 'Selecciona un medicamento';
                            medicamentoSelect.appendChild(defaultOption);

                            // Crear opciones para cada médico
                            data.forEach(function(medicamento) {
                                var option = document.createElement('option');
                                option.value = medicamento.id_medicamento;  // El valor será el id del médico
                                option.textContent = medicamento.nombre  // El texto visible será el nombre del médico
                                option.id = medicamento.nombre
                                medicamentoSelect.appendChild(option);
                            });
                        } else {
                            // Si no hay médicos, agregar una opción indicando que no hay disponibles
                            var noDoctorsOption = document.createElement('option');
                            noDoctorsOption.value = '';
                            noDoctorsOption.textContent = 'No hay médicos disponibles';
                            medicamentoSelect.appendChild(noDoctorsOption);
                        }
                    })
                    .catch(error => {
                        console.error("Error al cargar los médicos:", error);
                    });
                } else {
                    // Si no se seleccionó especialidad, limpiar el select de médicos
                    medicamentoSelect.innerHTML = '<option value="">Selecciona un medicamento</option>';
                }
            });
            });



        const btnNuevoMedicamento = document.getElementById("addMedicina");
                if (btnNuevoMedicamento !== null) {
                
                    btnNuevoMedicamento.addEventListener("click", openNewMedicameto)

                }

            function openNewMedicameto(){

                const dialog = document.getElementById("DialogNewMedicamentos");
                dialog.showModal(); 

            }


            const btnNuevaHospitalizacion = document.getElementById("addServicio");
            btnNuevaHospitalizacion.addEventListener("click", openNewHops)

            function openNewHops(){

                const dialog = document.getElementById("DialogNewServicio");
                dialog.showModal(); 

            }

            const btnActualizar = document.getElementById("actualizarDatosHosp");
            btnActualizar.addEventListener("click", openModalEdit)

            function openModalEdit(){

                let textoActual = document.getElementById("textoObservaciones").innerText;

                document.getElementById("observacionesHosp").value = textoActual;



                const dialog = document.getElementById("DialogActualizarEmerg");
                dialog.showModal(); 

            }

    </script>
</body>
</html>