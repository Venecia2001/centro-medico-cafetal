
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

              <h2>Completa tu Perfil</h2>
              <form action="isertarDatos.php" method="post" enctype="multipart/form-data">

                <input type='hidden' name='id' value='<?php echo $_SESSION["id"] ?>'>

                <label for="direccion">Direccion</label>
                <input id="direccion" type="text" placeholder="direccion" name="direccion">

                <label for="edad">Edad</label>
                <input id="edad" type="number" placeholder="edad" name="edad">

                
                <label for="genero">Genero</label>
                <select class='opcionesRol' name="genero" id="sexo">
                    <option value="nada">Seleccione Sexo</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <!-- <option value="noSabe">39 tipos de gay</option> -->
                </select>

                <label for="alergias">Alergias</label>
                <input id="alergias" type="text" placeholder="alergias" name="alergias">

                <label for="ocupacion">Ocupacion</label>
                <select class='opcionesRol' name="ocupacion" id="ocupacion">
                    <option value="nada">Seleccione Ocupacion</option>
                    <option value="nada">Desempleado</option>
                    <option value="trabajo informal">chambas dispersas</option>
                    <option value="trabajo formal">empresa</option>
                </select>

                <label for="educacion">Nivel de Educacion</label>
                <select class='opcionesRol' name="educacion" id="educacion">
                    <option value="nada">Seleccione Educacion</option>
                    <option value="nada">Sin estudios</option>
                    <option value="basica">basicos</option>
                    <option value="universitaria">universitarios</option>
                </select>

                <button type="submit" id="botonEditar" name="perfilUsuario"> Guardar Perfil</button>

              </form>
            </div>
    </section>

    <section class="contendorPerfil"  <?php if ($formularioVisible) echo 'style="display:none;"'; ?>>


        <div class='datosPersonales-citasProximas'>
            <div class='datosPersonales'>

                <div class='head_head_datos'>

                    <h2>Datos Personales</h2>

                </div>

                <div class='bodyDatosPersonales'>
                    <?php
                        include "conex_bd.php";
                        $id_usuario = $_SESSION["id"] ;

                        $consultaMysql = "SELECT * FROM usuarios us JOIN perfil_usuario pf ON us.id = pf.id_usuario WHERE us.id = $id_usuario";
                        $result= $conexion->query($consultaMysql);

                        if ($result === false) {
                            echo "Error en la consulta: " . $conexion->error;
                        }else{
                    
                        }
                        while($datos=$result->fetch_object()){

                            $idCedula = $datos->id;
                            $nombrePac = $datos->nombre;
                            $apellidoPac =  $datos->apellido;
                            $correo = $datos->correo;
                            $telefono = $datos->telefono;
                            $direccion = $datos->direccion;
                            $fechaNac =  $datos->fecha_nacimiento;
                            $Sexo = $datos->genero;
                            $alergias = $datos->alergias;
                            $ocupacion =  $datos->ocupacion;
                            $educacion = $datos->nivel_educacion;           
                            
                            ?>

                            <h3> Nombre: <span class='dato'> <?php echo $datos->nombre ?> </span> </h3><br>
                            <h3> Apellido: <?php echo $datos->apellido ?></h3><br>
                            <h3> Correo Electronico:<?php echo $datos->correo ?></h3><br>
                            <h3> Telefono: <?php echo $datos->telefono ?></h3><br>
                            <h3> Direccion: <?php echo $datos->direccion ?></h3><br>
                            <h3> Fecha de nacimiento: <?php echo $datos->fecha_nacimiento ?></h3><br>

                            <?php

                            $fechaCreation = $fechaNac;
                            
                            $fechaCreation = new DateTime($fechaCreation);

                            // Crear un objeto DateTime para la fecha actual
                            $fechaActual = new DateTime();

                            // Calcular la diferencia entre la fecha actual y la fecha de nacimiento
                            $edadDinamica = $fechaActual->diff($fechaCreation);
                            
                            ?>

                            <h3> Edad: <?php echo $edadDinamica->y ?></h3><br>
                            <h3> Sexo: <?php echo $datos->genero?></h3><br>
                            <h3> alergias: <?php echo $datos->alergias?></h3><br>
                            <h3> Ocupacion: <?php echo $datos->ocupacion ?></h3><br>
                            <h3> Nivel de Estudio: <?php echo $datos->nivel_educacion ?></h3>
                            <?php
                        }
                    ?>

                    <button id='btnEditarDatos' class="botonEditar">Editar</button>
                </div>
                
            </div>

            <div class='HistorialMedico'>
                <div class='headHistorial'>

                <div class='head_head'>
                    <h3>Citas Solicitadas</h3>

                </div>
                <div class='bodyHead'>

                <div class='textHead'>
                    <h3>Total Citas</h3>
                </div>
                <div class='cifraCita'>
                    <?php 
                    
                    $consultaCitasPaciente = "SELECT COUNT(id_cita) AS cantidad FROM citas WHERE id_cliente = $id_usuario";
                    $resultCitas = mysqli_query($conexion,$consultaCitasPaciente);

                    while($datos=$resultCitas->fetch_object()){

                        $numeroCitas = $datos->cantidad;

                    }
                    ?>
                    <span id='numeroCita'><?php echo $numeroCitas ?></span>
                </div>

                </div>
                </div>
                <div class='cuerpoHistorial'>

                <div class='ultimaCita'>

                    <?php

                        $consultaHistorial = "SELECT hm.*, c.id_cita, c.id_medico, c.id_cliente, c.fecha, c.especialidad, cl_paciente.nombre AS nombre_paciente, cl_medico.nombre AS nombre_medico, cl_medico.apellido AS apellidoMed, e.nombre_esp FROM historial_medico hm JOIN citas c ON hm.id_cita = c.id_cita JOIN usuarios cl_paciente ON c.id_cliente = cl_paciente.id JOIN usuarios cl_medico ON c.id_medico = cl_medico.id JOIN especialidades e ON e.id_especialidad = c.especialidad WHERE c.id_cliente = $id_usuario AND c.fecha < CURDATE() AND c.estado = 'realizado' ORDER BY c.fecha DESC LIMIT 1";
                        $resultHistorial = mysqli_query($conexion,$consultaHistorial);

                        if(mysqli_num_rows($resultHistorial) > 0){ 
        
                            while($datos=$resultHistorial->fetch_array()){ 
                                // $id = $datos["id"];
                                // $nombre = $datos["nombre"];
                                // $apellido = $datos["apellido"];
                                // $telefono = $datos["telefono"];
                                $id_citaHistorial = $datos['id_cita'];
                                $fecha = $datos["fecha"];
                                $diagnos = $datos["diagnostico"];
                                $tratamiento = $datos["tratamiento"];
                                $prescripcion = $datos["prescripcion"];      
                                $examenes = $datos['examenes_realizados'];    
                                $doctorRes = $datos ['nombre_medico'];
                                $doctorApellido= $datos ['apellidoMed'];
                                $nombrePaciente = $datos['nombre_paciente'];
                                $nombre_esp = $datos['nombre_esp'];
                            ?>
                            

                            <div class="reporteCita">

                                <div class='head_head'>
                                    <h3 id='tituloUltimaCt'>Ultima Cita</h3>
                                </div>
                                <div class='datosDeCita'> 
                                    <h3>Fecha Cita: <?php echo $fecha ?> </h3><br>
                                    <h3>Especialidad: <?php echo $nombre_esp ?> </h3><br>
                                    <h3>Doctor: <?php echo $doctorRes." ".$doctorApellido ?> </h3><br>
                                    <h3>Paciente: <?php echo $nombrePaciente ?> </h3><br>
                                    <h3>Diagnostico: <?php echo $diagnos?></h3><br>
                                    <h3>Tratamiento: <?php echo $tratamiento?></h3><br>

                                </div>

                                <a href="perfil_historialMedico.php" class='enlaceHistorial'>Ver Historial Medico</a>
                            </div>
                            <?php
                            }
                        }else{
                    ?>
                                <div class="reporteCita">

                                    <div class='head_head'>
                                        <h3 id='tituloUltimaCt'>Ultima Cita</h3>
                                    </div>
                                    <div class='datosDeCita'> 
                                        <h3>Fecha Cita:</h3><br>
                                        <h3>Especialidad: </h3><br>
                                        <h3>Doctor: </h3><br>
                                        <h3>Paciente:</h3><br>
                                        <h3>Diagnostico:</h3><br><br>
                                        <h3>Aun no tiene citas en la plataforma</h3><br>

                                    </div>

                                    <a href="perfil_historialMedico.php" class='enlaceHistorial'>Ver Historial Medico</a>
                                </div>

                   <?php
                        }
                    ?>
                </div>

                </div>
            </div>

        </div>

        <div class="titlePerfil">

        <div class='head_head_proximas'>

            <h3>Citas Proximas</h3>

        </div>

            <?php 

                $proximasCitas = "SELECT c.id_cita, c1.nombre AS nombre_paciente, c2.nombre AS nombre_medico, c2.apellido AS apellido_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.id_especialidad WHERE c.fecha BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) AND c.id_cliente = $id_usuario  AND c.estado NOT IN ('anulado', 'realizado')";
                $resultadoCitas = mysqli_query($conexion,$proximasCitas);

                if(mysqli_num_rows($resultadoCitas) > 0) { 

                    while ($fila = mysqli_fetch_assoc($resultadoCitas)) { ?>

                        <div class='iten_citas'>
                            <div class='seccion' id='especialidad'> <div class='headCitas' id='headEspecialidad'><h3>Especialidades</h3></div> <span> <?php echo $fila['nombre_esp'] ?> </span></div>
                            <div class='seccion' id='nombreDoctor'> <div class='headCitas'><h3>Medico</h3></div> <span> <?php echo $fila['nombre_medico'].' '.$fila['apellido_medico'] ?> </span></div>
                            <div class='seccion' id='fechaDeCIta'> <div class='headCitas'><h3>Fecha</h3></div> <span><?php echo $fila['fecha'] ?> </span></div>
                            <div class='seccion' id='horaCita'> <div class='headCitas'><h3>Hora</h3></div> <span><?php echo $fila['hora'] ?></span></div>
                            <div class='seccion' id='estadoCita'> <div class='headCitas' id='headEstado'><h3>estado</h3></div> <span> <?php echo $fila['estado'] ?></span></div>
                        </div>

                        <?php
                    }

                }else{ ?>

                    <div class='iten_citas'>
                        <div class='seccion' id='especialidadElse'> <div class='headCitas' id='headEspecialidadElse'><h3>Registros</h3></div> <span> No tienes agendadas citas por ahora</span></div>
        
                    </div>

                    <?php
                }
            ?>

        </div>
        
    </section>

            <dialog id="DialogEdicion">
                <div class="formulariosEdit">
                    <div class="headerVentana"> 
                        <h2>Modificar Usuario</h2>
                        <form method="dialog">
                            <button class="ModalClose"> X</button>
                        </form>
                    </div>

                <div id="RegistroPublicos">
                    <form action="Crud_Admin/editar.php" method="post" id='formEdit'>
                        <div class='camposPrincipales'>
                            <input type="hidden" id="idUsuario" name="id_user" value="<?php echo $id_usuario ?>">

                            <label for="nombre">Nombre</label>
                            <input id="nombre" type="text" placeholder="Nombre" class="nombreClase" name="newNombre" value="<?php echo $nombrePac ?>">

                            <label for="Apellido">Apellido</label>
                            <input id="apellido" type="text" placeholder="Apellido" class="apellido" name="newApellido" value="<?php echo $apellidoPac ?>">

                            <label for="Telefono">Telefono</label>
                            <input id="telefono" type="text" placeholder="Telefono" name="newTelefono" value="<?php echo $telefono?>">

                            <label for="Email">Correo Electronico</label>
                            <input id="correo" type="email" placeholder="Correo Electronico" name="newEmail" value="<?php echo $correo ?>">

                            <label for="direccion">Direccion</label>
                            <input id="direccionEdit" type="text" placeholder="Direccion" name="direccionEdit" value="<?php echo $direccion ?>">

                            <label for="alergias">Alergias</label>
                            <input id="alergiasEdit" type="text" placeholder="alergias" name="alergiasEdit" value="<?php echo $alergias ?>">
                        </div>

                        <div class='camposSecond'>

                            <label for="fecha_nac">Fecha de Nacimiento</label>
                            <input id="fecha_nacimiento" type="date" placeholder="Fecha de Nacimiento" name="fecha_nacEdit" value="<?php echo $fechaNac ?>">

                            <label for="genero">Genero</label>
                            <select name="generoEdit" id="sexoId">
                                <option value="masculino" <?php echo $Sexo == 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                                <option value="femenino" <?php echo $Sexo == 'femenino' ? 'selected' : ''; ?>>Femenino</option>
                                <option value="noSabe" <?php echo $Sexo == 'noSabe' ? 'selected' : ''; ?>>No sabe</option>
                            </select>

                            <label for="ocupacion">Ocupacion</label>
                            <select name="ocupacionEdit" id="ocupacionEdit">
                                <option value="nada" <?php echo $ocupacion == 'nada' ? 'selected' : ''; ?>>Desempleado</option>
                                <option value="trabajo_informal" <?php echo $ocupacion == 'trabajo_informal' ? 'selected' : ''; ?>>Chambas dispersas</option>
                                <option value="trabajo_formal" <?php echo $ocupacion== 'trabajo_formal' ? 'selected' : ''; ?>>Empresa</option>
                            </select>

                            <label for="educacion">Nivel de Educacion</label>
                            <select name="educacionEdt" id="educacionEdit">
                                <option value="nada" <?php echo $educacion == 'nada' ? 'selected' : ''; ?>>Sin estudios</option>
                                <option value="basica" <?php echo $educacion == 'basica' ? 'selected' : ''; ?>>Básicos</option>
                                <option value="universitaria" <?php echo $educacion == 'universitaria' ? 'selected' : ''; ?>>Universitarios</option>
                            </select>

                            <button type="submit" class="botonesLogin" id="botonRegistrarse" name="editarDatosPersonales">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
    </dialog>


            <script>

                const btnEditar = document.getElementById('btnEditarDatos');
                btnEditar.addEventListener('click', mostrarModalEdit)

                function mostrarModalEdit(){
                    const dialog = document.getElementById("DialogEdicion");
                    dialog.showModal(); 
                }


            </script>

</body>
</html>



<?php include "footer.php";  ?>