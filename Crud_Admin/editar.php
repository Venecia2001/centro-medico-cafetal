<?php 

include("../conex_bd.php");


if(isset($_POST["registrar"])){

    if(!empty($_POST["nombre"]) and !empty($_POST["apellido"]) and !empty($_POST["telefono"]) and !empty($_POST["email"]) and !empty($_POST["contraseña"]) and !empty($_POST["rolR"]) ){
        
        $cedulaId = $_POST["cedulaUser"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $tlf = $_POST["telefono"];
        $email = $_POST["email"];
        $clave = $_POST["contraseña"];
        $rol = $_POST['rolR'];

        $consultaSql = "INSERT INTO usuarios(id,nombre,apellido,telefono,correo,contraseña,rol) VALUES ('$cedulaId','$nombre','$apellido','$tlf','$email','$clave','$rol')";
        $resultado = mysqli_query($conexion,$consultaSql);

        if($resultado) {
            header("location:../seccionAdmin.php");
        }else{
            ?>
            <h3 class="bad">ha ocurrido un error</h3>
            <?php
        }

    }else{
        ?>
        <h3 class="bad">Debes llenar todos los campos</h3>
        <?php
    }
}



if(isset($_POST['eliminar'])){

    $id = $_POST["id"];
    
    $consulta2 = "DELETE FROM usuarios WHERE id='$id'";
    $consultaEnd = mysqli_query($conexion, $consulta2);

    if($consultaEnd){

        header("location:../seccionAdmin.php");

    }
}


if (!empty($_POST["idEditar"])) {

    $idEdit = $_POST['idEditar'];
    
    
    $consultaDatos = "SELECT * FROM usuarios WHERE id=$idEdit";
    $resultados = mysqli_query($conexion,$consultaDatos);

    $fila= mysqli_fetch_assoc($resultados);

    $idE = $fila["id"];
    $nombreE = $fila["nombre"];
    $apellidoE = $fila["apellido"];
    $telefonoE = $fila["telefono"];
    $correoE = $fila["correo"];
    $claveE = $fila["contraseña"];
    $rolE = $fila["rol"];

    echo json_encode(array(
        'id' => $idE,
        'nombre' => $nombreE,
        'apellido' => $apellidoE,
        'telefono' => $telefonoE,
        'correo' => $correoE,
        'clave' => $claveE,
        'rol' => $rolE
    ));
} else {
    echo json_encode(array('error' => 'No se encontraron datos.'));
}

if(isset($_POST['editar'])){

    $id_user = $_POST['id_user'];
    $newNombre = $_POST['newNombre'];
    $newApellido = $_POST['newApellido'];
    $newtelefono = $_POST['newTelefono'];
    $newCorreo = $_POST['newEmail'];
    $newClave = $_POST['newClave'];
    $newrol = $_POST['newRol'];

    $consultaEditar =" UPDATE `usuarios` SET `nombre`='$newNombre',`apellido`='$newApellido',`telefono`='$newtelefono',`correo`='$newCorreo',`contraseña`='$newClave',`rol`='$newrol' WHERE id=$id_user";

    $result_edit = mysqli_query($conexion,$consultaEditar);

    if($result_edit){

        header("location:../seccionAdmin.php");
        
    }else{
        echo "no se realizaron actualizaciones";
    }
}

?>