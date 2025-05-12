<?php 
include("conex_bd.php");

if(isset($_POST['editarFoto'])){

    $target_dir = "uploads/";
    
    $image = $_FILES['archivoImg'];
    $id_seccion = $_POST["idSeccion"];

    $fecha = new DateTime();

    $imagen = $fecha->getTimestamp()."_".$_FILES['archivoImg']['name'];

    $imagen_temporal= $_FILES['archivoImg']['tmp_name'];

    move_uploaded_file($imagen_temporal,"uploads/.$imagen");
    
   
    $consultaActualizar = "UPDATE secciones_pagina SET imgen_seccion ='$imagen' WHERE id_seccion = $id_seccion";
    $resulAct = mysqli_query($conexion,$consultaActualizar);
    
    if($resulAct){

        header("location:configuracionIndex.php");
        
    }else{
        echo "no se realizaron actualizaciones";
    }

}else{

    // echo "No se ha seleccionado ningún archivo.<br>";

}

?>


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

        <h2 class='tituloSeccion'>Pagina Principal </h2>

        <div class="simulacionBody">

            <div class="seccionPricipal">

                <?php 

                include "conex_bd.php";

                $consultaSeccion1 ="SELECT * FROM secciones_pagina WHERE id_seccion = 1";
                $resultadoSql = mysqli_query($conexion, $consultaSeccion1);

                while($data = $resultadoSql->fetch_array()){
                    $idSeccion = $data["id_seccion"];
                    $titulo = $data['titulo_seccion'];
                    $descripcion = $data['descripcion_seccion'];
                    $fotoRelacionada = $data['imgen_seccion'];
                    $textoDeBoton = $data["texto_btn"];

                }
 
                ?>


                <div id="seccionInicio1">
                    <input type="hidden" id="idSeccion" value = "<?php echo $idSeccion ?>">
                    <h1><?php echo $titulo ?></h1>
                    <p><?php echo $descripcion ?></p>
                    <button id="botonInicio"><?php echo $textoDeBoton ?></button>

                </div>

                <img src="uploads/.<?php echo $fotoRelacionada ?>" alt="Imagen de especialidad">
               
                <div class="mensajeEditFoto" id="actualizarFoto">

                    <span id="mesajeEdit">Agregar Imagen</span>

                </div>


            </div>


            <section id="contenedorPrincipal">

            <?php 

                include "conex_bd.php";

                $consultaSeccion2 ="SELECT * FROM secciones_pagina WHERE id_seccion = 2";
                $resultadoSql = mysqli_query($conexion, $consultaSeccion2);

                while($data = $resultadoSql->fetch_array()){
                    $idSeccion2 = $data["id_seccion"];
                    $titulo2 = $data['titulo_seccion'];
                    $descripcion2 = $data['descripcion_seccion'];
                    $fotoRelacionada2 = $data['imgen_seccion'];
                    $textoDeBoton2 = $data["texto_btn"];

                }

            ?>

                <div id="citaOnline">
                    <input type="hidden" id="idSeccion2" value = "<?php echo $idSeccion2 ?>">
                    <h2><?php echo $titulo2 ?></h2>
                </div>

                <div id="contenedorCita">

                    <div class="cita" id="listaDeCitas">
                        <h3 id="H3Online"> <?php echo $descripcion2 ?></h3>
                        <ul>
                            <li>Cardiología</li>
                            <li>Odontología</li>
                            <li>Traumatología</li>
                        </ul>

                        <button id="citasOnline"><?php echo $textoDeBoton2 ?></button>

                    </div>

                    <div class="cita" id="imagenOnline">

                    <img src="uploads/.<?php echo $fotoRelacionada2 ?>" alt="Imagen de citas" class="imagenCita" >

                    </div>

                </div>

            </section>

            <section class="secttionMedicos">

            
            <?php 

                include "conex_bd.php";

                $consultaSeccion2 ="SELECT * FROM secciones_pagina WHERE id_seccion = 3";
                $resultadoSql = mysqli_query($conexion, $consultaSeccion2);

                while($data = $resultadoSql->fetch_array()){
                    $idSeccion3 = $data["id_seccion"];
                    $titulo3 = $data['titulo_seccion'];
                    $descripcion3 = $data['descripcion_seccion'];
                    $fotoRelacionada3 = $data['imgen_seccion'];
                    $textoDeBoton3 = $data["texto_btn"];

                }

            ?>


                <div class="contenedorInfoDoctor">

                    <div id="contenedorCita">

                        <div class="cita" id="directorio">
                            <h3 id="H3Online"><?php echo $titulo3 ?></h3>
                            <input type="hidden" id="idSeccion3" value = "<?php echo $idSeccion3 ?>">
                    
                            <p class="ParafoEspecialistas"><?php echo $descripcion3 ?></p>

                            <button id=""><a href="Medicos_SanPedro.php"> <?php echo $textoDeBoton3 ?></a></button>

                    
                        </div>

                        <div class="cita" id="imagenMedicos">
                
                        <img src="uploads/.<?php echo $fotoRelacionada3 ?>" alt="Imagen de citas" class="imagenCita" >
                        </div>
                    </div>

                </div>
            </section>

            <section id="espacioDeServicios">

            <?php 

                include "conex_bd.php";

                $consultaSeccion4 ="SELECT * FROM secciones_pagina WHERE id_seccion = 4";
                $resultadoSql = mysqli_query($conexion, $consultaSeccion4);

                while($data = $resultadoSql->fetch_array()){
                    $idSeccion4 = $data["id_seccion"];
                    $titulo4 = $data['titulo_seccion'];
                    $descripcion4 = $data['descripcion_seccion'];
                    $fotoRelacionada4 = $data['imgen_seccion'];
                    $textoDeBoton4 = $data["texto_btn"];

                }

            ?>

                <div class="contenedorServicios">

                    <div class="informacionServicios" id="inforImportante">

                        <h2><?php echo $titulo4 ?></h2>
                        <input type="hidden" id="idSeccion4" value = "<?php echo $idSeccion4 ?>">

                        <p id="conceptoServicios"><?php echo $descripcion4 ?></p>
                        <button id="#"><a href="paginaServicios.php"> <?php echo $textoDeBoton4 ?></a> </button>
                    </div>


                    <div class="informacionServiciosImg" id="fotoDeLosServicios">

                    
                    <img src="uploads/.<?php echo $fotoRelacionada4 ?>" alt="Imagen de citas" class="imagenCita" >

                    </div>

                </div>

            </section>



        </div>

        <dialog id="pruebaDialogGeneral" class="stilosDialog">

        
                <form method="dialog">
                    <button class="ModalClose"> X</button>
                </form>

                <h2>Modificar Informacion</h2>

                <form action="Crud_Admin/editDeContenido.php"  method="POST" id="contenidoDialog1" class="contenidoDialog">

                    


                </form>



        </dialog>

        <dialog id="dialogFotografico" class="stilosDialog">

        
            <button type="button" id="closeBtn" class="ModalClose"> X</button>

            <h2>Modificar Informacion</h2>

            <form action="configuracionIndex.php" method="POST" enctype="multipart/form-data" id ="contenidoDialogImg"  class="contenidoDialog" >

                <input type="hidden" id="idDeSeccion" name="idSeccion">
                <label for="">Agregar nueva Foto</label>
                <input type="file" id="fotografiasComplementarias" name="archivoImg">

                <input type="submit" name="editarFoto" value="Actualizar">


            </form>

        </dialog>

        



    </main>
    

    <script>

    const formulario = document.getElementById("contenidoDialog1")
    const dialogEditText = document.getElementById("pruebaDialogGeneral")
    const dialogEditFoto = document.getElementById("dialogFotografico")

    const cerrarVentana = document.getElementById("closeBtn")
    cerrarVentana.addEventListener("click", ()=>{

        dialogEditFoto.close();
       

    })

    const cuadroPrincipal = document.getElementById("seccionInicio1")
    cuadroPrincipal.addEventListener("click", ()=>{

        dialogEditText.showModal();
        formulario.innerHTML = ""

        const inputId = document.getElementById("idSeccion");
        let idSeccion = inputId.value

        console.log(idSeccion)
        console.log("hola presionaste el cuadro")

        fetch('Crud_Admin/editDeContenido.php?numero_id=' + idSeccion)
            .then(response => response.json())  // Procesamos la respuesta como JSON
              .then(result => {
                      // Limpiamos el select de médicos
                    //   contenedorTarjetas.innerHTML = '';

                    // let divDeCampos = document.createElement('div')

                    const campos = [
                        { label: 'titulo', id: 'titulo', type: 'text' },
                        { label: 'descripcion', id: 'descripcion', type: 'text' },
                        { label: 'texto Boton', id: 'textoBtn', type: 'text' },
                    ];

                    campos.forEach(campo => {
                        // Crear el label
                        const label = document.createElement('label');
                        label.setAttribute('for', campo.id);
                        label.textContent = campo.label;

                        // Crear el input o textarea dependiendo del id
                        let elemento;
                        if (campo.id === "descripcion") {
                            // Crear un textarea para el caso "descripcion"
                            elemento = document.createElement('textarea');
                        } else {
                            // Crear un input para los demás casos
                            elemento = document.createElement('input');
                            elemento.setAttribute('type', campo.type);
                        }

                        // Configurar el elemento (input o textarea)
                        elemento.setAttribute('id', campo.id);
                        elemento.setAttribute('name', campo.id);

                        // Añadir el label y el elemento al formulario
                        formulario.appendChild(label);
                        formulario.appendChild(elemento);
                    
                    });

                        let inputId = document.createElement('input')
                        inputId.setAttribute('type','hidden' )
                        inputId.setAttribute('id','oculto' )
                        inputId.setAttribute('name', 'idDeSeccion');
                        

                        let botonEditar = document.createElement('input')
                        botonEditar.setAttribute('type','submit' )
                        botonEditar.setAttribute('id','botonAct' )
                        botonEditar.setAttribute('name', 'bntEdit');
                        botonEditar.classList.add('clasebtn');
                        botonEditar.value = "enviar"

                        formulario.appendChild(botonEditar);
                        formulario.appendChild(inputId);
                      // Si hay médicos, los agregamos al select
                      if (result.success) {
                          // Crear un primer option para "Seleccionar un médico"
                          console.log(result);

                          let datosDeSeccion = result.data[0]

                          console.log(datosDeSeccion.titulo);

                            document.getElementById("titulo").value = datosDeSeccion.titulo;
                            document.getElementById("descripcion").value = datosDeSeccion.descripcion;
                            document.getElementById("textoBtn").value = datosDeSeccion.textoDeBoton;
                            document.getElementById("oculto").value = datosDeSeccion.idSeccion;
                            
                      } else {
                          // cuerpoTabla.innerHTML = "<tr><td colspan='6'>No se encontraron datos relacionados.</td></tr>";
                      }
                  })
                  .catch(error => {
                      console.error("Error al cargar los médicos:", error);
                  });
        
        })

        const cuadroCambiarFoto = document.getElementById("actualizarFoto");
        cuadroCambiarFoto.addEventListener("click", ()=>{

            let idDeHidden = document.getElementById("idSeccion").value

            document.getElementById("idDeSeccion").value = idDeHidden

            console.log(idDeHidden);

            dialogEditFoto.show()

        })

        const CitasOnlineImg = document.getElementById("imagenOnline");
        CitasOnlineImg.addEventListener("click", ()=>{

            let idDeHidden = document.getElementById("idSeccion2").value

            document.getElementById("idDeSeccion").value = idDeHidden

            console.log(idDeHidden);

            dialogEditFoto.show()

        })

        const medicosImg = document.getElementById("imagenMedicos");
        medicosImg.addEventListener("click", ()=>{

            let idDeHidden = document.getElementById("idSeccion3").value

            document.getElementById("idDeSeccion").value = idDeHidden

            console.log(idDeHidden);

            dialogEditFoto.show()

        })

        const serviciosImg = document.getElementById("fotoDeLosServicios");
        serviciosImg.addEventListener("click", ()=>{

            let idDeHidden = document.getElementById("idSeccion4").value

            document.getElementById("idDeSeccion").value = idDeHidden

            console.log(idDeHidden);

            dialogEditFoto.show()

        })



        function obtenerDatosDeSeccion(idSeccion) {
             return fetch('Crud_Admin/editDeContenido.php?numero_id=' + idSeccion)
                .then(response => response.json())  // Procesamos la respuesta como JSON
                .then(result => {
                    if (result.success) {
                        return result.data;  // Devuelves los datos si la respuesta es exitosa
                    } else {
                        throw new Error("No se encontraron datos relacionados.");  // Lanzas un error si no hay datos
                    }
            })
            .catch(error => {
                console.error("Error al cargar los datos:", error);
                throw error;  // Propagas el error para manejarlo en otro lugar
            });
        }


        const cuadroCitasOnline = document.getElementById("listaDeCitas");
        cuadroCitasOnline.addEventListener("click", ()=>{

            dialogEditText.showModal();
            formulario.innerHTML = ""

            const inputId = document.getElementById("idSeccion2");
            let idSeccion = inputId.value

            const campos = [
                        { label: 'titulo', id: 'titulo', type: 'text' },
                        { label: 'descripcion', id: 'descripcion', type: 'text' },
                        { label: 'texto Boton', id: 'textoBtn', type: 'text' },
                    ];

                    campos.forEach(campo => {
                        // Crear el label
                        const label = document.createElement('label');
                        label.setAttribute('for', campo.id);
                        label.textContent = campo.label;

                        // Crear el input o textarea dependiendo del id
                        let elemento;
                        if (campo.id === "descripcion") {
                            // Crear un textarea para el caso "descripcion"
                            elemento = document.createElement('textarea');
                        } else {
                            // Crear un input para los demás casos
                            elemento = document.createElement('input');
                            elemento.setAttribute('type', campo.type);
                        }

                        // Configurar el elemento (input o textarea)
                        elemento.setAttribute('id', campo.id);
                        elemento.setAttribute('name', campo.id);

                        // Añadir el label y el elemento al formulario
                        formulario.appendChild(label);
                        formulario.appendChild(elemento);
                    
                    });

                    let inputHidden = document.createElement('input')
                    inputHidden.setAttribute('type','hidden' )
                    inputHidden.setAttribute('id','hiddenId' )
                    inputHidden.setAttribute('name', 'hiddenId');
                        

                    let botonEditar = document.createElement('input')
                    botonEditar.setAttribute('type','submit' )
                    botonEditar.setAttribute('id','botonAct' )
                    botonEditar.setAttribute('name', 'edicionSeccion2');
                    botonEditar.classList.add('clasebtn');
                    botonEditar.value = "enviar"

                    formulario.appendChild(botonEditar);
                    formulario.appendChild(inputHidden);

            


            obtenerDatosDeSeccion(idSeccion)
            .then(datos => {
                // Aquí puedes trabajar con los datos obtenidos
                console.log(datos);
                let datosDeSeccion = datos[0]

                document.getElementById("titulo").value = datosDeSeccion.titulo;
                document.getElementById("descripcion").value = datosDeSeccion.descripcion;
                document.getElementById("textoBtn").value = datosDeSeccion.textoDeBoton;
                document.getElementById("hiddenId").value = datosDeSeccion.idSeccion;

                // Hacer algo con los datos, como agregar los médicos al select
            })
            .catch(error => {
                // Aquí puedes manejar cualquier error que ocurra durante la obtención de los datos
                console.log('Hubo un error al obtener los datos:', error);
            });
            

        })

        const cuadroMedicos = document.getElementById("directorio");
        cuadroMedicos.addEventListener("click", ()=>{

            dialogEditText.showModal();
            formulario.innerHTML = ""

            const inputId = document.getElementById("idSeccion3");
            let idSeccion = inputId.value

            const campos = [
                        { label: 'titulo', id: 'titulo', type: 'text' },
                        { label: 'descripcion', id: 'descripcion', type: 'text' },
                        { label: 'texto Boton', id: 'textoBtn', type: 'text' },
                    ];

                    campos.forEach(campo => {
                        // Crear el label
                        const label = document.createElement('label');
                        label.setAttribute('for', campo.id);
                        label.textContent = campo.label;

                        // Crear el input o textarea dependiendo del id
                        let elemento;
                        if (campo.id === "descripcion") {
                            // Crear un textarea para el caso "descripcion"
                            elemento = document.createElement('textarea');
                        } else {
                            // Crear un input para los demás casos
                            elemento = document.createElement('input');
                            elemento.setAttribute('type', campo.type);
                        }

                        // Configurar el elemento (input o textarea)
                        elemento.setAttribute('id', campo.id);
                        elemento.setAttribute('name', campo.id);

                        // Añadir el label y el elemento al formulario
                        formulario.appendChild(label);
                        formulario.appendChild(elemento);
                    
                    });

                    let inputHidden = document.createElement('input')
                    inputHidden.setAttribute('type','hidden' )
                    inputHidden.setAttribute('id','hiddenId' )
                    inputHidden.setAttribute('name', 'hiddenId');
                        

                    let botonEditar = document.createElement('input')
                    botonEditar.setAttribute('type','submit' )
                    botonEditar.setAttribute('id','botonAct' )
                    botonEditar.setAttribute('name', 'edicionDirectorio');
                    botonEditar.classList.add('clasebtn');
                    botonEditar.value = "enviar"

                    formulario.appendChild(botonEditar);
                    formulario.appendChild(inputHidden);

            


            obtenerDatosDeSeccion(idSeccion)
            .then(datos => {
                // Aquí puedes trabajar con los datos obtenidos
                console.log(datos);
                let datosDeSeccion = datos[0]

                document.getElementById("titulo").value = datosDeSeccion.titulo;
                document.getElementById("descripcion").value = datosDeSeccion.descripcion;
                document.getElementById("textoBtn").value = datosDeSeccion.textoDeBoton;
                document.getElementById("hiddenId").value = datosDeSeccion.idSeccion;

                // Hacer algo con los datos, como agregar los médicos al select
            })
            .catch(error => {
                // Aquí puedes manejar cualquier error que ocurra durante la obtención de los datos
                console.log('Hubo un error al obtener los datos:', error);
            });
            

        })


        const cuadroServicios = document.getElementById("inforImportante");
        cuadroServicios.addEventListener("click", ()=>{

            dialogEditText.showModal();
            formulario.innerHTML = ""
            

            const inputId = document.getElementById("idSeccion4");
            let idSeccion = inputId.value

            const campos = [
                        { label: 'titulo', id: 'titulo', type: 'text' },
                        { label: 'descripcion', id: 'descripcion', type: 'text' },
                        { label: 'texto Boton', id: 'textoBtn', type: 'text' },
                    ];

                    campos.forEach(campo => {
                        // Crear el label
                        const label = document.createElement('label');
                        label.setAttribute('for', campo.id);
                        label.textContent = campo.label;

                        // Crear el input o textarea dependiendo del id
                        let elemento;
                        if (campo.id === "descripcion") {
                            // Crear un textarea para el caso "descripcion"
                            elemento = document.createElement('textarea');
                        } else {
                            // Crear un input para los demás casos
                            elemento = document.createElement('input');
                            elemento.setAttribute('type', campo.type);
                        }

                        // Configurar el elemento (input o textarea)
                        elemento.setAttribute('id', campo.id);
                        elemento.setAttribute('name', campo.id);

                        // Añadir el label y el elemento al formulario
                        formulario.appendChild(label);
                        formulario.appendChild(elemento);
                    
                    });

                    let inputHidden = document.createElement('input')
                    inputHidden.setAttribute('type','hidden' )
                    inputHidden.setAttribute('id','hiddenId' )
                    inputHidden.setAttribute('name', 'hiddenId');
                        

                    let botonEditar = document.createElement('input')
                    botonEditar.setAttribute('type','submit' )
                    botonEditar.setAttribute('id','botonAct' )
                    botonEditar.setAttribute('name', 'edicionServicios');
                    botonEditar.classList.add('clasebtn');
                    botonEditar.value = "enviar"

                    formulario.appendChild(botonEditar);
                    formulario.appendChild(inputHidden);

            


            obtenerDatosDeSeccion(idSeccion)
            .then(datos => {
                // Aquí puedes trabajar con los datos obtenidos
                console.log(datos);
                let datosDeSeccion = datos[0]

                document.getElementById("titulo").value = datosDeSeccion.titulo;
                document.getElementById("descripcion").value = datosDeSeccion.descripcion;
                document.getElementById("textoBtn").value = datosDeSeccion.textoDeBoton;
                document.getElementById("hiddenId").value = datosDeSeccion.idSeccion;

                // Hacer algo con los datos, como agregar los médicos al select
            })
            .catch(error => {
                // Aquí puedes manejar cualquier error que ocurra durante la obtención de los datos
                console.log('Hubo un error al obtener los datos:', error);
            });
            

        })

    </script>
</body>
</html>   