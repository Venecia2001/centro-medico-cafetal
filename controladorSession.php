<?php

session_start();

include "conex_bd.php";

if(isset($_POST["loginUsuarios"])){
    if(!empty($_POST["usuario"]) and !empty($_POST["password"])){

        $loginUsuarios = $_POST["usuario"];
        $loginPassword = $_POST["password"];
        
        $sql = $conexion->query("SELECT * FROM usuarios WHERE correo='$loginUsuarios' and contraseña='$loginPassword' ");

        if($datos=$sql->fetch_array()) {

            $_SESSION["usuario"]= $loginUsuarios;
            $_SESSION["nombre"]= $datos["nombre"];
            $_SESSION["apellido"]=$datos["apellido"];
            $_SESSION["id"]=$datos["id"];
            $rolUsuario = $datos["rol"];

            if ($rolUsuario == 3){

                header("location:index.php"); 

            }else if($rolUsuario == 1){

                header("location:seccionAdmin.php");
            }
            else if($rolUsuario == 2){

                header("location:seccionMedicos.php");
            }
            else if($rolUsuario == 4){

                header("location:seccionRecepcion.php");
            }

            echo $datos['id'];      // Accede al valor de la columna 'id' (por nombre)
            echo $datos['correo'];  // Accede al valor de la columna 'correo'
            echo $datos['nombre'];  // Accede al valor de la columna 'nombre'

        } else{

            $_SESSION['error_login'] = "Correo o contraseña incorrectos. Por favor, intenta de nuevo.";
            header("location:login.php"); // Redirige de vuelta a la página de login
            
        } 

    }
}
    // if(isset($_POST["loginUsuarios"])){
    //     if (isset($_POST["usuario"]) && isset($_POST["password"])) {

    //         function validate($data){
    //             $data = trim($data);
    //             $data = stripslashes($data);
    //             $data = htmlspecialchars($data);
                
    //             return $data;
    //         }

    //         $usuario = validate($_POST['usuario']);
    //         $password = validate($_POST["password"]);

    //         if(empty($usuario)){
    //             header("location:login.php?error-El usuario es requedido");
    //             exit();

    //         }else if(empty($password)){

    //             header("location:login.php?error-La contraseña es requedida");
    //             exit();
    //         }

    //         // $password = md5($password);

    //         $sql = "SELECT * FROM usuarios WHERE correo='$usuario' and contraseña='$password' ";
    //         $result = mysqli_query($conexion, $sql);

    //         if (mysqli_num_rows($result) === 1){

    //             $row = mysqli_fetch_assoc($result);
    //             if ($row["usuario"] === $usuario && $row["password"] === $password) {

    //                 $_SESSION["usuarios"] = $row["usuario"];
    //                 $_SESSION["nombre"] = $row["nombre"];
    //                 $_SESSION["id_cliente"] = $row["id"];

    //                 header("location:index.php");
    //                 exit();
    //             }else{
    //                 header("location:login.php?error-La contraseña y/o el usuario es incorecto");
    //                 exit();
    //             }
    //         }else{
    //             header("location:login.php?error-La contraseña y/o el usuario es incorecto");
    //             exit();
    //         }

    //     }
    // }

?>