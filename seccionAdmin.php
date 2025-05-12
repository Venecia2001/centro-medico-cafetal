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
                <th>Correo</th>
                <th>Contraseña</th>
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
                    $clave = $datos["contraseña"];
                    $rol = $datos["nombre_rol"];       
                ?>

            <tr>
                <td> <?php echo $id; ?></td>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $apellido; ?></td>
                <td><?php echo $telefono; ?></td>
                <td><?php echo $correo; ?></td>
                <td><?php echo $clave; ?></td>
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
                                         <button type='submit' name='eliminar' class='delete'><span class='material-symbols-outlined'> delete </span></button>
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
                    <form action='Crud_Admin/editar.php'   method="POST">

                    
                        <label for="cedulaId">Cedula</label>
                        <input id ="cedulaId" type="number" placeholder="Cedula" class="nombreClase" name="cedulaUser">

                        <label for="nombre">Nombre</label>
                        <input id ="nombreR" type="text" placeholder="Nombre" class="nombreClase" name="nombre">

                        <label for="Apellido">Apellido</label>
                        <input id="ApellidoR" type="text" placeholder="Apellido" class="ApellidoClase" name="apellido">

                        <label for="Telefono">Telefono</label>
                        <input id="TelefonoR" type="text" placeholder="Telefono" name="telefono">

                        <label for="Email">Email</label>
                        <input id="EmailR" type="email" placeholder="Email" name="email" >

                        <label for="clave">Contraseña</label>
                        <input id="claveR" type="password" placeholder="Contraseña" name="contraseña">

                        <select name="rolR" id="opcionesRol">
                            <option value="">Seleccione un rol</option>
                            <option value="1">Administrador</option>
                            <option value="2">Medico</option>
                            <option value="3">Usuario</option>
                            <option value="4">Recepcion</option>
                        </select>

                        <button type="submit" class="botonesLogin" id="botonRegistrarse" name="registrar" >Registrar</button>
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

                        <form action="Crud_Admin/editar.php"  method="post">

                            <input type="hidden" id="idUsuario" name ="id_user" value="">

                            <label for="nombre">Nombre</label>
                            <input id ="nombre" type="text" placeholder="Nombre" class="nombreClase"  name="newNombre" value="">

                            <label for="Apellido">Apellido</label>
                            <input id="apellido" type="text" placeholder="Apellido" class="apellido" name="newApellido" value="">

                            <label for="Telefono">Telefono</label>
                            <input id="telefono" type="text" placeholder="Telefono" name="newTelefono" value="">

                            <label for="Email">Correo Electronico</label>
                            <input id="correo" type="email" placeholder="Correo Electronico" name="newEmail" value="" >

                            <label for="cedula">contraseña</label>
                            <input id="clave" type="text" placeholder="Cedula" name="newClave" value="" >

                            <label for="rol">rol de usuario</label>
                            <input id="rol" type="text" placeholder="rol" name="newRol" value="" >

                            <button type="submit" class="botonesLogin" id="botonRegistrarse" name="editar" >Editar</button>
                        </form>
                        
                    </div>

                </div>
            </dialog>
        </div>



    </main>

    <script>

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

        linkDelete.forEach(boton => {
            boton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del enlace o botón

                var confirmar = confirm("¿Estás seguro de que deseas eliminar este usuario?");

                if (confirmar) {
                    // Encontrar el formulario más cercano al botón presionado
                    let formulario = this.closest("form");
                    if (formulario) {
                        formulario.submit(); // Enviar el formulario correcto
                    } else {
                        console.error("No se encontró el formulario asociado.");
                    }
                } else {
                    console.log("Eliminación cancelada");
                }
            });
        });

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
                    document.getElementById('telefono').value = data.telefono;
                    document.getElementById('correo').value = data.correo;
                    document.getElementById('clave').value = data.clave;
                    document.getElementById('rol').value = data.rol;
                    
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