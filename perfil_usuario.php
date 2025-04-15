
<?php
    include "header.php";

        $id_usuario = $_SESSION["id"] ;

        include "conex_bd.php";

        $consultaMysql = "SELECT * FROM usuarios us JOIN perfil_usuario pf ON us.id = pf.id_usuario WHERE us.id = $id_usuario";
            // $cosultica = "SELECT * FROM clientes";
            $result= $conexion->query($consultaMysql);

            if ($result === false) {
                echo "Error en la consulta: " . $conexion->error;
            }else{
               
            }

            if($result->num_rows > 0){

                $formularioVisible = false; // Ocultar formulario
            }else{
                echo "completa tu perfil por favor";
                $formularioVisible = true;
            }

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

    <section class="formularios"  <?php if (!$formularioVisible) echo 'style="display:none;"'; ?>>

            <!-- <h2>Completa la informacion de tu perfil</h2> -->

            <div id="iniciarSeccion">

              <h2>Completa tu perfil de usuario</h2>
              <form action="isertarDatos.php" method="post" enctype="multipart/form-data">

                <input type='hidden' name='id' value='<?php echo $_SESSION["id"] ?>'>

                <label for="cedula">cedula</label>
                <input id="cedula" type="text" placeholder="cedula" name="cedula">

                <label for="direccion">direccion</label>
                <input id="direccion" type="text" placeholder="direccion" name="direccion">

                <label for="fecha_nac">fecha de Nacimiento</label>
                <input id="fecha_nac" type="date" placeholder="fecha de Nacimiento" name="fecha_nac">

                <label for="edad">edad</label>
                <input id="edad" type="number" placeholder="edad" name="edad">

                
                <label for="genero">genero</label>
                <select name="genero" id="sexo">
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="noSabe">39 tipos de gay</option>
                </select>

                <label for="alergias">alergias</label>
                <input id="alergias" type="text" placeholder="alergias" name="alergias">

                <label for="ocupacion">Ocupacion</label>
                <select name="ocupacion" id="ocupacion">
                    <option value="nada">en nada</option>
                    <option value="trabajo informal">chambas dispersas</option>
                    <option value="trabajo formal">empresa</option>
                </select>

                <label for="educacion">Nivel de Educacion</label>
                <select name="educacion" id="educacion">
                    <option value="nada">Sin estudios</option>
                    <option value="basica">basicos</option>
                    <option value="universitaria">universitarios</option>
                </select>

                <button type="submit" class="botonesLogin" name="perfilUsuario"> Guardar Perfil</button>

              </form>

              <a id="LinkRegistro">¿No tienes Cuenta?<span class="textoImport"> Crear una</span></a>
            </div>
    </section>

    <section class="informacionPersonal"  <?php if ($formularioVisible) echo 'style="display:none;"'; ?>>
        <div class="titlePerfil">
        <h1>Perfil:</h1>

        <div class="fotoPerfil">

            <div class="foto">foto</div>
            <p>Nombre y apellido</p>

        </div>

        </div>
        

        <?php
            include "conex_bd.php";
            $id_usuario = $_SESSION["id"] ;


            $consultaMysql = "SELECT * FROM usuarios us JOIN perfil_usuario pf ON us.id = pf.id_usuario WHERE us.id = $id_usuario";
            // $cosultica = "SELECT * FROM clientes";
            $result= $conexion->query($consultaMysql);

            if ($result === false) {
                echo "Error en la consulta: " . $conexion->error;
            }else{
        
            }

            // if($result->num_rows > 0){

            //     echo "si hay informacion gafo";
            //     $formularioVisible = false; // Ocultar formulario
            // }else{
            //     echo "completa tu perfil por favor";
            //     $formularioVisible = true;
            // }

            while($datos=$result->fetch_object()){ ?>

                <h2> Nombre: <?php echo $datos->nombre ?></h2><br>
                <h2> Apellido: <?php echo $datos->apellido ?></h2><br>
                <h2> Correo Electronico:<?php echo $datos->correo ?></h2><br>
                <h2> Telefono: <?php echo $datos->telefono ?></h2><br>
                <h2> Direccion: <?php echo $datos->direccion ?></h2><br>
                <h2> Fecha de nacimiento: <?php echo $datos->fecha_nacimiento ?></h2><br>
                <h2> Edad: <?php echo $datos->edad ?></h2><br>
                <h2> Sexo: <?php echo $datos->genero?></h2><br>
                <h2> alergias: <?php echo $datos->alergias?></h2><br>
                <h2> Ocupacion: <?php echo $datos->ocupacion ?></h2><br>
                <h2> Nivel de Estudio: <?php echo $datos->nivel_educacion ?></h2>
                
                <?php
            }
        
        
        ?>

        <button class="botonesLogin">editar</button>

        <a href="" class="botonesLogin">Reportes de citas</a>
    </section>

</body>
</html>



<?php include "footer.php";  ?>