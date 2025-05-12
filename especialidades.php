<?php 

include("conex_bd.php");

if(isset($_POST['registroEsp'])){

    $nombreEspecialidad = $_POST['nombreEsp'];
    $Descripcion = $_POST['DescripcionEsp'];
    $consultorio = $_POST['consultorioEsp'];
    $Servicio_relacionado = $_POST['servicioRel'];

    $imagenFondo = $_FILES['archivo'];

    $fecha = new DateTime();

    $imagenNombre = $fecha->getTimestamp()."_".$_FILES['archivo']['name'];

    
    $imagen_temporal= $_FILES['archivo']['tmp_name'];

    move_uploaded_file($imagen_temporal,"uploads/.$imagenNombre");

    $consultaDeRegistro = "INSERT INTO `especialidades`(`nombre_esp`, `descripcion_esp`, `consultorio`, `servicio_id`, `imagen_fondo`) VALUES ('$nombreEspecialidad','$Descripcion','$consultorio','$Servicio_relacionado','$imagenNombre')";

    $resultadoConsult = mysqli_query($conexion, $consultaDeRegistro);

    if($resultadoConsult){

        header("location:especialidades.php");

    }else{
        echo "hay un error por ahi";
    }
}

// if(isset($_POST['ModificarEsp'])){

//     $idEsp = $_POST['idDeEsp'];
//     $nombreEsp = $_POST['nombreEsp'];
//     $descripcionEsp = $_POST['DescripcionEsp'];
//     $consultorioEsp = $_POST['consultorioEsp'];
//     $servicioRel = $_POST['servicioRel'];
//     $nombreDeImagen = $_POST['archivoNombre'];


//         if (!empty($_FILES['archivoEdit'])) {


//                 // $imagenFondo = $_FILES['archivoEdit'];
            
//                 $fecha = new DateTime();
            
//                 $imagenNombreEdit = $fecha->getTimestamp()."_".$_FILES['archivoEdit']['name'];
            
                
//                 $imagen_temporales= $_FILES['archivoEdit']['tmp_name'];
            
//                 move_uploaded_file($imagen_temporales,"uploads/.$imagenNombreEdit");

//                 $imagenFondo = $imagenNombreEdit;

//                 $consultaAct = "UPDATE especialidades SET nombre_esp ='$nombreEsp',descripcion_esp ='$descripcionEsp',consultorio='$consultorioEsp',servicio_id='$servicioRel',imagen_fondo='$imagenFondo' WHERE id_especialidad = '$idEsp'";
//                 $actualizacion = mysqli_query($conexion, $consultaAct);
            
//                 if($actualizacion){
            
//                     header("location:especialidades.php");
            
//                 }else{
//                     echo "hay un error por ahi";
//                 }

//         }else{

//             $consultaAct = "UPDATE especialidades SET nombre_esp ='$nombreEsp',descripcion_esp ='$descripcionEsp',consultorio='$consultorioEsp',servicio_id='$servicioRel', imagen_fondo='$nombreDeImagen' WHERE id_especialidad = '$idEsp'";
//             $actualizacion = mysqli_query($conexion, $consultaAct);

//             if($actualizacion){

//                 header("location:especialidades.php");

//             }else{
//                 echo "hay un error por ahi";
//             }

//         }
//         // $fecha = new DateTime();

//         // $imagenNombreEdit = $fecha->getTimestamp()."_".$_FILES['archivoEdit']['name'];

        
//         // $imagen_temporales= $_FILES['archivoEdit']['tmp_name'];

//         // move_uploaded_file($imagen_temporales,"uploads/.$imagenNombreEdit");

    
// }

if (isset($_POST['ModificarEsp'])) {

    // Recogemos los datos del formulario
    $idEsp = $_POST['idDeEsp'];
    $nombreEsp = $_POST['nombreEsp'];
    $descripcionEsp = $_POST['DescripcionEsp'];
    $consultorioEsp = $_POST['consultorioEsp'];
    $servicioRel = $_POST['servicioRel'];
    $nombreDeImagen = $_POST['archivoNombre'];  // Nombre de la imagen actual

    // Obtener el valor de la imagen actual desde la base de datos (en caso de no subir una nueva imagen)
    $imagenFondo = $nombreDeImagen;

    // Verificar si se ha subido una nueva imagen
    if (!empty($_FILES['archivoEdit']['name'])) {  // Si el campo del archivo no está vacío
        // Procesar la nueva imagen
        $fecha = new DateTime();
        $imagenNombreEdit = $fecha->getTimestamp() . "_" . $_FILES['archivoEdit']['name'];
        $imagen_temporales = $_FILES['archivoEdit']['tmp_name'];

        // Mover la imagen a la carpeta de destino
        if (move_uploaded_file($imagen_temporales, "uploads/.$imagenNombreEdit")) {
            // Si se subió correctamente, actualizamos el nombre de la imagen
            $imagenFondo = $imagenNombreEdit;
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    }

    // Consulta SQL para actualizar la especialidad
    $consultaAct = "UPDATE especialidades SET 
                        nombre_esp = '$nombreEsp',
                        descripcion_esp = '$descripcionEsp',
                        consultorio = '$consultorioEsp',
                        servicio_id = '$servicioRel',
                        imagen_fondo = '$imagenFondo' 
                    WHERE id_especialidad = '$idEsp'";

    // Ejecutar la consulta
    $actualizacion = mysqli_query($conexion, $consultaAct);

    // Comprobar si la actualización fue exitosa
    if ($actualizacion) {
        header("Location: especialidades.php");
    } else {
        echo "Error al actualizar la especialidad.";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="interfazAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lilita+One&family=Lobster&family=Satisfy&display=swap" rel="stylesheet">
</head>
<body>
<?php include "sideba_admin.php" ?>
    <main> 
        <h1 class='tituloSeccion'>Especialidades Medicas</h1>


        <div class="especialidades">


            <div class='contenedorBtnAgg'>
                <a  class="bigTarjeta" id="aggEspecialidades">
                    <div class="tituloTarjeta">
                        <h2>Agregar Especialidad</h2>
                        <span class="material-symbols-outlined">add_circle</span>
                    </div>
                    <!-- <span class="material-symbols-outlined"> Post Add </span> -->
                </a>
            </div>
            <?php 

            include "conex_bd.php";

            $getDatosTarjetas ="SELECT id_especialidad, nombre_esp, imagen_fondo FROM especialidades;";
            $resultadosDatos = mysqli_query($conexion, $getDatosTarjetas);

            while($datos = $resultadosDatos->fetch_assoc()){

                $idEspecialidad = $datos['id_especialidad'];
                $nombre_esp = $datos['nombre_esp'];
                $img_fondo = $datos['imagen_fondo'];

            ?>
                <div class="bigTarjeta">

                        <div class="tituloTarjeta">
                            <h2><?php echo $nombre_esp;?></h2>

                            <div class="AccionesEdit">

                                <form  action='Crud_Admin/newEspecialidades.php' id="form_editar_<?php echo $idEspecialidad; ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="idEditar" value="<?php echo $idEspecialidad; ?>">
                                    <button type="button" class="btnEdit" onclick="enviarFormulario(<?php echo $idEspecialidad; ?>)"><span class='material-symbols-outlined'> edit </span></button>
                                </form>

                                <?php echo "
                                            <form  id='formEliminar' action='Crud_Admin/newEspecialidades.php' method ='POST'>
                                                <input type='hidden' name='id' value='".$idEspecialidad."'>
                                                <button type='submit' name='eliminar' class='btnEdit btnDelete'><span class='material-symbols-outlined'> delete </span></button>
                                            </form>
                                ";?>

                            </div>
                            
                        </div>

                    <a href="paginasEspecialidades.php?id=<?php echo $idEspecialidad; ?>" class="tarjetas">

                      
                        <img src="uploads/.<?php echo $img_fondo; ?>" alt="Imagen de especialidad">


                    </a>
                </div>


                <?php
            }

            ?>

        </div>

    </main>

    <dialog id="modalRegistroEsp" class = "dialogEsp">

        <div class="headerModel"> 

                <h2 class='tituloRegistroDialog'>Nueva Especialidad</h2>

                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>
        </div>

            <div class="registroEsp">
                <h2>Datos Especialidad</h2>
                <form method="POST" action="especialidades.php" class="formEsp" enctype="multipart/form-data">

                            <label for="nombre">Nombre Especialidad:</label>
                            <input type="text" name="nombreEsp" id="nombreEsp" required><br>

                            <label for="nombre">Descripcion de la Especialidad:</label>
                            <input type="text" name="DescripcionEsp" id="DescripcionEsp" required><br>

                            <label for="telefono">consultorio:</label>
                            <input type="number" name="consultorioEsp" id="consultorio" required><br>

                            <label for="correo">Servicio Relacionado:</label>
                            <select name="servicioRel" id="esp" required>
                                <option value="">Seleccione la especialidad</option>
                                <?php
                                include "conex_bd.php";
                                    
                                $sql = $conexion->query("SELECT id_servicio, nombre_servicio FROM `servicios`");

                                 while($datos=$sql->fetch_object()){ ?>

                                <option value="<?php echo $datos->id_servicio ?>"><?php echo $datos->nombre_servicio?></option>

                                <?php
                                
                                } 
                                ?>
                        </select><br><br>

                            <label for="clave">imagen Relacionada:</label>
                            <input type="file" name="archivo" id="inputFotoResg" required>

                            <input type="submit" name="registroEsp" class="botonesLogin" id="botonRegistrar" value="Crear Especialidad">
                </form>
            </div>

        </dialog>

        <dialog id="modalEdit" class="dialogEsp">
            
            <div class="registroMed">
                <h2>Modificar Especialidad</h2>

                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>
            </div>

            <div class='registroEsp'>
                <form method="POST" action="especialidades.php" class="formMed" enctype="multipart/form-data">

                    <h2 class='tituloRegistroDialog'>Datos Especialidad</h2>
                        
                        <input type="hidden" name="idDeEsp" id="idDeLaEsp">

                        <label for="nombre">Nombre Especialidad:</label>
                        <input type="text" name="nombreEsp" id="nombreEspecialidad" required><br>

                        <label for="nombre">Descripcion de la Especialidad:</label>
                        <textarea id="DescripcionEspecialidad" name="DescripcionEsp" rows="4" cols="30" placeholder="Escribe aquí..."></textarea><br><br>

                        <label for="consultorio">consultorio:</label>
                        <input type="text"  id="consultorioEdit" name="consultorioEsp" required /><br>

                        <label for="correo">Servicio Relacionado:</label>
                        <select name="servicioRel" id="ServicioEsp" required>
                            <option value="">Seleccione la especialidad</option>
                            <?php
                                include "conex_bd.php";
                                            
                                $sql = $conexion->query("SELECT id_servicio, nombre_servicio FROM `servicios`");

                                while($datos=$sql->fetch_object()){ ?>

                                <option value="<?php echo $datos->id_servicio ?>"><?php echo $datos->nombre_servicio?></option>

                            <?php
                                    
                            } 
                            ?>
                            </select><br>

                            <label for="clave">imagen Relacionada:</label>
                            <label id="inputImg"></label>
                            <input type="hidden" name="archivoNombre" id="inputNombre">

                            <input type="file" name="archivoEdit" id="inputFile">

                            <input type="submit" name="ModificarEsp" id="botonRegistrar" value="Modificar">
                </form>
            </div>
            
        </dialog>




    <script>

        const tarjetaAgg = document.getElementById("aggEspecialidades");
        tarjetaAgg.addEventListener("click", openModal);
        console.log("que pasa")

        function openModal(){
            const dialog = document.getElementById("modalRegistroEsp");
            dialog.showModal();
            console.log("que pasa")
        }

        function enviarFormulario(id) {
        
        var inputId = document.querySelector(`#form_editar_${id} input[name='idEditar']`).value;

        console.log(inputId)

        // Realizamos la solicitud con fetch
        fetch('Crud_Admin/newEspecialidades.php', {
        method: 'POST',  // Método de la solicitud
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'  // Tipo de contenido
        },
        body: `idEditar=${encodeURIComponent(inputId)}`  // El cuerpo de la solicitud con el idEditar
        })
        .then(response => {
            // Verificamos si la respuesta es exitosa
            if (!response.ok) {
                throw new Error('Error en la solicitud AJAX');
            }
            // Convertimos la respuesta en JSON
            return response.json();
        })
        .then(data => {
            // Si hay un error en los datos devueltos
            if (data.error) {
                alert(data.error);  // Si hay error, mostrarlo
            }else {
                // Si la respuesta es exitosa, hacer algo con los datos
                console.log(data);  // Muestra los datos en la consola
                // Actualizar los campos en la interfaz, por ejemplo:

                console.log(data.foto_relacionada)

                document.getElementById('idDeLaEsp').value = data.id;
                document.getElementById('nombreEspecialidad').value = data.nombre;
                document.getElementById('DescripcionEspecialidad').value = data.descripcion;
                document.getElementById('consultorioEdit').value = data.N_consultorio;
                document.getElementById('ServicioEsp').value = data.servicio_relacionado;
                document.getElementById('inputImg').innerHTML = data.foto_relacionada;
                document.getElementById('inputNombre').value = data.foto_relacionada;
                // document.getElementById('cedulaMed').value = data.cedula;
                // document.getElementById('fechaNac').value = data.fecha_nac;

                const dialogEdit = document.getElementById("modalEdit");
                dialogEdit.showModal()

                
                
            }
        })
        .catch(error => {
            // Si ocurre un error en cualquier parte del proceso
            console.error('Error:', error);
        });
    
    
    
    }



    

    </script>


</body>
</hyml>