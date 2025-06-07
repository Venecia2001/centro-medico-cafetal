<?php 
include("conex_bd.php");

if(isset($_POST['fotoEnviada'])){

    $target_dir = "uploads/";
    
    $image = $_FILES['archivo'];
    $id_doctor = $_POST["id_doc"];

    $fecha = new DateTime();

    $imagen = $fecha->getTimestamp()."_".$_FILES['archivo']['name'];

    $imagen_temporal= $_FILES['archivo']['tmp_name'];

    move_uploaded_file($imagen_temporal,"uploads/.$imagen");
    
    // // Obtener el nombre del archivo y su extensión
    // $image_name = basename($image["name"]);
    // $image_tmp_name = $image["tmp_name"];
    // $image_size = $image["size"];
    // $image_error = $image["error"];
    
    // // Definir el directorio de destino
    // $target_file = $target_dir.$image_name;
    

    // $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // // Verificar si el archivo es una imagen real o un falso
    // if (isset($_POST["submit"])) {
    //     $check = getimagesize($image_tmp_name);
    //     if ($check !== false) {
    //         echo "El archivo es una imagen - " . $check["mime"] . ".<br>";
    //     } else {
    //         echo "El archivo no es una imagen.<br>";
    //         exit;
    //     }
    // }

    // // Validaciones
    // $upload_ok = 1;
    
    // // Comprobar el tamaño del archivo
    // if ($image_size > 5000000) {  // 5 MB máximo
    //     echo "Lo siento, el archivo es demasiado grande.<br>";
    //     $upload_ok = 0;
    // }

    // // Permitir solo ciertos formatos de imagen
    // if ($image_file_type != "jpg" && $image_file_type != "jpeg" && $image_file_type != "png" && $image_file_type != "gif") {
    //     echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.<br>";
    //     $upload_ok = 0;
    // }

    // // Verificar si hubo algún error en la subida
    // if ($image_error !== 0) {
    //     echo "Hubo un error en la subida del archivo.<br>";
    //     $upload_ok = 0;
    // }

    // // Verificar si $upload_ok es 0 debido a un error
    // if ($upload_ok == 0) {
    //     echo "Lo siento, tu archivo no fue subido.<br>";
    // } else {
    //     // Intentar mover el archivo a la carpeta de destino
    //     if (move_uploaded_file($image_tmp_name, $target_file)) {
    //         echo "El archivo " . htmlspecialchars($image_name) . " ha sido subido exitosamente.<br>";
    //     } else {
    //         echo "Lo siento, ocurrió un error al subir tu archivo.<br>";
    //     }
    // }

    $consultaActualizar = "UPDATE medicos SET foto_perfil = '$imagen' WHERE id_medico = $id_doctor";
    $resulAct = mysqli_query($conexion,$consultaActualizar);
    
    if($resulAct){

        header("location:seccionMedicos.php");
        
    }else{
        echo "no se realizaron actualizaciones";
    }

}else{

    // echo "No se ha seleccionado ningún archivo.<br>";

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="interfazMedico.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>

<aside class="sidebar">

    <?php
        session_start();

        // if (empty($_SESSION["usuario"])) {
        //     header("location:login.php");
        //     exit();
        // }

        // echo "bienvenid@".$_SESSION["nombre"]." ".$_SESSION["apellido"]." ".$_SESSION["id"];

        $idMedicoSession = $_SESSION["id"];

    ?>


        <form action="" class= "sidebar__form">
            <input type="checkbox" id="open_menu">
            <label for="open_menu" class="material-symbols-outlined">close</label>
            <label class="material-symbols-outlined open-button" for="open_menu">double_arrow</label>
        </form>
        <picture class= "sidebar__picture">
            <img src="imagenes/logo-removebg-preview (1).png" alt="logo" width ="150px">
        </picture>

        <nav class= "sidebar__nav" >
        
        <ul>

        <li class="sidebar__item">
            <span class="material-symbols-outlined">Person</span>
            <a href="#">Perfil</a>
        </li>
        <!-- <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="seccionAdmin.php">Notificaciones</a>
        </li> -->
        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="citasDeMedicos.php">citas medicas</a>
        </li>

        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="resultadosCitas.php">Diagnostico de Citas</a>
        </li>

        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="historialCitas_medicos.php">Historial de Citas</a>
        </li>


        <li class="sidebar__item">
            <span class="material-symbols-outlined">Schedule</span>
            <a href="controlHorarios_medicos.php">Horarios</a>
        </li>
       
        </ul>

        </nav>

        <div class="sidebar__profile">
            <ul>
                <li class ="item__profile">
                    <?php 

                    include "conex_bd.php";
                    
                    $consultaPerfil = "SELECT foto_perfil FROM medicos WHERE id_medico = $idMedicoSession";
                    $resultConsulta = mysqli_query($conexion, $consultaPerfil);
                    
                    while($data = $resultConsulta->fetch_array()){

                        $fotoPerfil = $data['foto_perfil'];

                    }
                    
                    ?> 

                    <img width="100" src="uploads/.<?php echo $fotoPerfil ?>" alt="fotoPerfil">
                    <!-- <img src="imagenes/doctor07.jpg" alt="doctor" width="120px"> -->
                    <span class= "profile-option">mi perfil</span>
                </li>
                <li  class="sidebar__item">
                    <span class="material-symbols-outlined">logout</span>
                    <span><a href="cerrar.php" id="cerrarSesion">cerrar sesion</a></span>
                </li>

            </ul>

        </div>


    </aside>

    <main>

        <div class ="infoMedico">

            <div class='datosPersonalesHead'>

                <h2>Datos Personales</h2>

            </div>
            <div class='contendorDeDatos'>

            

                <?php 
                
                include "conex_bd.php";

                $consultaDatos = "SELECT us.*, m.id_medico, m.id_especialidad, m.direccion, m.foto_perfil, m.titulación_academica, m.perfil_experiencia, e.nombre_esp AS nombre_especialidad FROM usuarios us JOIN medicos m ON us.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE us.id = $idMedicoSession;";
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
                    $rolMedico = $data['rol'];
                    $fotoPerfil = $data['foto_perfil'];
                    $fechaNac = $data['fecha_nacimiento'];
                    $universidad = $data['titulación_academica'];
                    $perfilDoctor = $data['perfil_experiencia'];
                    
                }
                ?>
            

                <div class="infoPrincipal">

                    <div class="cajaTexto">
                        <label>Nombre: </label>
                        <span class="campoDeInformacion"> <?php echo $nombreMed ?></span><br>
                    </div>
                    <div class="cajaTexto">
                        <label>apellido: </label>
                        <span class="campoDeInformacion"> <?php echo $apellidoMed ?> </span><br>
                    </div>
                    <div class="cajaTexto">
                        <label>Telefono: </label>
                        <span class="campoDeInformacion"> <?php echo $telefono ?></span><br>
                    </div>
                    <div class="cajaTexto">
                        <label>Correo: </label>
                        <span class="campoDeInformacion"> <?php echo $correo ?></span><br>
                    </div>
                    <div class="cajaTexto">
                        <label>Especialidad: </label>
                        <span class="campoDeInformacion"> <?php echo $nombre_esp ?></span><br>
                    </div>

                    <div class="cajaTexto">
                        <label>Dirección: </label>
                        <span class="campoDeInformacion"> <?php echo $direccion ?></span><br>
                    </div>

                    <!-- <div class="cajaTexto">
                        <label>Contraseña: </label>
                        <span class="campoDeInformacion"> <?php echo $clave ?></span><br>
                    </div> -->

                    <button id="btnEditar">Editar Datos</button>
    
                </div>
                <div class="infoAdicional">

                    <div class='datosDeMedico'> 
                    
                        <div class="cajaTexto">  
                            <label>Fecha nacimiento: </label>
                            <span class="campoDeInformacion"> <?php echo $fechaNac ?></span><br>
                        </div>

                        <div class="cajaTexto">  
                            <label>Fecha universidad: </label>
                            <span class="campoDeInformacion"> <?php echo $universidad ?></span><br>
                        </div>

                        <div class="cajaTexto">  
                            <label>Experiencia: </label>
                            <span class="campoDeInformacion"> <?php echo $perfilDoctor?: '<span class="nota">Nota,</span> Es importante que registre su experiencia para ofrecer mas informacion a nuestros usuarios'; ?></span><br>

                            <button id="botonSoloUnavez" class="<?php echo empty($perfilDoctor) ? '' : 'oculto'; ?>">
                                Completar Experiencia
                            </button>

                        </div>

                    </div>

                    <div class="cajaTexto" id="cajaAgregarFoto">  

                            <div class="cajaTextoDeFoto">  
                                <label>Foto Perfil: </label>
                                <div class="imgPerfil">
                                    <img width="100" src="uploads/.<?php echo $fotoPerfil ?>" alt="fotoPerfil">
                                </div>
                            
                            </div>

                        <button class='claseBtn' id='botonFoto'>Agregar Foto</button>
                    </div>

                </div>
            </div>
            
        </div>



        <dialog id="modalEdit" >

                    <h2 class='tituloDialog'>Modificar Datos</h2>
            <div class="registroMed">
                
                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>

                <form method="POST" action="Crud_Admin/datosMedicos.php" class="formMed" id='formulario_edicion_medicos'>
                    <div class="infoBasica">

                            <input type="hidden" name="id_doc" value="<?php echo $idMed?>" id="id_doctor">
                    
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombreM" id="nombreMed" value = "<?php echo $nombreMed ?>" required><br>

                            <label for="nombre">Apellido:</label>
                            <input type="text" name="apellidoM" id="apellidoMed" value="<?php echo $apellidoMed ?>" required><br>
                            
                            <label for="Telefono">Telefono</label>
  
                            <?php

                                $telefonoCompleto = $telefono;

                                $prefijo = substr($telefono, 0, 4);         // primeros 4 dígitos
                                $numeroSinPrefijo = substr($telefono, 4);

                            ?>

                                <div class='campoCompuestoCI'>

                                    <select class='prefijoTelefono' id="PrefijoTlfEdit" name="prefijoTlf" required>
                                        <option value="0412" <?= $prefijo == "0412" ? 'selected' : '' ?>>0412</option>
                                        <option value="0414" <?= $prefijo == "0414" ? 'selected' : '' ?>>0414</option>
                                        <option value="0416" <?= $prefijo == "0416" ? 'selected' : '' ?>>0416</option>
                                        <option value="0422" <?= $prefijo == "0422" ? 'selected' : '' ?>>0422</option>
                                        <option value="0424" <?= $prefijo == "0424" ? 'selected' : '' ?>>0424</option>
                                        <option value="0426" <?= $prefijo == "0426" ? 'selected' : '' ?>>0426</option>
                                    </select>

                                    <input type="text" name="telefonoM" id="telefonoMed"  value="<?php echo $numeroSinPrefijo ?>" required><br>
                                </div>

                            <label for="correo">Correo:</label>
                            <input type="email" name="correoMed" id="correoMed"  value="<?php echo $correo ?>" required><br>
                            
                            <label for="direccion">Dirección:</label>
                            <input type="text" name="direccionMed" id="direccionEdit" value="<?php echo $direccion ?>" required><br>

                            <label for="clave">Contraseña:</label>
                            <input type="text" name="ClaveMed" id="claveMed" placeholder="Solo llena si deseas cambiar la contraseña" required><br><br>

                            <!-- <label for="clave">Contraseña:</label>
                            <input id="claveMed" type="text" name="ClaveMed" placeholder="Solo llena si deseas cambiar la contraseña"> -->

                            <input type="hidden" name="rolMedico" value=2>
                    </div>

                    <div class="infoPerfil"> 
                        
                        <label for="rolMedico">Rol de Medico</label>
                            <select name="rolMedico" class='selecRol' id="selectTipodeMedicoEdit">
                                <option value="">Seleccione un rol</option>
                                <option value="2" <?= $rolMedico == 2 ? 'selected' : '' ?>>Médico regular</option>
                                 <option value="5" <?= $rolMedico == 5 ? 'selected' : '' ?>>Medico de Urgencias</option>
                            </select>


                        <label for="">Especialidad</label>
                        <select name="especialidad" id="esp" required>
                            <!-- <option value=""></option> -->
                            <?php
                            include "conex_bd.php";
                                    
                            $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades`");

                            while($datos=$sql->fetch_object()){ ?>

                                <option value="<?php echo $datos->id_especialidad ?>" <?= ($datos->nombre_esp == $nombre_esp) ? 'selected' : '' ?>>
                                    <?php echo $datos->nombre_esp ?>
                                </option>

                            <?php
                                    $selectEspecialidad = $datos->nombre_esp;
                                } 
                            ?>
                        </select><br>

                            <label for="cedula">Estudios Universitarios:</label>
                            <input type="text" name="estudios" id="universidad"  value="<?php echo $universidad ?>" required><br>

                            <label for="fecha_nac">Fecha nacimiento:</label>
                            <input type="date" name="fecha_nac" id="fechaNac"  value="<?php echo $fechaNac ?>" required><br>

                            <label for="experiencia">Experiencia:</label>
                            <textarea id="experiencias" name="experienciaMed" rows="4" cols="50" value="<?php echo $perfilDoctor ?>"><?php echo $perfilDoctor ?></textarea>

                            <input type="submit" name="EdicionCompleta" value="Editar Médico" id ="botonRegistroMed">

                            <span class="resultado"></span>
                    </div>
                </form>


            </div>

        </dialog>
         
        <dialog id='ventadaNewFoto' class='dialogCorto'>

                <h2 class='tituloDialog'>Agrega Foto de Perfil</h2>

                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>


            <form method="POST" action="seccionMedicos.php" enctype="multipart/form-data" class="aggFoto">

                <label>foto Perfil:</label>
                <span class="campoDeInformacion"> <?php echo $fotoPerfil ?></span><br>
                <input type="file" name="archivo" id="">
                <input type="hidden" name="id_doc" value=" <?php echo $idMed?>">

                <input type="submit" name="fotoEnviada" value="agregar Foto" class='btnAgregarFoto'>
            </form>

        </dialog>

        <dialog id='ventadaCompletarExp' class='dialogCorto'>

                <h2 class='tituloDialog'>Descripcion de Experiencia</h2>

                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>


            <form method="POST" action="Crud_Admin/datosMedicos.php" class="aggFoto">

                <label>Descripcion:</label>
                <input type="hidden" name="id_doc" value=" <?php echo $idMed?>">
                <textarea name="descripcionXp" id="cajaDeDescrip" rows="5" cols="50"></textarea>

                <input type="submit" name="descripcionEnviada" value="Agregar Descripcion" class='btnAgregarFoto'>

            </form>

        </dialog>



    </main>




    <script>

    const dialogEditar = document.getElementById("btnEditar");
    dialogEditar.addEventListener("click", mostrarForm)

    function mostrarForm(){
        const dialog = document.getElementById("modalEdit");
        dialog.showModal();

    }

    const dialogFoto = document.getElementById("botonFoto");
    dialogFoto.addEventListener("click", mostrarDialog)

    function mostrarDialog(){
        const dialog = document.getElementById("ventadaNewFoto");
        dialog.showModal();

    }

    const dialogDescripcion = document.getElementById("botonSoloUnavez");
    dialogDescripcion.addEventListener("click", mostrarDialogDes)

    function mostrarDialogDes(){
        const dialog = document.getElementById("ventadaCompletarExp");
        dialog.showModal();

    }

    const spanResultado = document.querySelector(".resultado");

    function validarFormulario(campos) {
            let error = [];
            let textoPattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
            let textoDescripcionPattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,;:()\-"¿?!¡']+$/;
            let clavePattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

            const {
                nombre,
                apellido,
                cedula,
                telefono,
                email,
                fechaNacimiento,
                clave,
                repetirClave,
                direccion,
                estudios,
                rolMedico,
                especialidad
            } = campos;

            if(nombre.length < 2 || nombre.length > 40 || !textoPattern.test(nombre)){
                return [true, "El nombre solo debe contener letras y tener mínimo 2 caracteres."];
            } else if(apellido.length < 2 || apellido.length > 40 || !textoPattern.test(apellido)){
                return [true, "El apellido solo debe contener letras y tener mínimo 2 caracteres."];
            } else if(cedula && (!/^\d+$/.test(cedula) || cedula.length < 7 || cedula.length > 9 || cedula.startsWith('0'))){
                return [true, "La cédula no es válida. Debe tener entre 7 y 9 dígitos y no comenzar con 0."];
            }else if(!/^\d{7}$/.test(telefono)){
                return [true, "El número debe tener exactamente 7 dígitos."];
            } else if(email.length < 5 || email.length > 40 || 
                    email.indexOf("@") === -1 || 
                    email.indexOf(".") === -1 || 
                    email.match(/[@.]{2,}/) || 
                    /^[.@-]|[.@-]$/.test(email) || 
                    (email.match(/@/g) || []).length !== 1 || 
                    !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)){
                return [true, "Email no válido."];
            } else if (!fechaNacimiento) {
                return [true, "Debes ingresar tu fecha de nacimiento."];
            }

            const fechaHoy = new Date();
            const fechaNac = new Date(fechaNacimiento);
            const fechaMinima = new Date('1915-01-01');

            if (fechaNac < fechaMinima) {
                return [true, "La fecha de nacimiento no puede ser anterior a 1915."];
            }

            let edad = fechaHoy.getFullYear() - fechaNac.getFullYear();
            const mes = fechaHoy.getMonth() - fechaNac.getMonth();
            if (mes < 0 || (mes === 0 && fechaHoy.getDate() < fechaNac.getDate())) {
                edad--;
            }

            if (edad < 18) {
                return [true, "Debes tener al menos 18 años para registrarte."];
            }

            if (campos.clave !== "") {
                if (!clavePattern.test(campos.clave)) {
                    error[0] = true;
                    error[1] = "La nueva contraseña debe tener al menos 6 caracteres, una mayúscula, un número y un símbolo.";
                    return error;
                }
            }   

            if (repetirClave != null && repetirClave !== clave){
                error[0] = true;
                error[1] = "Las contraseñas no coinciden.";
                return error;
            }

            if(direccion.length < 2 || direccion.length > 255 || !textoDescripcionPattern.test(direccion)){
                return [true, "La direccion solo debe contener letras y tener mínimo 2 caracteres."];
            } else if(estudios.length < 2 || estudios.length > 125 || !textoDescripcionPattern.test(estudios)){
                return [true, "la universidad de Egreso solo debe contener letras y tener mínimo 2 caracteres."];
            }

            if (!campos.rolMedico) {
                return [true, "Debes seleccionar un rol de médico."];
            } else if (!campos.especialidad) {
                return [true, "Debes seleccionar una especialidad."];
            }   

            return [false, ""];
    }

    const botonEditar = document.getElementById("botonRegistroMed"); // botón del formulario de edición
    botonEditar.addEventListener("click", function(e) {
        const campos = {
            nombre: document.getElementById("nombreMed").value.trim(),
            apellido: document.getElementById("apellidoMed").value.trim(),
            telefono: document.getElementById("telefonoMed").value.trim(),
            email: document.getElementById("correoMed").value.trim(),
            fechaNacimiento: document.getElementById("fechaNac").value,
            clave: document.getElementById("claveMed").value,
            direccion:  document.getElementById("direccionEdit").value,
            estudios: document.getElementById("universidad").value,
            rolMedico: document.getElementById("selectTipodeMedicoEdit").value,
            especialidad: document.getElementById("esp").value
        };

        const camposConCedula = { ...campos, cedula: null};

        const error = validarFormulario(campos);
        if (error[0]) {
            e.preventDefault();
            spanResultado.innerHTML = error[1];
            spanResultado.classList.add("red");
            spanResultado.classList.remove("green");
        } else {
            spanResultado.innerHTML = "Te has registrado correctamente";
            spanResultado.classList.add("green");
            spanResultado.classList.remove("red");

            const formEdit = document.getElementById("formulario_edicion_medicos");
            const hiddenInputEdit = document.createElement("input");
            hiddenInputEdit.type = "hidden";
            hiddenInputEdit.name = "EdicionCompleta";
            formEdit.appendChild(hiddenInputEdit);
            formEdit.submit();
        }
    });

    </script>
    
</body>
</html>