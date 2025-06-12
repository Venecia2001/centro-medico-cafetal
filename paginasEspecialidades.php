<?php 

    include "conex_bd.php";

    // Verificar si el parámetro 'id' está presente en la URL
    if (isset($_GET['id'])) {

        $idEspecialidad = $_GET['id'];


        $consulta ="SELECT esp.*, ser.* FROM especialidades esp JOIN servicios ser ON esp.servicio_id = ser.id_servicio WHERE esp.id_especialidad = $idEspecialidad";
        $resultadoConsulta = mysqli_query($conexion, $consulta);

        while($datos = $resultadoConsulta->fetch_assoc()){
            
            $nombre_esp = $datos['nombre_esp'];
            $descripcion_esp =$datos['descripcion_esp'];
            $img_fondo = $datos['imagen_fondo'];
            $idServicio = $datos['servicio_id'];
            $ServicioNombre = $datos['nombre_servicio'];
            $descripcion_ser = $datos['descripcion'];
            $foto_servicio = $datos['img_relacionada'];
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

<section id="informacion">


  <div class="contenedor1" id="infoSeccion">

    <?php 
    
    ?>

      <h2> <?php echo $nombre_esp ?></h2><br>

      <p class="textoPricipal"> <?php echo $descripcion_esp ?></p>


      <?php 
        if (!empty($_SESSION['usuario'])) {
            $nombreCompleto = "bienvenid@ " . $_SESSION["nombre"] . " " . $_SESSION["apellido"];
            ?>
            <input type='hidden' id="sesionUsuarioPhp" value='<?php echo htmlspecialchars($nombreCompleto, ENT_QUOTES, "UTF-8"); ?>'>
      <?php
      } else {
      ?>
        <input type='hidden' id="sesionUsuarioPhp" value=''>
      <?php
      }
      ?>

          <!-- <input type='hidden' id="sesionUsuarioPhp" value='<?php echo "bienvenid@".$_SESSION["nombre"]?>'> -->
        

      <button id="botonSolicitud"> solicita una cita </button>

      <dialog id="mesajeCitaOnline"> 

          <div class="bodyMensaje">

            <form method="dialog">
                  <button class="ModalClose"> X</button>
            </form>

            <div class="textAlUser">
                  <h2>¡Atención!</h2>

              <p>
                Para agendar una cita médica, primero necesitas estar registrado como usuario.
                Si aún no tienes una cuenta, por favor regístrate para poder acceder a nuestros servicios.
                </p>

                <button> <a id="enlaceRegistro" href="registroUsuarios.php"> Regístrate Ahora </a> </button>

            </div>
          </div>


      </dialog>

      <!-- <dialog id="dialogOnline" >
        <div class="contenidoDialog"> 

            <div class="headerModel">
              <h2> Citas Online</h2>

              <form method="dialog">
                <button class="ModalClose"> X</button>
              </form>
            </div>

          <div class="contenedorDialog"> 

              <div class="segmento" id="especialidades">

                <div class="tituloDeSegmento"> Especialidades </div>

                <div id="listaEspecialidades">

                  <a id="cardio">Cardiología</a>
              
                </div>
              </div>

              <div class="segmento" id="doctores ">

                <div class="tituloDeSegmento" > Doctores </div>

                  <div id="listaDoctores"> </div>

                </div>

              <div class="segmento" id="fechas">

                <div class="tituloDeSegmento"> Fechas </div>

                <div id="calendarioCita">
                  
                  <div class="cuadroDePrueba">

                        <div class="grid-iten diasSemana" >LUNES</div>
                        <div class="grid-iten diasSemana">MARTES</div>
                        <div class="grid-iten diasSemana">MIERCOLES</div>
                        <div class="grid-iten diasSemana">JUEVES</div>
                        <div class="grid-iten diasSemana">VIERNES</div>
                        <div class="grid-iten diasSemana">SABADO</div>
                        <div class="grid-iten diasSemana">DOMINGO</div>

                        <div class="grid-iten" id="PrimerDay">1</div>
                        <div class="grid-iten" >2</div>
                        <div class="grid-iten">3</div>
                        <div class="grid-iten">4</div>
                        <div class="grid-iten">5</div>
                        <div class="grid-iten">6</div>
                        <div class="grid-iten">7</div>
                        <div class="grid-iten">8</div>
                        <div class="grid-iten">9</div>
                        <div class="grid-iten">10</div>
                        <div class="grid-iten">11</div>
                        <div class="grid-iten">12</div>
                        <div class="grid-iten">13</div>
                        <div class="grid-iten">14</div>
                        <div class="grid-iten">15</div>
                        <div class="grid-iten">16</div>
                        <div class="grid-iten">17</div>
                        <div class="grid-iten">18</div>
                        <div class="grid-iten">19</div>
                        <div class="grid-iten">20</div>
                        <div class="grid-iten">21</div>
                        <div class="grid-iten">22</div>
                        <div class="grid-iten ">23</div>
                        <div class="grid-iten DiaDispinible" >24</div>
                        <div class="grid-iten">25</div>
                        <div class="grid-iten DiaDispinible">26</div>
                        <div class="grid-iten">27</div>
                        <div class="grid-iten DiaDispinible">28</div>
                        <div class="grid-iten ">29</div>
                        <div class="grid-iten">30</div>
                        <div class="grid-iten">31</div>
                  </div>

                  <div id="contenedorDeHoras">
                    <h2 id="tituloHoras">Hora disponibles</h2>

                    <div class="cuadroHoras">
                      <div class="grid-horas" >8:00AM</div>
                      <div class="grid-horas">9:00AM</div>
                      <div class="grid-horas">10:00AM</div>
                      <div class="grid-horas">11:00AM</div>
                      <div class="grid-horas">12:00PM</div>
                    </div>
                  </div>

                </div>
              </div>
              
          </div>
          
          <div class="contenedorBoton">
            <button id="botonDialog" > Continuar</button>
          </div>

        </div>
      </dialog> -->

  </div>

  <div class="contenedor1" id="fotoPrincipal">

  <img src="uploads/.<?php echo $img_fondo; ?>" alt="Imagen de especialidad">
      
  </div>


</section>

<section class="Servicios">

  <div class="ultrasonido" id="infoServicio">

  <h2><?php echo $ServicioNombre ?></h2>

  <p> <?php echo $descripcion_ser ?></p>

  <button id="solicitarServicio">solicitar Servicio</button>


  <!-- <dialog id="AddServico"> 

      <div class="encabezado">
        <h2>Servicio Ultresonido </h2>
      </div>

      <form method="dialog">
        <button class="ModalClose"> X</button>
      </form>
      
      <div class="cuadroInterno">

        <div class="informacionPersonal">

          <div id="imagenNombre">
            
          </div>

          <div id="MetodoPago" class="texto">
            <h2>Metodos de pago</h2>

            <img src="../imagenes/paypal-logo-promo.png" alt="logo de paypal" width="120px"> 

            <p>Realice su pago registrándonos como:
              GRUPO MÉDICO SAN PEDRO, C.A.
              pagos@grupomedsp.com</p>

            <p>
              Estimado usuario, una vez comprado y procesado su pago, para disfrutar del servicio, debe comunicarse a los teléfonos 0414/0424254 CLINICA (2546433) coordinando así su respectiva cita.</p>

            <button>Pagar Servicio </button>
          </div>
      </div>
  </dialog> -->
</div>

<div class="fotoServicio">

  <img src="imagenes/<?php echo $foto_servicio; ?>" alt="Imagen de especialidad">
       
</div>

</section>


<section class="directorio">

<div class="Doctores"> 
  <h2> Directorio Médico</h2>
</div>

<div class="contenedorDirectorio">

  
  <div class="grupoDoctores">

  <?php 

      include "conex_bd.php";

      $consultaDatos = "SELECT cl.*, m.id_medico, m.id_especialidad, m.direccion, m.foto_perfil, e.nombre_esp AS nombre_especialidad FROM usuarios cl JOIN medicos m ON cl.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE e.id_especialidad = $idEspecialidad AND cl.rol <> 5;";
      $resultadosConsulta = mysqli_query($conexion, $consultaDatos);

      while($data = $resultadosConsulta->fetch_array()){

          $idMed = $data["id"];
          $nombreMed = $data['nombre'];
          $apellidoMed = $data['apellido'];
          $telefono = $data["telefono"];
          $correo = $data["correo"];
          $clave = $data["contraseña"];
          $nombre_esp = $data['nombre_especialidad'];
          $direccion = $data['direccion'];
          $fotoPerfil = $data['foto_perfil'];
          $fechaNac = $data['fecha_nacimiento'];

      ?>
          <a href="descripcionDeMedicos.php?id=<?php echo $idMed; ?>"  class="tarjetasNombres" id="enlaceDatos">
        <div> 
            <img src="uploads/.<?php echo $fotoPerfil ?>" alt="doctor" width="135px" height="160px">
        </div>
        <div class="informacionDoctor"> 
            <h2><?php echo $nombreMed." ".$apellidoMed ?></h2>
            <b><?php echo $nombre_esp ?></b>
        </div>
    </a>
    
      <?php

  }

?>
<!--  
    <a  class="tarjetasNombres" id="enlaceDatos">
        <div> 
            <img src="../imagenes/doctorArigas.jpeg" alt="doctor" width="120px" height="120px">
        </div>
        <div class="informacionDoctor"> 
            <h2>Jhoan Artigas</h2>
            <b>Cardiologo</b>
        </div>
    </a>
  </div> -->

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

                      <input type="hidden" value="<?php echo $_SESSION["rolUser"]; ?>" name="rol_usuario">
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

                      <input type="hidden" id="specialty_id_hidden" name="especialidad" value="<?php echo $idEspecialidad ?>">
                      <input type="hidden" id="specialty_name_hidden" name="especialidad_nombre" value="<?php echo $nombre_esp?>">
                      
                      <?php
                          include "conex_bd.php";
                                
                          $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades` WHERE id_especialidad = $idEspecialidad");

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
                    <input type="hidden" name="medico_id" id="medico_id_hidden">
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
                      <input type="text" id="fechaPruebas" placeholder="aaaa/mm/dd" name="fecha" />

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


<?php include "footer.php";  ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Incluir el archivo de idioma de Flatpickr en español -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>

  const pPhp = document.getElementById("sesionUsuarioPhp").value;

  const botonCitas= document.getElementById("botonSolicitud");

  if (pPhp !== "") {
        console.log("El elemento tiene texto y es: " + pPhp);
        botonCitas.addEventListener("click", openModal);
    } else {
        console.log("El elemento está vacío o no tiene texto");
        botonCitas.addEventListener("click", openMensajeAdvertencia);
    }


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


      // const botonCitas = document.getElementById('botonSolicitud')
      // botonCitas.addEventListener("click", openModal)

      function openModal(){

        const dialog = document.getElementById("dialogCitasOnline");
        dialog.showModal(); 

      }

      function openMensajeAdvertencia(){
        const dialog = document.getElementById("mesajeCitaOnline");
        dialog.showModal(); 
      }

        document.addEventListener("DOMContentLoaded", function() {
            // Obtener el campo de especialidades y médicos
            let doctorSelect = document.getElementById('doctor_id');
            let specialty_id = document.getElementById('specialty_id_hidden').value

              // Cuando se cambia la especialidad
                console.log(specialty_id);

                fetch('obtener_medicos.php?specialty_id=' + specialty_id)
                .then(response => response.json())
                .then(data => {

                    console.log(data);
                    const doctorContainer = document.getElementById('doctorContainer');
                    doctorContainer.innerHTML = '';

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
                    });

                    doctorContainer.appendChild(doctorDiv);

                    doctorDiv.addEventListener('click', function () {
                    // Quitar selección previa
                    document.querySelectorAll('.doctor-item').forEach(el => el.classList.remove('seleccionado'));

                    // Marcar el actual como seleccionado
                    this.classList.add('seleccionado');

                    // Guardar el ID en un input hidden si estás usando uno
                    document.getElementById('medico_id_hidden').value = this.dataset.id;

                    // Mostrar en consola
                    console.log("Seleccionado:", this.dataset.id);

                    // 👉 Llamar a cargarHorarios pasándole el id del médico
                        cargarHorarios(this.dataset.id);
                    });

                });

                

                } else {
                doctorContainer.innerHTML = '<div>No hay médicos disponibles.</div>';
                }
            });
        })

        function cargarHorarios(){

          let medicoId = document.getElementById("medico_id_hidden").value;
          // let fechasDis = document.getElementById("fecha");

          console.log("este es la cadena 2"+medicoId)

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
                      }else if (day === 6) {  // Sabado
                          dayElem.style.backgroundColor = '#4c1a1a'; // Color de fondo para Sabado
                          dayElem.style.color = '#ffffff';           // Color del texto para Sabado
                      }else if (day === 0) {  // Domingo
                          dayElem.style.backgroundColor = '#39b8df'; // Color de fondo para Domingo
                          dayElem.style.color = '#ffffff';           // Color del texto para Domingo
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

// Llamar a la función para generar las horas





</script>

</body>

</html>