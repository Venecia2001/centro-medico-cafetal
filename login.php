<?php
session_start();
include("conex_bd.php");

// print_r($_SESSION);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="longinCss.css">
</head>
<body>

    <section class="formularios">


    <div class="cuadrocompleto">
      
            <div id="iniciarSeccion">

              <h2>Iniciar Sesion</h2>
              <form action="controladorSession.php" method="post">

                <label for="nombre">Usuario</label>
                <input id="nombre" type="text" placeholder="Usuario" name="usuario">

                <label for="Contraseña">Contraseña</label>
                <input id="Contraseña" type="password" placeholder="Contraseña"  name="password">

                <button type="submit" class="botonesLogin" name="loginUsuarios"> INGRESAR</button>

              </form>

              <a href="registroUsuarios.php" id="LinkRegistro">¿No tienes Cuenta?<span class="textoImport"> Crear una</span></a>
              
              <?php 
                if (isset($_SESSION['error_login'])) {
                  // Mostrar el mensaje de error
                  echo "<p class='textoError' style='color: red;'>" . $_SESSION['error_login'] . "</p>";
                  
                  // Limpiar el mensaje de error después de mostrarlo
                  unset($_SESSION['error_login']);
                }
              
              ?>

            </div>



        <div class="cuadroWithImg">

          <p></p>

        </div>
    </div>

    </section>


</body>
</html>