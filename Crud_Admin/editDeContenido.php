<?php 

include("../conex_bd.php");

if(isset($_GET['numero_id'])){

    $idDeSeccion = $_GET['numero_id'];

    $getDatos = "SELECT * FROM secciones_pagina WHERE id_seccion = $idDeSeccion";
    $resultado = mysqli_query($conexion, $getDatos);


    if($resultado->num_rows > 0){

        $datosSeccion = [];

        while ($row = $resultado->fetch_assoc()) {
            $datosSeccion[] = [            
                'idSeccion' => $row["id_seccion"],
                'titulo' => $row['titulo_seccion'],
                'descripcion' => $row['descripcion_seccion'],
                'fotoRelacionada' => $row['imgen_seccion'],
                'textoDeBoton' => $row["texto_btn"]
            ];
        }

        $response = [
            'success' => true,
            'data' => $datosSeccion,
            'message' => "Resultados encontrados en la base de datos."
        ];
        echo json_encode($response);
        } else {
        $response = [
            'success' => false,
            'message' => "No se encontraron datos relacionados porque la consulta no devuelve mas de uno."
        ];
        echo json_encode($response);
    }
    }else {
    $response = [
        'success' => false,
        'message' => "No se encontraron datos relacionados porque nisiquiera entra ."
    ];
    echo json_encode($response);
}



if(isset($_POST['bntEdit'])){


    $Id = $_POST['idDeSeccion'];
    $tituloSeccion = $_POST['titulo'];
    $descricionNew = $_POST['descripcion'];
    $contenidoBoton = $_POST['textoBtn'];

    $consultaActualizacion ="UPDATE `secciones_pagina` SET titulo_seccion='$tituloSeccion',descripcion_seccion='$descricionNew',texto_btn='$contenidoBoton' WHERE id_seccion = $Id";
    $resultadoActualizado = mysqli_query($conexion, $consultaActualizacion);

    if($resultadoActualizado) {
        header("location:../configuracionIndex.php");
    }

}

if(isset($_POST['edicionSeccion2'])){


    $Id = $_POST['hiddenId'];
    $tituloSeccion = $_POST['titulo'];
    $descricionNew = $_POST['descripcion'];
    $contenidoBoton = $_POST['textoBtn'];

    $consultaActualizacion ="UPDATE `secciones_pagina` SET titulo_seccion='$tituloSeccion',descripcion_seccion='$descricionNew',texto_btn='$contenidoBoton' WHERE id_seccion = $Id";
    $resultadoActualizado = mysqli_query($conexion, $consultaActualizacion);

    if($resultadoActualizado) {
        header("location:../configuracionIndex.php");
    }

}

if(isset($_POST['edicionDirectorio'])){


    $Id = $_POST['hiddenId'];
    $tituloSeccion = $_POST['titulo'];
    $descricionNew = $_POST['descripcion'];
    $contenidoBoton = $_POST['textoBtn'];

    $consultaActualizacion ="UPDATE `secciones_pagina` SET titulo_seccion='$tituloSeccion',descripcion_seccion='$descricionNew',texto_btn='$contenidoBoton' WHERE id_seccion = $Id";
    $resultadoActualizado = mysqli_query($conexion, $consultaActualizacion);

    if($resultadoActualizado) {
        header("location:../configuracionIndex.php");
    }

}

if(isset($_POST['edicionServicios'])){


    $Id = $_POST['hiddenId'];
    $tituloSeccion = $_POST['titulo'];
    $descricionNew = $_POST['descripcion'];
    $contenidoBoton = $_POST['textoBtn'];

    $consultaActualizacion ="UPDATE `secciones_pagina` SET titulo_seccion='$tituloSeccion',descripcion_seccion='$descricionNew',texto_btn='$contenidoBoton' WHERE id_seccion = $Id";
    $resultadoActualizado = mysqli_query($conexion, $consultaActualizacion);

    if($resultadoActualizado) {
        header("location:../configuracionIndex.php");
    }

}










// if(isset($_GET['seccion_id'])){

//     $idDeSeccion2 = $_GET['seccion_id'];

//     $getDatos2 = "SELECT * FROM secciones_pagina WHERE id_seccion = $idDeSeccion2";
//     $resultado2 = mysqli_query($conexion, $getDatos2);


//     if($resultado2->num_rows > 0){

//         $datosSeccion = [];

//         while ($row = $resultado2->fetch_assoc()) {
//             $datosSeccion[] = [            
//                 'idSeccion' => $row["id_seccion"],
//                 'titulo' => $row['titulo_seccion'],
//                 'descripcion' => $row['descripcion_seccion'],
//                 'fotoRelacionada' => $row['imgen_seccion'],
//                 'textoDeBoton' => $row["texto_btn"]
//             ];
//         }

//         $response = [
//             'success' => true,
//             'data' => $datosSeccion,
//             'message' => "Resultados encontrados en la base de datos."
//         ];
//         echo json_encode($response);
//         } else {
//         $response = [
//             'success' => false,
//             'message' => "No se encontraron datos relacionados porque la consulta no devuelve mas de uno."
//         ];
//         echo json_encode($response);
//     }
//     }else {
//     $response = [
//         'success' => false,
//         'message' => "No se encontraron datos relacionados porque nisiquiera entra ."
//     ];
//     echo json_encode($response);


// }

?>