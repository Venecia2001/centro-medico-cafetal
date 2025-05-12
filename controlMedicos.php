<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="interfazAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

<?php include "sideba_admin.php" ?>

    <main>
        <h2 class='tituloSeccion'>  Medicos Registrados</h2>
        <div class="tituloAgregar">
            <h2>Agregar Medico</h2>
            <button id="openFormulario" >+</button>
        </div>


        <dialog id="modalRegistro">

                <h2>Agregar Nuevo Doctor</h2>
                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>

            <div class="registroMed">

                <form method="POST" action="Crud_Admin/registro_medico.php" class="formularioMed">
                
                    <div class="infoBasica">

                            <label for="cedula">Cedula:</label>
                            <input type="text" name="cedula" id="cedulaReg" required><br>

                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombreM" id="nombreReg" required><br>

                            <label for="nombre">Apellido:</label>
                            <input type="text" name="apellidoM" id="apellidoReg" required><br>

                            <label for="telefono">Telefono:</label>
                            <input type="text" name="telefonoM" id="telefonoReg" required><br>

                            <label for="correo">Correo:</label>
                            <input type="email" name="correoMed" id="correoReg" required><br>

                            <label for="clave">Contraseña:</label>
                            <input type="text" name="ClaveMed" id="claveReg" required><br><br>

                            <label for="rolMedico">Rol de Medico</label>
                            <select name="rolMedico" id="selectTipodeMedico">
                                <option value="2">Medico regular</option>
                                <option value="5">Medico de Urgencias</option>
                            </select>
                    </div>

                    <div class="infoPerfil"> 
                        <label for="">Especialidad</label>
                        <select name="especialidad" id="espReg" required>
                            <option value="">Seleccione la especialidad</option>
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
                            <input type="text" name="direccionMed" id="direccionReg" required><br>

                            
                            <label for="direccion">Estudios Universitarios:</label>
                            <input type="text" name="estudiosUni" id="estudiosU" required><br>

                            <label for="fecha_nac">Fecha nacimiento:</label>
                            <input type="date" name="fecha_nac" id="fechaNacReg" required><br>

                            <input type="submit" name="registroCompleto" value="Registrar Médico" id ="botonRegistroMed">
                    </div>
                </form>


            </div>

        </dialog>

        <div class="tablaMed"> 
                                
        <table>
           <thead>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Contraseña</th>
            <th>Especialidad</th>
            <th>Direccion</th>
            <th>Foto_perfil</th>
            <th>Fecha_naciento</th>
            <th>Editar</th>
            <th> Borrar </th>
           </thead>
           <tbody>
            <?php

                include "conex_bd.php";               

                $consultaDatos = "SELECT cl.*, m.id_medico, m.id_especialidad, m.direccion,m.foto_perfil, e.nombre_esp AS nombre_especialidad FROM usuarios cl JOIN medicos m ON cl.id = m.id_medico JOIN especialidades e ON m.id_especialidad = e.id_especialidad;";
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
                    ?>


                    <tr>
                    <td> <?php echo $idMed; ?></td>
                    <td><?php echo $nombreMed; ?></td>
                    <td><?php echo $apellidoMed; ?></td>
                    <td><?php echo $telefono; ?></td>
                    <td><?php echo $correo; ?></td>
                    <td><?php echo $clave; ?></td>
                    <td><?php echo $nombre_esp; ?></td>
                    <td><?php echo $direccion; ?></td>
                    <td><?php echo $fotoPerfil; ?></td>
                    <td><?php echo $fechaNac; ?></td>
                    <td>
                    <!-- Formulario con botón para editar -->
                        <form  action='Crud_Admin/pruebaEdit.php' id="form_editar_<?php echo $idMed; ?>" method="POST" style="display:inline;">
                            <input type="hidden" name="idEditar" value="<?php echo $idMed; ?>">
                            <button type="button" class="linkEditar" onclick="enviarFormulario(<?php echo $idMed; ?>)">editar</button>
                        </form>
                    </td>
                    <?php echo "<td> 
                                    
                                    <form  id='formEliminar' action='Crud_Admin/pruebaEdit.php' method ='POST'>
                                        <input type='hidden' name='id' value='".$idMed."'>
                                         <button type='submit' name='eliminar' class='delete'><span class='material-symbols-outlined'> delete </span></button>
                                    </form>
                            </td>";?>


                    </tr>





                    <?php
                }
            
            ?>
            
           </tbody>                     

        </table>

        <dialog id="modalEdit">

            <div class="editMedicos">
                <h2>Datos Doctor</h2>
                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>
            <div>
                <div class="registroMed">

                    <form method="POST" action="Crud_Admin/pruebaEdit.php" class="formularioMed">
                        <div class="infoBasica">

                                <input type="hidden" name="id_doc" value="" id="id_doctor">
                        
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombreM" id="nombreMed" required><br>

                                <label for="nombre">Apellido:</label>
                                <input type="text" name="apellidoM" id="apellidoMed" required><br>

                                <label for="telefono">Telefono:</label>
                                <input type="text" name="telefonoM" id="telefonoMed" required><br>

                                <label for="correo">Correo:</label>
                                <input type="email" name="correoMed" id="correoMed" required><br>

                                <label for="clave">Contraseña:</label>
                                <input type="text" name="ClaveMed" id="claveMed" required><br><br>

                                <input type="hidden" name="rolMedico" value=2>
                        </div>

                        <div class="infoPerfil"> 
                            <label for="">Especialidad</label>
                            <select name="especialidad" id="esp" required>
                                <option value="">Seleccione la especialidad</option>
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
                                <input type="text" name="direccionMed" id="direccionM" required><br>

                                <label for="cedula">Cedula:</label>
                                <input type="text" name="cedula" id="cedulaMed" required><br>

                                <label for="fecha_nac">Fecha nacimiento:</label>
                                <input type="date" name="fecha_nac" id="fechaNac" required><br>

                                <input type="submit" name="EdicionCompleta" value="Editar Médico" id ="botonRegistroMed">
                        </div>
                    </form>

                </div>
        </dialog>
    
        </div>
    </main>


    <script>

        const botonModal = document.getElementById("openFormulario");
        botonModal.addEventListener("click", openModal)

        function openModal(){
            const dialog = document.getElementById("modalRegistro");
            dialog.showModal();
        
        }

        function enviarFormulario(id) {
        
            var inputId = document.querySelector(`#form_editar_${id} input[name='idEditar']`).value;

            console.log(inputId)

            // Realizamos la solicitud con fetch
            fetch('Crud_Admin/pruebaEdit.php', {
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

                    document.getElementById('id_doctor').value = data.id;
                    document.getElementById('nombreMed').value = data.nombre;
                    document.getElementById('apellidoMed').value = data.apellido;
                    document.getElementById('telefonoMed').value = data.telefono;
                    document.getElementById('correoMed').value = data.correo;
                    document.getElementById('claveMed').value = data.clave;
                    document.getElementById('direccionM').value = data.direccion;
                    document.getElementById('cedulaMed').value = data.id;
                    document.getElementById('fechaNac').value = data.fecha_nac;

                    const dialog = document.getElementById("modalEdit");
                    dialog.showModal()
                    
                }
            })
            .catch(error => {
                // Si ocurre un error en cualquier parte del proceso
                console.error('Error:', error);
            });
        
        
        
        }

    </script>
</body>
</html>