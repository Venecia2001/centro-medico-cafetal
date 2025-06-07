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
                    <div class='campoCompuestoCI'>

                        <select id="nacionalidad" name="nacionalidadCi" required>
                            <option value="V">V</option>
                            <option value="E">E</option>
                        </select>

                        <input id="cedula" type="text" placeholder="Cedula" class="cedula" name="cedula">

                    </div>

                    <label for="Telefono">Telefono</label>
                    <div class='campoCompuestoCI'>

                        <select id="PrefijoTlf" name="prefijoTlf" required>
                            <option value="0412">0412</option>
                            <option value="0414">0414</option>
                            <option value="0416">0416</option>
                            <option value="0422">0422</option>
                            <option value="0424">0424</option>
                            <option value="0426">0426</option>
                        </select>

                        <input id="Telefono" type="text" placeholder="1234567" name="telefono">
                    </div>
                    

                    <label for="Email">Email</label>
                    <input id="Email" type="email" placeholder="Email" name="email" >

                    <label for="fecha_nac">Fecha de Nacimiento</label>
                    <input id="fecha_nac" type="date" min="1920-01-01" placeholder="fecha de Nacimiento" name="fecha_nac">

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

            const fechaNacimiento = document.getElementById('fecha_nac').value;

            const telefono = inputTelefono.value.trim();

            // const prefijosValidos = ['0412', '0414', '0416', '0422', '0424', '0426'];

            // const tienePrefijoValido = prefijosValidos.some(prefijo => telefono.startsWith(prefijo));

            if(imputNombre.value.length < 2 || imputNombre.value.length > 40 || !textoPattern.test(imputNombre.value)){
                error[0] = true;
                error[1] = "El nombre solo debe contener letras y espacios y tener como minimo 2 letras."
                return error;
            }else if(inputApellido.value.length < 2 || inputApellido.value.length > 40 || !textoPattern.test(inputApellido.value)){
                error[0] = true;
                error[1] = "El apellido solo debe contener letras y espacios y tener como minimo 2 letras."
                return error;
            }else if(!/^\d+$/.test(inputCedulaId.value) || inputCedulaId.value.length < 7 || inputCedulaId.value.length > 9 || inputCedulaId.value.startsWith('0') ){
                error[0] = true;
                error[1] = "La cédula no es válida. Debe tener entre 7 y 9 dígitos, solo números, y no puede comenzar con 0."
                return error;
            }else if (!/^\d{7}$/.test(telefono)) {
                error[0] = true;
                error[1] = "El teléfono es inválido. Debe tener 11 dígitos y comenzar con un prefijo válido (0412, 0414, etc.)";
                return error;
            }else if(
                inputEmail.value.length < 5 ||
                inputEmail.value.length > 40 ||
                inputEmail.value.indexOf("@") === -1 ||
                inputEmail.value.indexOf(".") === -1 ||
                inputEmail.value.match(/[@.]{2,}/) || // caracteres repetidos
                /^[.@-]|[.@-]$/.test(inputEmail.value) || // empieza o termina mal
                (inputEmail.value.match(/@/g) || []).length !== 1 || // más de un @
                !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(inputEmail.value) // formato general
                ){
                error[0] = true;
                error[1] = "El email no es valido, este no debe contener caracteres especiales repetidos tampoco comenzar o terminar con caracteres especiales ni contener mas de @. "
                return error
            }else if (!fechaNacimiento) {
                error[0] = true;
                error[1] = "Por favor, ingresa tu fecha de nacimiento.";
                return error;
            }else if(!clavePattern.test(inputContraseña.value)){
            error[0] = true;
            error[1] = "La contraseña debe tener al menos 6 caracteres, incluir una letra mayúscula, un número y un carácter especial (!@#$%^&*)."
            return error
            }else if (inputRepeatContraseña.value != inputContraseña.value){
            error[0] = true;
            error[1] = "su contraseña no coinsede"
            return error
            }

            // Validación de edad (Fecha de nacimiento)
            

            const fechaHoy = new Date();
            const fechaNac = new Date(fechaNacimiento);

            const fechaMinima = new Date('1915-01-01');
            if (fechaNac < fechaMinima) {
                error[0] = true;
                error[1] = "La fecha de nacimiento no puede ser anterior al año 1915.";
                return error;
            }
            
            let edad = fechaHoy.getFullYear() - fechaNac.getFullYear();
            const mes = fechaHoy.getMonth() - fechaNac.getMonth();
            
            if (mes < 0 || (mes === 0 && fechaHoy.getDate() < fechaNac.getDate())) {
                edad--;
            }
            
            if (edad < 18) {
                error[0] = true;
                error[1] = "Debes tener al menos 18 años para registrarte.";
                return error;
            }

            error[0] = false
            return error
        
            
        }


    </script>
</body>
</html>