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
  </head>

<?php include "header.php";  ?>

<section id="informacion">


  <div class="contenedor1" id="infoSeccion">
      <h2>Cardiología</h2><br>

      <p class="textoPricipal">Contamos con los mejores especialistas en el area,ademas de una infraestructura idónea, cómoda para los usuarios y completamente equipada con tecnología de punta, nuestro objetivo en todo momento de lograr el mayor bienestar para cada uno de nuestros usuarios.</p>

      <button id="botonSolicitud"> solicita una cita </button>

      <dialog id="dialogOnline" >
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
      </dialog>

  </div>

  <div class="contenedor1" id="fotoPrincipal">
      
  </div>


</section>

<section class="Servicios">

  <div class="ultrasonido" id="infoServicio">

  <h2>Servicio de Ultrasonido</h2>

  <p>Es una prueba de diagnóstico. Es un examen que utiliza ondas sonoras para observar el interior de los vasos sanguíneos. Es útil para evaluar las arterias coronarias que irrigan el corazón.</p>

  <button id="solicitarServicio">solicitar Servicio</button>


  <dialog id="AddServico"> 

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
  </dialog>
</div>

<div class="fotoServicio">
       
</div>

</section>


<section class="directorio">

<div class="Doctores"> 
  <h2> Directorio Médico</h2>
</div>

<div class="contenedorDirectorio">
  
  <div class="Grupo1">

    <a  class="tarjetasNombres" id="enlaceDatos">
        <div> 
            <img src="../imagenes/doctorArigas.jpeg" alt="doctor" width="120px" height="120px">
        </div>
        <div class="informacionDoctor"> 
            <h2>Jhoan Artigas</h2>
            <b>Cardiologo</b>
        </div>
    </a>

    <a  class="tarjetasNombres">
        <div> 
          <img src="../imagenes/doctora02.jpg" alt="doctor" width="120px" height="120px">
        </div>
        <div class="informacionDoctor"> 
          <h2>Mayli Guerra</h2>
          <b>Cardiologa</b>
        </div>
    </a>

      
    <a class="tarjetasNombres">
        <div> 
          <img src="../imagenes/retratoDeDoctor.jpg" alt="messimiami" width="120px" height="120px">
        </div>
        <div class="informacionDoctor"> 
          <h2>Cristian Zambrano</h2>
          <b>Cardiologo</b>
        </div>
    </a>

  </div>

  <div class="Grupo2">

    <a class="tarjetasNombres" id="enlaceDatos">
        <div> 
            <img src="../imagenes/doctor07.jpg" alt="messimiami" width="120px" height="120px">
        </div>
        <div class="informacionDoctor"> 
            <h2>Jose Azuaje</h2>
            <b>Cardiologo</b>
        </div>
    </a>

    <a  class="tarjetasNombres">
        <div> 
          <img src="../imagenes/doctora03.jfif" alt="messimiami" width="120px" height="120px">
        </div>
        <div class="informacionDoctor"> 
          <h2>Mariana Garcia</h2>
          <b>Cardiologa</b>
        </div>
    </a>

      
    <a class="tarjetasNombres">
        <div> 
          <img src="../imagenes/doctora04.jpg" alt="messimiami" width="120px" height="120px">
        </div>
        <div class="informacionDoctor"> 
          <h2>Paola Zambrano</h2>
          <b>Cardiologo</b>
        </div>
    </a>

  </div>

</section>


<section id="formulario">

<div class="cuadroFron">  
    <h2>informacion de Cliente </h2>
    <p>todos los campos son requeridos</p><br>

    <form action="" id="form">
        <label for="nombre">Nombre</label>
        <input id="nombre" type="text" placeholder="Nombre">

        <label for="Apellido">Apellido</label>
        <input id="Apellido" type="text" placeholder="Apellido">

        <label for="Cedula">Cedula de Indentidad</label>
        <input id="Cedula" type="text" placeholder="Cedula de Indentidad ">

        <label for="Email">Email</label>
        <input id="Email" type="email" placeholder="Email" >

        <label for="Telefono">Telefono</label>
        <input id="Telefono" type="number" placeholder="Telefono">

        <label for="Fecha">Fecha de nacimiento</label>
        <input id="Fecha" type="date" placeholder="Fecha de nacimiento">

        <label for="Edad">Edad</label>
        <input id="Edad" type="number"placeholder="Edad" >

        <label for="Sexo">Sexo</label>
        <select name="sexo" id="Sexo">
            <option value="1">Masculino</option>
            <option value="2">Femenino</option>
        </select>

        <button type="submit">Crear cita</button>
    </form>

 </div>


</section>

<script>
      
  const botonServicio = document.getElementById("solicitarServicio")
  botonServicio.addEventListener("click", ventanaEmergente)
  const contenedorDoctores = document.getElementById("listaDoctores")

  const bontonAgendar= document.getElementById("botonSolicitud")
  const cuadroDeFechas = document.getElementById("calendarioCita")
  bontonAgendar.addEventListener("click", mostrarDialog)

  let doctorescardiologos = []
  let botonesClass = []

  class DoctoresC{
  constructor(nombre, foto){
    this.nombre = nombre
    this.foto = foto
  }   




  let cardiologo1 = new DoctoresC("Jhoan Artigas", "../imagenes/doctorArigas.jpeg")

  let cardiologo2 = new DoctoresC("Maily Guerra", "../imagenes/doctora02.jpg")

  let cardiologo3 = new DoctoresC("Cristian Zambrano", "../imagenes/retratoDeDoctor.jpg")

  let cardiologo4 = new DoctoresC("Mariana Garcia", "../imagenes/doctora03.jfif")

  let cardiologo5 = new DoctoresC("Paola Jimenez", "../imagenes/doctora04.jpg")

  let cardiologo6 = new DoctoresC("Jose Azuaje", "../imagenes/doctor07.jpg")

  doctorescardiologos.push(cardiologo1, cardiologo2, cardiologo3, cardiologo4, cardiologo5, cardiologo6)


  function ventanaEmergente(){

  const dialog = document.getElementById("AddServico");
  dialog.showModal(); 
  }

  function mostrarDialog(){
  const dialog = document.getElementById("dialogOnline");
  dialog.showModal();

  contenedorDoctores.innerHTML= ""

  doctorescardiologos.forEach((medico) =>{
  listaObetos= `
    <a class="dotorCardiologo EventoPro" id=${medico.nombre}>
        <img src=${medico.foto} alt=${medico.nombre} class="fotoDoctor">
          <p>${medico.nombre}</p>
    </a>`

    contenedorDoctores.innerHTML += listaObetos
  })

  botonesClass = document.querySelectorAll(".EventoPro")

  botonesClass.forEach(boton =>{
  boton.addEventListener("click", mostrarFecha)
  })

  }

  function mostrarFecha(){

  cuadroDeFechas.style.display ="flex"
  }

</script>



<?php include "footer.php";  ?>





