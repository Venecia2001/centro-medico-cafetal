<?php include "header.php";  ?>

<div class="seccionInicio">

    <section id="seccionInicio1">

            <?php 

                include "conex_bd.php";

                $consultaSeccion1 ="SELECT * FROM secciones_pagina WHERE id_seccion = 1";
                $resultadoSql = mysqli_query($conexion, $consultaSeccion1);

                while($data = $resultadoSql->fetch_array()){
                    $idSeccion = $data["id_seccion"];
                    $titulo = $data['titulo_seccion'];
                    $descripcion = $data['descripcion_seccion'];
                    $fotoRelacionada = $data['imgen_seccion'];
                    $textoDeBoton = $data["texto_btn"];

                }
 
            ?>

        <h1><?php echo $titulo ?></h1>
        <p><?php echo $descripcion ?></p>

          <?php
            $ocultarBoton = isset($_SESSION['usuario']) ? "oculto" : "";
          ?>

          <button id="botonInicio" class="<?php echo $ocultarBoton; ?>">
              <a href="registroUsuarios.php"><?php echo $textoDeBoton; ?></a>
          </button>
          
        <!-- <button id="botonInicio"> <a href="registroUsuarios.php"> <?php echo $textoDeBoton ?></a></button> -->


        <?php 
        if(!empty($_SESSION['usuario'])) { ?>

          <p id="sesionUsuarioPhp"> <?php echo "bienvenid@".$_SESSION["nombre"]." ".$_SESSION["apellido"]; ?> </p>
        <?php
        }
        ?>

    </section>

    <img src="uploads/.<?php echo $fotoRelacionada ?>" alt="Imagen de especialidad">

</div>

<div id="cardiologia" class="SeccionEspecialidades">
    <div class="tituloEsecialidad">
      <h2 id="titulo2">Especialidades Médicas</h2>
    </div>

    <div class="especialidades">

          <?php 
          
            include "conex_bd.php";

            $getDatosTarjetas ="SELECT id_especialidad, nombre_esp, imagen_fondo FROM especialidades;";
            $resultadosDatos = mysqli_query($conexion, $getDatosTarjetas);

            while($datos = $resultadosDatos->fetch_assoc()){

              $idEspecialidad = $datos['id_especialidad'];
              $nombre_esp = $datos['nombre_esp'];
              $img_fondo = $datos['imagen_fondo'];

            ?>

            <a href="paginasEspecialidades.php?id=<?php echo $idEspecialidad; ?>" class="tarjetas">

                <div class="tituloTarjeta" > 
                  <h2><?php echo $nombre_esp ?></h2> 
                </div>

                <img src="uploads/.<?php echo $img_fondo; ?>" alt="Imagen de especialidad">
            </a>


              <?php
            }
        
          ?>
    </div>
      
</div>

<section class='contenerdorGradeCitasOnline'>

  <section id="contenedorPrincipal">

      
        <?php 

          include "conex_bd.php";

          $consultaSeccion2 ="SELECT * FROM secciones_pagina WHERE id_seccion = 2";
          $resultadoSql = mysqli_query($conexion, $consultaSeccion2);

          while($data = $resultadoSql->fetch_array()){
              $idSeccion2 = $data["id_seccion"];
              $titulo2 = $data['titulo_seccion'];
              $descripcion2 = $data['descripcion_seccion'];
              $fotoRelacionada2 = $data['imgen_seccion'];
              $textoDeBoton2 = $data["texto_btn"];

          }

        ?>

      <div id="citaOnline">
          <h2><?php echo $titulo2?></h2>
      </div>

      <div id="contenedorCita">

          <div class="cita" id="listaDeCitas">

            <div class="MargenArriba"></div>

              <h3 id="H3Online"><?php echo $descripcion2?></h3>
              <ul>
                  <li>Cardiología</li>
                  <li>Odontología</li>
                  <li>Traumatología</li>
              </ul>

              <button id="citasOnline"><?php echo $textoDeBoton2?></button>

              <div class="Margenabajo"></div>

          </div>

          <div class="cita" id="imagenOnline">
          <img src="uploads/.<?php echo $fotoRelacionada2; ?>" alt="Imagen de especialidad">

          </div>

      </div>

  </section>

</section>

<section class="secttionMedicos">

        <?php 

          
          include "conex_bd.php";

          $consultaSeccion3 ="SELECT * FROM secciones_pagina WHERE id_seccion = 3";
          $resultadoSql = mysqli_query($conexion, $consultaSeccion3);

          while($data = $resultadoSql->fetch_array()){
              $idSeccion3 = $data["id_seccion"];
              $titulo3 = $data['titulo_seccion'];
              $descripcion3 = $data['descripcion_seccion'];
              $fotoRelacionada3 = $data['imgen_seccion'];
              $textoDeBoton3 = $data["texto_btn"];

          }

        ?>

        <div class="contenedorInfoDoctor">

          <div id="contenedorCita">

                <div class="cita" id="directorio">
                    <h3 id="H3InfoDoctores"> <?php echo $titulo3 ?> </h3>
                    
                    <p class="ParafoEspecialistas"><?php echo $descripcion3 ?></p>

                    <button id="btnDirectorio"><a href="Medicos_SanPedro.php"> <?php echo $textoDeBoton3 ?> </a></button>

                    
              </div>

              <div class="cita" id="imagenMedicos">

                <img src="uploads/.<?php echo $fotoRelacionada3; ?>" alt="Imagen de especialidad">
                
              </div>
            </div>

        </div>

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

                <button> <a id="enlaceRegistro" href="registroUsuarios.php"> <?php echo $textoDeBoton ?></a> </button>

            </div>
          </div>


        </dialog>

</section>

<section id="espacioDeServicios">
  <?php 

    include "conex_bd.php";

    $consultaSeccion4 ="SELECT * FROM secciones_pagina WHERE id_seccion = 4";
    $resultadoSql = mysqli_query($conexion, $consultaSeccion4);

    while($data = $resultadoSql->fetch_array()){
        $idSeccion4 = $data["id_seccion"];
        $titulo4 = $data['titulo_seccion'];
        $descripcion4 = $data['descripcion_seccion'];
        $fotoRelacionada4 = $data['imgen_seccion'];
        $textoDeBoton4 = $data["texto_btn"];

    }

  ?>


  <div class="contenedorServicios">

    <div class="informacionServicios" id="inforImportante">

    <h2> <?php echo $titulo4 ?> </h2>

    <p id="conceptoServicios"> <?php echo $descripcion4 ?> </p>
    <button id="btnDeServicios"><a href="paginaServicios.php">  <?php echo $textoDeBoton4 ?> </a> </button>
    </div>


    <div class="informacionServiciosImg" id="fotoDeLosServicios">

    <img src="uploads/.<?php echo $fotoRelacionada4; ?>" alt="Imagen de especialidad">

      
    </div>

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
                        <input type="date" id="fechaNacimientoMenor" name="fechaNacimientoMenor" max="<?= date('Y-m-d'); ?>">

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
                      <input type="hidden" id="specialty_id_hidden" name="especialidad" value="">
                      <input type="hidden" id="specialty_name_hidden" name="especialidad_nombre" value="">
                      
                      <?php
                          include "conex_bd.php";
                                
                          $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades`");

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
    

<?php include "footer.php";  ?>

          <?php
            include "conex_bd.php";
            include "isertarDatos.php";
          ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Incluir el archivo de idioma de Flatpickr en español -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>


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


    document.querySelectorAll('.especialidad').forEach(div => {
      div.addEventListener('click', function () {
        // Quitar selección previa
        document.querySelectorAll('.especialidad').forEach(el => el.classList.remove('seleccionada'));

        // Marcar actual
        this.classList.add('seleccionada');

        // Guardar ID en input hidden
        // document.getElementById('specialty_id_hidden').value = this.dataset.id;

        // console.log("Especialidad seleccionada:", this.dataset.id);
        
        // Aquí puedes disparar otras funciones como cargar doctores, etc.
        // cargarMedicos(this.dataset.id);
      });
    });

    document.addEventListener('DOMContentLoaded', function () {
      const especialidades = document.querySelectorAll('.especialidad');
      const inputId = document.getElementById('specialty_id_hidden');
      const inputNombre = document.getElementById('specialty_name_hidden');

      especialidades.forEach(function (esp) {
        esp.addEventListener('click', function () {
          const id = this.getAttribute('data-id');
          const nombre = this.textContent.trim();

          inputId.value = id;
          inputNombre.value = nombre;

          // Opcional: resaltar la selección
          especialidades.forEach(e => e.classList.remove('selected'));
          this.classList.add('selected');
        });
      });
    });


  const pPhp = document.getElementById("sesionUsuarioPhp");

  // if(pPhp.innerHtml == ""){
  //   console.log("no se ha iniciado sesion alguna")
  // }else{
  //   console.log(pPhp.innerHTML);
  // }
  // Verificar si el contenido del elemento no está vacío
  // console.log(pPhp.innerHTML);

  let horaDeInicio = null;
  let horaDeCierre = null;

  const botonTraumatologia =document.getElementById("traumatologia")
  const botonOdontologia =document.getElementById("odontologia")
  const botonInicio = document.getElementById("botonInicio")
  const botonCitas= document.getElementById("citasOnline")
  const botonCardiologia = document.getElementById("cardio")
  const inicioSesion =document.getElementById("iniciarSeccion")
  const RegistroUsuario = document.getElementById("RegistroUsuario")


  // const botonInicioSesion = document.getElementById("botonInicoSesion")
  // const botonMostrarRegistro = document.getElementById("botonRegistro")

  const cuadroDeFechas = document.getElementById("calendarioCita")
  const listaDoctores = document.getElementById("listaDoctores")

  if (pPhp && pPhp.textContent.trim() !== "") {


    console.log("El elemento tiene texto y es"+ pPhp.textContent);
    botonCitas.addEventListener("click", openModal)

  } else {

    console.log("El elemento está vacío o no tiene texto");
    botonCitas.addEventListener("click", openMensajeAdvertencia)

  }

// Parte de formularios 

  // const imputNombre = document.querySelector(".nombreClase")
  // const inputApellido = document.querySelector(".ApellidoClase")
  // const inputTelefono = document.getElementById("Telefono")
  // const inputEmail = document.getElementById("Email")
  // const inputContraseña = document.getElementById("clave")
  // const inputRepeatContraseña = document.getElementById("claveRepeat")
  // const spanResultado = document.querySelector(".resultado")

  let fechaUsuario = null;   

  // const botonEviar = document.getElementById("botonRegistrarse")
  // botonEviar.addEventListener("click", (e) =>{
  //   let error = validarFormulario();
  //   if(error[0]){
  //       spanResultado.innerHTML = error[1];
  //       spanResultado.classList.add("red")
  //   }else{
  //       spanResultado.innerHTML = "te has registrado corectamente"
  //       spanResultado.classList.add("green")
  //       spanResultado.classList.remove("red")
  //   }
  // })
  

  let listaObetos
  botonInicio.addEventListener("click", openLogin)
  
  function openMensajeAdvertencia(){
    const dialog = document.getElementById("mesajeCitaOnline");
    dialog.showModal(); 
  }

  
  // function mostrarFronRegistro(){
  //   inicioSesion.style.display = "none"
  //   botonMostrarRegistro.classList.add("botonesLoginSelecionado");
  //   botonMostrarRegistro.classList.remove("botonesLogin")
  //   botonInicioSesion.classList.remove("botonesLoginSelecionado")
  //   botonInicioSesion.classList.add("botonesLogin")

  //   RegistroUsuario.style.display ="flex"

  // }

  // function mostrarFormInicio(){

  //   inicioSesion.style.display = "flex"
  //   botonInicioSesion.classList.add("botonesLoginSelecionado");
  //   botonInicioSesion.classList.remove("botonesLogin")
  //   botonMostrarRegistro.classList.remove("botonesLoginSelecionado")
  //   botonMostrarRegistro.classList.add("botonesLogin")

  //   RegistroUsuario.style.display ="none"

  // }

  // function mostrarFron(){

  //   inicioSesion.style.display = "none"
  //   botonMostrarRegistro.classList.add("botonesLoginSelecionado");
  //   botonMostrarRegistro.classList.remove("botonesLogin")
  //   botonInicioSesion.classList.remove("botonesLoginSelecionado")
  //   botonInicioSesion.classList.add("botonesLogin")
    
  //   RegistroUsuario.style.display ="flex"
  // }

  function openLogin(){
    const dialog = document.getElementById("DialogRegistro");
    dialog.showModal();
  }

  function openModal(){

    const dialog = document.getElementById("dialogCitasOnline");
     dialog.showModal(); 

  }
  
  function mostrarFecha(){

    cuadroDeFechas.style.display ="flex"
  }

    //Mostrar medicos dependiendo de la especialidad de manera dinamica 

    document.addEventListener("DOMContentLoaded", function() {
            // Obtener el campo de especialidades y médicos
            var doctorSelect = document.getElementById('doctor_id');

            // Cuando se cambia la especialidad
            document.querySelectorAll('.especialidad').forEach(item => {
                item.addEventListener('click', function () {
                const specialty_id = this.dataset.id;
                document.getElementById('specialty_id_hidden').value = specialty_id;

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
            });
            });
        })
             

            // Función para obtener horarios según el médico seleccionado

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

            const hoy = new Date();
            const fechaMaxima = new Date(hoy.setMonth(hoy.getMonth() + 6));

            // Formatear la fecha máxima a "YYYY-MM-DD"
            const fechaMaximaStr = fechaMaxima.toISOString().split('T')[0];

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
                    maxDate: fechaMaximaStr, // Limitar a 6 meses
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
                                } else if (day === 6) {  // Sabado
                                    dayElem.style.backgroundColor = '#4c1a1a'; // Color de fondo para Sabado
                                    dayElem.style.color = '#ffffff';           // Color del texto para viernes
                                } else if (day === 0) {  // Domingo
                                    dayElem.style.backgroundColor = '#39b8df'; // Color de fondo para Domingo
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

            // Llamar a la función para generar las horas
            

              

    
</script>
   
