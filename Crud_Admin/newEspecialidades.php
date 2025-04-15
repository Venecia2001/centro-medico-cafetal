<?php 

include("../conex_bd.php");

if (!empty($_POST["idEditar"])) {

    $idEdit = $_POST['idEditar'];

    $getDatosTarjetas ="SELECT * FROM especialidades WHERE id_especialidad = $idEdit";
    $resultadosDatos = mysqli_query($conexion, $getDatosTarjetas);

    $fila= mysqli_fetch_assoc($resultadosDatos);

    $idEsp = $fila["id_especialidad"];
    $nombreEsp = $fila["nombre_esp"];
    $descripcionEsp = $fila["descripcion_esp"];
    $consultorio = $fila["consultorio"];
    $servicio_id = $fila["servicio_id"];
    $imagen = $fila["imagen_fondo"];
   
    echo json_encode(array(
        'id' => $idEsp,
        'nombre' => $nombreEsp,
        'descripcion' => $descripcionEsp,
        'N_consultorio' => $consultorio,
        'servicio_relacionado' => $servicio_id,
        'foto_relacionada' => $imagen
    ));
} else {
    echo json_encode(array('error' => 'No se encontraron datos.'));
}


if(isset($_POST['eliminar'])){

    $idEspecialidad = $_POST['id'];

    $consulta2 = "DELETE FROM especialidades WHERE id_especialidad='$idEspecialidad'";
    $consultaEnd = mysqli_query($conexion, $consulta2);

    if($consultaEnd){

        header("location:../especialidades.php");

    }



}

// if(isset($_POST['ModificarEsp'])){

//     $idEsp = $_POST['idDeEsp'];
//     $nombreEsp = $_POST['nombreEsp'];
//     $descripcionEsp = $_POST['DescripcionEsp'];
//     $consultorioEsp = $_POST['consultorioEsp'];
//     $servicioRel = $_POST['servicioRel'];
//     $nombreDeImagen = $_POST['archivoNombre'];

//     if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {


//         $imagenFondo = $_FILES['archivo'];

//         $fecha = new DateTime();

//         $imagenNombre = $fecha->getTimestamp()."_".$_FILES['archivo']['name'];

    
//         $imagen_temporal= $_FILES['archivo']['tmp_name'];

//         move_uploaded_file($imagen_temporal,"uploads/.$imagenNombre");

//     }else{

//         $imagenNombre = $nombreDeImagen;

//     }


//     $consultaAct = "UPDATE especialidades SET nombre_esp ='$nombreEsp',descripcion_esp ='$descripcionEsp',consultorio='$consultorioEsp',servicio_id='$servicioRel',imagen_fondo='$imagenNombre' WHERE id_especialidad = '$idEsp'";
//     $actualizacion = mysqli_query($conexion, $consultaAct);

//     if($actualizacion){

//         header("location:../especialidades.php");

//     }else{
//         echo "hay un error por ahi";
//     }

// }



// if(isset($_POST['registroEsp'])){

//     $nombreEspecialidad = $_POST['nombreEsp'];
//     $Descripcion = $_POST['DescripcionEsp'];
//     $consultorio = $_POST['consultorioEsp'];
//     $Servicio_relacionado = $_POST['servicioRel'];

//     $imagenFondo = $_FILES['archivo'];

//     $fecha = new DateTime();

//     $imagenNombre = $fecha->getTimestamp()."_".$_FILES['archivo']['name'];

    
//     $imagen_temporal= $_FILES['archivo']['tmp_name'];

//     move_uploaded_file($imagen_temporal,"uploads/.$imagenNombre");

//     $consultaDeRegistro = "INSERT INTO `especialidades`(`nombre_esp`, `descripcion_esp`, `consultorio`, `servicio_id`, `imagen_fondo`) VALUES ('$nombreEspecialidad','$Descripcion','$consultorio','$Servicio_relacionado','$imagenNombre')";

//     $resultadoConsult = mysqli_query($conexion, $consultaDeRegistro);

//     if($resultadoConsult){

//         header("location:especialidades.php");

//     }else{
//         echo "hay un error por ahi";
//     }


// }



?>