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

<!-- <section id="informacion">


  <div class="contenedor1" id="infoSeccion">

      <h2> Doctor Fulanito  </h2><br>

      <p class="textoPricipal"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente fugit odio nesciunt alias officiis tempore rerum dolorem blanditiis at ad sed, iste cumque laborum repellendus minus repellat similique? Sapiente, labore.</p>

      <button id="botonSolicitud"> solicita una cita </button>

  </div>

  <div class="contenedor1" id="fotoPrincipal">

  <img src="uploads/.<?php echo $img_fondo; ?>" alt="Imagen de especialidad">
      
  </div>


</section> -->

<section class="directorio">


<div class="Doctores">

  <h2> Directorio Médico</h2>

  <div class="formularioDeNombres">
    <form action="Crud_Admin/barraBusquedaMedicos.php" method="GET" id="formularioBusqueda">

      <input id="inputBusquedaDeDoctor" type="text"  placeholder="busca el medico..." > 
      <input type="submit" name="busquedaDoctores" value="buscar" id="btnBuscar">

    </form>

  </div>

  <div class="formularioEspecialidades">

    <!-- <form action="Crud_Admin/filtroEspecialidades.php" method="GET">

        <select name="especialidad" id="specialty_id">
            <option value="">Seleccione una especialidad</option>
                    
              <?php
                //include "conex_bd.php";
                            
                 // $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades`");

                     // while($datos=$sql->fetch_object()){ ?>

                          <option value="<?php echo $datos->id_especialidad ?>"><?php echo $datos->nombre_esp?></option>

                      <?php
                          //$selectEspecialidad = $datos->nombre_esp;
                      //} 
                      ?>
        </select>

    </form> -->

    <form action="Crud_Admin/filtroEspecialidades.php" method="POST">
      <ul class="especialidades_list">

        <?php
          include "conex_bd.php";
          $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades`");

          while($datos = $sql->fetch_object()) {
        ?>
          <li><a href="#" class="especialidad-link" data-value="<?php echo $datos->id_especialidad ?>"><?php echo $datos->nombre_esp ?></a></li>
        <?php
          }
        ?>
      </ul>

      <!-- Campo oculto para enviar el ID de la especialidad al servidor -->
      <input type="hidden" id="selected_specialty_id" name="especialidad_id" value="">

      <!-- Botón de envío -->
      <!-- <button type="submit">Enviar</button> -->
    </form>

  </div>

 
</div>

<div class="contenedorDirectorio" >

  
  <div class="grupoDoctores" id="boxWithTarjetas">

  <?php 

      include "conex_bd.php";

      $consultaDatos = "SELECT cl.*, m.id_medico, m.id_especialidad, m.direccion, m.foto_perfil, m.fecha_nacimiento, e.nombre_esp AS nombre_especialidad FROM usuarios cl JOIN medicos m ON cl.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE cl.rol <> 5;";
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

  </div>

</section>

<?php include "footer.php";  ?>


<script>

  let especialidad 

  let barraBusqueda = document.getElementById('inputBusquedaDeDoctor');
  let contenedorTarjetas = document.getElementById('boxWithTarjetas');
  const inputFiltrar = document.getElementById("specialty_id");

 
  document.getElementById('formularioBusqueda').addEventListener('submit', function(event) {
    event.preventDefault();

    // barraBusqueda.innerHtml = inputFiltrar.value

    var palabraClave = barraBusqueda.value;
    console.log(palabraClave)

    // Si se seleccionó una especialidad
    // Usar fetch para hacer la solicitud
        fetch('Crud_Admin/barraBusquedaMedicos.php?palabra_id=' + palabraClave )
              .then(response => response.json())  // Procesamos la respuesta como JSON
              .then(data => {
                      // Limpiamos el select de médicos
                      contenedorTarjetas.innerHTML = '';

                      // Si hay médicos, los agregamos al select
                      if (data.success) {
                          // Crear un primer option para "Seleccionar un médico"
                          console.log(data);

                      
                          //Iterar sobre los resultados y agregar filas a la tabla
                          data.data.forEach(medico => {
                              // Crear una fila de la tabla

                              let codigoHtml = document.createElement('div');
                              
                              codigoHtml.innerHTML = `
                              <a href="descripcionDeMedicos.php?id=${medico.id_Medico}"  class="tarjetasNombres" id="enlaceDatos">
                                <div> 
                                  <img src="uploads/.${medico.fotoPerfil}" alt="doctor" width="120px" height="120px">
                                </div>
                                <div class="informacionDoctor"> 
                                  <h2>${medico.nombre} ${medico.apellido}</h2>
                                  <b>${medico.nombre_esp}</b>
                                </div>
                              </a>
                              
                              `
    
                              // // Agregar la fila al cuerpo de la tabla
                              contenedorTarjetas.appendChild(codigoHtml);
                          });
                    
                      } else {
                          // cuerpoTabla.innerHTML = "<tr><td colspan='6'>No se encontraron datos relacionados.</td></tr>";
                      }
                  })
                  .catch(error => {
                      console.error("Error al cargar los médicos:", error);
                  });
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Obtener todos los enlaces con la clase 'especialidad-link'
      const especialidadLinks = document.querySelectorAll('.especialidad-link');

      // Agregar un evento de clic a cada enlace
      especialidadLinks.forEach(link => {
        link.addEventListener('click', function(event) {
          event.preventDefault(); // Evitar que el enlace haga su acción por defecto

          // Obtener el valor de 'data-value' (ID de la especialidad)
          const specialtyId = this.getAttribute('data-value');

          console.log(specialtyId)

          // // Establecer el valor del campo oculto con el ID de la especialidad
          // document.getElementById('selected_specialty_id').value = specialtyId;

          // Cambiar el texto del enlace para reflejar la especialidad seleccionada
          // const selectedText = this.textContent;
          // document.querySelector('.especialidades-list li:first-child a').textContent = `Especialidad seleccionada: ${selectedText}`;

          // Enviar la solicitud al servidor con fetch
          fetch('Crud_Admin/filtroEspecialidades.php', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "espcialidad_id=" + specialtyId
          })
          .then(response => response.json())  // Procesar la respuesta como JSON
          .then(data => {

            contenedorTarjetas.innerHTML = '';
            
            // Puedes mostrar la respuesta en la página o hacer algo con los datos
            if (data.success) {

              console.log(data);

               //Iterar sobre los resultados y agregar filas a la tabla
                 data.data.forEach(medico => {
                     // Crear una fila de la tabla

                    let codigoHtml = document.createElement('div');
                              
                      codigoHtml.innerHTML = `
                              <a href="descripcionDeMedicos.php?id=${medico.id_Medico}"  class="tarjetasNombres" id="enlaceDatos">
                                 <div> 
                                  <img src="uploads/.${medico.fotoPerfil}" alt="doctor" width="120px" height="120px">
                                </div>
                                 <div class="informacionDoctor"> 
                                   <h2>${medico.nombre} ${medico.apellido}</h2>
                                   <b>${medico.nombre_esp}</b>
                                 </div>
                               </a>
                              
                       `
    
                     // Agregar la fila al cuerpo de la tabla
                         contenedorTarjetas.appendChild(codigoHtml);
                 });

            } else {
              // Si la respuesta no es exitosa, mostrar un mensaje de error
              alert('Hubo un error al seleccionar la especialidad');
            }
          })
          .catch(error => {
            console.error('Error al enviar los datos:', error);
            alert('Hubo un error al intentar enviar los datos');
          });
    });
  });
});



</script>

</body>

</html>