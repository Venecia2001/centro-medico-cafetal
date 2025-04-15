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


<section class="directorio">


    <div class="Doctores">

        <h2> Servicios Médicos</h2>

        
    </div>

    <div class="contenedorDirectorio" >

    
        <div class="grupoDoctores" id="boxWithTarjetas">

                <?php 

                include "conex_bd.php";

                $consultaDatos = "SELECT * FROM servicios WHERE id_servicio != 5";
                $resultadosConsulta = mysqli_query($conexion, $consultaDatos);

                while($data = $resultadosConsulta->fetch_array()){

                    $idServicio = $data["id_servicio"];
                    $nombreSer = $data['nombre_servicio'];
                    $descripcion = $data['descripcion'];
                    $fotoDelServicio = $data['img_relacionada'];
                 
                ?>

                    <a href="#"  class="tarjetasServicios" id="enlaceServicios">
                        <div class="contentImg"> 
                            <img src="imagenes/<?php echo $fotoDelServicio; ?>" alt="Imagen de especialidad">
                        </div>
                        <div class="informacionDoctor"> 
                            <h2><?php echo $nombreSer ?></h2>
                            <b><?php echo $descripcion  ?></b>
                        </div>
                    </a>
                   
                
                <?php

            }
            
            ?>


                  


        </div>





    </div>



</section>

<?php include "footer.php";  ?>

</body>

</html>