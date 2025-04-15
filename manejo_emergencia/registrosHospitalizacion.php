<?php 

include("../conex_bd.php");

if(isset($_POST["registroDeMedicamento"])){

    $idEmergenciaMedica = $_POST["idEmergencia"];
    $id_medicamento = $_POST["idMedicamento"];
    $dosis = $_POST["dosisAdministrada"];
    $presentacionMed = $_POST["presentacionMed"];
    $observaciones = $_POST["observaciones"];

    $sentencia = "INSERT INTO medicamentos_emergencia(`id_emergencia`, `medicamento_id`, `dosis`, `presentacion`, `observaciones`) VALUES ('$idEmergenciaMedica','$id_medicamento','$dosis','$presentacionMed','$observaciones')";
    $resultadoSentencia = mysqli_query($conexion,$sentencia);

    if($resultadoSentencia) {

        header("location:../registrosDeEmergencias.php?id=" . $idEmergenciaMedica);

        ?>
            <h3 id ="notice">Se realizo else registro corectamente</h3>
        <?php
    }else{
        ?>
            <h3 class="mensajeFallido">ha ocurrido un error</h3>
        <?php
    }
    
}

if(isset($_POST['eliminarMedicamento'])){

    $id = $_POST["id"];
    $id_emergencia = $_POST["idEmergencia"];
    $AdministradoDurante = $_POST['AdministradoDurante'];
    
    $consulta2 = "DELETE FROM medicamentos_emergencia WHERE medicamento_emergencia_id ='$id'";
    $consultaEnd = mysqli_query($conexion, $consulta2);

    if($consultaEnd){

        if($AdministradoDurante === "Hospitalizacion") {
            header("Location: ../registrosHospitalizacion.php?id=" . $id_emergencia);
        } else {
            header("Location: ../registrosDeEmergencias.php?id=" . $id_emergencia);
        }

    }
}

if(isset($_POST['eliminarServicio'])){

    $id = $_POST["id"];
    $id_emergencia = $_POST["idEmergencia"];
    $AdministradoDurante = $_POST['AdministradoDurante'];
    
    $consulta2 = "DELETE FROM servicios_emergencia WHERE servicio_emergencia_id  ='$id'";
    $consultaEnd = mysqli_query($conexion, $consulta2);

    if($consultaEnd){

        if($AdministradoDurante === "Hospitalizacion") {
            header("Location: ../registrosHospitalizacion.php?id=" . $id_emergencia);
        } else {
            header("Location: ../registrosDeEmergencias.php?id=" . $id_emergencia);
        }

    }
}










?>