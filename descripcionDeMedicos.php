<?php 

      include "conex_bd.php";

      if (isset($_GET['id'])) {

        $idMedico = $_GET['id'];

        $consultaDatos = "SELECT cl.*, m.id_medico, m.id_especialidad, m.direccion, m.foto_perfil, m.fecha_nacimiento, m.titulación_academica, m.perfil_experiencia, e.nombre_esp AS nombre_especialidad FROM usuarios cl JOIN medicos m ON cl.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE m.id_medico = $idMedico ;";
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
    </a> -->


<?php include "footer.php";  ?>

</body>

</html>