<?php 

      include "conex_bd.php";

      if (isset($_GET['id'])) {

        $idMedico = $_GET['id'];

        $consultaDatos = "SELECT cl.*, m.id_perfil,  m.id_medico, m.id_especialidad, m.direccion, m.foto_perfil, m.titulación_academica, m.perfil_experiencia, e.nombre_esp AS nombre_especialidad FROM usuarios cl JOIN medicos m ON cl.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE m.id_medico = $idMedico ;";
        $resultadosConsulta = mysqli_query($conexion, $consultaDatos);

        while($data = $resultadosConsulta->fetch_array()){

            $idMed = $data["id"];
            $idPerfilMed = $data['id_perfil'];
            $nombreMed = $data['nombre'];
            $apellidoMed = $data['apellido'];
            $telefono = $data["telefono"];
            $correo = $data["correo"];
            $clave = $data["contraseña"];
            $id_especialidad = $data['id_especialidad'];
            $nombre_esp = $data['nombre_especialidad'];
            $direccion = $data['direccion'];
            $fotoPerfil = $data['foto_perfil'];
            $fechaNac = $data['fecha_nacimiento'];
            $perfilDeMedico = $data['perfil_experiencia'];
            $universidadEgreso = $data['titulación_academica'];
        }

    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Cardiologia</title>
    <link rel="stylesheet" href="stilos.cardiologia.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lilita+One&family=Lobster&family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  </head>

<?php include "header.php";  ?>

<section id="espacioInfoMedico">


  <div class="contenedor1" id="infoSeccion">

      <h2> <?php echo $nombreMed." ".$apellidoMed ?> </h2><br>

      <p> <strong>Medico</strong>: <?php echo $universidadEgreso ?> </p><br>

      <p class="textoPricipal"> <?php echo $perfilDeMedico ?></p>

      <h3>Horarios de Consulta</h3><br>

      <?php
      
      $consultaPrevia = "SELECT * FROM medicos WHERE id_medico = $idMedico";
      $resultadoPrev = mysqli_query($conexion, $consultaPrevia);

      while($dato = $resultadoPrev->fetch_array()){
        $idMedicoPerfil = $dato['id_perfil'];
      }
      
        $getHorariosDeMedicos = "SELECT * FROM `disponibilidad_horarios` WHERE medico_relac = $idMedicoPerfil;";
        $resultadosHorarios = mysqli_query($conexion, $getHorariosDeMedicos);

    
        while($fila = $resultadosHorarios->fetch_array()){

        $idHorario = $fila["id_disponibilidad"];
        $diaSemana = $fila['dia_semana'];
        $horaInicio = $fila["hora_inicio"];
        $horaFin = $fila["hora_fin"];
        $estado_dis = $fila['estado_disponibilidad'];

        switch ($diaSemana) {
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

        ?>

        <p><?php echo $nombreDia." De ".$horaInicio." hasta ".$horaFin ?></p>  <br>


        <?php
    }
      
      ?>

    <button id="botonSolicitud"> solicita una cita </button>

  </div>

  <div class="contenedor1" id="fotoPrincipal">

  <img src="uploads/.<?php echo $fotoPerfil; ?>" alt="Imagen de especialidad">
      
  </div>


</section>

    <dialog id="dialogCitasOnline">

        <section class="registroDeCita">

          <?php 
          
          $mensaje ="";

          if (isset($_SESSION['mensaje'])) {
            $mensaje = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
          }

          ?>
            
            <div class="camposFron">

                  <h2 class="titulo">Citas Online</h2>
                  <form method="dialog">
                      <button class="ModalClose"> X</button>
                  </form>
              

              <form action="isertarDatos.php" method = "post" id="formCitas">
                  <div class="nombrePaciente espacioU">

                    <div class="headerCitas">
                      <h2> Usuario</h2><br>
                    </div>
                    
                    <?php 
                      if(!empty($_SESSION['usuario'])) { ?>

                      <h3 class="nombreUsuario"> Usuario: </h3>
                      <h3 class="nombreUsuario"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"]; ?> </h3>
                      <?php
                    }
                    ?>
                    <?php 
                      if(!empty($_SESSION['usuario'])) { ?>

                      <input type="hidden" value="<?php echo $_SESSION["id"] ?>" name="nameUser">
                      <?php
                    }
                    ?>

                    <!-- Mostrar mensaje de éxito o error -->
                    <?php if (!empty($mensaje)) echo $mensaje; ?>

                    <button type="button" id='btnVerCitaMenor'>Cita a Menor de Edad</button>

                    <div id='formCitaInterna' class="datosMenor">
                        <div class="headerCitas">
                            <h2> Datos del Menor</h2><br>
                        </div>

                      <div class='textoDeInput'>
                        
                        <label for="nombreMenor">Nombre del Menor:</label>
                        <input type="text" id="nombreMenor" name="nombreMenor" placeholder="Nombre y Apellido del menor">
                        
                        <label for="fechaNacimientoMenor">Fecha de Nacimiento:</label>
                        <input type="date" id="fechaNacimientoMenor" name="fechaNacimientoMenor">

                        <!-- Consentimiento del representante -->
                        <label for="consentimientoMenor" id='textCheck'>
                            <input type="checkbox" id="consentimientoMenor" name="consentimientoMenor"> Acepto que soy el representante legal del menor.
                        </label><br><br>
                      </div>
                    </div>


                  </div>

                  <div class="ParteEspc espacioU">

                    <div class="headerCitas">
                      <h2> Especialidades</h2><br>
                    </div>

                    <div class="especialidadesCita">
                      <input type="hidden" id="specialty_id_hidden" name="especialidad" value="<?php echo $id_especialidad ?>">
                      
                      <?php
                          include "conex_bd.php";
                                
                          $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades` WHERE id_especialidad = $id_especialidad");

                          while($datos=$sql->fetch_object()){ ?>

                              <div class="especialidad"  data-id="<?php echo $datos->id_especialidad ?>"><?php echo $datos->nombre_esp?></div>

                          <?php
                              $selectEspecialidad = $datos->nombre_esp;
                          } 
                      ?>
                    </div>

                  </div>
                    
                  <div class="parteMedicos espacioU">

                    <div class="headerCitas">
                      <h2> Médicos</h2><br>
                    </div>
                    
                    <div id="doctorContainer" class="doctores-lista"></div>
                    <input type="hidden" name="medico_id" id="medico_id_hidden" value='<?php echo $idPerfilMed ?>'>
                    <input type="hidden" name="medico_idTrue" id="medico_hidden">

                  </div>
                      <!-- <label for="hora">fecha de cita</label> -->
                      <!-- <input type="date" id="fecha" name="fecha"> -->
                      
                  <div class="parteCalendario_hora espacioU">

                    <div class="headerCitas">
                      <h2> Horarios</h2><br>
                    </div>

                    <div class="espacioCalendario">
                      <label for="fechaPruebas">Fecha de cita</label>
                      <input type="text" id="fechaPruebas"   placeholder="aaaa/mm/dd" name="fecha" />

                      <div id="mensajeFecha"></div><br>
                    </div>

                    <div class="espacioHoras">
                        <label for="hora">Selecciona una hora:</label>
                        <select id="horaSelect" name="horaSelecion">
                          <!-- Las horas disponibles se generarán con JavaScript -->
                        </select>
                        
                        <div id="mensajeHora"></div><br>
                      </div>     

                      <input type="submit" id="submit_button" value="Confirmar Cita" name="confirmarCita">
                    </div>
                </form>
              
            </div>
        </section>
      </dialog>

      <style>

        .flatpickr-calendar {
          margin: auto;
          display: block; /* por si acaso está en inline */
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

<?php include "footer.php";  ?>



<script>


    const botonCitaMenor = document.getElementById('btnVerCitaMenor')
      botonCitaMenor.addEventListener("click", openFormCita)

      function openFormCita(){

        const today = new Date();

        // Calcular la fecha de hace 18 años
        const eighteenYearsAgo = new Date(today.setFullYear(today.getFullYear() - 18));

        // Formatear la fecha como YYYY-MM-DD
        const formattedDate = eighteenYearsAgo.toISOString().split('T')[0];

        // Asignar la fecha máxima al input de fecha de nacimiento
        document.getElementById('fechaNacimientoMenor').setAttribute('min', formattedDate);


        const formInterno = document.getElementById("formCitaInterna");
        formInterno.style.display = "block"; 
        
  }


      const botonCitas = document.getElementById('botonSolicitud')
      botonCitas.addEventListener("click", openModal)

      function openModal(){

        const dialog = document.getElementById("dialogCitasOnline");
        dialog.showModal(); 

      }

document.addEventListener("DOMContentLoaded", function() {
    // Obtener el campo de especialidades y médicos
    let doctorSelect = document.getElementById('doctor_id');
    let specialty_id = document.getElementById('specialty_id_hidden').value;
    
    // Cuando se cambia la especialidad
    console.log(specialty_id);

    fetch('obtener_medicos.php?specialty_id=' + specialty_id)
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const doctorContainer = document.getElementById('doctorContainer');
        doctorContainer.innerHTML = '';

        // Aquí definimos el idPerfil que debe ser seleccionado por defecto
        const defaultDoctorId = Number(document.getElementById('medico_id_hidden').value); // Asegúrate de que sea un número

        console.log('el medico por defecto es'+ defaultDoctorId)

        if (data.length > 0) {
            data.forEach(function(medico) {
                const doctorDiv = document.createElement('div');
                doctorDiv.classList.add('doctor-item');
                doctorDiv.dataset.id = medico.idPerfil;

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'id_medico';
                hiddenInput.value = medico.id_medico;  // ← Aquí usas la propiedad correcta

                // Creamos la imagen
                const img = document.createElement('img');
                img.src = 'uploads/.' + (medico.foto || 'default.jpg');  // Ruta por defecto si no hay imagen
                img.alt = medico.nombre;

                // Creamos el nombre completo
                const nombre = document.createElement('span');
                nombre.textContent = `${medico.nombre} ${medico.apellido}`;

                doctorDiv.appendChild(img);
                doctorDiv.appendChild(nombre);
                doctorDiv.appendChild(hiddenInput);

                // Evento clic
                doctorDiv.addEventListener('click', function () {
                    document.querySelectorAll('.doctor-item').forEach(el => el.classList.remove('seleccionado'));
                    this.classList.add('seleccionado');
                    document.getElementById('medico_id_hidden').value = this.dataset.id;
                    document.getElementById('medico_hidden').value = hiddenInput.value;

                    console.log("Seleccionado:", this.dataset.id);
                    
                    // Llamar a cargarHorarios
                    cargarHorarios(this.dataset.id);
                });

                doctorContainer.appendChild(doctorDiv);

                // Si el idPerfil del médico es 25, seleccionarlo por defecto
                if (medico.idPerfil === defaultDoctorId) {
                    doctorDiv.classList.add('seleccionado');
                    document.getElementById('medico_id_hidden').value = doctorDiv.dataset.id;
                    document.getElementById('medico_hidden').value = hiddenInput.value;

                    // Llamar a cargarHorarios para el médico seleccionado
                    cargarHorarios(doctorDiv.dataset.id);

                    console.log("Seleccionado por defecto:", doctorDiv.dataset.id);
                }
            });
        } else {
            doctorContainer.innerHTML = '<div>No hay médicos disponibles.</div>';
        }
    });
});

        function cargarHorarios(idPerdil){

          let medicoId = document.getElementById("medico_id_hidden").value;
          // let fechasDis = document.getElementById("fecha");

          console.log("este es la cadena 2"+idPerdil)

          if (medicoId) {
              fetch("verificarFechas.php", {
                  method: "POST",
                  headers: {
                      "Content-Type": "application/x-www-form-urlencoded"
                  },
                  body: "medico_id=" + idPerdil
              })
              .then(response => response.json())  // Convertimos la respuesta JSON
              .then(data => {
                  // Aquí puedes manejar el array de días recibidos
                  console.log(data);  // Muestra el array de días disponibles en la consola
                  pintarDias(data);

                  document.getElementById("fechaPruebas").addEventListener("change", function() {
                  var fechaSeleccionada = fechaUsuario ;
              
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
                      document.getElementById("mensajeFecha").innerHTML = (data.message); // Mensaje del servidor
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
          minDate: "today",
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
                          dayElem.style.backgroundColor = '##00a5a5'; // Color de fondo para miércoles
                          dayElem.style.color = '#ffffff';           // Color del texto para miércoles
                      } else if (day === 3) {  // Viernes
                          dayElem.style.backgroundColor = '#FF5722'; // Color de fondo para viernes
                          dayElem.style.color = '#ffffff';           // Color del texto para viernes
                      } else if (day === 4) {  // Viernes
                          dayElem.style.backgroundColor = '##007343'; // Color de fondo para viernes
                          dayElem.style.color = '#ffffff';           // Color del texto para viernes
                      }else if (day === 5) {  // Viernes
                          dayElem.style.backgroundColor = '#00b4c0'; // Color de fondo para viernes
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
      option.classList.add('optionHoras');
      select.appendChild(option);
    }
  }


</script>
</body>

</html>