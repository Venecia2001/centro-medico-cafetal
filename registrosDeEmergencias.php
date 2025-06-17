<?php 

session_start(); // Iniciar sesión para recuperar el mensaje de error

include("conex_bd.php");

if(!empty($_GET["id"])) {

    $idEmergencia = $_GET['id'];

    $consultaEmergenciaMed = "SELECT
    em.id_emergencia, 
    em.tipo_emergencia,
    em.id_paciente,
    em.id_paciente_temp,
    em.fecha_emergencia,
    em.diagnostico,
    em.descripcion,
    em.gravedad,
    em.estado_emergencia,
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
    me.costo_total,
    -- Servicios médicos realizados en la emergencia
    se.servicio_emergencia_id,
    s.id_servicio,
    s.nombre_servicio,
    se.descripcion AS descripcion_servicio,
    se.costo AS costo_servicio,
    se.fecha_servicio
FROM emergencias_medicas em
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
-- Servicios médicos realizados durante la emergencia
LEFT JOIN servicios_emergencia se ON em.id_emergencia = se.emergencia_medica_id
LEFT JOIN servicios s ON se.servicio_id = s.id_servicio
WHERE em.id_emergencia = ?";

    $stmt = $conexion->prepare($consultaEmergenciaMed);
    $stmt->bind_param("i", $idEmergencia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $medicamentos = [];
    $servicios = [];
    $datosEmergencia = null;

    while ($fila = $resultado->fetch_assoc()) {
        // Si $datosEmergencia es null, almacena los datos generales de la emergencia
        if ($datosEmergencia === null) {
            $datosEmergencia = [
                "idDeEmergencia" => $fila['id_emergencia'],
                "tipoEmergencia" => $fila['tipo_emergencia'],
                "idPaciente" => $fila['id_paciente'],
                "fechaEmergencia" => $fila['fecha_emergencia'],
                "diagnostico" => $fila['diagnostico'],
                "descripcion" => $fila['descripcion'],
                "gravedad" => $fila['gravedad'],
                "estadoEmergencia" => $fila['estado_emergencia'],
                "nombrePaciente" => $fila['paciente_registrado'] ?: $fila['paciente_temporal'],
                "nombreMedico" => $fila['nombre_medico'] . " " . $fila['apellido_medico'],
                "nombreEnfermero" => $fila['nombre_enfermero'] . " " . $fila['apellido_enfermero']
            ];
        }

        // Almacenar cada medicamento administrado en un array
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

        if (!empty($fila['nombre_servicio'])) {
            $servicios[] = [
                "servicio_emergencia_id" => $fila['servicio_emergencia_id'],
                "nombreServ" => $fila['nombre_servicio'],
                "descripcion" => $fila['descripcion_servicio'],
                "costo" => $fila['costo_servicio'],
                "id_servicio" => $fila['id_servicio'],
                "fecha_servicio" => $fila['fecha_servicio']
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
                        <img src="imagenes/barsita.jpg" alt="doctor" width="120px">
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
                
                <h2 class='titulosAreas' >Datos de la Emergencia</h2>
            </div>

            <div class='bodyDeCuadro'>


                <div class='contendorInfo'>

                    <p><strong>Id Emergencia:</strong> <span id="idEmergencia"><?php echo htmlspecialchars($datosEmergencia['idDeEmergencia']); ?></span></p>
                    <p><strong>Paciente:</strong> <span id="paciente"><?php echo htmlspecialchars($datosEmergencia['nombrePaciente']); ?></span></p>
                    <p><strong>Medico responsable:</strong> <span id="medicoResponsable"><?php echo htmlspecialchars($datosEmergencia['nombreMedico']); ?></span></p>
                    <p><strong>Enfermero:</strong> <span id="enfermero"><?php echo  htmlspecialchars($datosEmergencia['nombreEnfermero']);?></span></p>
                    <p><strong>Tipo Emergencia:</strong> <span id="emergenciaTipo"><?php echo htmlspecialchars($datosEmergencia['tipoEmergencia']); ?></span></p>

                    <div class='contenedorObservaciones'>
                        <p><strong>Descripcion</strong> <span id="descripcionMostrar"><?php echo htmlspecialchars($datosEmergencia['descripcion']); ?></span></p>
                    </div>           

                        <?php
                            // Verificar el estado de la emergencia
                            $estadoEmergencia = $datosEmergencia['estadoEmergencia'];
                        ?>

                    <?php 
                    
                    $consultaHospitalizacion = "SELECT COUNT(*) AS total FROM hospitalizacion WHERE emergencia_medica_id = '$idEmergencia'";
                    $resultado = mysqli_query($conexion, $consultaHospitalizacion);

                    if ($resultado) {
                        $fila = mysqli_fetch_assoc($resultado);
                        $hayHospitalizacion = $fila['total'] > 0; // Si el total es mayor a 0, hay hospitalización
                    } else {
                        $hayHospitalizacion = false; // En caso de error en la consulta
                    }

                    // Mostrar el botón adecuado según si hay hospitalización o no
                    if ($hayHospitalizacion): ?>
                        <a href="registrosHospitalizacion.php?id=<?php echo $idEmergencia; ?>" class="btnEnlace">Datos de Hospitalización</a>
                    <?php else: ?>

                        <p><strong>Requiere Hospitalización:</strong> 
                            <?php
                                $debeOcultarse = ($estadoEmergencia == 'Finalizado') ? 'style="display: none;"' : '';
                                ?>

                                <p><strong>Requiere Hospitalización:</strong> 
                                    <span id="hospitalizacionSioNo">
                                        <button id="btnDialogHospitalizacion" <?php echo $debeOcultarse; ?>>Registrar Hospitalización</button>
                                    </span>
                                </p>
                        </p>

                    <?php endif; ?>

                    
                                
                    <?php
                        
                        if (isset($_SESSION['errorMensaje'])) {
                            echo '<div class="mensajeError">' . $_SESSION['errorMensaje'] . '</div>';
                            unset($_SESSION['errorMensaje']); // Eliminar el mensaje después de mostrarlo
                        }
                    ?>

                    <?php 

                        if (isset($_SESSION['mensajeExito'])) {
                            echo "<div class='mensajeExito'> style='color: green; font-weight: bold;'>" . $_SESSION['mensajeExito'] . "</div>";
                            unset($_SESSION['mensajeExito']); // Eliminar la variable de sesión después de mostrarla
                        }

                    
                    ?>


                </div>

                <div class='contendorInfo'>
                    
                    <p id="pFecha"><strong>Fecha:</strong> <span id="fechaEmergencia"><?php echo htmlspecialchars($datosEmergencia['fechaEmergencia']); ?></span></p>
                    <p id="pGravedad"><strong>Gravedad</strong> <span id="gravedadEmergencia"><?php echo htmlspecialchars($datosEmergencia['gravedad']);?></span></p>
                    <p id="pEstado"><strong>Estado de Emergencia:</strong> <span id="estadoEmerg"><?php echo htmlspecialchars($datosEmergencia['estadoEmergencia']); ?></span></p>

                    <div id="pDiagnostico">
                        <p><strong>Diagnóstico:</strong> <span id="mostrarDiagnostico"><?php echo htmlspecialchars($datosEmergencia['diagnostico']); ?></span></p>

                    </div>

                    <form id="form_editar_<?php echo $datosEmergencia['idDeEmergencia']; ?>" action="manejo_emergencia/modificarRegistro.php" method="POST" style="display:inline;">
                        <input type="hidden" name="idEditar" value="<?php echo $datosEmergencia['idDeEmergencia']; ?>">
                        <button type="button" class="btnActualizar" onclick="enviarFormulario(<?php echo $datosEmergencia['idDeEmergencia']; ?>)">Actualizar Datos</button>
                    </form>
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
                                 echo '<button id="addMedicina" class="btnNewRegistros" style="display: none;">Agregar Medicamento</button>';
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
                                        && $medUni['esenarioAdministracion'] === 'Emergencia'
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

                    <?php if (!empty($servicios)): ?>
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
                            <?php
                            $serviciosUnicos = []; // Almacena solo servicios con IDs únicos

                            foreach ($servicios as $servUni) {
                                if (!in_array($servUni['servicio_emergencia_id'], array_column($serviciosUnicos, 'servicio_emergencia_id'))) {
                                    $serviciosUnicos[] = $servUni;
                                }
                            }
                            ?>
                                <?php foreach ($serviciosUnicos  as $serv): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($serv['id_servicio']); ?></td>
                                        <td><?php echo htmlspecialchars($serv['nombreServ']); ?></td>
                                        <td><?php echo htmlspecialchars($serv['descripcion']); ?></td>
                                        <td><?php echo htmlspecialchars($serv['fecha_servicio']); ?></td>
                                        <td><?php echo htmlspecialchars($serv['costo']); ?></td>
                                        <td>
                                            <form id="formEliminar" action="manejo_emergencia/registrosHospitalizacion.php" method="POST">
                                                <input type="hidden" name="idEmergencia" value="<?php echo $idEmergencia; ?>">
                                                <input type="hidden" name="id" value="<?php echo $serv['servicio_emergencia_id']; ?>">
                                                
                                                <button type="submit" name="eliminarServicio" class="deleteMed"
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
                            <p>No se incluyo el uso de Servicios</p>
                        <?php endif; ?>
                </div>
                
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

                            <input id ="esenarioAplicacion" type="hidden" name="AdministradoDurante" value="Emergencia">

                            <label for="nombre">categoria de medicamento</label>
                            <select name="NombreCtegoria" id="categoriaMedicamento" class='selectMedicamento' required>
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
                            <select name="idMedicamento" id="selectMedicamento" class='selectMedicamento' required>
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
                            <select name="presentacionMed" id="presentacion" class='selectMedicamento' required> 
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

                            <button type="submit" class="botonRegistroDual" id="botonRegistrarMedicamento" name="registroDeMedicamento">Registrar</button>
                        </form>

                    <span class="resultado"></span>

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

                    <input id ="idEmergencia" type="hidden" name="idEmergencia" value="<?php echo $idEmergencia  ?>">

                    <input id ="esenarioAplicacion" type="hidden" name="AdministradoDurante" value="Emergencia">


                    <label for="nombre">Servicio Prestado</label>
                    <select name="idServicio" id="selectServ" class='selectMedicamento' required>
                        <option value="">Seleccione el servicio</option>
                        <?php 
                        
                        $getServicio = "SELECT id_servicio, nombre_servicio FROM servicios";
                        $resultadoServ = mysqli_query($conexion, $getServicio);

                        while($datos= $resultadoServ->fetch_assoc()){ ?>

                            <option value="<?php echo $datos['id_servicio'] ?>"><?php echo $datos['nombre_servicio'] ?></option>

                            <?php
                        }
                        ?>
                    </select><br>

                    <label for="dosis">Descripcion</label>
                    <input id="descripcion" type="text" placeholder="Descripcion" class="descripciones" name="descripcionServicio" required><br>

                    <label for="fechaDeregisto">Fecha y Hora</label>
                    <input id="Fecha" type="datetime-local" name="fechaDeRegisto" required><br>

                    <button type="submit" class="botonRegistroDual" id="botonRegistrarServicio" name="registroDeServicio">Registrar</button>
                </form>

        </div>

    </dialog>

    <dialog id="DialogActualizarEmerg" class="dialogRegistrosNew">

            <div class="headerModel"> 
                <form method="dialog">
                <button class="ModalClose"> X</button>
                </form>
            </div>

        <div id="RegistroUsuarioNew">

            <h2>Actualizar Datos</h2>
                <form action="manejo_emergencia/modificarRegistro.php"  method="post" id='formEditEmergencia'>

                    <input id ="idEmergencia" type="hidden" name="idEmergencia" value="<?php echo $idEmergencia  ?>">
<!-- 
                    <label for="diagnostico">Diagnostico</label>
                    <input type="text" id="dianosticoAct" placeholder="Diagnostico" name ="posibleDiagnostico"> -->

                    <label for="diagnostico">Diagnóstico:</label>
                    <textarea id="dianosticoAct" name="posibleDiagnostico" rows="4" cols="50" placeholder="Ingrese el diagnóstico aquí..."></textarea>

                    <label for="descripcion">Descripcion</label>
                    <input id="descripcionEdit" type="text" placeholder="Descripcion" name="descripcionAct"><br>

                    <label for="fechaDeregisto">Estado de Emergencia</label>
                    <select name="estadoActual" id="selecRegistro">
                        <option value="En proceso">En Proceso</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                    <p>Nota: Al momento de seleccionar la emergencia como finaliza se genera la factura correspodiente automaticamente </p>

                    <button type="submit" class="botonRegistroDual" id="btnActualizarEmerg" name="ActualizarEmergencia">Actualizar</button>
                </form>

        </div>

    </dialog>

    <dialog id="DialogNewHosp" class="dialogRegistrosNew">

        <div class="headerModel"> 
            <form method="dialog">
            <button class="ModalClose"> X</button>
            </form>
        </div>

        <div id="RegistroUsuarioNew">

            <h2>Registrar Hospitalizacion</h2>
            <form action="manejo_emergencia/registrosDatos.php"  method="post" id='formHosp'>

                <input id ="idEmergencia" type="hidden" name="idEmergencia" value="<?php echo $idEmergencia?>">

                <!-- <label for="FechaDeIngreso">Fecha De Ingreso</label>
                <input type="date" id="fechaHosp" name ="fechaInicioHosp" required> -->

                <label for="tipoDeHabitacion">Tipo de Habitacion</label>
                <select name="tipoDeHacitacion" id="selectHabitacion" required>
                    <option value="">Seleccione Habitacion</option>
                    <option value="General">General</option>
                    <option value="Privada">Privada</option>
                    <option value="UCI">UCI</option>
                </select> <br><br>

                <label for="nCama">Numero De Cama</label>
                <input type="text" id="nCama" name ="numeroCama" required>

                <label for="obsevaciones">Obsevaciones</label>
                <input type="text" id="obsevaciones" name ="observacionesDeHosp" required>

                <div id="message" style="display: none;"></div>

                <button type="submit" class="botonRegistroDual" id="btnNewHosp" name="registrarHospitalizacion">Registrar Hospitalizacion</button>
            </form>

        </div>

    </dialog>



    <script>

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
            btnNuevoMedicamento.addEventListener("click", openNewMedicameto)

            function openNewMedicameto(){

                const dialog = document.getElementById("DialogNewMedicamentos");
                dialog.showModal(); 

            }

            const btnNuevoServicio = document.getElementById("addServicio");
            btnNuevoServicio.addEventListener("click", openNewServicios)

            function openNewServicios(){

                const dialog = document.getElementById("DialogNewServicio");
                dialog.showModal(); 

            }

            // const btnNuevaHospitalizacion = document.getElementById("btnDialogHospitalizacion");
            const btnNuewHops = document.getElementById('btnDialogHospitalizacion');
            if (btnNuewHops !== null) {
            
                btnNuewHops.addEventListener("click", openNewHops)

            }
            function openNewHops(){

                const dialog = document.getElementById("DialogNewHosp");
                dialog.showModal(); 

            }

            function enviarFormulario(id) {
                var inputId = document.querySelector(`#form_editar_${id} input[name='idEditar']`).value;

                console.log(inputId);

                // Realizamos la solicitud con fetch
                fetch('manejo_emergencia/modificarRegistro.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `idEmergencia=${encodeURIComponent(inputId)}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud AJAX');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        console.log(data);

                        // Asignamos los valores a los inputs
                        const diagnosticoInput = document.getElementById('dianosticoAct');
                        const descripcionInput = document.getElementById('descripcionEdit');
                        const estadoInput = document.getElementById('selecRegistro');
                        const btnActualizar = document.getElementById('btnActualizarEmerg');

                        diagnosticoInput.value = data[0].diagnostico;
                        descripcionInput.value = data[0].descripcionEmerg;
                        estadoInput.value = data[0].estadoDeEmergencia;

                        console.log(estadoInput.value.trim().toLowerCase())

                         if (estadoInput.value.trim().toLowerCase() === "finalizado") {
                            btnActualizar.disabled = true;
                            btnActualizar.classList.add('desabilitarBtn');
                            btnActualizar.title = "No se puede actualizar un registro finalizado.";
                        } else {
                            btnActualizar.disabled = false;
                            btnActualizar.title = "";
                        }

                        // Mostramos el diálogo
                        let dialogEdit = document.getElementById("DialogActualizarEmerg");
                        dialogEdit.showModal();

                        // Manejamos el envío del formulario de edición
                        document.getElementById('formEditEmergencia').addEventListener("submit", function(e) {
                            e.preventDefault();

                            // Validación simple
                            if (
                                diagnosticoInput.value === "" ||
                                descripcionInput.value === "" 
                            ) {
                                alert("Por favor completa todos los campos obligatorios.");
                                return;
                            }

                            // Aquí puedes continuar con el envío del formulario, por ejemplo usando otro fetch.
                            console.log("Formulario validado y listo para enviar.");
                            document.getElementById("formEditEmergencia").submit();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }


            const form = document.getElementById('formHosp');
            const selectHacitacion = document.getElementById('selectHabitacion');
            const numeroCamaas = document.getElementById('nCama');
            const obsevaciones = document.getElementById('obsevaciones');
            const messageDiv = document.getElementById('message');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario hasta validar

                // // Validación simple
                //     if (
                //             selectHacitacion.value === "" ||
                //             numeroCamaas.value === "" ||
                //             obsevaciones.value === "" 
                //         ) {
                //         alert("Por favor completa todos los campos obligatorios.");
                //             return;
                //     }

                const formData = new FormData(form); 
                
                fetch('manejo_emergencia/registrosDatos.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        messageDiv.style.display = 'block';
                        messageDiv.style.color = 'green';
                        messageDiv.textContent = data.message;

                        // Redirigir a la página de éxito (si es necesario)
                        window.location.href = "registrosHospitalizacion.php?id=" + data.idHosp;
                    } else {
                        messageDiv.style.display = 'block';
                        messageDiv.style.color = 'red';
                        messageDiv.textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error('Error al registrar:', error);
                });
            });



    </script>
</body>
</html>