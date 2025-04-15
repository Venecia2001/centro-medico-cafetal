<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registro</title>
    <link rel="stylesheet" href="formRegistro.css">
</head>
<body>

    <div class="cuadrosDeRegistro">

        <div class="cuadrocompleto"> 

            <div id="RegistroUsuario">

                <h2>Registrarse</h2>
                <form action="isertarDatos.php"  method="POST" id="formRegistrouser">
                    <label for="nombre">Nombre</label>
                    <input id ="nombre" type="text" placeholder="Nombre" class="nombreClase" name="nombre">

                    <label for="Apellido">Apellido</label>
                    <input id="Apellido" type="text" placeholder="Apellido" class="ApellidoClase" name="apellido">

                    <label for="Cedula">Cedula</label>
                    <input id="cedula" type="text" placeholder="Cedula" class="cedula" name="cedula">

                    <label for="Telefono">Telefono</label>
                    <input id="Telefono" type="text" placeholder="Telefono" name="telefono">

                    <label for="Email">Email</label>
                    <input id="Email" type="email" placeholder="Email" name="email" >

                    <label for="clave">Contraseña</label>
                    <input id="clave" type="password" placeholder="Contraseña" name="contraseña">

                    <label for="claveRepeat">Repita Contraseña</label>
                    <input id="claveRepeat" type="password" placeholder="Repita su Contraseña ">

                    <input type="hidden" name="registrar" value="1">

                    <button type="submit" class="botonesLogin" id="botonRegistrarse" name="registrar" >REGISTRARSE</button>
                </form>

                <span class="resultado"> todos los campos son requeridos</span>

                <?php 
                
                if (isset($_SESSION['error'])) {
                    echo '<div id="errorMessage">' . $_SESSION['error'] . '</div>';
                    // Eliminar el mensaje de la sesión para que no se muestre en futuras cargas
                    unset($_SESSION['error']);
                }

                ?>
            </div>
            
            <div class="cuadroWithImg">

                <p></p>

            </div>
        </div>
    </div>

    <script>

        const imputNombre = document.querySelector(".nombreClase")
        const inputApellido = document.querySelector(".ApellidoClase")
        const inputTelefono = document.getElementById("Telefono")
        const inputCedulaId = document.getElementById("cedula")
        const inputEmail = document.getElementById("Email")
        const inputContraseña = document.getElementById("clave")
        const inputRepeatContraseña = document.getElementById("claveRepeat")

        const spanResultado = document.querySelector(".resultado")

        const botonEviar = document.getElementById("botonRegistrarse")
        botonEviar.addEventListener("click", (e) =>{
                e.preventDefault();

                let error = validarFormulario();
                if(error[0]){
                    spanResultado.innerHTML = error[1];
                    spanResultado.classList.add("red")
                }else{
                    spanResultado.innerHTML = "te has registrado corectamente"
                    spanResultado.classList.add("green")
                    spanResultado.classList.remove("red")

                    const form = document.getElementById("formRegistrouser");

                    form.submit();

                }
        })   


        function validarFormulario(){
            let error = [];
            let textoPattern = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
            let clavePattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

            if(imputNombre.value.length < 2 || imputNombre.value.length > 40 || !textoPattern.test(imputNombre.value)){
                error[0] = true;
                error[1] = "El nombre solo debe contener letras y espacios."
                return error;
            }else if(inputApellido.value.length < 2 || inputApellido.value.length > 40 || !textoPattern.test(inputApellido.value)){
                error[0] = true;
                error[1] = "El apellido solo debe contener letras y espacios."
                return error;
            }else if((!/^\d+$/.test(inputTelefono.value)) || inputTelefono.value.length != 11){
            error[0] = true;
            error[1] = "El telefono es invalido"
            return error;
            }else if(!/^\d+$/.test(inputCedulaId.value) || inputCedulaId.value.length < 7){
            error[0] = true;
            error[1] = "la cedula no es valida"
            return error;
            }else if(inputEmail.value.length < 5 || inputEmail.value.length > 40 || inputEmail.value.indexOf("@") == -1 || inputEmail.value.indexOf(".") == -1){
                error[0] = true;
                error[1] = "El email no es valido"
                return error
            }else if(!clavePattern.test(inputContraseña.value)){
            error[0] = true;
            error[1] = "La contraseña debe tener al menos 6 caracteres, incluir una letra mayúscula, un número y un carácter especial (!@#$%^&*)."
            return error
            }else if (inputRepeatContraseña.value != inputContraseña.value){
            error[0] = true;
            error[1] = "su contraseña no coinsede"
            return error
            }

            error[0] = false
            return error
        
            
        }


    </script>
</body>
</html>