<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>horarios</title>
    <link rel="stylesheet" href="interfazAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>

    <?php include "sideba_admin.php" ?>

    <main>

    <div class="agregarHorarios">

        <div class="cabezera">

            <h2>Añadir nuevo horarios</h2>
                    <form action="Crud_Admin/barraBusqueda.php" method="POST" id="searchForm">
                        <label for="search">Buscar:</label>
                        <input type="text" name="search" id="search" required>
                        <input type="submit" name="buscar" value="Buscar">
                    </form>
            <form action="Crud_Admin/registroHorarios_admin.php" method="post" id="formHorarios">

                <div class="medico aggEsp" id ="titulito">

                    <h2>Buscar Registro</h2>
                    
                </div>

                <div class="medico aggEsp">
                    <h2>Especialidad Medico</h2>
                    <select name="especialidad" id="specialty_id">
                                    <option value="">Seleccione la especialidad</option>
                                    <?php
                                    include "conex_bd.php";
                                            
                                    $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades`");

                                    while($datos=$sql->fetch_object()){ ?>

                                        <option value="<?php echo $datos->id_especialidad ?>"><?php echo $datos->nombre_esp?></option>

                                    <?php
                                            $selectEspecialidad = $datos->nombre_esp;
                                        } 
                                    ?>
                    </select><br>
                </div>

                <div class="medico aggNombre">
                        <h2>Nombre Medico</h2>
                        <select name="medico" id="doctor_id">
                            <option value="">Seleccione un médico</option>
                            
                        </select><br>
                </div>
                <div class="medico aggDiaSemana">
                        <h2>dia disponible</h2>
                        <select name="dia" id="diaSemana">
                            <option value="">Seleciona un dia</option>
                            <option value="1">Lunes</option>
                            <option value="2">Martes</option>
                            <option value="3">Miercoles</option>
                            <option value="4">Jueves</option>
                            <option value="5">Viernes</option>
                            <option value="6">Sabado</option>
                            <option value="7">Domingo</option>
                        </select>

                        
                </div>
                <div class="medico aggHoraInicio">
                        <h2>Ininio de Turno</h2>
                        <select name="comienzoTurno" id="horaC">
                        <option value="">Comienzo de turno</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                        </select>
                </div>

                <div class="medico aggHoraFin">
                        <h2>fin de turno</h2>
                        <select name="finTurno" id="horaF">
                        <option value="">Final de Turno</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                        </select>
                </div>

                <div class="medico btnRegistrar">
                
                    <input type="submit" name="registroHoras" id="submit_button">
                    <p id="mensajeAlert"></p>
                
                </div>

            </form>

        </div>

        <table>
            <thead>
                <th>id Horario</th>
                <th>Nombres Especialista</th>
                <th>Apellido</th>
                <th>Dia Disponible</th>
                <th>Inicio De turno</th>
                <th>Fin de turno</th>
                <th>estado_disponibilidad</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </thead>
            <tbody id="cuerpoTabla">
                  <?php 
                  
                  $getDatos = "SELECT dh.*, us.nombre, us.apellido FROM disponibilidad_horarios dh JOIN medicos m ON dh.medico_relac = m.id_perfil LEFT JOIN usuarios us ON m.id_medico = us.id";
                  $resultDatos = mysqli_query($conexion,$getDatos);
                  
                  while($fila = $resultDatos->fetch_array()){

                    $idHorario = $fila["id_disponibilidad"];
                    $nombreMed = $fila['nombre'];
                    $apellidoMed = $fila['apellido'];
                    $diaSemana = $fila['dia_semana'];
                    $horaInicio = $fila["hora_inicio"];
                    $horaFin = $fila["hora_fin"];
                    $estado_dis = $fila['estado_disponibilidad']
                   
                    ?>

                    <tr>
                        <td> <?php echo $idHorario; ?></td>
                        <td><?php echo $nombreMed; ?></td>
                        <td><?php echo $apellidoMed; ?></td>

                        <td><?php switch ($diaSemana) {
                                    case 1:
                                        $nombreDia = 'Lunes';
                                        break;
                                    case 2:
                                        $nombreDia = 'Martes';
                                        break;
                                    case 3:
                                        $nombreDia = 'Miércoles';
                                        break;
                                    case 4:
                                        $nombreDia = 'Jueves';
                                        break;
                                    case 5:
                                        $nombreDia = 'Viernes';
                                        break;
                                    case 6:
                                        $nombreDia = 'Sábado';
                                        break;
                                    case 7: 
                                        $nombreDia = 'Domingo';
                                        break;
                                    default:
                                        $nombreDia = 'Día no válido';
                                        break;
                            }

                        echo $nombreDia; // Imprimirá "Jueves" ?></td>

                        <td><?php echo $horaInicio; ?></td>
                        <td><?php echo $horaFin; ?></td>
                        <td><?php echo $estado_dis; ?></td>
                        <td>
                            <!-- Formulario con botón para editar -->
                            <form id="form_editar_<?php echo $idHorario; ?>" action="Crud_Admin/accionesHorarios.php" method="POST" style="display:inline;">
                                <input type="hidden" name="idEditar" value="<?php echo $idHorario; ?>">
                                <button type="button" class="linkEditar" onclick="enviarFormulario(<?php echo $idHorario; ?>)">editar</button>
                            </form>
                        </td>

                        <?php echo "<td> 
                                    
                                    <form  id='formEliminar' action='Crud_Admin/accionesHorarios.php' method ='POST'>
                                        <input type='hidden' name='id' value='".$idHorario."'>
                                         <button type='submit' name='eliminarHorario' class='deleteMed'><span class='material-symbols-outlined'> delete </span></button>
                                    </form>
                            </td>";?>
                        
                        
                    </tr>

                    <?php
                  }
                  ?>



                </tr>
                
            </tbody>
        </table>


        <dialog id="modalEdit" class = "dialogEsp">

            <h3>Formulario para Modificar</h3>

            <div class="formEditar">

                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>

                <form action="Crud_Admin/resultadoFinalCitas.php" method="POST">

                    <input type="hidden" name="idHorarios" id="idDeHorarios" value="">

                    <label for="">Especialidad</label><br>
                    <select name="especialidad" id="especialidadEdit"  class="selectForm">
                                    <option value="">Seleccione la especialidad</option>
                                    <?php
                                    include "conex_bd.php";
                                            
                                    $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades`");

                                    while($datos=$sql->fetch_object()){ ?>

                                        <option value="<?php echo $datos->id_especialidad ?>"><?php echo $datos->nombre_esp?></option>

                                    <?php
                                            $selectEspecialidad = $datos->nombre_esp;
                                        } 
                                    ?>
                    </select><br>
                    <label for="">Medico</label><br>
                    <select name="medicoEdit" id="doctor_id_edit" class="selectForm">
                        <option value="">Seleccione un médico</option>
                            
                    </select><br>
                    <label for="">Dia de la Semana</label><br>
                    <select name="diaEdit" id="diaSemanaEdit"  class="selectForm">
                        <option value="">Seleciona un dia</option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                        <option value="7">Domingo</option>
                    </select><br>

                    <label for="">Hora De Inicio</label><br>
                    <!-- <span id="mensajeEmer"></span> -->
                    <select name="comienzoTurnoEdit" id="horaComienzoEdit"  class="selectForm">
                        <option value="">Comienzo</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                    </select><br>

                    <label for="">Hora de culminacion</label><br>
                    <!-- <span id="mensajeHoraFin"></span> -->
                    <select name="finTurnoEdit" id="horaFEdit"  class="selectForm">
                        <option value="">Final de Turno</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                    </select><br>
                    <label for="">Disponibilidad de horario</label><br>
                    <select name="disponibilidadEdit" id="dispo_dia"  class="selectForm">
                        <option value="">disponinibilidad de dia</option>
                        <option value="Disponible">Disponible</option>
                        <option value="No disponible">No Disponible</option>  
                    </select><br>

                       <input type="submit" id="botonEdit" name="editHorarios" value="Confirmar Cambios" >                 
                </form>


            </div>
        </dialog>

    </div>
        
    </main>


    <script>

        document.addEventListener("DOMContentLoaded", function() {
            // Obtener el campo de especialidades y médicos
            var specialtySelect = document.getElementById('specialty_id');
            var doctorSelect = document.getElementById('doctor_id');

            // Cuando se cambia la especialidad
            specialtySelect.addEventListener('change', function() {
            var specialty_id = specialtySelect.value;

            // Si se seleccionó una especialidad
            if (specialty_id) {
                // Usar fetch para hacer la solicitud
                fetch('Crud_Admin/obtener_medicosHorarios.php?specialty_id=' + specialty_id)
                .then(response => response.json())  // Procesamos la respuesta como JSON
                .then(data => {

                    console.log(data)
                    // Limpiamos el select de médicos
                    doctorSelect.innerHTML = '';

                    // Si hay médicos, los agregamos al select
                    if (data.length > 0) {
                        // Crear un primer option para "Seleccionar un médico"
                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = 'Selecciona un médico';
                        doctorSelect.appendChild(defaultOption);

                        // Crear opciones para cada médico
                        data.forEach(function(medico) {
                            var option = document.createElement('option');
                            option.value = medico.perfilMed;  // El valor será el id del médico
                            option.textContent = medico.nombre+" "+medico.apellido;  // El texto visible será el nombre del médico
                            option.id = medico.nombre
                            doctorSelect.appendChild(option);
                        });
                    } else {
                        // Si no hay médicos, agregar una opción indicando que no hay disponibles
                        var noDoctorsOption = document.createElement('option');
                        noDoctorsOption.value = '';
                        noDoctorsOption.textContent = 'No hay médicos disponibles';
                        doctorSelect.appendChild(noDoctorsOption);
                    }
                })
                .catch(error => {
                    console.error("Error al cargar los médicos:", error);
                });
            } else {
                // Si no se seleccionó especialidad, limpiar el select de médicos
                doctorSelect.innerHTML = '<option value="">Selecciona un médico</option>';
            }
            });
        });


        // misma funcion pero para editar los registros...

        var espSelect = document.getElementById('especialidadEdit');
        var doctorEdit = document.getElementById('doctor_id_edit');

            // Cuando se cambia la especialidad

            // Si se seleccionó una especialidad
            
        // Obtener el campo de barraBusqueda y tbody
        var barraBusqueda = document.getElementById('search');
        var cuerpoTabla = document.getElementById('cuerpoTabla');

        
        
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault(); 

                var palabraClave = barraBusqueda.value;

                console.log(palabraClave)

                // Si se seleccionó una especialidad
                // Usar fetch para hacer la solicitud
                fetch('Crud_Admin/barraBusqueda.php?palabra_id=' + palabraClave )
                .then(response => response.json())  // Procesamos la respuesta como JSON
                .then(data => {
                    // Limpiamos el select de médicos
                    cuerpoTabla.innerHTML = '';

                    // Si hay médicos, los agregamos al select
                    if (data.success) {
                        // Crear un primer option para "Seleccionar un médico"
                        console.log(data);

                    
                        // Iterar sobre los resultados y agregar filas a la tabla
                        data.data.forEach(medico => {
                            // Crear una fila de la tabla
                            const fila = document.createElement('tr');
                            
                            // Crear celdas para cada propiedad
                            fila.innerHTML = `
                                <td>${medico.id_disponibilidad}</td>
                                <td>${medico.nombre}</td>
                                <td>${medico.apellido}</td>
                                <td>${medico.dia_semana}</td>
                                <td>${medico.hora_inicio}</td>
                                <td>${medico.hora_fin}</td>
                                <td>${medico.disponibilidad}</td>
                                <td>
                                    <form id="form_editar_${medico.id_disponibilidad}" action="Crud_Admin/accionesHorarios.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="idEditar" value="${medico.id_disponibilidad}">
                                        <button type="button" class="linkEditar" onclick="enviarFormulario(${medico.id_disponibilidad})">editar</button>
                                    </form>
                                </td>

                                <td> 
                                    <form  id='formEliminar' action='Crud_Admin/accionesHorarios.php' method ='POST'>
                                        <input type='hidden' name='id' value='${medico.id_disponibilidad}'>
                                         <button type='submit' name='eliminarHorario' class='deleteMed'><span class='material-symbols-outlined'> delete </span></button>
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


        document.getElementById("diaSemana").addEventListener("change", function() {

            let idMedico =  document.getElementById("doctor_id").value
            let diaSeleccionado =  document.getElementById("diaSemana").value;

            console.log(idMedico+" "+diaSeleccionado)

            var datos = new FormData();
            datos.append('dia', diaSeleccionado);
            datos.append('id_medico', idMedico);

            fetch('Crud_Admin/accionesHorarios.php', {
                method: 'POST',
                body: datos
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();  // Intentamos convertir la respuesta a JSON
            })
            .then(data => {
                console.log(data);
                if (data.validacion) {
                    document.getElementById("submit_button").disabled = false;
                    document.getElementById("mensajeAlert").innerHTML = " ";
                } else {
                    document.getElementById("submit_button").disabled = true;
                    document.getElementById("mensajeAlert").innerHTML = data.mensaje;
                    console.log(data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });


        });
        function enviarFormulario(id) {
            // Obtener el ID del formulario de edición
            var inputId = document.querySelector(`#form_editar_${id} input[name='idEditar']`).value;

            console.log(inputId);

            // Realizamos la solicitud con fetch
            fetch('Crud_Admin/editHorarios.php', {
                method: 'POST',  // Método de la solicitud
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'  // Tipo de contenido
                },
                body: `idEditar=${encodeURIComponent(inputId)}`  // El cuerpo de la solicitud con el idEditar
            })
            .then(response => {
            // Primero verificamos que la respuesta sea exitosa
            if (!response.ok) {
                throw new Error('Error en la solicitud AJAX');
            }

            // Leemos la respuesta como JSON solo una vez
            return response.json(); // Esto consume el cuerpo de la respuesta
        })
        .then(data => {
            // Aquí ya podemos usar los datos correctamente
            if (data.error) {
                alert('Error: ' + data.error);  // Si hay un error, mostrarlo
                return;  // Salir de la función si hay error
            }

            // Procesar la respuesta, ahora que tenemos los datos correctamente
            console.log(data);
            // Actualizar los campos con los datos devueltos
            document.getElementById('idDeHorarios').value = data.id;
            document.getElementById('especialidadEdit').value = data.id_esp;
            document.getElementById('diaSemanaEdit').value = data.diaSemana;
            document.getElementById('dispo_dia').value = data.disponibilidad;

            // Actualizar el select de médicos
            actualizarSelectMedicos(data.id_esp, data.idMedico);

            console.log(data.idMedico)

            // Actualizar las horas (hora de inicio y fin)
            document.getElementById('horaComienzoEdit').value = data.horaInicio.split(':').slice(0, 2).join(':');
            document.getElementById('horaFEdit').value = data.horaFin.split(':').slice(0, 2).join(':');

            // Pinta el modal con la información de los datos recibidos
        
        })
        .catch(error => {
            // Si ocurre un error en cualquier parte del proceso
                console.error('Error:', error);
                alert('Hubo un error al procesar la solicitud. Inténtalo nuevamente.');
        });
}

function actualizarSelectMedicos(especialidadId, idMedico) {
    fetch(`Crud_Admin/obtener_medicosHorarios.php?specialty_id=${especialidadId}`)
        .then(response => response.json())  // Procesamos la respuesta como JSON
        .then(medicos => {
            console.log(medicos)
            const doctorEdit = document.getElementById('doctor_id_edit');  // Suponiendo que el ID es 'doctorEdit'
            doctorEdit.innerHTML = '';  // Limpiar el select antes de agregar las nuevas opciones

            // Si hay médicos, los agregamos al select
            if (medicos.length > 0) {
                let defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Selecciona un médico';
                doctorEdit.appendChild(defaultOption);

                medicos.forEach(function(medico) {
                    let option = document.createElement('option');
                    option.value = medico.perfilMed;
                    option.textContent = `${medico.nombre} ${medico.apellido}`;
                    doctorEdit.appendChild(option);
                });
            } else {
                // Si no hay médicos disponibles
                let noDoctorsOption = document.createElement('option');
                noDoctorsOption.value = '';
                noDoctorsOption.textContent = 'No hay médicos disponibles';
                doctorEdit.appendChild(noDoctorsOption);
            }

            console.log(idMedico); // Verifica el valor de idMedico

            // Si se pasó el idMedico, seleccionamos esa opción
            if (idMedico) {
                const medicoOption = doctorEdit.querySelector(`option[value='${idMedico}']`);
                console.log(idMedico); // Verifica el valor de idMedico
                console.log(medicoOption.value); // Verifica el valor de la opción
                if (medicoOption) {
                    medicoOption.selected = true;
                }
            }

            const dialogEdit = document.getElementById("modalEdit");
            dialogEdit.showModal(); 
            
        })
        .catch(error => {
            console.error('Error al obtener médicos:', error);
            // Opcionalmente, puedes manejar los errores de la obtención de médicos aquí.
        });
}


function pintarSelect(idMedico, horaInicio, horaFin, idDisponibilidad) {
    // Actualiza el campo del formulario con el ID de la disponibilidad
    document.getElementById('dispo_dia').value = idDisponibilidad;

    // Actualiza el campo para la hora de inicio (sin los segundos)
    document.getElementById('horaComienzoEdit').value = horaInicio;

    // Actualiza el campo para la hora de fin (sin los segundos)
    document.getElementById('horaFEdit').value = horaFin;

    // Actualiza el campo del formulario con el ID del médico
    document.getElementById('doctor_id_edit').value = idMedico;

    // Muestra el modal con la información actualizada
     // Abre el modal (asegúrate de tener un modal con este ID en tu HTML)

    // Log para depuración (puedes eliminarlo si no lo necesitas)
    console.log(idMedico);
    console.log(horaFin);
}


        

    </script>
    
</body>
</html>