<?php

session_start();

include "conex_bd.php";


if (isset($_POST["loginUsuarios"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {

        $loginUsuarios = $_POST["usuario"];
        $loginPassword = $_POST["password"];

        // Consulta segura con sentencia preparada
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $loginUsuarios);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($datos = $resultado->fetch_assoc()) {
            $hash = $datos['contraseña'];

            // 1. Verificamos si la contraseña es un hash válido y coincide
            if (password_verify($loginPassword, $hash)) {

                // Login exitoso con hash
                iniciarSesion($datos);
            }
            // 2. Si no es hash (posible texto plano)
            elseif ($loginPassword === $hash) {
                // Opción opcional: actualizamos la contraseña con hash en la BD
                $nuevoHash = password_hash($loginPassword, PASSWORD_BCRYPT);
                $updateStmt = $conexion->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
                $updateStmt->bind_param("si", $nuevoHash, $datos["id"]);
                $updateStmt->execute();
                $updateStmt->close();

                // Login exitoso con contraseña sin hash (ahora actualizada)
                iniciarSesion($datos);
            }
            else {
                $_SESSION['error_login'] = "Correo o contraseña incorrectos.";
                header("location:login.php");
                exit();
            }
        } else {
            $_SESSION['error_login'] = "Correo o contraseña incorrectos.";
            header("location:login.php");
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error_login'] = "Debes llenar todos los campos.";
        header("location:login.php");
        exit();
    }
}

function iniciarSesion($datos) {
    $_SESSION["usuario"]  = $datos["correo"];
    $_SESSION["nombre"]   = $datos["nombre"];
    $_SESSION["apellido"] = $datos["apellido"];
    $_SESSION["id"]       = $datos["id"];
    $rolUsuario           = $datos["rol"];

    switch ($rolUsuario) {
        case 1: header("location:inicioAdmin.php"); break;
        case 2: header("location:seccionMedicos.php"); break;
        case 3: header("location:index.php"); break;
        case 4: header("location:seccionRecepcion.php"); break;
        default: header("location:index.php"); break;
    }
    exit();
}

// if (isset($_POST["loginUsuarios"])) {
//     if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {

//         $loginUsuarios = $_POST["usuario"];
//         $loginPassword = $_POST["password"];

//         // Consulta segura con sentencia preparada
//         $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
//         $stmt->bind_param("s", $loginUsuarios);
//         $stmt->execute();
//         $resultado = $stmt->get_result();

//         if ($datos = $resultado->fetch_assoc()) {
//             // Verificar la contraseña con hash
//             if (password_verify($loginPassword, $datos['contraseña'])) {

//                 $_SESSION["usuario"]  = $loginUsuarios;
//                 $_SESSION["nombre"]   = $datos["nombre"];
//                 $_SESSION["apellido"] = $datos["apellido"];
//                 $_SESSION["id"]       = $datos["id"];
//                 $rolUsuario = $datos["rol"];

//                 // Redirección según rol
//                 if ($rolUsuario == 1) {
//                     header("location:inicioAdmin.php");
//                 } elseif ($rolUsuario == 2) {
//                     header("location:seccionMedicos.php");
//                 } elseif ($rolUsuario == 3) {
//                     header("location:index.php");
//                 } elseif ($rolUsuario == 4) {
//                     header("location:seccionRecepcion.php");
//                 }
//                 exit(); // Detener ejecución después de redirigir
//             } else {
//                 $_SESSION['error_login'] = "Correo o contraseña incorrectos.";
//                 header("location:login.php");
//                 exit();
//             }
//         } else {
//             $_SESSION['error_login'] = "Correo o contraseña incorrectos.";
//             header("location:login.php");
//             exit();
//         }

//         $stmt->close();
//     } else {
//         $_SESSION['error_login'] = "Debes llenar todos los campos.";
//         header("location:login.php");
//         exit();
//     }
// }


// if(isset($_POST["loginUsuarios"])){
//     if(!empty($_POST["usuario"]) and !empty($_POST["password"])){

//         $loginUsuarios = $_POST["usuario"];
//         $loginPassword = $_POST["password"];
        
//         $sql = $conexion->query("SELECT * FROM usuarios WHERE correo='$loginUsuarios' and contraseña='$loginPassword' ");

//         if($datos=$sql->fetch_array()) {

//             $_SESSION["usuario"]= $loginUsuarios;
//             $_SESSION["nombre"]= $datos["nombre"];
//             $_SESSION["apellido"]=$datos["apellido"];
//             $_SESSION["id"]=$datos["id"];
//             $rolUsuario = $datos["rol"];

//             if ($rolUsuario == 3){

//                 header("location:index.php"); 

//             }else if($rolUsuario == 1){

//                 header("location:inicioAdmin.php");
//             }
//             else if($rolUsuario == 2){

//                 header("location:seccionMedicos.php");
//             }
//             else if($rolUsuario == 4){

//                 header("location:seccionRecepcion.php");
//             }

//             echo $datos['id'];      // Accede al valor de la columna 'id' (por nombre)
//             echo $datos['correo'];  // Accede al valor de la columna 'correo'
//             echo $datos['nombre'];  // Accede al valor de la columna 'nombre'

//         } else{

//             $_SESSION['error_login'] = "Correo o contraseña incorrectos. Por favor, intenta de nuevo.";
//             header("location:login.php"); // Redirige de vuelta a la página de login
            
//         } 

//     }
// }

?>