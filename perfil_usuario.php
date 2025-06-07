
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

            <div id="seccionPerfil">

              <h2>Completa tu Perfil</h2>

              <form action="isertarDatos.php" method="post" enctype="multipart/form-data" id='formDatosPerfil'>

                <div class = 'seccionesFormPerfil'>

                    <input type='hidden' name='id' value='<?php echo $_SESSION["id"] ?>'>

                     <label for="direccion">Direccion</label>
                                            <select name="direccion" class="opcionesRol" required>
                                                <option   value="Capital - Baruta - Alto Prado">Capital - Baruta - Alto Prado</option>
                                                <option   value="Capital - Baruta - Baruta" >Capital - Baruta - Baruta</option>
                                                <option   value="Capital - Baruta - Bello Monte" >Capital - Baruta - Bello Monte</option>
                                                <option   value="Capital - Baruta - Caurimare" >Capital - Baruta - Caurimare</option>
                                                                                                                        
                                                <option   value="Capital - Baruta - El Cafetal" >Capital - Baruta - El Cafetal</option>                                                                      
                                                <option   value="Capital - Baruta - La Trinidad" >Capital - Baruta - La Trinidad</option>
                                                <option   value="Capital - Baruta - Las Mercedes" >Capital - Baruta - Las Mercedes</option>
                                                <option   value="Capital - Chacao - Altamira" >Capital - Chacao - Altamira</option>
                                                                                                                                                                                   
                                                <option   value="Capital - Chacao - Chacaito" >Capital - Chacao - Chacaito</option>                                     
                                                                                                                    
                                                <option   value="Capital - Chacao - Los Palos Grandes">Capital - Chacao - Los Palos Grandes</option>
                                            
                                                <option   value="Capital - El Hatillo - El Hatillo" >Capital - El Hatillo - El Hatillo</option>
                                                                                                                        
                                                <option   value="Capital - Libertador - Antímano" >Capital - Libertador - Antímano</option>
                                                <option   value="Capital - Libertador - Caricuao" >Capital - Libertador - Caricuao</option>
                                                <option   value="Capital - Libertador - Catia" >Capital - Libertador - Catia</option>
                                                
                                                <option   value="Capital - Libertador - El Silencio" >Capital - Libertador - El Silencio</option>
                                                <option   value="Capital - Libertador - El Valle" >Capital - Libertador - El Valle</option>
                                                <option   value="Capital - Libertador - Guaicaipuro" >Capital - Libertador - Guaicaipuro</option>
                                                <option   value="Capital - Libertador - La Bandera" >Capital - Libertador - La Bandera</option>
                                                                                                                
                                                <option   value="Capital - Libertador - La Paz" >Capital - Libertador - La Paz</option>
                                                <option   value="Capital - Libertador - La Rinconada">Capital - Libertador - La Rinconada</option>
                                                <option   value="Capital - Libertador - La Yaguara" >Capital - Libertador - La Yaguara</option>
                                                <option   value="Capital - Libertador - Las Adjuntas">Capital - Libertador - Las Adjuntas</option>
                                                <option   value="Capital - Libertador - Los Proceres" >Capital - Libertador - Los Proceres</option>
                                                                                                                            
                                                <option   value="Capital - Sucre - Boleíta Norte" >Capital - Sucre - Boleíta Norte</option>
                                                <option   value="Capital - Sucre - Boleíta Sur" >Capital - Sucre - Boleíta Sur</option>
                                                <option   value="Capital - Sucre - El Llanito" >Capital - Sucre - El Llanito</option>
                                                <option   value="Capital - Sucre - El Marqués" >Capital - Sucre - El Marqués</option>
                                                <option   value="Capital - Sucre - Fila de Mariches" >Capital - Sucre - Fila de Mariches</option>
                                                <option   value="Capital - Sucre - La California Norte" >Capital - Sucre - La California Norte</option>
                                                <option   value="Capital - Sucre - La California Sur" >Capital - Sucre - La California Sur</option>
                                                <option   value="Capital - Sucre - La Urbina" >Capital - Sucre - La Urbina</option>
                                                
                                                
                                                                                                                            
                                                <option  value="Capital - Sucre - Petare" >Capital - Sucre - Petare</option>
                                                                                                                    
                                                <option   value="Capital - Sucre - Terrazas del Avíla">Capital - Sucre - Terrazas del Avíla</option>
                                                <option   value="Interior - Miranda - Caucagua" >Interior - Miranda - Caucagua</option>
                                                <option   value="Interior - Miranda - Charallave" >Interior - Miranda - Charallave</option>
                                                <option   value="Interior - Miranda - Cua" >Interior - Miranda - Cua</option>
                                                <option   value="Interior - Miranda - Guarenas" >Interior - Miranda - Guarenas</option>
                                                <option   value="Interior - Miranda - Guatire" >Interior - Miranda - Guatire</option>
                                                <option   value="Interior - Miranda - Higuerote" >Interior - Miranda - Higuerote</option>
                                                <option   value="Interior - Miranda - Los Teques" >Interior - Miranda - Los Teques</option>
                                                <option   value="Interior - Miranda - Ocumare del Tuy" >Interior - Miranda - Ocumare del Tuy</option>
                                                <option   value="Interior - Miranda - San Antonio de los Altos" >Interior - Miranda - San Antonio de los Altos</option>
                                                <option   value="Interior - Vargas - Caraballeda" >Interior - Vargas - Caraballeda</option>
                                                <option   value="Interior - Vargas - Catia la Mar" >Interior - Vargas - Catia la Mar</option>
                                                <option   value="Interior - Vargas - La Guaira" >Interior - Vargas - La Guaira</option>
                                                <option   value="Interior - Vargas - Maiquetía" >Interior - Vargas - Maiquetía</option>
                                                <option   value="Interior - Vargas - Naiguatá" >Interior - Vargas - Naiguatá</option>
                                                <option   value="Interior - Amazonas - Puerto Ayacucho" >Interior - Amazonas - Puerto Ayacucho</option>
                                                <option   value="Interior - Anzoategui - Anaco" >Interior - Anzoategui - Anaco</option>
                                                <option   value="Interior - Anzoategui - Barcelona" >Interior - Anzoategui - Barcelona</option>
                                                <option   value="Interior - Anzoategui - Boca de Uchire" >Interior - Anzoategui - Boca de Uchire</option>
                                                <option   value="Interior - Anzoategui - Cantaura" >Interior - Anzoategui - Cantaura</option>
                                                <option   value="Interior - Anzoategui - Clarines" >Interior - Anzoategui - Clarines</option>
                                                <option   value="Interior - Anzoategui - Cúpira" >Interior - Anzoategui - Cúpira</option>
                                                <option   value="Interior - Anzoategui - El Tigre" >Interior - Anzoategui - El Tigre</option>
                                                <option   value="Interior - Anzoategui - Puerto la Cruz" >Interior - Anzoategui - Puerto la Cruz</option>
                                                <option   value="Interior - Anzoategui - Puerto Piritu" >Interior - Anzoategui - Puerto Piritu</option>
                                                <option   value="Interior - Anzoategui - San Jose de Guanipa" >Interior - Anzoategui - San Jose de Guanipa</option>
                                                <option   value="Interior - Apure - Achaguas" >Interior - Apure - Achaguas</option>
                                                <option   value="Interior - Apure - Biruaca" >Interior - Apure - Biruaca</option>
                                                <option   value="Interior - Apure - Elorza" >Interior - Apure - Elorza</option>
                                                <option   value="Interior - Apure - Guasdualito" >Interior - Apure - Guasdualito</option>
                                                <option   value="Interior - Apure - San Fernando de Apure" >Interior - Apure - San Fernando de Apure</option>
                                                <option   value="Interior - Aragua - Cagua" >Interior - Aragua - Cagua</option>
                                                <option   value="Interior - Aragua - La Victoria" >Interior - Aragua - La Victoria</option>
                                                <option   value="Interior - Aragua - Maracay" >Interior - Aragua - Maracay</option>
                                                <option   value="Interior - Aragua - Turmero" >Interior - Aragua - Turmero</option>
                                                <option   value="Interior - Barinas - Barinas" >Interior - Barinas - Barinas</option>
                                                <option   value="Interior - Barinas - Barinitas" >Interior - Barinas - Barinitas</option>
                                                <option   value="Interior - Barinas - Socopó" >Interior - Barinas - Socopó</option>
                                                <option   value="Interior - Bolivar - Caicara del Orinoco" >Interior - Bolivar - Caicara del Orinoco</option>
                                                <option   value="Interior - Bolivar - Ciudad Bolivar" >Interior - Bolivar - Ciudad Bolivar</option>
                                                <option   value="Interior - Bolivar - El Callao" >Interior - Bolivar - El Callao</option>
                                                <option   value="Interior - Bolivar - Guasipati" >Interior - Bolivar - Guasipati</option>
                                                <option   value="Interior - Bolivar - Puerto Ordaz" >Interior - Bolivar - Puerto Ordaz</option>
                                                <option   value="Interior - Bolivar - Tumeremo" >Interior - Bolivar - Tumeremo</option>
                                                <option   value="Interior - Bolivar - Upata" >Interior - Bolivar - Upata</option>
                                                <option   value="Interior - Carabobo - Guacara" >Interior - Carabobo - Guacara</option>
                                                <option   value="Interior - Carabobo - Puerto Cabello" >Interior - Carabobo - Puerto Cabello</option>
                                                <option   value="Interior - Carabobo - Valencia" >Interior - Carabobo - Valencia</option>
                                                <option   value="Interior - Cojedes - San Carlos" >Interior - Cojedes - San Carlos</option>
                                                <option   value="Interior - Cojedes - Tinaco" >Interior - Cojedes - Tinaco</option>
                                                <option   value="Interior - Cojedes - Tinaquillo" >Interior - Cojedes - Tinaquillo</option>
                                                <option   value="Interior - Delta Amacuro - Tucupita" >Interior - Delta Amacuro - Tucupita</option>
                                                <option   value="Interior - Falcón - Carirubana" >Interior - Falcón - Carirubana</option>
                                                <option   value="Interior - Falcón - Punta Cardón" >Interior - Falcón - Punta Cardón</option>
                                                <option   value="Interior - Falcón - Punto Fijo" >Interior - Falcón - Punto Fijo</option>
                                                <option   value="Interior - Falcón - Santa Ana de Coro" >Interior - Falcón - Santa Ana de Coro</option>
                                                <option   value="Interior - Falcón - Vela de Coro" >Interior - Falcón - Vela de Coro</option>
                                                <option   value="Interior - Guárico - Calabozo" >Interior - Guárico - Calabozo</option>
                                                <option   value="Interior - Guárico - San Juan de los Morros" >Interior - Guárico - San Juan de los Morros</option>
                                                <option   value="Interior - Guárico - Valle de la Pascua">Interior - Guárico - Valle de la Pascua</option>
                                                <option   value="Interior - Guárico - Zaraza" >Interior - Guárico - Zaraza</option>
                                                <option   value="Interior - Lara - Barquisimeto" >Interior - Lara - Barquisimeto</option>
                                                <option   value="Interior - Lara - Cabudare" >Interior - Lara - Cabudare</option>
                                                <option   value="Interior - Lara - Carora" >Interior - Lara - Carora</option>
                                                <option   value="Interior - Lara - El Tocuyo9" >Interior - Lara - El Tocuyo</option>
                                                <option   value="Interior - Lara - Quibor" >Interior - Lara - Quibor</option>
                                              
                                                <option   value="Interior - Mérida - El Vigía" >Interior - Mérida - El Vigía</option>
                                                <option   value="Interior - Mérida - Mérida" >Interior - Mérida - Mérida</option>
                                                <option   value="Interior - Mérida - Nueva Bolívar" >Interior - Mérida - Nueva Bolívar</option>
                                                <option   value="Interior - Mérida - Tovar" >Interior - Mérida - Tovar</option>
                                                <option   value="Interior - Monagas - Maturin" >Interior - Monagas - Maturin</option>
                                                <option   value="Interior - Monagas - Punta de Mata" >Interior - Monagas - Punta de Mata</option>
                                                <option   value="Interior - Monagas - Temblador" >Interior - Monagas - Temblador</option>
                                                <option   value="Interior - Nueva Esparta - La Asunción" >Interior - Nueva Esparta - La Asunción</option>
                                                <option   value="Interior - Nueva Esparta - Porlamar" >Interior - Nueva Esparta - Porlamar</option>
                                                <option   value="Interior - Portuguesa - Acarigua" >Interior - Portuguesa - Acarigua</option>
                                                <option   value="Interior - Portuguesa - Guanare" >Interior - Portuguesa - Guanare</option>
                                                <option selected="selected" value="Interior - Portuguesa - Biscucuy" >Interior - Portuguesa - Biscucuy</option>
                                                <option   value="Interior - Portuguesa - Chabasquen" >Interior - Portuguesa - Chabasquen</option>
                                                <option   value="Interior - Portuguesa - Ospino" >Interior - Portuguesa - Ospino</option>
                                                <option   value="Interior - Portuguesa - Guanarito" >Interior - Portuguesa - Guanarito</option>
                                                <option   value="Interior - Sucre - Carupano" >Interior - Sucre - Carupano</option>
                                                <option   value="Interior - Sucre - Cumaná" >Interior - Sucre - Cumaná</option>
                                                <option   value="Interior - Sucre - Güiria" >Interior - Sucre - Güiria</option>
                                                <option   value="Interior - Táchira - San Antonio del Táchira" >Interior - Táchira - San Antonio del Táchira</option>
                                                <option   value="Interior - Táchira - San Cristóbal" >Interior - Táchira - San Cristóbal</option>
                                                <option   value="Interior - Trujillo - Boconó" >Interior - Trujillo - Boconó</option>
                                                <option   value="Interior - Trujillo - Trujillo" >Interior - Trujillo - Trujillo</option>
                                                <option   value="Interior - Trujillo - Valera" >Interior - Trujillo - Valera</option>
                                                <option   value="Interior - Yaracuy - Chivacoa" >Interior - Yaracuy - Chivacoa</option>
                                                <option   value="Interior - Yaracuy - Cocorote" >Interior - Yaracuy - Cocorote</option>
                                                <option   value="Interior - Yaracuy - Nirgua" >Interior - Yaracuy - Nirgua</option>
                                                <option   value="Interior - Yaracuy - San Felipe" >Interior - Yaracuy - San Felipe</option>
                                                <option   value="Interior - Yaracuy - Yaritagua" >Interior - Yaracuy - Yaritagua</option>
                                                <option   value="Interior - Zulia - Cabimas" >Interior - Zulia - Cabimas</option>
                                                <option   value="Interior - Zulia - Ciudad Ojeda" >Interior - Zulia - Ciudad Ojeda</option>
                                                <option   value="Interior - Zulia - Maracaibo" >Interior - Zulia - Maracaibo</option>
                                        </select>      

                    <label for="estatura">Altura(Cm)</label>
                    <input id="estatura" type="number" placeholder="170..." min="0" step="0.1" name="altura" require>

                    <label for="peso">Peso (kg)</label>
                    <input id="peso" type="number" name="pesoKg" placeholder="60..." min="0" step="0.1" required>


                    <label for="alergias">Alergias</label>
                    <input id="alergias" type="text" placeholder="alergias" maxlength="30" name="alergias" require>

                    <label for="genero">Genero</label>
                    <select class='opcionesRol' name="genero" id="sexo" require>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="prefiero_no_decirlo">Prefiero no decirlo</option>
                        <!-- <option value="noSabe">39 tipos de gay</option> -->
                    </select>


                </div>

                <div class='seccionesFormPerfil'>
                    
                    <label for="">Condiciones de salud crónicas</label>
                    <select class='opcionesRol' name="enfermedades" id="enfermedadesC" require>
                        <option value="Hipertensión arterial">Hipertensión arterial</option>
                        <option value="Diabetes mellitus">Diabetes mellitus (tipo 1 y tipo 2)</option>
                        <option value="Enfermedades cardiovasculares">Enfermedades cardiovasculares</option>
                        <option value="Asma">Asma</option>
                        <option value="Artritis reumatoide">Artritis reumatoide</option>
                        <option value="Obesidad">Obesidad</option>
                        <option value="Ninguna">Ninguna</option>
                    </select>

                    <label for="ocupacion">Ocupacion</label>
                    <select class='opcionesRol' name="ocupacion" id="ocupacion" require>
                        <option   value="Ejecutivo/Administrativo" >Ejecutivo/Administrativo</option>
                        <option   value="Obrero Calificado" >Obrero Calificado</option>
                        <option   value="Obrero No Calificado" >Obrero No Calificado</option>
                        <option   value="Profesional Independiente" >Profesional Independiente</option>
                        <option   value="Obrero Independiente" >Obrero Independiente</option>
                        <option   value="Estudiante" >Estudiante</option>
                        <option   value="Trabajo en el hogar">Trabajo en el hogar</option>
                        <option   value="Jubilados y/o Pensionados" >Jubilados y/o Pensionados</option>
                        <option   value="Miembro de la FAN" >Miembro de la FAN</option>
                        <option   value="Ninguna de las anteriores" >Ninguna de las anteriores</option>
                    </select>

                    <label for="educacion">Nivel de Educacion</label>
                    <select class='opcionesRol' name="educacion" id="educacion" required>
                        <option   value="Postgrado" >Postgrado</option>
                        <option   value="Educación Superior" >Educación Superior</option>
                        <option   value="Bachiller" >Bachiller</option>
                        <option   value="Educación básica" >Educación básica</option>
                        <option   value="Ninguna de las anteriores" >Ninguna de las anteriores</option>
                    </select>

                <button type="submit" id="botonEditar" name="perfilUsuario"> Guardar Perfil</button>
                
                </div>

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
                            $clave = $datos->contraseña;
                            $fechaNac =  $datos->fecha_nacimiento;
                            $Sexo = $datos->genero;
                            $altura = $datos->altura;
                            $peso = $datos->peso;
                            $enfermedades = $datos->condiciones_medicas;
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
                            <h3> Alergias: <?php echo $datos->alergias?></h3><br>
                            <h3> Altura: <?php echo $datos->altura?> cm</h3><br>
                            <h3> Peso: <?php echo $datos->peso?> Kg</h3><br>
                            <h3> Condiciones de salud crónicas:<?php echo $datos->condiciones_medicas?></h3><br>
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

                                        <h3 class='mensajeCita'>Aun no tiene citas en la plataforma</h3><br>

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

                $proximasCitas = "SELECT c.id_cita, c1.nombre AS nombre_paciente, c2.nombre AS nombre_medico, c2.apellido AS apellido_medico, e.nombre_esp, c.fecha, c.hora, c.estado, c.fecha_creacion FROM citas c JOIN usuarios c1 ON c.id_cliente = c1.id JOIN usuarios c2 ON c.id_medico = c2.id JOIN especialidades e ON c.especialidad = e.nombre_esp WHERE c.fecha BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) AND c.id_cliente = $id_usuario  AND c.estado NOT IN ('anulado', 'realizado')";
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
                            <input id="nombreEdit" type="text" placeholder="Nombre" class="nombreClase" name="newNombre" value="<?php echo $nombrePac ?>">

                            <label for="Apellido">Apellido</label>
                            <input id="apellidoEdit" type="text" placeholder="Apellido" class="apellido" name="newApellido" value="<?php echo $apellidoPac ?>">


                            <label for="Telefono">Telefono</label>
                            <div class='campoCompuestoCI'>

                                <select id="PrefijoTlf" name="prefijoTlf" required>
                                    <option value="0412">0412</option>
                                    <option value="0414">0414</option>
                                    <option value="0416">0416</option>
                                    <option value="0422">0422</option>
                                    <option value="0424">0424</option>
                                    <option value="0426">0426</option>
                                </select>

                                <input id="telefonoEdit" type="text" placeholder="Telefono" name="newTelefono" value="<?php echo $telefono?>">
                            </div>
                            

                            <label for="Email">Correo Electronico</label>
                            <input id="correoEdit" type="email" placeholder="Correo Electronico" name="newEmail" value="<?php echo $correo ?>">

                            <label for="direccion">Direccion</label>
                                            <select name="direccionEdit" class="opcionesRol" required>
                                                <option   value="Capital - Baruta - Alto Prado" <?php echo $direccion == 'Capital - Baruta - Alto Prado' ? 'selected' : ''; ?>  >Capital - Baruta - Alto Prado</option>
                                                <option   value="Capital - Baruta - Baruta" <?php echo $direccion == 'Capital - Baruta - Baruta' ? 'selected' : ''; ?>  >Capital - Baruta - Baruta</option>
                                                <option   value="Capital - Baruta - Bello Monte" <?php echo $direccion == 'Capital - Baruta - Bello Monte' ? 'selected' : ''; ?> >Capital - Baruta - Bello Monte</option>
                                                <option   value="Capital - Baruta - Caurimare" <?php echo $direccion == 'Capital - Baruta - Caurimare' ? 'selected' : ''; ?> >Capital - Baruta - Caurimare</option>
                                                                                                                        
                                                <option   value="Capital - Baruta - El Cafetal" <?php echo $direccion == 'Capital - Baruta - El Cafetal' ? 'selected' : ''; ?> >Capital - Baruta - El Cafetal</option>                                                                      
                                                <option   value="Capital - Baruta - La Trinidad" <?php echo $direccion == 'Capital - Baruta - La Trinidad' ? 'selected' : ''; ?> >Capital - Baruta - La Trinidad</option>
                                                <option   value="Capital - Baruta - Las Mercedes" <?php echo $direccion == 'Capital - Baruta - Las Mercedes' ? 'selected' : ''; ?> >Capital - Baruta - Las Mercedes</option>
                                                <option   value="Capital - Chacao - Altamira" <?php echo $direccion == 'Capital - Chacao - Altamira' ? 'selected' : ''; ?> >Capital - Chacao - Altamira</option>
                                                                                                                                                                                   
                                                <option   value="Capital - Chacao - Chacaito" <?php echo $direccion == 'Capital - Chacao - Chacaito' ? 'selected' : ''; ?> >Capital - Chacao - Chacaito</option>                                     
                                                                                                                    
                                                <option   value="Capital - Chacao - Los Palos Grandes" <?php echo $direccion == 'Capital - Chacao - Los Palos Grandes' ? 'selected' : ''; ?>>Capital - Chacao - Los Palos Grandes</option>
                                            
                                                <option   value="Capital - El Hatillo - El Hatillo" <?php echo $direccion == 'Capital - El Hatillo - El Hatillo' ? 'selected' : ''; ?> >Capital - El Hatillo - El Hatillo</option>
                                                                                                                        
                                                <option   value="Capital - Libertador - Antímano" <?php echo $direccion == 'Capital - Libertador - Antímano' ? 'selected' : ''; ?> >Capital - Libertador - Antímano</option>
                                                <option   value="Capital - Libertador - Caricuao" <?php echo $direccion == 'Capital - Libertador - Caricuao' ? 'selected' : ''; ?> >Capital - Libertador - Caricuao</option>
                                                <option   value="Capital - Libertador - Catia" <?php echo $direccion == 'Capital - Libertador - Catia' ? 'selected' : ''; ?> >Capital - Libertador - Catia</option>
                                                
                                                <option   value="Capital - Libertador - El Silencio" <?php echo $direccion == 'Capital - Libertador - El Silencio' ? 'selected' : ''; ?> >Capital - Libertador - El Silencio</option>
                                                <option   value="Capital - Libertador - El Valle" <?php echo $direccion == 'Capital - Libertador - El Valle' ? 'selected' : ''; ?> >Capital - Libertador - El Valle</option>
                                                <option   value="Capital - Libertador - Guaicaipuro" <?php echo $direccion == 'Capital - Libertador - Guaicaipuro' ? 'selected' : ''; ?> >Capital - Libertador - Guaicaipuro</option>
                                                <option   value="Capital - Libertador - La Bandera" <?php echo $direccion == 'Capital - Libertador - La Bandera' ? 'selected' : ''; ?> >Capital - Libertador - La Bandera</option>
                                                                                                                
                                                <option   value="Capital - Libertador - La Paz" <?php echo $direccion == 'Capital - Libertador - La Paz' ? 'selected' : ''; ?> >Capital - Libertador - La Paz</option>
                                                <option   value="Capital - Libertador - La Rinconada" <?php echo $direccion == 'Capital - Libertador - La Rinconada' ? 'selected' : ''; ?> >Capital - Libertador - La Rinconada</option>
                                                <option   value="Capital - Libertador - La Yaguara" <?php echo $direccion == 'Capital - Libertador - La Yaguara' ? 'selected' : ''; ?> >Capital - Libertador - La Yaguara</option>
                                                <option   value="Capital - Libertador - Las Adjuntas" <?php echo $direccion == 'Capital - Libertador - Las Adjuntas' ? 'selected' : ''; ?> >Capital - Libertador - Las Adjuntas</option>
                                                <option   value="Capital - Libertador - Los Proceres" <?php echo $direccion == 'Capital - Libertador - Los Proceres' ? 'selected' : ''; ?> >Capital - Libertador - Los Proceres</option>
                                                                                                                            
                                                <option   value="Capital - Sucre - Boleíta Norte" <?php echo $direccion == 'Capital - Sucre - Boleíta Norte' ? 'selected' : ''; ?> >Capital - Sucre - Boleíta Norte</option>
                                                <option   value="Capital - Sucre - Boleíta Sur" <?php echo $direccion == 'Capital - Sucre - Boleíta Sur' ? 'selected' : ''; ?> >Capital - Sucre - Boleíta Sur</option>
                                                <option   value="Capital - Sucre - El Llanito" <?php echo $direccion == 'Capital - Sucre - El Llanito' ? 'selected' : ''; ?> >Capital - Sucre - El Llanito</option>
                                                <option   value="Capital - Sucre - El Marqués" <?php echo $direccion == 'Capital - Sucre - El Marqués' ? 'selected' : ''; ?> >Capital - Sucre - El Marqués</option>
                                                <option   value="Capital - Sucre - Fila de Mariches" <?php echo $direccion == 'Capital - Sucre - Fila de Mariches' ? 'selected' : ''; ?> >Capital - Sucre - Fila de Mariches</option>


                                                <option   value="Capital - Sucre - La California Norte" <?php echo $direccion == 'Capital - Sucre - La California Norte' ? 'selected' : ''; ?> >Capital - Sucre - La California Norte</option>
                                                <option   value="Capital - Sucre - La California Sur" <?php echo $direccion == 'Capital - Sucre - La California Sur' ? 'selected' : ''; ?> >Capital - Sucre - La California Sur</option>
                                                <option   value="Capital - Sucre - La Urbina" <?php echo $direccion == 'Capital - Sucre - La Urbina' ? 'selected' : ''; ?> >Capital - Sucre - La Urbina</option>
                                                
                                                                               
                                                <option value="Capital - Sucre - Petare" <?php echo $direccion == 'Capital - Sucre - Petare' ? 'selected' : ''; ?> >Capital - Sucre - Petare</option>
                                                                                                                    
                                                <option   value="Capital - Sucre - Terrazas del Avíla" <?php echo $direccion == 'Capital - Sucre - Terrazas del Avíla' ? 'selected' : ''; ?>>Capital - Sucre - Terrazas del Avíla</option>
                                                <option   value="Interior - Miranda - Caucagua" <?php echo $direccion == 'Interior - Miranda - Caucagua' ? 'selected' : ''; ?> >Interior - Miranda - Caucagua</option>
                                                <option   value="Interior - Miranda - Charallave" <?php echo $direccion == 'Interior - Miranda - Charallave' ? 'selected' : ''; ?> >Interior - Miranda - Charallave</option>
                                                <option   value="Interior - Miranda - Cua" <?php echo $direccion == 'Interior - Miranda - Cua' ? 'selected' : ''; ?> >Interior - Miranda - Cua</option>
                                                <option   value="Interior - Miranda - Guarenas" <?php echo $direccion == 'Interior - Miranda - Guarenas' ? 'selected' : ''; ?> >Interior - Miranda - Guarenas</option>
                                                <option   value="Interior - Miranda - Guatire" <?php echo $direccion == 'Interior - Miranda - Guatire' ? 'selected' : ''; ?> >Interior - Miranda - Guatire</option>
                                                <option   value="Interior - Miranda - Higuerote" <?php echo $direccion == 'Interior - Miranda - Higuerote' ? 'selected' : ''; ?> >Interior - Miranda - Higuerote</option>
                                                <option   value="Interior - Miranda - Los Teques" <?php echo $direccion == 'Interior - Miranda - Los Teques' ? 'selected' : ''; ?> >Interior - Miranda - Los Teques</option>
                                                <option   value="Interior - Miranda - Ocumare del Tuy" <?php echo $direccion == 'Interior - Miranda - Ocumare del Tuy' ? 'selected' : ''; ?> >Interior - Miranda - Ocumare del Tuy</option>
                                                <option   value="Interior - Miranda - San Antonio de los Altos" <?php echo $direccion == 'Interior - Miranda - San Antonio de los Altos' ? 'selected' : ''; ?> >Interior - Miranda - San Antonio de los Altos</option>
                                                <option   value="Interior - Vargas - Caraballeda" <?php echo $direccion == 'Capital - Libertador - Catia' ? 'selected' : ''; ?> >Interior - Vargas - Caraballeda</option>
                                                <option   value="Interior - Vargas - Catia la Mar" <?php echo $direccion == 'Interior - Vargas - Catia la Mar' ? 'selected' : ''; ?> >Interior - Vargas - Catia la Mar</option>
                                                <option   value="Interior - Vargas - La Guaira" <?php echo $direccion == 'Interior - Vargas - La Guaira' ? 'selected' : ''; ?> >Interior - Vargas - La Guaira</option>
                                                <option   value="Interior - Vargas - Maiquetía" <?php echo $direccion == 'Interior - Vargas - Maiquetía' ? 'selected' : ''; ?> >Interior - Vargas - Maiquetía</option>
                                                <option   value="Interior - Vargas - Naiguatá"  <?php echo $direccion == 'Interior - Vargas - Naiguatá' ? 'selected' : ''; ?>>Interior - Vargas - Naiguatá</option>
                                                <option   value="Interior - Amazonas - Puerto Ayacucho" <?php echo $direccion == 'Interior - Amazonas - Puerto Ayacucho' ? 'selected' : ''; ?> >Interior - Amazonas - Puerto Ayacucho</option>
                                                <option   value="Interior - Anzoategui - Anaco" <?php echo $direccion == 'Interior - Anzoategui - Anaco' ? 'selected' : ''; ?> >Interior - Anzoategui - Anaco</option>

                                                <option   value="Interior - Anzoategui - Barcelona" <?php echo $direccion == 'Interior - Anzoategui - Barcelona' ? 'selected' : ''; ?> >Interior - Anzoategui - Barcelona</option>
                                                <option   value="Interior - Anzoategui - Boca de Uchire" <?php echo $direccion == 'Interior - Anzoategui - Boca de Uchire' ? 'selected' : ''; ?> >Interior - Anzoategui - Boca de Uchire</option>
                                                <option   value="Interior - Anzoategui - Cantaura" <?php echo $direccion == 'Interior - Anzoategui - Cantaura' ? 'selected' : ''; ?> >Interior - Anzoategui - Cantaura</option>
                                                <option   value="Interior - Anzoategui - Clarines" <?php echo $direccion == 'Interior - Anzoategui - Clarines' ? 'selected' : ''; ?> >Interior - Anzoategui - Clarines</option>
                                                <option   value="Interior - Anzoategui - Cúpira" <?php echo $direccion == 'Interior - Anzoategui - Cúpira' ? 'selected' : ''; ?> >Interior - Anzoategui - Cúpira</option>
                                                <option   value="Interior - Anzoategui - El Tigre" <?php echo $direccion == 'Interior - Anzoategui - El Tigre' ? 'selected' : ''; ?> >Interior - Anzoategui - El Tigre</option>
                                                <option   value="Interior - Anzoategui - Puerto la Cruz" <?php echo $direccion == 'Interior - Anzoategui - Puerto la Cruz' ? 'selected' : ''; ?> >Interior - Anzoategui - Puerto la Cruz</option>
                                                <option   value="Interior - Anzoategui - Puerto Piritu" <?php echo $direccion == 'Interior - Anzoategui - Puerto Piritu' ? 'selected' : ''; ?> >Interior - Anzoategui - Puerto Piritu</option>
                                                <option   value="Interior - Anzoategui - San Jose de Guanipa" <?php echo $direccion == 'Interior - Anzoategui - San Jose de Guanipa' ? 'selected' : ''; ?> >Interior - Anzoategui - San Jose de Guanipa</option>

                                                <option   value="Interior - Apure - Achaguas" <?php echo $direccion == 'nterior - Apure - Achaguas' ? 'selected' : ''; ?> >Interior - Apure - Achaguas</option>
                                                <option   value="Interior - Apure - Biruaca" <?php echo $direccion == 'Interior - Apure - Biruaca' ? 'selected' : ''; ?> >Interior - Apure - Biruaca</option>
                                                <option   value="Interior - Apure - Elorza" <?php echo $direccion == 'Interior - Apure - Elorza' ? 'selected' : ''; ?> >Interior - Apure - Elorza</option>
                                                <option   value="Interior - Apure - Guasdualito" <?php echo $direccion == 'Interior - Apure - Guasdualito' ? 'selected' : ''; ?> >Interior - Apure - Guasdualito</option>
                                                <option   value="Interior - Apure - San Fernando de Apure" <?php echo $direccion == 'Interior - Apure - San Fernando de Apure' ? 'selected' : ''; ?> >Interior - Apure - San Fernando de Apure</option>

                                                <option   value="Interior - Aragua - Cagua" <?php echo $direccion == 'Interior - Aragua - Cagua' ? 'selected' : ''; ?> >Interior - Aragua - Cagua</option>
                                                <option   value="Interior - Aragua - La Victoria" <?php echo $direccion == 'Interior - Aragua - La Victoria' ? 'selected' : ''; ?> >Interior - Aragua - La Victoria</option>
                                                <option   value="Interior - Aragua - Maracay" <?php echo $direccion == 'Interior - Aragua - Maracay' ? 'selected' : ''; ?> >Interior - Aragua - Maracay</option>
                                                <option   value="Interior - Aragua - Turmero" <?php echo $direccion == 'Interior - Aragua - Turmero' ? 'selected' : ''; ?> >Interior - Aragua - Turmero</option>

                                                <option   value="Interior - Barinas - Barinas" <?php echo $direccion == 'Interior - Barinas - Barinas' ? 'selected' : ''; ?> >Interior - Barinas - Barinas</option>
                                                <option   value="Interior - Barinas - Barinitas" <?php echo $direccion == 'Interior - Barinas - Barinitas' ? 'selected' : ''; ?> >Interior - Barinas - Barinitas</option>
                                                <option   value="Interior - Barinas - Socopó" <?php echo $direccion == 'Interior - Barinas - Socopó' ? 'selected' : ''; ?> >Interior - Barinas - Socopó</option>

                                                <option   value="Interior - Bolivar - Caicara del Orinoco" <?php echo $direccion == 'Interior - Bolivar - Caicara del Orinoco' ? 'selected' : ''; ?> >Interior - Bolivar - Caicara del Orinoco</option>
                                                <option   value="Interior - Bolivar - Ciudad Bolivar" <?php echo $direccion == 'Interior - Bolivar - Ciudad Bolivar' ? 'selected' : ''; ?> >Interior - Bolivar - Ciudad Bolivar</option>
                                                <option   value="Interior - Bolivar - El Callao" <?php echo $direccion == 'Interior - Bolivar - El Callao' ? 'selected' : ''; ?> >Interior - Bolivar - El Callao</option>
                                                <option   value="Interior - Bolivar - Guasipati" <?php echo $direccion == 'Interior - Bolivar - Guasipati' ? 'selected' : ''; ?> >Interior - Bolivar - Guasipati</option>
                                                <option   value="Interior - Bolivar - Puerto Ordaz" <?php echo $direccion == 'Interior - Bolivar - Puerto Ordaz' ? 'selected' : ''; ?> >Interior - Bolivar - Puerto Ordaz</option>
                                                <option   value="Interior - Bolivar - Tumeremo" <?php echo $direccion == 'Interior - Bolivar - Tumeremo' ? 'selected' : ''; ?> >Interior - Bolivar - Tumeremo</option>
                                                <option   value="Interior - Bolivar - Upata" <?php echo $direccion == 'Interior - Bolivar - Upata' ? 'selected' : ''; ?> >Interior - Bolivar - Upata</option>

                                                <option   value="Interior - Carabobo - Guacara" <?php echo $direccion == 'Interior - Carabobo - Guacara' ? 'selected' : ''; ?> >Interior - Carabobo - Guacara</option>
                                                <option   value="Interior - Carabobo - Puerto Cabello" <?php echo $direccion == 'Interior - Carabobo - Puerto Cabello' ? 'selected' : ''; ?> >Interior - Carabobo - Puerto Cabello</option>
                                                <option   value="Interior - Carabobo - Valencia" <?php echo $direccion == 'Interior - Carabobo - Valencia' ? 'selected' : ''; ?> >Interior - Carabobo - Valencia</option>

                                                <option   value="Interior - Cojedes - San Carlos" <?php echo $direccion == 'Interior - Cojedes - San Carlos' ? 'selected' : ''; ?> >Interior - Cojedes - San Carlos</option>
                                                <option   value="Interior - Cojedes - Tinaco" <?php echo $direccion == 'Interior - Cojedes - Tinaco' ? 'selected' : ''; ?> >Interior - Cojedes - Tinaco</option>
                                                <option   value="Interior - Cojedes - Tinaquillo" <?php echo $direccion == 'Interior - Cojedes - Tinaquillo' ? 'selected' : ''; ?> >Interior - Cojedes - Tinaquillo</option>
                                                <option   value="Interior - Delta Amacuro - Tucupita" <?php echo $direccion == 'Interior - Delta Amacuro - Tucupita' ? 'selected' : ''; ?> >Interior - Delta Amacuro - Tucupita</option>

                                                <option   value="Interior - Falcón - Carirubana" <?php echo $direccion == 'Interior - Falcón - Carirubana' ? 'selected' : ''; ?> >Interior - Falcón - Carirubana</option>
                                                <option   value="Interior - Falcón - Punta Cardón" <?php echo $direccion == 'Interior - Falcón - Punta Cardón' ? 'selected' : ''; ?> >Interior - Falcón - Punta Cardón</option>
                                                <option   value="Interior - Falcón - Punto Fijo" <?php echo $direccion == 'Interior - Falcón - Punto Fijo' ? 'selected' : ''; ?> >Interior - Falcón - Punto Fijo</option>
                                                <option   value="Interior - Falcón - Santa Ana de Coro" <?php echo $direccion == 'Interior - Falcón - Santa Ana de Coro' ? 'selected' : ''; ?> >Interior - Falcón - Santa Ana de Coro</option>
                                                <option   value="Interior - Falcón - Vela de Coro" <?php echo $direccion == 'Interior - Falcón - Vela de Coro' ? 'selected' : ''; ?> >Interior - Falcón - Vela de Coro</option>
                                                <option   value="Interior - Guárico - Calabozo" <?php echo $direccion == 'Interior - Guárico - Calabozo' ? 'selected' : ''; ?> >Interior - Guárico - Calabozo</option>

                                                <option   value="Interior - Guárico - San Juan de los Morros" <?php echo $direccion == 'Interior - Guárico - San Juan de los Morros' ? 'selected' : ''; ?> >Interior - Guárico - San Juan de los Morros</option>
                                                <option   value="Interior - Guárico - Valle de la Pascua" <?php echo $direccion == 'Interior - Guárico - Valle de la Pascua' ? 'selected' : ''; ?> >Interior - Guárico - Valle de la Pascua</option>
                                                <option   value="Interior - Guárico - Zaraza" <?php echo $direccion == 'Interior - Guárico - Zaraza' ? 'selected' : ''; ?> >Interior - Guárico - Zaraza</option>

                                                <option   value="Interior - Lara - Barquisimeto" <?php echo $direccion == 'Interior - Lara - Barquisimeto' ? 'selected' : ''; ?> >Interior - Lara - Barquisimeto</option>
                                                <option   value="Interior - Lara - Cabudare" <?php echo $direccion == 'Interior - Lara - Cabudare' ? 'selected' : ''; ?> >Interior - Lara - Cabudare</option>
                                                <option   value="Interior - Lara - Carora" <?php echo $direccion == 'Interior - Lara - Carora' ? 'selected' : ''; ?> >Interior - Lara - Carora</option>
                                                <option   value="Interior - Lara - El Tocuyo" <?php echo $direccion == 'Interior - Lara - El Tocuyo' ? 'selected' : ''; ?> >Interior - Lara - El Tocuyo</option>
                                                <option   value="Interior - Lara - Quibor" <?php echo $direccion == 'Interior - Lara - Quibor' ? 'selected' : ''; ?> >Interior - Lara - Quibor</option>
                                              
                                                <option   value="Interior - Mérida - El Vigía" <?php echo $direccion == 'Interior - Mérida - El Vigía' ? 'selected' : ''; ?> >Interior - Mérida - El Vigía</option>
                                                <option   value="Interior - Mérida - Mérida" <?php echo $direccion == 'Interior - Mérida - Mérida' ? 'selected' : ''; ?> >Interior - Mérida - Mérida</option>
                                                <option   value="Interior - Mérida - Nueva Bolívar" <?php echo $direccion == 'Interior - Mérida - Nueva Bolívar' ? 'selected' : ''; ?> >Interior - Mérida - Nueva Bolívar</option>
                                                <option   value="Interior - Mérida - Tovar" <?php echo $direccion == 'Interior - Mérida - Tovar' ? 'selected' : ''; ?> >Interior - Mérida - Tovar</option>
                                                
                                                <option   value="Interior - Monagas - Maturin" <?php echo $direccion == 'Interior - Monagas - Maturin' ? 'selected' : ''; ?> >Interior - Monagas - Maturin</option>
                                                <option   value="Interior - Monagas - Punta de Mata" <?php echo $direccion == 'Interior - Monagas - Punta de Mata' ? 'selected' : ''; ?> >Interior - Monagas - Punta de Mata</option>
                                                <option   value="Interior - Monagas - Temblador" <?php echo $direccion == 'Interior - Monagas - Temblador' ? 'selected' : ''; ?> >Interior - Monagas - Temblador</option>

                                                <option   value="Interior - Nueva Esparta - La Asunción" <?php echo $direccion == 'Interior - Nueva Esparta - La Asunción' ? 'selected' : ''; ?> >Interior - Nueva Esparta - La Asunción</option>
                                                <option   value="Interior - Nueva Esparta - Porlamar" <?php echo $direccion == 'Interior - Nueva Esparta - Porlamar' ? 'selected' : ''; ?> >Interior - Nueva Esparta - Porlamar</option>

                                                <option   value="Interior - Portuguesa - Acarigua" <?php echo $direccion == 'Interior - Portuguesa - Acarigua' ? 'selected' : ''; ?> >Interior - Portuguesa - Acarigua</option>
                                                <option   value="Interior - Portuguesa - Guanare" <?php echo $direccion == 'Interior - Portuguesa - Guanare' ? 'selected' : ''; ?> >Interior - Portuguesa - Guanare</option>
                                                <option   value="Interior - Portuguesa - Biscucuy" <?php echo $direccion == 'Interior - Portuguesa - Biscucuy' ? 'selected' : ''; ?> >Interior - Portuguesa - Biscucuy</option>
                                                <option   value="Interior - Portuguesa - Chabasquen" <?php echo $direccion == 'nterior - Portuguesa - Chabasquen' ? 'selected' : ''; ?> >Interior - Portuguesa - Chabasquen</option>
                                                <option   value="Interior - Portuguesa - Ospino" <?php echo $direccion == 'Interior - Portuguesa - Ospino' ? 'selected' : ''; ?> >Interior - Portuguesa - Ospino</option>
                                                <option   value="Interior - Portuguesa - Guanarito" <?php echo $direccion == 'Interior - Portuguesa - Guanarito' ? 'selected' : ''; ?> >Interior - Portuguesa - Guanarito</option>

                                                <option   value="Interior - Sucre - Carupano" <?php echo $direccion == 'Interior - Sucre - Carupano' ? 'selected' : ''; ?> >Interior - Sucre - Carupano</option>
                                                <option   value="Interior - Sucre - Cumaná" <?php echo $direccion == 'Interior - Sucre - Cumaná' ? 'selected' : ''; ?> >Interior - Sucre - Cumaná</option>
                                                <option   value="Interior - Sucre - Güiria" <?php echo $direccion == 'Interior - Sucre - Güiria' ? 'selected' : ''; ?> >Interior - Sucre - Güiria</option>

                                                <option   value="Interior - Táchira - San Antonio del Táchira" <?php echo $direccion == 'Interior - Táchira - San Antonio del Táchira' ? 'selected' : ''; ?> >Interior - Táchira - San Antonio del Táchira</option>
                                                <option   value="Interior - Táchira - San Cristóbal" <?php echo $direccion == 'Interior - Táchira - San Cristóbal' ? 'selected' : ''; ?> >Interior - Táchira - San Cristóbal</option>

                                                <option   value="Interior - Trujillo - Boconó" <?php echo $direccion == 'Interior - Trujillo - Boconó' ? 'selected' : ''; ?> >Interior - Trujillo - Boconó</option>
                                                <option   value="Interior - Trujillo - Trujillo" <?php echo $direccion == 'Interior - Trujillo - Trujillo' ? 'selected' : ''; ?> >Interior - Trujillo - Trujillo</option>
                                                <option   value="Interior - Trujillo - Valera" <?php echo $direccion == 'Interior - Trujillo - Valera' ? 'selected' : ''; ?> >Interior - Trujillo - Valera</option>

                                                <option   value="Interior - Yaracuy - Chivacoa" <?php echo $direccion == 'Interior - Yaracuy - Chivacoa' ? 'selected' : ''; ?> >Interior - Yaracuy - Chivacoa</option>
                                                <option   value="Interior - Yaracuy - Cocorote" <?php echo $direccion == 'Interior - Yaracuy - Cocorote' ? 'selected' : ''; ?> >Interior - Yaracuy - Cocorote</option>
                                                <option   value="Interior - Yaracuy - Nirgua" <?php echo $direccion == 'Interior - Yaracuy - Nirgua' ? 'selected' : ''; ?> >Interior - Yaracuy - Nirgua</option>
                                                <option   value="Interior - Yaracuy - San Felipe" <?php echo $direccion == 'Interior - Yaracuy - San Felipe' ? 'selected' : ''; ?> >Interior - Yaracuy - San Felipe</option>
                                                <option   value="Interior - Yaracuy - Yaritagua" <?php echo $direccion == 'Interior - Yaracuy - Yaritagua' ? 'selected' : ''; ?> >Interior - Yaracuy - Yaritagua</option>
                                                <option   value="Interior - Zulia - Cabimas" <?php echo $direccion == 'Interior - Zulia - Cabimas' ? 'selected' : ''; ?> >Interior - Zulia - Cabimas</option>
                                                <option   value="Interior - Zulia - Ciudad Ojeda" <?php echo $direccion == 'Interior - Zulia - Ciudad Ojeda' ? 'selected' : ''; ?> >Interior - Zulia - Ciudad Ojeda</option>
                                                <option   value="Interior - Zulia - Maracaibo" <?php echo $direccion == 'Interior - Zulia - Maracaibo' ? 'selected' : ''; ?> >Interior - Zulia - Maracaibo</option>
                                        </select>

                            <label for="alergias">Alergias</label>
                            <input id="alergiasEdit" type="text" placeholder="alergias" name="alergiasEdit" value="<?php echo $alergias ?>">
                            
                            
                            <label for="estatura">Altura(Cm)</label>
                            <input id="estaturaEdit" type="number" placeholder="170..." min="0" step="0.1" name="alturaEdit" value="<?php echo $altura ?>" require>


                        </div>


                        <div class='camposSecond'>

                            <label for="peso">Peso (kg)</label>
                            <input id="pesoEdit" type="number" name="pesoKgEdit" placeholder="60..." min="0" step="0.1" value="<?php echo $peso ?>" required>

                            <label for="genero">Genero</label>
                            <select name="generoEdit" id="sexoId" class='opcionesRol'>
                                <option value="masculino" <?php echo $Sexo == 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                                <option value="femenino" <?php echo $Sexo == 'femenino' ? 'selected' : ''; ?>>Femenino</option>
                                <option value="prefiero_no_decirlo" <?php echo $Sexo == 'prefiero_no_decirlo' ? 'selected' : ''; ?> >Prefiero no decirlo</option>
                            </select>

                            <label for="fecha_nac">Fecha de Nacimiento</label>
                            <input id="fecha_nacimientoEdit" type="date" placeholder="Fecha de Nacimiento" name="fecha_nacEdit" value="<?php echo $fechaNac ?>">

                            
                            <label for="">Condiciones de salud crónicas</label>
                            <select class='opcionesRol' name="enfermedadesEdit" id="enfermedadesC" require>
                                <option value="Hipertensión arterial" <?php echo $enfermedades == 'Hipertensión arterial' ? 'selected' : ''; ?> >Hipertensión arterial</option>
                                <option value="Diabetes mellitus" <?php echo $enfermedades == 'Diabetes mellitus' ? 'selected' : ''; ?>>Diabetes mellitus (tipo 1 y tipo 2)</option>
                                <option value="Enfermedades cardiovasculares" <?php echo $enfermedades == 'Enfermedades cardiovasculares' ? 'selected' : ''; ?>>Enfermedades cardiovasculares</option>
                                <option value="Asma" <?php echo $enfermedades == 'Asma' ? 'selected' : ''; ?>>Asma</option>
                                <option value="Artritis reumatoide" <?php echo $enfermedades == 'Artritis reumatoide' ? 'selected' : ''; ?>>Artritis reumatoide</option>
                                <option value="Obesidad" <?php echo $enfermedades == 'Obesidad' ? 'selected' : ''; ?>>Obesidad</option>
                                <option value="Ninguna" <?php echo $enfermedades == 'Ninguna' ? 'selected' : ''; ?>>Ninguna</option>
                            </select>


                            <label for="ocupacion">Ocupacion</label>
                            <select class='opcionesRol' name="ocupacionEditar" id="ocupacionEdit" require>
                                <option   value="Ejecutivo/Administrativo" <?php echo $ocupacion == 'Ejecutivo/Administrativo' ? 'selected' : ''; ?> >Ejecutivo/Administrativo</option>
                                <option   value="Obrero Calificado" <?php echo $ocupacion == 'Obrero Calificado' ? 'selected' : ''; ?> >Obrero Calificado</option>
                                <option   value="Obrero No Calificado" <?php echo $ocupacion == 'Obrero No Calificado' ? 'selected' : ''; ?> >Obrero No Calificado</option>
                                <option   value="Profesional Independiente" <?php echo $ocupacion == 'Profesional Independiente' ? 'selected' : ''; ?> >Profesional Independiente</option>
                                <option   value="Obrero Independiente" <?php echo $ocupacion == 'Obrero Independiente' ? 'selected' : ''; ?> >Obrero Independiente</option>
                                <option   value="Estudiante" <?php echo $ocupacion == 'Estudiante' ? 'selected' : ''; ?> >Estudiante</option>
                                <option   value="Trabajo en el hogar" <?php echo $ocupacion == 'Trabajo en el hogar' ? 'selected' : ''; ?>>Trabajo en el hogar</option>
                                <option   value="Jubilados y/o Pensionados" <?php echo $ocupacion == 'Jubilados y/o Pensionados' ? 'selected' : ''; ?> >Jubilados y/o Pensionados</option>
                                <option   value="Miembro de la FAN" <?php echo $ocupacion == 'Miembro de la FAN' ? 'selected' : ''; ?> >Miembro de la FAN</option>
                                <option   value="Ninguna de las anteriores" <?php echo $ocupacion == 'Ninguna de las anteriores' ? 'selected' : ''; ?> >Ninguna de las anteriores</option>
                            </select>

                            <label for="educacion">Nivel de Educacion</label>
                            <select class='opcionesRol' name="educacionEditar" id="educacionEdit" required>
                                <option   value="Postgrado" <?php echo $educacion == 'Postgrado' ? 'selected' : ''; ?> >Postgrado</option>
                                <option   value="Educación Superior" <?php echo $educacion == 'Educación Superior' ? 'selected' : ''; ?> >Educación Superior</option>
                                <option   value="Bachiller" <?php echo $educacion == 'Bachiller' ? 'selected' : ''; ?> >Bachiller</option>
                                <option   value="Educación básica" <?php echo $educacion == 'Educación básica' ? 'selected' : ''; ?> >Educación básica</option>
                                <option   value="Ninguna de las anteriores" <?php echo $educacion == 'Ninguna de las anteriores' ? 'selected' : ''; ?> >Ninguna de las anteriores</option>
                            </select>


                            <button type="submit" class="botonesLogin" id="botonRegistrarseEdit" name="editarDatosPersonales">Guardar</button>

                             <span class="resultado"> todos los campos son requeridos</span>
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

        const imputNombre = document.getElementById("nombreEdit")
        const inputApellido = document.getElementById("apellidoEdit")
        const inputTelefono = document.getElementById("telefonoEdit")
        const inputEmail = document.getElementById("correoEdit")
        const inputAlergias = document.getElementById('alergiasEdit')

        const spanResultado = document.querySelector(".resultado")

        const botonEviar = document.getElementById("botonRegistrarseEdit")
        botonEviar.addEventListener("click", (e) =>{
                e.preventDefault();

                let error = validarFormulario();
                if(error[0]){
                    spanResultado.innerHTML = error[1];
                    spanResultado.classList.add("red")
                }else{
                    spanResultado.innerHTML = "te has registrado corectamente"
                    spanResultado.classList.add("green")
                    spanResultado.classList.remove("red")

                    const form = document.getElementById("formEdit");

                    const hiddenButton = document.createElement("input");
                    hiddenButton.type = "hidden";
                    hiddenButton.name = "editarDatosPersonales";
                    form.appendChild(hiddenButton);
                    form.submit();
                }
        })
        
        function validarFormulario(){
            let error = [];
            let textoPattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

            const fechaNacimiento = document.getElementById('fecha_nacimientoEdit').value;

            const telefono = inputTelefono.value.trim();

            if(imputNombre.value.length < 2 || imputNombre.value.length > 40 || !textoPattern.test(imputNombre.value)){
                error[0] = true;
                error[1] = "El nombre solo debe contener letras y espacios y tener como minimo 2 letras."
                return error;
            }else if(inputApellido.value.length < 2 || inputApellido.value.length > 40 || !textoPattern.test(inputApellido.value)){
                error[0] = true;
                error[1] = "El apellido solo debe contener letras y espacios y tener como minimo 2 letras."
                return error;
            }else if (!/^\d{7}$/.test(telefono)) {
                error[0] = true;
                error[1] = "El teléfono es inválido. Debe tener 11 dígitos";
                return error;
            }else if(
                inputEmail.value.length < 5 ||
                inputEmail.value.length > 40 ||
                inputEmail.value.indexOf("@") === -1 ||
                inputEmail.value.indexOf(".") === -1 ||
                inputEmail.value.match(/[@.]{2,}/) || // caracteres repetidos
                /^[.@-]|[.@-]$/.test(inputEmail.value) || // empieza o termina mal
                (inputEmail.value.match(/@/g) || []).length !== 1 || // más de un @
                !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(inputEmail.value) // formato general
                ){
                error[0] = true;
                error[1] = "El email no es valido, este no debe contener caracteres especiales repetidos tampoco comenzar o terminar con caracteres especiales ni contener mas de @. "
                return error
            }else if (!fechaNacimiento) {
                error[0] = true;
                error[1] = "Por favor, ingresa tu fecha de nacimiento.";
                return error;
            }else if(inputAlergias.value.length < 2 || inputAlergias.value.length > 40 || !textoPattern.test(inputAlergias.value)){
                error[0] = true;
                error[1] = "El nombre de la alergia solo debe contener letras y espacios, minimo 2 letras."
                return error;
            }
            // Validación de edad (Fecha de nacimiento)
            const fechaHoy = new Date();
            const fechaNac = new Date(fechaNacimiento);

            const fechaMinima = new Date('1915-01-01');
            if (fechaNac < fechaMinima) {
                error[0] = true;
                error[1] = "La fecha de nacimiento no puede ser anterior al año 1915.";
                return error;
            }
            
            let edad = fechaHoy.getFullYear() - fechaNac.getFullYear();
            const mes = fechaHoy.getMonth() - fechaNac.getMonth();
            
            if (mes < 0 || (mes === 0 && fechaHoy.getDate() < fechaNac.getDate())) {
                edad--;
            }
            
            if (edad < 18) {
                error[0] = true;
                error[1] = "Debes tener al menos 18 años para registrarte.";
                return error;
            }

            error[0] = false
            return error
        }





        </script>

</body>
</html>



<?php include "footer.php";  ?>