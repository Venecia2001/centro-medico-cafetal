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

        <h2 class='tituloSeccion'>Turnos Médicos Registrados</h2>

        <div class="cuadroBusqueda" id ="titulito">

            <form action="Crud_Admin/barraBusqueda.php" method="POST" id="searchForm">
                <input type="text" name="search" placeholder="Escribe aquí, busca por nombre apellido o cedula" id="search" required>
                <input type="submit" name="buscar" class='btnBuscarHorarios' value="Buscar">
            </form>

        </div>



        <div class="cabezera"> 

            <form action="Crud_Admin/registroHorarios_admin.php" method="post" id="formHorarios">

                <div class="medico aggEsp"> 

                    <h2>Informacion</h2>
                    <p>Para los médicos de guardia se registrar turnos de 24 horas</p>
                    
                </div>

                <div class="medico aggNombre">
                        <h2>Médicos de Guardia</h2>
                    <select name="medico" id="specialty_id" class="selectForm" require>
                                    <option value="">Seleccione el Médico</option>
                                    <?php
                                    include "conex_bd.php";
                                            
                                    $sql = $conexion->query("SELECT u.id, u.nombre, u.apellido, m.id_perfil, u.rol FROM usuarios u JOIN medicos m ON m.id_medico = u.id WHERE u.rol = 5;");

                                    while($datos=$sql->fetch_object()){ ?>

                                        <option value="<?php echo $datos->id_perfil ?>"><?php echo $datos->nombre.' '.$datos->apellido?></option>

                                    <?php
                                            $rolMedico = $datos->rol;
                                            $idMedicoPerfil = $datos->id_perfil;
                                        } 
                                    ?>
                    </select><br>
                    <input type="hidden" name='rolMedico' value='<?php echo $rolMedico ?>'>
                    <input type="hidden" name='' id='idPerfilMedico' value='<?php echo $idMedicoPerfil  ?>'>
                </div>

               
                <div class="medico aggDiaSemana">
                        <h2>Dia disponible</h2>
                        <select name="dia" id="diaSemana" class="selectForm" require>
                            <option value="">Seleciona un dia</option>
                            <option value="1">Lunes</option>
                            <option value="2">Martes</option>
                            <option value="3">Miercoles</option>
                            <option value="4">Jueves</option>
                            <option value="5">Viernes</option>
                            <option value="6">Sabado</option>
                            <option value="0">Domingo</option>
                        </select>

                        
                </div>

                
                <div class="medico aggHoraInicio" require>
                        <h2>Ininio de Turno</h2>
                        <select name="comienzoTurno" class="selectForm" id="horaC">
                                <option value="">Comienzo de turno</option>
                                 <option value="00:00">00:00</option>
                        </select>
                </div>

                <div class="medico aggHoraFin">
                        <h2>fin de turno</h2>
                        <select name="finTurno" id="horaF" class="selectForm" require>
                        <option value="">Final de Turno</option>
                                <option value="23:59">23:59</option>
                        </select>
                </div>

                <div class="medico btnRegistrar">

                    <input type="submit" name="registroHoras" id="button_horario" value='Registrar'>
                    <p id="mensajeAlert"></p>
                
                </div>
            </form>

        </div>

        <table id='tablaHorarios'>
            <thead>
                <th>id Horario</th>
                <th>Nombres Médico</th>
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
                  
                  $getDatos = "SELECT dh.*, us.nombre, us.apellido FROM disponibilidad_horarios dh JOIN medicos m ON dh.medico_relac = m.id_perfil LEFT JOIN usuarios us ON m.id_medico = us.id WHERE us.rol = 5";
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
                                    case 0: 
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
                                    
                                    <form  id='formEliminar' action='Crud_Admin/accionesHorarios.php' method ='POST' onsubmit=\"return confirm('¿Estás seguro de que deseas Eliminar este Horarios?');\">
                                        <input type='hidden' name='id' value='".$idHorario."'>
                                        <input type='hidden' name='rolUsuario' value='".$rolMedico."'>
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


       <dialog id="modalEdit">

            <h3 class ='tituloFormulario'>Formulario para Modificar</h3>

            <div class="formEditar">

                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>

                <form action="Crud_Admin/resultadoFinalCitas.php" method="POST" id='FormEdicionHorarios'>

                    <input type="hidden" name="idHorarios" id="idDeHorarios" value="">

                    <input type="hidden" name='rolMedico' value='<?php echo $rolMedico ?>'>

                    <label for="">Nombre de Médico</label><br>
                    <input type="text"  id="doctor_id_edit" readonly><br><br>

                    <input type="hidden" name="medicoEdit" id='refMedico' >

                    <!-- <select name="medicoEdit" id="doctor_id_edit" class="selectForm">
                        <option value="">Seleccione un médico</option>
                            
                    </select><br> -->
                    <label for="">Dia de la Semana</label><br>
                    <select name="diaEdit" id="diaSemanaEdit"  class="selectForm">
                        <option value="">Seleciona un dia</option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                        <option value="0">Domingo</option>
                    </select><br>

                    <label for="">Hora De Inicio</label><br>
                    <!-- <span id="mensajeEmer"></span> -->
                    <select name="comienzoTurnoEdit" id="horaComienzoEdit"  class="selectForm">
                        <option value="">Comienzo de Turno </option>
                        <option value="00:00">00:00</option>
                    </select><br>

                    <label for="">Hora de culminacion</label><br>
                    <!-- <span id="mensajeHoraFin"></span> -->
                    <select name="finTurnoEdit" id="horaFEdit" class="selectForm">
                        <option value="">Final de Turno</option>
                        <option value="23:59">23:59</option>
                    </select><br>
                    <label for="">Disponibilidad de horario</label><br>
                    <select name="disponibilidadEdit" id="dispo_dia"  class="selectForm">
                        <option value="">disponinibilidad de dia</option>
                        <option value="Disponible">Disponible</option>
                        <option value="No disponible">No Disponible</option>  
                    </select><br>

                       <input type="submit" id="botonEdit" name="editHorarios" value="Confirmar Cambios" >
                        <p id="mensajeAlertEdit"></p>
                </form>


            </div>
        </dialog>

    </div>
        
    </main>


    <script>

        document.getElementById("button_horario").addEventListener("click", function(e) {
            e.preventDefault(); // Previene el envío del formulario hasta validar

            const medico = document.getElementById("specialty_id").value;
            // const medico = document.getElementById("doctor_id").value;
            const dia = document.getElementById("diaSemana").value;
            const comienzoTurno = document.getElementById("horaC").value;
            const finTurno = document.getElementById("horaF").value;
            const mensaje = document.getElementById("mensajeAlert");

            if (!medico || !dia || !comienzoTurno || !finTurno) {
                // mensaje.textContent = "Debes seleccionar todos los campos antes de registrar.";
                // mensaje.style.color = "red";
                alert('Debes seleccionar todos los campos antes de registrar.')
            } else {
                // Validación adicional: inicio debe ser menor que fin
                if (comienzoTurno >= finTurno) {
                    mensaje.textContent = "La hora de inicio debe ser menor que la de fin.";
                    mensaje.style.color = "red";
                    return;
                }

                // // Todo bien, enviamos el formulario
                // document.getElementById("formHorarios").submit();

                 const formHorario = document.getElementById("formHorarios");
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "registroHoras";
                formHorario.appendChild(hiddenInput);
                formHorario.submit();
                }
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

            let idMedico =  document.getElementById("idPerfilMedico").value
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
                    document.getElementById("button_horario").disabled = false;
                    document.getElementById("mensajeAlert").innerHTML = " ";
                } else {
                    document.getElementById("button_horario").disabled = true;
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
                const dialogEdit = document.getElementById("modalEdit");
                dialogEdit.showModal(); 
                // Actualizar los campos con los datos devueltos
                document.getElementById('idDeHorarios').value = data.id;
                document.getElementById('refMedico').value = data.idPerfilMedico;

                document.getElementById('doctor_id_edit').value = data.nombreM +' '+ data.apellidoM;
                document.getElementById('diaSemanaEdit').value = data.diaSemana;
                document.getElementById('dispo_dia').value = data.disponibilidad;

                // Actualizar el select de médicos
                // actualizarSelectMedicos(data.id_esp, data.idMedico);

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

        document.getElementById('FormEdicionHorarios').addEventListener('submit', function (event) {
                const dia = document.getElementById('diaSemanaEdit').value;
                const horaInicio = document.getElementById('horaComienzoEdit').value;
                const horaFin = document.getElementById('horaFEdit').value;
                const mensaje = document.getElementById('mensajeAlertEdit');

                // Limpiar mensaje anterior
                mensaje.textContent = '';

                if (!dia || !horaInicio || !horaFin) {
                    event.preventDefault(); // Evita el envío del formulario
                    mensaje.textContent = 'Por favor, complete todos los campos antes de continuar.';
                    mensaje.style.color = 'red';
                    return;
                }

                // Validación adicional: la hora de fin debe ser mayor a la de inicio
                if (horaFin <= horaInicio) {
                    event.preventDefault();
                    mensaje.textContent = 'La hora de fin debe ser mayor que la hora de inicio.';
                    mensaje.style.color = 'red';
                    return;
                }

            // Si todo está bien, el formulario se envía
        });




        

    </script>
    
</body>
</html>