<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Cardiologia</title>
    <link rel="stylesheet" href="citas.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lilita+One&family=Lobster&family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  </head>

<?php include "header.php";  ?>

    <section class="registro_citas">

        <div class="formularios">

            <div id="RegistroPublicos">

                <h2>Ingresar Medico</h2>
                <form  method="post">
                <label for="nombre">Nombre</label>
                <input id ="nombre" type="text" placeholder="Nombre" class="nombreClase" name="nombre">

                <label for="Apellido">Apellido</label>
                <input id="Apellido" type="text" placeholder="Apellido" class="apellido" name="apellido">

                <label for="especialidad">Especialidad</label>
                <input id="especialidad" type="number" placeholder="Especialidad" class="especialidad" name="especialidad">

                <label for="direccion">Direccion</label>
                <input id="direccion" type="text" placeholder="Direccion" class="direccion" name="direccion">

                <label for="Telefono">Telefono</label>
                <input id="Telefono" type="text" placeholder="Telefono" name="telefono">

                <label for="Email">Correo Electronico</label>
                <input id="Email" type="email" placeholder="Correo Electronico" name="email" >

                <label for="cedula">Cedula</label>
                <input id="cedula" type="text" placeholder="Cedula" name="cedula" >

                <!-- <label for="Cargos">Cargos</label>
                <select id="CargosOpciones" name="Cargos">
                        <option value="Jefe">Jefe</option>
                        <option value="Obrero">Obrero</option>
                        <option value="administrativo">administrativo</option>
                 </select> -->

                <button type="submit" class="botonesLogin" id="botonRegistrarse" name="registrarMedicos" >REGISTAR</button>
                </form>

                <span class="resultado"> todos los campos son requedidos</span>

            </div>


        </div>
    

    </section>

    
    <?php

        include "conex_bd.php";
        include "isertarDatos.php";

    ?>  



<?php include "footer.php";  ?>