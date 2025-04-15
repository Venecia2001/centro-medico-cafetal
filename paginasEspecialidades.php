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
  </head>

<?php include "header.php";  ?>

<section id="informacion">


  <div class="contenedor1" id="infoSeccion">

    <?php 
    
    ?>

      <h2> <?php echo $nombre_esp ?></h2><br>

      <p class="textoPricipal"> <?php echo $descripcion_esp ?></p>

      <button id="botonSolicitud"> solicita una cita </button>

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

  
  <div class="Grupo1">

  <?php 

      include "conex_bd.php";

      $consultaDatos = "SELECT cl.*, m.id_medico, m.id_especialidad, m.direccion, m.cedula, m.foto_perfil, m.fecha_nacimiento, e.nombre_esp AS nombre_especialidad FROM usuarios cl JOIN medicos m ON cl.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE e.id_especialidad = $idEspecialidad AND cl.rol <> 5;";
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
          $cedula = $data['cedula'];
          $fotoPerfil = $data['foto_perfil'];
          $fechaNac = $data['fecha_nacimiento'];

      ?>
          <a href="descripcionDeMedicos.php?id=<?php echo $idMed; ?>"  class="tarjetasNombres" id="enlaceDatos">
        <div> 
            <img src="uploads/.<?php echo $fotoPerfil ?>" alt="doctor" width="120px" height="120px">
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

<?php include "footer.php";  ?>

</body>

</html>