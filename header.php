<?php
session_start();

// if (isset($_SESSION["usuario"]) != "johan851artigas@gmail.com" ){
//      header("location:login.php");
// }

// if (empty($_SESSION["usuario"])) {
//     header("location:login.php");
//     exit();
// }

if(!empty($_SESSION['usuario'])){

    // echo "bienvenid@".$_SESSION["nombre"]." ".$_SESSION["apellido"]." ".$_SESSION["id"];
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clínica San Pedro</title>
    <link rel="stylesheet" href="styles2.css">
    <link rel="icon" href="imagenes/logo-removebg-preview (1).png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lilita+One&family=Lobster&family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>

    <header>
        <div id="logo">
            <img src="imagenes/logo-removebg-preview (1).png" class="logotipo">
            <a href="index.php" id="tituloPrincipal">Clínica San Pedro</a>
        </div>
        
        <nav class="menuPrincipal">
        <ul>
            <li> <a class="botones" href="index.php">Inicio</a></li>
            <li><a class="botones" href="#cardiologia">Especialidades</a> </li>
            <!-- <li> <a class="botones"  href="#horarios">Horarios</a> </li> -->
            <li> <a class="botones" href="#contactos">Contactos</a> </li>
            <?php if (!isset($_SESSION['usuario'])): ?>
                <li> <a class="botones" href="login.php">inicio de Sesion</a> </li>
            <?php else: ?>

                <?php

                include "conex_bd.php";

                $idUsuario  = $_SESSION['id'];

                $consultaPerfil = "SELECT COUNT(*) AS total FROM perfil_usuario WHERE id_usuario = $idUsuario";
                $resultadoPerfil = mysqli_query($conexion, $consultaPerfil);

                if ($resultadoPerfil) {
                    $row = mysqli_fetch_assoc($resultadoPerfil);
                    $total = $row['total'];

                    if ($total > 0) { ?>
                        <li> <a class="botones" href="perfil_usuario.php">Perfil</a> </li>
                    <?php
                    }else{ ?>

                        <li> <a class="botones PerfilImcompleto" title="Completa tu perfil" href="perfil_usuario.php"> Perfil</a> </li>
                        <?php
                    }
                }    
                ?>
                

                <li> <a class="botones" href="perfil_historialMedico.php">Historial Medico</a> </li>
                <li> <a class="botones" href="cerrar.php">Cerrar Sesion</a> </li>
            <?php endif; ?>
        </ul>
        <nav class="menuDeServicios">
            <input type="checkbox" id="menuServicios">
            <label  for="menuServicios">Servicios <samp id="flecha">▼</samp></label>
            <ul id="itenServicios">
                <li> <a href="paginaServicios.php"> Ultrasonido</a></li>
                <li> <a href="paginaServicios.php">Rayos X</a></li>
                <li> <a href="paginaServicios.php">Endodoncia</a></li>
            </ul>
        </nav>
        </nav>

        

        <nav class="MenuHambur">
        <input type="checkbox" id="menu">
        <label  for="menu"> ☰</label>
        <ul>
            <li> <a class="botones" href="">Inicio</a></li>
            <li><a class="botones" href="#cardiologia">Especialidades</a></li>
            <li> <a class="botones"  href="#horarios">Horarios</a></li>
            <li> <a class="botones" href="#logo">Servicios</a>  </li>
        </ul>
        </nav>
    </header>