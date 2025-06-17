<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="interfazAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
<?php include "sideba_admin.php" ?>
    <main>

        <div class="usuarios_regis">

            <h1 class='tituloSeccion' >Usuarios Registrados</h1>

            <div class="agregarUsuarios">

            <h2>Agregar Nuevo Usuario</h2>
            <button id="addUser">+</button>

            </div>

            <table id='tableUser'>
            <thead>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th class="cell-correo">Correo</th>
                <th >Fecha_Nacimiento</th>
                <!-- <th class="cell-oculta-texto">Contraseña</th> -->
                <th>Rol de Usuario</th>
                <th colspan='2'>Acciones</th>
            </thead>
            <tbody>
            <?php

            include("conex_bd.php");

            $consultaUser = "SELECT c.*, r.nombre AS nombre_rol FROM usuarios c JOIN rol_usuarios r ON c.rol = r.id_rol WHERE rol = 3 OR rol = 1";
            $result =  mysqli_query($conexion, $consultaUser);

            if($result){

                while($datos=$result->fetch_array()){ 
                    $id = $datos["id"];
                    $nombre = $datos["nombre"];
                    $apellido = $datos["apellido"];
                    $telefono = $datos["telefono"];
                    $correo = $datos["correo"];
                    $nacimiento = $datos["fecha_nacimiento"];
                    $clave = $datos["contraseña"];
                    $rol = $datos["nombre_rol"];       
                ?>

            <tr>
                <td> <?php echo $id; ?></td>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $apellido; ?></td>
                <td><?php echo $telefono; ?></td>
                <td class="cell-correo"><?php echo $correo; ?></td>
                 <td class="cell-correo"><?php echo $nacimiento; ?></td>
                <td><?php echo $rol; ?></td>
                <td class='tdEditar'>
                    <!-- Formulario con botón para editar -->
                    <form id="form_editar_<?php echo $id; ?>" action="Crud_Admin/editar.php" method="POST" style="display:inline;">
                        <input type="hidden" name="idEditar" value="<?php echo $id; ?>">
                        <button type="button" class="linkEditar" onclick="enviarFormulario(<?php echo $id; ?>)">Editar</button>
                    </form>
                </td>
                
                <?php echo "<td>
                                    <form  id='formEliminar' action='Crud_Admin/editar.php' method ='POST'>
                                        <input type='hidden' name='id' value='".$id."'>
                                         <button type='submit' name='eliminar' class='delete'  onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\")'><span class='material-symbols-outlined'> delete </span></button>
                                    </form>
                            </td>";?>

            
            </tr>

            <?php   } 
                                    
            }  
                ?>
            </tbody>

            </table>
 
            <dialog id="DialogRegistro">

                    <div class="headerModel"> 
                        <h2 class='tituloRegistroDialog'>Agregar Nuevo Usuario</h2>
                        <form method="dialog">
                        <button class="ModalClose"> X</button>
                        </form>
                    </div>

                <div id="RegistroUsuario">
                    <form action='Crud_Admin/editar.php' id='formularioLadoAdmni' method="POST">

                        <label for="nombre">Nombre</label>
                        <input id ="nombreR" type="text" placeholder="Nombre" class="nombreClase" name="nombre">

                        <label for="Apellido">Apellido</label>
                        <input id="ApellidoR" type="text" placeholder="Apellido" class="ApellidoClase" name="apellido">

                        <label for="Cedula">Cédula</label>
                        <div class='campoCompuestoCI'>

                            <select id="nacionalidad" name="nacionalidadCi" required>
                                <option value="V">V</option>
                                <option value="E">E</option>
                            </select>

                            <input id="cedulaReg" type="text" placeholder="Cédula" class="nombreClase" name="cedulaUser">

                        </div>

                        <label for="Telefono">Teléfono </label>
                            <div class='campoCompuestoCI'>

                                <select class='prefijoTelefono' id="PrefijoTlf" name="prefijoTlf" required>
                                    <option value="0412">0412</option>
                                    <option value="0414">0414</option>
                                    <option value="0416">0416</option>
                                    <option value="0422">0422</option>
                                    <option value="0424">0424</option>
                                    <option value="0426">0426</option>
                                </select>

                                <input id="TelefonoR" type="text" placeholder="1234567" name="telefono">
                            </div>

                        <label for="Email">Email</label>
                        <input id="EmailR" type="email" placeholder="Email" name="email" >

                        <label for="feha_nac">Fecha de Nacimiento</label>
                        <input id="feha_nacR" min="1920-01-01" type="date" name="fecha_nacimientoNew" >

                        <label for="claveR">Contraseña</label>
                        <input id="claveR" type="password" placeholder="Contraseña" name="contraseña">

                        <label for="claveRepeat">Repita Contraseña</label>
                            <input id="claveRepeat" type="password" placeholder="Repita su Contraseña ">

                        <select name="rolR" id="opcionesRol" class='selecRol' require>
                            <option value="">Seleccione un rol</option>
                            <option value="1">Administrador</option>
                            <option value="2">Medico</option>
                            <option value="3">Usuario</option>
                            <option value="4">Recepcion</option>
                        </select>

                        <button type="submit" class="botonesLogin" id="botonRegistrarseNew" name="registrar" >Registrar</button>
                    </form>

                    <span class="resultado"> todos los campos son requeridos</span>

                </div>
    
            </dialog>


        </div>

        <div class="editarForm" id="seccionEdit">


            <dialog id="DialogEdicion">

                <div class="formularios">

                    <div class="headerModel"> 
                        <h2>Modificar Usuario</h2>
                        <form method="dialog">
                        <button class="ModalClose"> X</button>
                        </form>
                    </div>

                    <div id="RegistroPublicos">

                        <form action="Crud_Admin/editar.php" id='formEditar' method="post">

                            <input type="hidden" id="idUsuario" name ="id_user" value="">

                            <label for="nombre">Nombre</label>
                            <input id ="nombre" type="text" placeholder="Nombre" class="nombreClase"  name="newNombre" value="">

                            <label for="Apellido">Apellido</label>
                            <input id="apellido" type="text" placeholder="Apellido" class="apellido" name="newApellido" value="">

                            <label for="Telefono">Teléfono </label>
                            <div class='campoCompuestoCI'>

                                <select class='prefijoTelefono' id="PrefijoTlfEdit" name="prefijoTlf" required>
                                    <option value="0412">0412</option>
                                    <option value="0414">0414</option>
                                    <option value="0416">0416</option>
                                    <option value="0422">0422</option>
                                    <option value="0424">0424</option>
                                    <option value="0426">0426</option>
                                </select>

                                <input id="telefono" type="text" placeholder="1234567" name="newTelefono">
                            </div>

                            <label for="Email">Correo Electronico</label>
                            <input id="correo" type="email" placeholder="Correo Electronico" name="newEmail" value="" >

                            <label for="cedula">contraseña</label>
                            <!-- <input id="clave" type="text" placeholder="Cedula" name="newClave" value="" > -->
                            <input id="clave" type="password" name="newClave" placeholder="Solo llena si deseas cambiar la contraseña">

                            <label for="feha_nac">Fecha de Nacimiento</label>
                            <input id="feha_nacEdit" min="1920-01-01" type="date" name="fecha_nacimientoEdit" >

                            <label for="rol">rol de usuario</label>
                            <!-- <input id="rol" type="text" placeholder="rol" name="newRol" value="" > -->

                            <select id='rol' name="newRol" class='selecRol' require>
                                <option value="">Seleccione un rol</option>
                                <option value="1">Administrador</option>
                                <option value="2">Medico</option>
                                <option value="3">Usuario</option>
                                <option value="4">Recepcion</option>
                            </select>

                            <button type="submit" class="botonesLogin" id="botonRegistrarse" name="editar">Editar</button>

                            <span id="resultadoEdit" class="resultado"></span>
                        </form>
                        
                    </div>

                </div>
            </dialog>
        </div>



    </main>

    <script>


        // const imputNombre = document.querySelector(".nombreClase")
        // const inputApellido = document.getElementById("ApellidoR")
        // const inputTelefono = document.getElementById("TelefonoR")
        // const inputCedulaId = document.getElementById("cedulaReg")
        // const inputEmail = document.getElementById("EmailR")
        // const inputContraseña = document.getElementById("claveR")
        // const inputRepeatContraseña = document.getElementById("claveRepeat")

        // const spanResultado = document.querySelector(".resultado")

        // const botonEviar = document.getElementById("botonRegistrarseNew")
        // botonEviar.addEventListener("click", (e) =>{
        //         e.preventDefault();

        //         let error = validarFormulario();
        //         if(error[0]){
        //             spanResultado.innerHTML = error[1];
        //             spanResultado.classList.add("red")
        //         }else{
        //             spanResultado.innerHTML = "te has registrado corectamente"
        //             spanResultado.classList.add("green")
        //             spanResultado.classList.remove("red")

        //             const form = document.getElementById("formularioLadoAdmni");

        //             const hiddenButton = document.createElement("input");
        //             hiddenButton.type = "hidden";
        //             hiddenButton.name = "registrar";
        //             form.appendChild(hiddenButton);
        //             form.submit();
        //         }
        // })   


        // function validarFormulario(){
        //     let error = [];
        //     let textoPattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
        //     let clavePattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

        //     const fechaNacimiento = document.getElementById('feha_nacR').value;

        //     const telefono = inputTelefono.value.trim();

        //     // const prefijosValidos = ['0412', '0414', '0416', '0422', '0424', '0426'];

        //     // const tienePrefijoValido = prefijosValidos.some(prefijo => telefono.startsWith(prefijo));

        //     if(imputNombre.value.length < 2 || imputNombre.value.length > 40 || !textoPattern.test(imputNombre.value)){
        //         error[0] = true;
        //         error[1] = "El nombre solo debe contener letras y espacios y tener como minimo 2 letras."
        //         return error;
        //     }else if(inputApellido.value.length < 2 || inputApellido.value.length > 40 || !textoPattern.test(inputApellido.value)){
        //         error[0] = true;
        //         error[1] = "El apellido solo debe contener letras y espacios y tener como minimo 2 letras."
        //         return error;
        //     }else if(!/^\d+$/.test(inputCedulaId.value) || inputCedulaId.value.length < 7 || inputCedulaId.value.length > 9 || inputCedulaId.value.startsWith('0') ){
        //         error[0] = true;
        //         error[1] = "La cédula no es válida. Debe tener entre 7 y 9 dígitos, solo números, y no puede comenzar con 0."
        //         return error;
        //     }else if (!/^\d{7}$/.test(telefono)) {
        //         error[0] = true;
        //         error[1] = "El teléfono es inválido. Debe tener 11 dígitos y comenzar con un prefijo válido (0412, 0414, etc.)";
        //         return error;
        //     }else if(
        //         inputEmail.value.length < 5 ||
        //         inputEmail.value.length > 40 ||
        //         inputEmail.value.indexOf("@") === -1 ||
        //         inputEmail.value.indexOf(".") === -1 ||
        //         inputEmail.value.match(/[@.]{2,}/) || // caracteres repetidos
        //         /^[.@-]|[.@-]$/.test(inputEmail.value) || // empieza o termina mal
        //         (inputEmail.value.match(/@/g) || []).length !== 1 || // más de un @
        //         !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(inputEmail.value) // formato general
        //         ){
        //         error[0] = true;
        //         error[1] = "El email no es valido, este no debe contener caracteres especiales repetidos tampoco comenzar o terminar con caracteres especiales ni contener mas de @. "
        //         return error
        //     }else if (!fechaNacimiento) {
        //         error[0] = true;
        //         error[1] = "Por favor, ingresa tu fecha de nacimiento.";
        //         return error;
        //     }else if(!clavePattern.test(inputContraseña.value)){
        //     error[0] = true;
        //     error[1] = "La contraseña debe tener al menos 6 caracteres, incluir una letra mayúscula, un número y un carácter especial (!@#$%^&*)."
        //     return error
        //     }else if (inputRepeatContraseña.value != inputContraseña.value){
        //     error[0] = true;
        //     error[1] = "su contraseña no coinsede"
        //     return error
        //     }

        //     // Validación de edad (Fecha de nacimiento)
            

        //     const fechaHoy = new Date();
        //     const fechaNac = new Date(fechaNacimiento);

        //     const fechaMinima = new Date('1915-01-01');
        //     if (fechaNac < fechaMinima) {
        //         error[0] = true;
        //         error[1] = "La fecha de nacimiento no puede ser anterior al año 1915.";
        //         return error;
        //     }
            
        //     let edad = fechaHoy.getFullYear() - fechaNac.getFullYear();
        //     const mes = fechaHoy.getMonth() - fechaNac.getMonth();
            
        //     if (mes < 0 || (mes === 0 && fechaHoy.getDate() < fechaNac.getDate())) {
        //         edad--;
        //     }
            
        //     if (edad < 18) {
        //         error[0] = true;
        //         error[1] = "Debes tener al menos 18 años para registrarte.";
        //         return error;
        //     }

        //     error[0] = false
        //     return error
        // }

        // let linkDelete = document.querySelectorAll(".delete")
        // linkDelete.forEach(boton =>{
        // boton.addEventListener("click", prevenir)
        // })

        // function prevenir(){
            
        //     var confirmar = confirm("¿Estás seguro de que deseas eliminar este usuario?");

        //     // Si el usuario confirma, enviamos el formulario
        //     if (confirmar) {
        //         document.getElementById("formEliminar").submit(); // Enviar el formulario
        //     } else {
                
        //         console.log("Eliminación cancelada");
        //     }

        // }

        let linkDelete = document.querySelectorAll(".delete");

        // linkDelete.forEach(boton => {
        //     boton.addEventListener("click", function(event) {
        //     event.preventDefault(); // Prevenir el comportamiento por defecto del enlace o botón

        //         var confirmar = confirm("¿Estás seguro de que deseas eliminar este usuario?");

        //         if (confirmar) {
        //             // Encontrar el formulario más cercano al botón presionado
        //             let formulario = this.closest("form");
        //             if (formulario) {
        //                 formulario.submit(); // Enviar el formulario correcto
        //             } else {
        //                 console.error("No se encontró el formulario asociado.");
        //             }
        //         } else {
        //             console.log("Eliminación cancelada");
        //         }
        //     });
        // });

        seccionEditar=document.getElementById("seccionEdit");
        let botonRegistro = document.getElementById("addUser");
        botonRegistro.addEventListener("click", openModal)

        function openModal(){

            let dialogRegistro = document.getElementById("DialogRegistro");
            dialogRegistro.showModal();

        }

        //  linkEditar = document.querySelectorAll(".linkEditar")
        //  linkEditar.forEach(boton =>{
        //  boton.addEventListener("click", mostrarModal)
        //  })

        //  console.log(linkEditar);

        const links = document.querySelectorAll('.linkEditar');
        links.forEach(boton =>{
         boton.addEventListener("click", mostrarModal)
        })

        function mostrarModal(){
            let dialogEdit = document.getElementById("DialogEdicion");
            dialogEdit.showModal();
        }

        function enviarFormulario(id) {
        
            var inputId = document.querySelector(`#form_editar_${id} input[name='idEditar']`).value;

            // Realizamos la solicitud con fetch
            fetch('Crud_Admin/editar.php', {
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
                    document.getElementById('idUsuario').value = data.id;
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apellido').value = data.apellido;
                    document.getElementById("PrefijoTlfEdit").value = data.prefijo;
                    document.getElementById('telefono').value = data.numeroSinPrefijo;
                    document.getElementById('correo').value = data.correo;
                    document.getElementById('feha_nacEdit').value = data.fechaNac;
                    // document.getElementById('clave').value = data.clave;
                    document.getElementById('rol').value = data.rol;
                    
                }
            })
            .catch(error => {
                // Si ocurre un error en cualquier parte del proceso
                console.error('Error:', error);
            });
            
            
            
        }

        // ---------------------------
    // Validación reutilizable
    // ---------------------------
    function validarFormulario(campos) {
        let error = [];
        let textoPattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
        let clavePattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

        const {
            nombre,
            apellido,
            cedula,
            telefono,
            email,
            fechaNacimiento,
            clave,
            repetirClave
        } = campos;

        if(nombre.length < 2 || nombre.length > 40 || !textoPattern.test(nombre)){
            return [true, "El nombre solo debe contener letras y tener mínimo 2 caracteres."];
        } else if(apellido.length < 2 || apellido.length > 40 || !textoPattern.test(apellido)){
            return [true, "El apellido solo debe contener letras y tener mínimo 2 caracteres."];
        } else if(cedula && (!/^\d+$/.test(cedula) || cedula.length < 7 || cedula.length > 9 || cedula.startsWith('0'))){
            return [true, "La cédula no es válida. Debe tener entre 7 y 9 dígitos y no comenzar con 0."];
        } else if(!/^\d{7}$/.test(telefono)){
            return [true, "El número de teléfono  debe tener exactamente 11 dígitos, incluyendo su prefijo determinado"];
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

        return [false, ""];
    }

    // ---------------------------
    // Manejo de formulario de registro
    // ---------------------------
    const botonRegistrar = document.getElementById("botonRegistrarseNew");
    const spanResultado = document.querySelector(".resultado");
    const spanResultadoEdit = document.getElementById("resultadoEdit")

    botonRegistrar.addEventListener("click", (e) => {
        e.preventDefault();

        const campos = {
            nombre: document.getElementById("nombreR").value.trim(),
            apellido: document.getElementById("ApellidoR").value.trim(),
            cedula: document.getElementById("cedulaReg").value.trim(),
            telefono: document.getElementById("TelefonoR").value.trim(),
            email: document.getElementById("EmailR").value.trim(),
            fechaNacimiento: document.getElementById("feha_nacR").value,
            clave: document.getElementById("claveR").value,
            repetirClave: document.getElementById("claveRepeat").value
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

            const form = document.getElementById("formularioLadoAdmni");
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "registrar";
            form.appendChild(hiddenInput);
            form.submit();
        }
    });

    // ---------------------------
    // Manejo de formulario de edición
    // ---------------------------
    const botonEditar = document.getElementById("botonRegistrarse"); // botón del formulario de edición
    botonEditar.addEventListener("click", function(e) {
        const campos = {
            nombre: document.getElementById("nombre").value.trim(),
            apellido: document.getElementById("apellido").value.trim(),
            telefono: document.getElementById("telefono").value.trim(),
            email: document.getElementById("correo").value.trim(),
            fechaNacimiento: document.getElementById("feha_nacEdit").value,
            clave: document.getElementById("clave").value,
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

            const formEdit = document.getElementById("formEditar");
            const hiddenInputEdit = document.createElement("input");
            hiddenInputEdit.type = "hidden";
            hiddenInputEdit.name = "editar";
            formEdit.appendChild(hiddenInputEdit);
            formEdit.submit();
        }
    });


    </script>
    
</body>
</html>