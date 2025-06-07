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
                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>
                 

            <div class="registroMed">

                <div class='tituloFormulario'><h2>Nuevo Doctor</h2></div>

                <form method="POST" action="Crud_Admin/registro_medico.php" id='formNewMedico' class="formularioMed">
                
                    <div class="infoBasica">

                            <label for="Cedula">Cedula</label>
                            <div class='campoCompuestoCI'>

                                <select id="nacionalidad" name="nacionalidadCi" required>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                </select>

                                <input id="cedulaMedico" type="text" placeholder="Cedula" class="nombreClase" name="cedula">

                            </div>

                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombreM" id="nombreReg" required><br>

                            <label for="nombre">Apellido:</label>
                            <input type="text" name="apellidoM" id="apellidoReg" required><br>

                            <label for="Telefono">Telefono</label>
                            <div class='campoCompuestoCI'>

                                <select class='prefijoTelefono' id="PrefijoTlf" name="prefijoTlf" required>
                                    <option value="0412">0412</option>
                                    <option value="0414">0414</option>
                                    <option value="0416">0416</option>
                                    <option value="0422">0422</option>
                                    <option value="0424">0424</option>
                                    <option value="0426">0426</option>
                                </select>

                                <input id="telefonoMedico" type="text" placeholder="1234567" name="telefonoM">
                            </div>

                            <label for="correo">Correo:</label>
                            <input type="email" name="correoMed" id="correoReg" required><br>

                            <label for="clave">Contraseña:</label>
                            <input type="password" name="ClaveMed" id="claveReg" required><br>

                            <label for="claveRepeat">Repita Contraseña</label>
                            <input id="claveRepeat" type="password" placeholder="Repita su Contraseña"><br>

                    </div>

                    <div class="infoPerfil"> 

                        
                        <label for="rolMedico">Rol de Medico</label>
                            <select name="rolMedico" class='selecRol' id="selectTipodeMedico">
                                <option value="">Seleccione un rol</option>
                                <option value="2">Medico regular</option>
                                <option value="5">Medico de Urgencias</option>
                            </select>

                        <label for="">Especialidad</label>
                        <select name="especialidad" id="espReg" class='selecRol' required>
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

                            <input type="submit" name="registroCompleto" value="Registrar Médico" id ="botonRegistroMedico">

                            <span class="resultado"> todos los campos son requeridos</span>
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
            <!-- <th>Contraseña</th> -->
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
                    
                    <td><?php echo $nombre_esp; ?></td>
                    <td><?php echo $direccion; ?></td>
                    <td id='celdaImg'> <img src="uploads/.<?php echo $fotoPerfil;?>" alt="Foto de perfil" width="60" height="60"></td>
                    <td><?php echo $fechaNac; ?></td>
                    <td>
                    <!-- Formulario con botón para editar -->
                        <form  action='Crud_Admin/pruebaEdit.php' id="form_editar_<?php echo $idMed; ?>" method="POST" style="display:inline;">
                            <input type="hidden" name="idEditar" value="<?php echo $idMed; ?>">
                            <button type="button" class="linkEditar" onclick="enviarFormulario(<?php echo $idMed; ?>)">editar</button>
                        </form>
                    </td>
                   <?php 
                        echo "<td> 
                                <form id='formEliminar' action='Crud_Admin/pruebaEdit.php' method='POST' onsubmit=\"return confirm('¿Estás seguro de que deseas eliminar este registro?');\">
                                    <input type='hidden' name='id' value='".$idMed."'>
                                    <button type='submit' name='eliminar' class='delete'>
                                        <span class='material-symbols-outlined'>delete</span>
                                    </button>
                                </form>
                            </td>";
                    ?>

                    </tr>

                    <?php
                }
            
            ?>
            
           </tbody>                     

        </table>

        <dialog id="modalEdit">

            <div class="editMedicos">
                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>
            <div>
                <div class="registroMed">

                    <h2 class='tituloFormulario'>Editar Datos</h2>
 
                    <form method="POST" action="Crud_Admin/pruebaEdit.php" class="formularioMed" id='formEditMedico'>
                        <div class="infoBasica">

                                <input type="hidden" name="id_doc" value="" id="id_doctor">

                                <!-- <label for="cedula">Cedula:</label>
                                <input type="text" name="cedula" id="cedulaMed" required><br> -->
                        
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombreM" id="nombreMed" required><br>

                                <label for="nombre">Apellido:</label>
                                <input type="text" name="apellidoM" id="apellidoMed" required><br>

                                <label for="Telefono">Telefono</label>
                                <div class='campoCompuestoCI'>

                                    <select class='prefijoTelefono' id="PrefijoTlfEdit" name="prefijoTlf" required>
                                        <option value="0412">0412</option>
                                        <option value="0414">0414</option>
                                        <option value="0416">0416</option>
                                        <option value="0422">0422</option>
                                        <option value="0424">0424</option>
                                        <option value="0426">0426</option>
                                    </select>

                                    <input id="telefonoMed" type="text" placeholder="1234567" name="telefonoM">
                                </div>

                                <label for="correo">Correo:</label>
                                <input type="email" name="correoMed" id="correoMed" required><br>

                                <label for="clave">Contraseña:</label>
                                <input id="claveMed" type="text" name="ClaveMed" placeholder="Solo llena si deseas cambiar la contraseña">

                                <input type="hidden" name="rolMedico" value=2>
                        </div>

                        <div class="infoPerfil">
                            
                            <label for="rolMedico">Rol de Medico</label>
                            <select name="rolMedico" class='selecRol' id="selectTipodeMedicoEdit">
                                <option value="">Seleccione un rol</option>
                                <option value="2">Medico regular</option>
                                <option value="5">Medico de Urgencias</option>
                            </select>

                            <label for="">Especialidad</label>
                            <select name="especialidad" id="espEdit" class='selecRol' required>
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

                                 <label for="direccion">Estudios Universitarios:</label>
                                <input type="text" name="estudiosUni" id="estudiosUEdit" required><br>

                                <label for="fecha_nac">Fecha nacimiento:</label>
                                <input type="date" name="fecha_nac" id="fechaNac" required><br>

                                <input type="submit" name="EdicionCompleta" value="Actualizar" id ="botonEditarMed">

                                <span id='resultadoEdit' class="resultado"></span>
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
                    document.getElementById('PrefijoTlfEdit').value = data.prefijoTlf;
                    document.getElementById('telefonoMed').value = data.telefono;
                    document.getElementById('correoMed').value = data.correo;
                    // document.getElementById('claveMed').value = data.clave;
                    document.getElementById('direccionM').value = data.direccion;
                    document.getElementById('espEdit').value = data.nombre_esp;
                    document.getElementById('selectTipodeMedicoEdit').value = data.rol;
                    // document.getElementById('cedulaMed').value = data.id;
                    document.getElementById('fechaNac').value = data.fecha_nac;
                    document.getElementById('estudiosUEdit').value = data.estudiosMedicos;

                    const dialog = document.getElementById("modalEdit");
                    dialog.showModal()
                     
                }
            })
            .catch(error => {
                // Si ocurre un error en cualquier parte del proceso
                console.error('Error:', error);
            });
        }

        function validarFormulario(campos) {
            let error = [];
            let textoPattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
            let textoDescripcionPattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,;:()\-"¿?!¡']+$/;
            let clavePattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

            const {
                nombre,
                apellido,
                cedula,
                telefono,
                email,
                fechaNacimiento,
                clave,
                repetirClave,
                direccion,
                estudios,
                rolMedico,
                especialidad
            } = campos;

            if(nombre.length < 2 || nombre.length > 40 || !textoPattern.test(nombre)){
                return [true, "El nombre solo debe contener letras y tener mínimo 2 caracteres."];
            } else if(apellido.length < 2 || apellido.length > 40 || !textoPattern.test(apellido)){
                return [true, "El apellido solo debe contener letras y tener mínimo 2 caracteres."];
            } else if(cedula && (!/^\d+$/.test(cedula) || cedula.length < 7 || cedula.length > 9 || cedula.startsWith('0'))){
                return [true, "La cédula no es válida. Debe tener entre 7 y 9 dígitos y no comenzar con 0."];
            }else if(!/^\d{7}$/.test(telefono)){
                return [true, "El número debe tener exactamente 7 dígitos."];
            } else if(email.length < 5 || email.length > 40 || 
                    email.indexOf("@") === -1 || 
                    email.indexOf(".") === -1 || 
                    email.match(/[@.]{2,}/) || 
                    /^[.@-]|[.@-]$/.test(email) || 
                    (email.match(/@/g) || []).length !== 1 || 
                    !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)){
                return [true, "Email no válido."];
            } else if (!fechaNacimiento) {
                return [true, "Debes ingresar tu fecha de nacimiento."];
            }

            const fechaHoy = new Date();
            const fechaNac = new Date(fechaNacimiento);
            const fechaMinima = new Date('1915-01-01');

            if (fechaNac < fechaMinima) {
                return [true, "La fecha de nacimiento no puede ser anterior a 1915."];
            }

            let edad = fechaHoy.getFullYear() - fechaNac.getFullYear();
            const mes = fechaHoy.getMonth() - fechaNac.getMonth();
            if (mes < 0 || (mes === 0 && fechaHoy.getDate() < fechaNac.getDate())) {
                edad--;
            }

            if (edad < 18) {
                return [true, "Debes tener al menos 18 años para registrarte."];
            }

            if (campos.clave !== "") {
                if (!clavePattern.test(campos.clave)) {
                    error[0] = true;
                    error[1] = "La nueva contraseña debe tener al menos 6 caracteres, una mayúscula, un número y un símbolo.";
                    return error;
                }
            }   

            if (repetirClave != null && repetirClave !== clave){
                error[0] = true;
                error[1] = "Las contraseñas no coinciden.";
                return error;
            }

            if(direccion.length < 2 || direccion.length > 255 || !textoDescripcionPattern.test(direccion)){
                return [true, "La direccion solo debe contener letras y tener mínimo 2 caracteres."];
            } else if(estudios.length < 2 || estudios.length > 100 || !textoDescripcionPattern.test(estudios)){
                return [true, "la universidad de ingreso solo debe contener letras y tener mínimo 2 caracteres."];
            }

            if (!campos.rolMedico) {
                return [true, "Debes seleccionar un rol de médico."];
            } else if (!campos.especialidad) {
                return [true, "Debes seleccionar una especialidad."];
            }   

            return [false, ""];
        }

    // ---------------------------
    // Manejo de formulario de registro
    // ---------------------------
    const botonRegistrar = document.getElementById("botonRegistroMedico");
    const spanResultado = document.querySelector(".resultado");
    const spanResultadoEdit = document.getElementById("resultadoEdit")

    botonRegistrar.addEventListener("click", (e) => {
        e.preventDefault();

        const campos = {
            nombre: document.getElementById("nombreReg").value.trim(),
            apellido: document.getElementById("apellidoReg").value.trim(),
            cedula: document.getElementById("cedulaMedico").value.trim(),
            telefono: document.getElementById("telefonoMedico").value.trim(),
            email: document.getElementById("correoReg").value.trim(),
            fechaNacimiento: document.getElementById("fechaNacReg").value,
            clave: document.getElementById("claveReg").value,
            repetirClave: document.getElementById("claveRepeat").value,
            direccion: document.getElementById("direccionReg").value,
            estudios: document.getElementById("estudiosU").value,
            rolMedico: document.getElementById("selectTipodeMedico").value,
            especialidad: document.getElementById("espReg").value
        };

        const error = validarFormulario(campos);
        if (error[0]) {
            spanResultado.innerHTML = error[1];
            spanResultado.classList.add("red");
            spanResultado.classList.remove("green");
        } else {
            spanResultado.innerHTML = "Te has registrado correctamente";
            spanResultado.classList.add("green");
            spanResultado.classList.remove("red");

            const form = document.getElementById("formNewMedico");
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "registroCompleto";
            form.appendChild(hiddenInput);
            form.submit();
        }
    });

    // ---------------------------
    // Manejo de formulario de edición
    // ---------------------------

    const botonEditar = document.getElementById("botonEditarMed"); // botón del formulario de edición
    botonEditar.addEventListener("click", function(e) {
        const campos = {
            nombre: document.getElementById("nombreMed").value.trim(),
            apellido: document.getElementById("apellidoMed").value.trim(),
            telefono: document.getElementById("telefonoMed").value.trim(),
            email: document.getElementById("correoMed").value.trim(),
            fechaNacimiento: document.getElementById("fechaNac").value,
            clave: document.getElementById("claveMed").value,
        };

        const camposConCedula = { ...campos, cedula: null };

        const error = validarFormulario(campos);
        if (error[0]) {
            e.preventDefault();
            spanResultadoEdit.innerHTML = error[1];
            spanResultadoEdit.classList.add("red");
            spanResultadoEdit.classList.remove("green");
        } else {
            spanResultadoEdit.innerHTML = "Te has registrado correctamente";
            spanResultadoEdit.classList.add("green");
            spanResultadoEdit.classList.remove("red");

            const formEdit = document.getElementById("formEditMedico");
            const hiddenInputEdit = document.createElement("input");
            hiddenInputEdit.type = "hidden";
            hiddenInputEdit.name = "EdicionCompleta";
            formEdit.appendChild(hiddenInputEdit);
            formEdit.submit();
        }
    });

    </script>
</body>
</html>