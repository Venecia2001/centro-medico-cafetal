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
            <a href="inicioAdmin.php">Perfil</a>
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
        <h1>hola doctor</h1>

        <div class ="infoMedico">

            <?php 
            
            include "conex_bd.php";

            $consultaDatos = "SELECT us.*, m.id_medico, m.id_especialidad, m.direccion, m.foto_perfil, m.fecha_nacimiento, e.nombre_esp AS nombre_especialidad FROM usuarios us JOIN medicos m ON us.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad WHERE us.id = $idMedicoSession;";
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
                    <label>Contraseña: </label>
                    <span class="campoDeInformacion"> <?php echo $clave ?></span><br>
                </div>

                <button id="btnEditar">EDITAR DATOS</button>
 
            </div>
            <div class="infoAdicional">
                <div class="cajaTexto">
                    <label>Especialidad: </label>
                    <span class="campoDeInformacion"> <?php echo $nombre_esp ?></span><br>
                </div>
                <div class="cajaTexto">
                    <label>Dirección: </label>
                    <span class="campoDeInformacion"> <?php echo $direccion ?></span><br>
                </div>
                <div class="cajaTexto">  
                    <label>Fecha nacimiento: </label>
                    <span class="campoDeInformacion"> <?php echo $fechaNac ?></span><br>
                </div>
                <div class="cajaTexto" id="cajaAgregarFoto">  

                    <form method="POST" action="seccionMedicos.php" enctype="multipart/form-data" class="aggFoto">

                        <label>foto Perfil:</label>
                        <span class="campoDeInformacion"> <?php echo $fotoPerfil ?></span><br>
                        <input type="file" name="archivo" id="">
                        <input type="hidden" name="id_doc" value=" <?php echo $idMed?>">
                        <input type="submit" name="fotoEnviada" value="agregar Foto">
                    </form>

                    <div class="imgPerfil">

                        <img width="100" src="uploads/.<?php echo $fotoPerfil ?>" alt="fotoPerfil">

                    </div>
                </div>
            </div>
            
        </div>



        <dialog id="modalEdit">
            <div class="registroMed">
                <h2>Datos Doctor</h2>
                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>

                <form method="POST" action="Crud_Admin/datosMedicos.php" class="formMed">
                    <div class="infoBasica">

                            <input type="hidden" name="id_doc" value="<?php echo $idMed?>" id="id_doctor">
                    
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombreM" id="nombreMed" value = "<?php echo $nombreMed ?>" required><br>

                            <label for="nombre">Apellido:</label>
                            <input type="text" name="apellidoM" id="apellidoMed" value=" <?php echo $apellidoMed ?>" required><br>

                            <label for="telefono">Telefono:</label>
                            <input type="text" name="telefonoM" id="telefonoMed"  value=" <?php echo $telefono ?>" required><br>

                            <label for="correo">Correo:</label>
                            <input type="email" name="correoMed" id="correoMed"  value=" <?php echo $correo ?>" required><br>

                            <label for="clave">Contraseña:</label>
                            <input type="text" name="ClaveMed" id="claveMed"  value=" <?php echo $clave ?>" required><br><br>

                            <input type="hidden" name="rolMedico" value=2>
                    </div>

                    <div class="infoPerfil"> 
                        <label for="">Especialidad</label>
                        <select name="especialidad" id="esp" required>
                            <option value=""><?php echo $nombre_esp ?></option>
                            <?php
                            include "conex_bd.php";
                                    
                            $sql = $conexion->query("SELECT id_especialidad, nombre_esp FROM `especialidades`");

                            while($datos=$sql->fetch_object()){ ?>

                                <option value="<?php echo $datos->id_especialidad ?>"><?php echo $datos->nombre_esp?></option>

                            <?php
                                    $selectEspecialidad = $datos->nombre_esp;
                                } 
                            ?>
                        </select><br>

                            <label for="direccion">Dirección:</label>
                            <input type="text" name="direccionMed" id="direccionM"  value=" <?php echo $direccion ?>" required><br>

                            <label for="cedula">Cedula:</label>
                            <input type="text" name="cedula" id="cedulaMed"  value=" <?php echo $cedula ?>" required><br>

                            <label for="fecha_nac">Fecha nacimiento:</label>
                            <input type="date" name="fecha_nac" id="fechaNac"  value="<?php echo $fechaNac ?>" required><br>

                            <input type="submit" name="EdicionCompleta" value="Editar Médico" id ="botonRegistroMed">
                    </div>
                </form>


            </div>

        </dialog>



    </main>




    <script>

    const dialogEditar = document.getElementById("btnEditar");
    dialogEditar.addEventListener("click", mostrarForm)

    function mostrarForm(){
        const dialog = document.getElementById("modalEdit");
        dialog.showModal();

    }

    </script>
    
</body>
</html>