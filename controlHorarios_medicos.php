<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document1</title>
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
        $nombreSesionMedico = $_SESSION["nombre"];

        $apellidoSesionMedico = $_SESSION['apellido'];

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
            <a href="seccionMedicos.php">Perfil</a>
        </li>
        <li class="sidebar__item">
            <span class="material-symbols-outlined">notifications</span>
            <a href="#">citas medicas</a>
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
            <a href="#">Horarios</a>
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
            <div class="agregarHorarios">

                <div class="cabezera">

                    <h2 class='tituloSeccion'>Gestion de Horarios</h2>
                          
                    <form action="Crud_Admin/resultadoFinalCitas.php" method="post" id="formHorarios">

                        <div class="medico aggNombre">
                                <h2>Nombre Medico</h2>
                                <h3><?php echo " ".$_SESSION["nombre"]." ".$_SESSION["apellido"]; ?></h3>

                                <?php $consultaPerfilMed = "SELECT * FROM medicos WHERE id_medico = $idMedicoSession";
                                $result = mysqli_query($conexion,$consultaPerfilMed);

                                while($fila = $result->fetch_array()){

                                    $idPerfilMedico = $fila['id_perfil'];
                                }
                                ?>

                                <input type="hidden" id="doctor_id" name="medico" value="<?php echo $idPerfilMedico ?>">
                                
                        </div>
                        <div class="medico aggDiaSemana">
                                <h2>dia disponible</h2>
                                <select name="dia" id="diaSemana">
                                    <option value="">Seleciona un dia</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miercoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sabado</option>
                                    <option value="7">Domingo</option>
                                </select>

                                
                        </div>
                        <div class="medico aggHoraInicio">
                                <h2>Ininio de Turno</h2>
                                <select name="comienzoTurno" id="horaC">
                                <option value="">Comienzo de turno</option>
                                        <option value="08:00">08:00</option>
                                        <option value="09:00">09:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                </select>
                        </div>

                        <div class="medico aggHoraFin">
                                <h2>fin de turno</h2>
                                <select name="finTurno" id="horaF">
                                <option value="">Final de Turno</option>
                                        <option value="08:00">08:00</option>
                                        <option value="09:00">09:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                </select>
                        </div>

                        <div class="medico" id='btnRegistrar'>

                            
                        
                            <input type="submit" name="registroHoras" id="button_horarios" class='button_horario' value='Registrar'>
                            <p id="mensajeAlert"></p>
                        
                        </div>

                    </form>

                </div>

                <table>
                    <thead>
                        <th>id Horario</th>
                        <th>Nombre Medico</th>
                        <th>Dia Disponible</th>
                        <th>Inicio De turno</th>
                        <th>Fin de turno</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <?php 
                        
                        $getDatos = "SELECT dh.*, cl.nombre, cl.apellido, m.id_perfil FROM disponibilidad_horarios dh LEFT JOIN medicos m ON dh.medico_relac = m.id_perfil LEFT JOIN usuarios cl ON m.id_medico = cl.id WHERE cl.id = $idMedicoSession";
                        $resultDatos = mysqli_query($conexion,$getDatos);
                        
                        while($fila = $resultDatos->fetch_array()){

                            $idHorario = $fila["id_disponibilidad"];
                            $nombreMed = $fila['nombre'];
                            $apellidoMed = $fila['apellido'];
                            $diaSemana = $fila['dia_semana'];
                            $horaInicio = $fila["hora_inicio"];
                            $horaFin = $fila["hora_fin"];
                            $estado_dis = $fila['estado_disponibilidad']
                        
                            ?>

                            <tr>
                                <td> <?php echo $idHorario; ?></td>
                                <td><?php echo $nombreMed." ".$apellidoMed; ?></td>

                                <td><?php switch ($diaSemana) {
                                            case 1:
                                                $nombreDia = 'Lunes';
                                                break;
                                            case 2:
                                                $nombreDia = 'Martes';
                                                break;
                                            case 3:
                                                $nombreDia = 'Miércoles';
                                                break;
                                            case 4:
                                                $nombreDia = 'Jueves';
                                                break;
                                            case 5:
                                                $nombreDia = 'Viernes';
                                                break;
                                            case 6:
                                                $nombreDia = 'Sábado';
                                                break;
                                            case 7: 
                                                $nombreDia = 'Domingo';
                                                break;
                                            default:
                                                $nombreDia = 'Día no válido';
                                                break;
                                    }

                                echo $nombreDia; // Imprimirá "Jueves" ?></td>

                                <td><?php echo $horaInicio; ?></td>
                                <td><?php echo $horaFin; ?></td>
                                <td><?php echo $estado_dis; ?></td>
                                <td>
                                    <!-- Formulario con botón para editar -->
                                    <form id="form_editar_<?php echo $idHorario; ?>" action="Crud_Admin/accionesHorarios.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="idEditar" value="<?php echo $idHorario; ?>">
                                        <button type="button" class="linkEditar btnTable" onclick="enviarFormulario(<?php echo $idHorario; ?>)">Editar</button>
                                    </form>
                                </td>

                                <?php echo "<td> 
                                            
                                            <form  id='formEliminar' action='Crud_Admin/accionesHorarios.php' method ='POST'>
                                                <input type='hidden' name='id' value='".$idHorario."'>
                                                <button type='submit' name='eliminarHorario_medico' class='deleteMed delete'><span class='material-symbols-outlined'> delete </span></button>
                                            </form>
                                    </td>";?>
                                
                                
                            </tr>

                            <?php
                        }
                        ?>

                        </tr>
                        
                    </tbody>
                </table>
            </div>

        <dialog id="modalEdit" class = "dialogEsp" >

            <h3 class='tituloDialog'>Modificar Horario</h3>

            <div class="formEditar">

                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>

                <form action="Crud_Admin/resultadoFinalCitas.php" method="POST">

                    <input type="hidden" name="idHorarios" id="idDeHorarios" value="">

                    <label for="">Dia de la Semana</label><br>
                    <select name="diaEdit" id="diaSemanaEdit"  class="selectForm">
                        <option value="">Seleciona un dia</option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                        <option value="7">Domingo</option>
                    </select><br>

                    <label for="">Hora De Inicio</label><br>
                    <!-- <span id="mensajeEmer"></span> -->
                    <select name="comienzoTurnoEdit" id="horaComienzoEdit"  class="selectForm">
                        <option value="">Comienzo</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                    </select><br>

                    <label for="">Hora de culminacion</label><br>
                    <!-- <span id="mensajeHoraFin"></span> -->
                    <select name="finTurnoEdit" id="horaFEdit"  class="selectForm">
                        <option value="">Final de Turno</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                    </select><br>
                    <label for="">Disponibilidad de horario</label><br>
                    <select name="disponibilidadEdit" id="dispo_dia"  class="selectForm">
                        <option value="">disponinibilidad de dia</option>
                        <option value="Disponible">Disponible</option>
                        <option value="No disponible">No Disponible</option>  
                    </select><br>

                       <input type="submit" id="botonEdit" name="editHorarios_medico" value="Confirmar Cambios" >                 
                </form>


            </div>
        </dialog>
        
    </main>


    <script>

        document.getElementById("diaSemana").addEventListener("change", function() {

            idMedico =  document.getElementById("doctor_id").value
            let diaSeleccionado =  document.getElementById("diaSemana").value;

            console.log(idMedico+" "+diaSeleccionado)

            var datos = new FormData();
            datos.append('dia', diaSeleccionado);
            datos.append('id_medico', idMedico);

            fetch('Crud_Admin/accionesHorarios.php', {
                method: 'POST',
                body: datos
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();  // Intentamos convertir la respuesta a JSON
            })
            .then(data => {
                console.log(data);
                if (data.validacion) {
                    document.getElementById("button_horarios").disabled = false;
                    document.getElementById("button_horarios").classList.remove("disabled-button");
                    document.getElementById("mensajeAlert").innerHTML = " ";
                } else {
                    document.getElementById("button_horarios").disabled = true;
                    document.getElementById("button_horarios").classList.add("disabled-button");
                    document.getElementById("mensajeAlert").innerHTML = data.mensaje;
                    console.log(data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });


        });

        
        function enviarFormulario(id) {
        
        var inputId = document.querySelector(`#form_editar_${id} input[name='idEditar']`).value;

        console.log(inputId)

        // Realizamos la solicitud con fetch
        fetch('Crud_Admin/editHorarios.php', {
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
                
                console.log(data);  // Muestra los datos en la consola
                // Actualizar los campos en la interfaz, por ejemplo:

                let idDisponibilidad = data.id;

                let idDeMedico = data.idMedico;  // El id del médico que debe ser seleccionado
                
                let idEspecialidad = data.id_esp

                var horaSinSegundos = data.horaInicio.split(':').slice(0, 2).join(':'); // '9:00:00' -> '9:00'
                var horaFinSegundos = data.horaFin.split(':').slice(0, 2).join(':'); // '9:00:00' -> '9:00'
                            
                        
                document.getElementById('diaSemanaEdit').value = data.diaSemana;
                    

                var selectElement = document.getElementById("dispo_dia");
                selectElement.value = data.disponibilidad;
                            
                pintarSelect(horaSinSegundos,horaFinSegundos, idDisponibilidad)
                    
                   
            }
        })
        .catch(error => {
            // Si ocurre un error en cualquier parte del proceso
            console.error('Error:', error);
        });
    
    }

    function pintarSelect(hc,hf,disId){

        // let campoHora = document.getElementById('horaCEdit')
        // campoHora.value = hc

        document.getElementById('idDeHorarios').value = disId

        document.getElementById('horaComienzoEdit').value = hc

        document.getElementById('horaFEdit').value = hf

        // document.getElementById('doctor_id_edit').value = id

        // document.getElementById('mensajeEmer').textContent = hc
        // document.getElementById('mensajeHoraFin').textContent = hf

        const dialogEdit = document.getElementById("modalEdit");
        dialogEdit.showModal()
        
        console.log(hf)



    }





    </script>
</body>
</html>