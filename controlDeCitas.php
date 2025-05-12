<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="interfazAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

    <?php include "sideba_admin.php" ?>

    <main id='contedorMacroCitas'> 

    <h2 class='tituloSeccion'> Citas Medicas Registradas</h2>

    <div class="table__citas">
                <div class="filtroCitas">

                    <div class='btmNewCita'>

                        <button id=citaAdmin> Crear Cita</button>

                    </div>


                    <?php
                        $current_date = date('Y-m-d'); // Fecha actual
                        $one_week_later = date('Y-m-d', strtotime('+1 week')); // Fecha una semana más adelante
                    ?>
                    <form action="" method="POST" id="formulario_filtro">
                        <select name="filtro" id="seleccionarFechasCitas">
                            <option value="">Filtrar por Fecha</option>
                            <option value="<?php echo $current_date ?>">Citas del día</option>
                            <option value="filtroSemana_<?php echo $current_date . '_' . $one_week_later ?>">Citas de la semana</option>
                            <option value="totalCitas">Todas las citas</option>
                        </select>
                    </form>
                </div>
        <table>
            <thead>
                <th>Id_cita</th>
                <th>Paciente</th>
                <th>Medico</th>
                <th>especialidad</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estatus</th>
                <th>fecha de creacion</th>
                <th>Eliminar</th>
            </thead>
            <tbody id='bodyTable'>
                <?php 
                
                include "conex_bd.php";

                $citasSql = "SELECT c.id_cita, c1.nombre AS nombre_paciente, c2.nombre AS nombre_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id  JOIN usuarios c2 ON c.id_medico = c2.id  JOIN especialidades e ON c.especialidad = e.id_especialidad;";
                $result = mysqli_query($conexion, $citasSql);

                while($datos=$result->fetch_object()){ 
                    
                    $id_cita = $datos->id_cita; 
                    ?>

                    <tr>
                        <td><?php echo $datos->id_cita ?> </td>
                        <td><?php echo $datos->nombre_paciente ?> </td>
                        <td> Dr.<?php echo $datos->nombre_medico ?> </td>
                        <td><?php echo $datos->nombre_esp ?> </td>
                        <td><?php echo $datos->fecha ?> </td>
                        <td ><?php echo $datos->hora ?> </td>
                        <td class='<?php echo $datos->estado ?>'> <?php echo $datos->estado ?> </td>
                        <td><?php echo $datos->fecha_creacion ?> </td>
                    
                        <?php echo "<td>
                                        
                                        <form  id='formEliminar' action='Crud_Admin/Citas_medicas.php' method ='POST'>
                                            <input type='hidden' name='id_cita' value='".$datos->id_cita."'>
                                            <button type='submit' name='eliminarCita' class='delete'><span class='material-symbols-outlined'> delete </span></button>
                                        </form>
                                    </td>";?>



                    </tr>

                    <?php
                }
                
                ?>

            </tbody>
        </table><br><br>

    </div>

    <!-- <div>
            <form action="Citas_medicas.php" method="POST" >

            <input type="hidden" id="id_citas" name="idCita" value="">

            <label for="nombre">Paciente</label>
            <input type="text" id="nombrePac" name="nombrePac" value=""><br>

            <label for="medico">medico</label>
            <input type="text" id="medicoCita" name="medicoCita" value=""><br>

            <label for="esp">especialidad</label>
            <input type="text" id="esp" name="esp" value=""><br>

            <label for="esp">fecha</label>
            <input type="text" id="fecha" name="fecha" value=""><br>

            <label for="esp">hora</label>
            <input type="text" id="hora" name="hora" value=""><br>

            <label for="esp">estado</label>
            <input type="text" id="estado" name="estadoCita" value=""><br>

            <input type="submit" name="EditarCita" value="Editar">

            </form>

    </div> -->

        <dialog id='dialogNewCitaAdmin'>

                        <form method="dialog">
                            <button class="ModalClose"> X</button>
                        </form>

            <h2> Agregar nueva Cita</h2>

            <form action="Crud_Admin/Citas_medicas.php" method = "post" id="formCitas">

                <label for="usuarios">Paciente</label>
                <select name="nameUser" id="usuario">
                    <option value="">Seleccione un Paciente</option>
                    <?php 
                        $sql = $conexion->query("SELECT * FROM usuarios WHERE rol = 3");
                        while($users = $sql->fetch_object()){ ?>

                        <option value="<?php echo $users->id ?>"><?php echo $users->nombre?></option>

                        <?php
                        }
                    ?> 

                </select><br>

                <label for="especialidad">Especialidad:</label>
                <select name="especialidad" id="specialty_id">
                    <option value="">Seleccione una especialidad</option>
                    
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

                <label for="medico">Médico:</label>

                <select name="medico" id="doctor_id"  onchange="cargarHorarios()">
                    <option value="">Seleccione un médico</option>
                    
                </select><br>

                <input type="hidden" name='idDoctorTrue' id='medico_hidden'>

                <!-- <label for="hora">fecha de cita</label> -->
                <!-- <input type="date" id="fecha" name="fecha"> -->
                
                <div class="espacioCalendario">
                    <label for="fechaPruebas">Fecha de cita</label>
                    <input type="text" id="fechaPruebas" placeholder="aaaa/mm/dd" name="fecha" />


                    <div id="mensaje"></div><br>
                </div>
                <!-- 
                <label for="hora">hora de cita</label>
                <input type="time" id="horas" name="horaCita"> -->

                <label for="hora">Selecciona una hora:</label>
                <select id="horaSelect" name="horaSelecion">
                    <!-- Las horas disponibles se generarán con JavaScript -->
                </select>
                
                <div id="mensajeHora"></div><br>     

                <input type="submit" id="submit_button" value="Confirmar Cita" name="confirmarCita">

            </form>

        </dialog>

    </main>


    <style>

      .flatpickr-calendar {
        margin: auto;
        display: block;
        
      }

      .flatpickr-day {
          border-radius: 5px !important; /* Eliminar bordes redondeados */
          margin: 2px;
      } 
      
      .flatpickr-months .flatpickr-month {
        background: #008080;
        color: rgba(0, 0, 0, 0.9);
        fill: rgba(0, 0, 0, 0.9);
        height: 40px;
        line-height: 1;
      }

      /* Estilo para los días deshabilitados */
      .flatpickr-day.disabled {
          background-color:rgb(182, 182, 182) !important; /* Color de fondo para los días deshabilitados */
          color:rgb(139, 139, 139) !important; /* Color de texto para los días deshabilitados */
          pointer-events: none; /* Deshabilitar la interacción con los días */
      }

      /* Estilo para los días seleccionados, para hacer el fondo cuadrado */
      .flatpickr-day.selected {
          border-radius: 0 !important; /* Eliminar bordes redondeados */
          background-color: #00a291 !important; /* Cambiar el color de fondo */
          color: #fff !important; /* Cambiar el color del texto */
      }
  </style>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Incluir el archivo de idioma de Flatpickr en español -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>


    <script>

        // flatpickr("#fechaPruebas", {
        //     position: "auto",  // Ajusta la posición automáticamente
        //     appendTo: document.querySelector("dialog"),  // Coloca el calendario dentro del dialog
        //     // Otras configuraciones de Flatpickr que puedas necesitar
        // });

        const btnCita = document.getElementById('citaAdmin');
        btnCita.addEventListener("click", openLogin)

        function openLogin(){
            const dialog = document.getElementById("dialogNewCitaAdmin");
            dialog.showModal(); 
        } 

            
    let horaDeInicio = null;
    let horaDeCierre = null;

    function enviarFormulario(id) {
        
        var inputId = document.querySelector(`#form_editar_${id} input[name='idEditar']`).value;

        console.log(inputId);

        // Realizamos la solicitud con fetch
        fetch('Crud_Admin/Citas_medicas.php', {
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
                document.getElementById('id_citas').value = data.id;
                document.getElementById('nombrePac').value = data.nombrePaciente;
                document.getElementById('medicoCita').value = data.nombre_medico;
                document.getElementById('esp').value = data.especiaidad;
                document.getElementById('fecha').value = data.fecha;
                document.getElementById('hora').value = data.hora;
                document.getElementById('estado').value = data.status;

            }
        })
        .catch(error => {
            // Si ocurre un error en cualquier parte del proceso
            console.error('Error:', error);
        });
        
        
        
    }

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
                fetch('obtener_medicos.php?specialty_id=' + specialty_id)
                .then(response => response.json())  // Procesamos la respuesta como JSON
                .then(data => {
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
                            option.classList.add('doctor-item');
                            option.value = medico.idPerfil;  // El valor será el id del médico
                            option.textContent = medico.nombre+" "+medico.apellido;  // El texto visible será el nombre del médico
                            option.id = medico.nombre

                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'id_medico';
                            hiddenInput.value = medico.id_medico;


                            doctorSelect.appendChild(option);
                            doctorSelect.appendChild(hiddenInput);

                            option.addEventListener('click', function () {
                                document.querySelectorAll('.doctor-item').forEach(el => el.classList.remove('seleccionado'));
                                this.classList.add('seleccionado');

                                let inputId = document.getElementById('medico_hidden').value = hiddenInput.value;

                                console.log("Seleccionado:"+inputId);
                            });
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
    
    function cargarHorarios(){

        let medicoId = document.getElementById("doctor_id").value;
        // let fechasDis = document.getElementById("fecha");

        if (medicoId) {
            fetch("verificarFechas.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "medico_id=" + medicoId
            })
            .then(response => response.json())  // Convertimos la respuesta JSON
            .then(data => {
                // Aquí puedes manejar el array de días recibidos
                console.log(data);  // Muestra el array de días disponibles en la consola
                pintarDias(data);

                document.getElementById("fechaPruebas").addEventListener("change", function() {
                var fechaSeleccionada = fechaUsuario ;

                
                alert("estas intentando wacho la fecha es" + fechaSeleccionada)
            
                // Datos que enviarás al servidor
                var datos = new FormData();
                datos.append('fecha', fechaSeleccionada);
                datos.append('diasSemana', JSON.stringify(data)); // Ejemplo: Lunes, Miércoles y Viernes
                datos.append('idMedico', medicoId)

                // Realizamos una solicitud AJAX
                fetch('validarCita.php', {
                    method: 'POST',
                    body: datos
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mensaje").innerHTML = (data.message); // Mensaje del servidor
                    console.log(data); // El valor de $diaSemana desde PHP
                    horaDeInicio = data.horaDeInicio;
                    horaDeCierre = data.horaDeCierre;

                    generarHorasDisponibles();

                    // Verificar si la fecha seleccionada es válida
                    if (data.valido) {
                    // Si la fecha es válida, habilitamos el formulario para que pueda enviarse
                    document.getElementById("submit_button").disabled = false; // Habilitar el botón de enviar
                    } else {
                    // Si la fecha no es válida, deshabilitamos el formulario y mostramos un mensaje
                    document.getElementById("submit_button").disabled = true; // Deshabilitar el botón de enviar
                    }   


                    validarRangoHoras(data.diaSemana, medicoId);
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            })
        }) 
    } 

    }

    function validarRangoHoras(numeroDia, medicoId){


        document.getElementById("horaSelect").addEventListener("change", function() {
        let horaSeleccionada = this.value;

        console.log("las variables son: " + numeroDia + ", " + horaDeInicio + ", " + horaDeCierre+","+medicoId+"," + horaSeleccionada+","+fechaUsuario);

        const datos = new URLSearchParams();
        datos.append("numeroDeDia", numeroDia);
        datos.append("fechaSelecionada",fechaUsuario );
        datos.append("medicoId", medicoId);
        datos.append("horaInicio", horaDeInicio);
        datos.append("horaDeCierre", horaDeCierre);
        datos.append("horaSeleccionada", horaSeleccionada);  // Agregar horaSeleccionada


        fetch("validarHora.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: datos.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Si la respuesta fue exitosa, mostramos las horas disponibles
                console.log("Las horas disponibles son: " + data.horaInicio + " a " + data.horaFin);

                
                document.getElementById("mensajeHora").innerHTML = (data.message); // Muestra el mensaje completo al usuario
                document.getElementById("submit_button").disabled = false; // Habilitar el botón de enviar

                
                
            } else {
                // Si no hay horas disponibles, mostramos el mensaje de error
                document.getElementById("mensajeHora").innerHTML = (data.message); // Muestra el mensaje completo
                document.getElementById("submit_button").disabled = true; // Habilitar el botón de enviar
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });

        })


    }

    function pintarDias(arregloDay){

        let diasDisponibles = [];
        diasDisponibles = arregloDay;
        console.log(diasDisponibles)


        // Array de días disponibles (Lunes=1, Miércoles=3, Viernes=5)

        // Configuración de Flatpickr
        flatpickr("#fechaPruebas", {
            inline: true,
            dateFormat: "Y-m-d",  // Formato de la fecha
            disable: [
                // Deshabilitar todos los días que no estén en el array de días disponibles
                (date) => {
                    const day = date.getDay(); // Obtiene el día de la semana (0-6)
                    return !diasDisponibles.includes(day); // Deshabilitar si el día no está en el array
                }
            ],
            locale: "es", // Establecer el idioma a español

            onChange: function(selectedDates, dateStr, instance) {
                // Al seleccionar una fecha, guardamos la fecha seleccionada en la variable
                fechaUsuario = dateStr; // O también puedes usar selectedDates[0] para obtener la fecha en formato Date
                console.log("Fecha seleccionada: " + fechaUsuario);  // Muestra la fecha seleccionada en consola
            },


            onDayCreate: function(dObj, dStr, fp, dayElem) {
                // Se aplica un estilo a los días habilitados (según el array)
                if (dayElem.classList.contains('flatpickr-day')) {
                    const date = dayElem.dateObj;
                    const day = date.getDay();

                    if (diasDisponibles.includes(day)) {
                        // Si el día está en el array, aplicar estilo
                        if (day === 1) {  // Lunes
                            dayElem.style.backgroundColor = '#4CAF50'; // Color de fondo para lunes
                            dayElem.style.color = '#ffffff';           // Color del texto para lunes
                        } else if (day === 2) {  // Miércoles
                            dayElem.style.backgroundColor = '#2196F3'; // Color de fondo para miércoles
                            dayElem.style.color = '#ffffff';           // Color del texto para miércoles
                        } else if (day === 3) {  // Viernes
                            dayElem.style.backgroundColor = '#FF5722'; // Color de fondo para viernes
                            dayElem.style.color = '#ffffff';           // Color del texto para viernes
                        } else if (day === 4) {  // Viernes
                            dayElem.style.backgroundColor = '#FF5722'; // Color de fondo para viernes
                            dayElem.style.color = '#ffffff';           // Color del texto para viernes
                        }else if (day === 5) {  // Viernes
                            dayElem.style.backgroundColor = '#FF5722'; // Color de fondo para viernes
                            dayElem.style.color = '#ffffff';           // Color del texto para viernes
                        }
                    }
                }
            }
        });
        }

        function generarHorasDisponibles() {
        const select = document.getElementById('horaSelect');
        const startHour = horaDeInicio;
        const endHour = horaDeCierre;

        // Limpiar las opciones previas
        select.innerHTML = "";

        const startHourNumber = parseInt(startHour.split(":")[0], 10); // Extraer la hora (8)
        const endHourNumber = parseInt(endHour.split(":")[0], 10);     // Extraer la hora (16)

        // Crear las opciones de horas
        for (let hour = startHourNumber; hour < endHourNumber; hour++) {
            // Si la hora es 12, saltarla (hora de descanso)
            if (hour === 12) {
                continue;  // Salta la iteración cuando la hora es 12
            }

            // Formato de la hora en 24 horas (ej. 08:00, 09:00, ...)
            const formattedHour = hour < 10 ? `0${hour}:00` : `${hour}:00`;
            const option = document.createElement('option');
            option.value = formattedHour;
            option.text = formattedHour;
            select.appendChild(option);
        }
        }
        

        document.getElementById('seleccionarFechasCitas').addEventListener('change', function(event) {
            // Obtener el valor seleccionado
            const filtro = event.target.value;
    
            // Si no se ha seleccionado ninguna opción, no hacemos nada
            if (!filtro) return;

            if(filtro === "totalCitas"){
                location.reload();            
            }

            let url = '';
            let params = {};

            if (filtro === '<?php echo $current_date ?>') {
                // Si es la fecha del día, sólo mandamos la fecha actual
                url = 'Crud_Admin/filtroCitasAdmin.php';  // Reemplaza con la ruta a tu archivo PHP
                params = { fecha: '<?php echo $current_date ?>' };
            } else if (filtro.startsWith('filtroSemana_')) {
                // Si es la opción de la semana, dividimos el valor en las fechas de inicio y fin
                const [etiqueta, start_date, end_date] = filtro.split('_');
                url = 'Crud_Admin/filtroCitasAdmin.php';  // Reemplaza con la ruta a tu archivo PHP
                params = { start_date, end_date };
            }

            console.log(filtro);

            // Verificar si se seleccionó una opción válida
            if (filtro !== "") {
                // Enviar el valor seleccionado usando Fetch
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(params)
                })
                .then(response => {
                    // Verificar si la respuesta es exitosa (código de estado 200)
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json(); // Parsear la respuesta como JSON
                })
                .then(data => {

                    let contenedorCitas = document.getElementById("bodyTable");
                    // Aquí es donde procesamos el JSON recibido

                    contenedorCitas.innerHTML = '';

                    // const cuadroCitas = document.getElementById('seccionHistorial');
                    // cuadroCitas.innerHTML = '';

                    if (data.success) {
                        console.log(data.data)

                        data.data.forEach(cita => {

                        const fila = document.createElement('tr');
                                        
                        // Crear celdas para cada propiedad
                        fila.innerHTML = `
                            <td >${cita.id_cita}</td>
                            <td>${cita.nombrePaciente}</td>
                            <td>${cita.nombreMedico}</td>
                            <td>${cita.nombreEsp}</td>
                            <td>${cita.fecha}</td>
                            <td>${cita.hora}</td>
                            <td class="${cita.estado}">${cita.estado}</td>
                            <td>${cita.fechaCreacion}</td>
                            <td> 
                                <form  id='formEliminar' action='Crud_Admin/Citas_medicas.php' method ='POST'>
                                        <input type='hidden' name='id_cita' value='${cita.id_cita}'>
                                         <button type='submit' name='eliminarCita' class='delete'><span class='material-symbols-outlined'> delete </span></button>
                                </form>
                            </td>
                            
                        `;

                        // Agregar la fila al cuerpo de la tabla
                        contenedorCitas.appendChild(fila);
                        });

                        // Aquí puedes manejar los datos como lo desees
                    } else {
                        contenedorCitas.innerHTML = "<tr><td colspan='10'>No se encontraron datos relacionados.</td></tr>";
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });
            } else {
                // Si no se selecciona una opción válida, puedes hacer algo (opcional)
                console.log('No se ha seleccionado una opción válida.');
            }
        });

    </script>
    
</body>
</html>