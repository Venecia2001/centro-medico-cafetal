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
        <h1 class='tituloSeccion'>Panel de Control</h1>


    <div class="Panel">

        <div class="Panel__item">

                        <?php 
                            
                            include "conex_bd.php";

                            $getDatos ="SELECT COUNT(nombre) AS cantidad FROM usuarios WHERE rol = 3";
                            $result = mysqli_query($conexion, $getDatos);

                            $fila= mysqli_fetch_assoc($result);

                            $numeroUsuarios = $fila['cantidad'];

                            // Pacientes del último mes
                            $getMes = "SELECT COUNT(nombre) AS cantidad_mes FROM usuarios WHERE rol = 3 AND fecha_registro >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
                            $resultMes = mysqli_query($conexion, $getMes);
                            $filaMes = mysqli_fetch_assoc($resultMes);
                            $usuariosUltimoMes = $filaMes['cantidad_mes'];

                        ?>

            <a href="#" id="tarjPaciente" class="tarjeta">
                <div class="titlePanel"><p>Pacientes</p></div>
                <div class="contenido">
                    <div class="Texto"><p>Total Pacientes</p></div>
                    <div class="numerosBd" style="position: relative;">
                        <span class="numTarjeta"><?php echo $numeroUsuarios; ?></span>
                        <span id="numPacientesMes" title="Pacientes Registrados los ultimos 30 dias" class="badgeMes"><?php echo $usuariosUltimoMes; ?></span>
                    </div>
                </div>
            </a>

        </div>

        <div class="Panel__item">
             <a href="#" id="tarjMedicos" class="tarjeta">
                <div class="titlePanel"> <p>Medicos</p></div>

                <?php 
                    include "conex_bd.php";

                    $getDatosMed ="SELECT COUNT(nombre) AS cantidad FROM usuarios WHERE rol IN (2, 5)";
                    $result = mysqli_query($conexion, $getDatosMed);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroMedicos = $fila['cantidad'];
                    ?>
                <div class="contenido">

                    <div class="Texto"> <p>Total Medicos</p></div>
                    <div class="numerosBd"> <span class="numTarjeta"> <?php echo $numeroMedicos ?></span></div>
                </div>

             </a>
            
        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjCitas" class="tarjeta">
                <div class="titlePanel"> <p>Especialides</p></div>
                <?php 

                    $getDatosEsp ="SELECT COUNT(nombre_esp) AS cantidad FROM especialidades";
                    $result = mysqli_query($conexion, $getDatosEsp);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroEspecialidades = $fila['cantidad'];
                ?>
                <div class="contenido">
                    <div class="Texto"> <p>Total </p></div>
                    <div class="numerosBd"> <span class="numTarjeta"><?php echo $numeroEspecialidades ?></span></div>
                </div>
            </a>
        
        </div>

        <div class="Panel__item">
             <a href="#" id="tarjHorarios" class="tarjeta">
                <div class="titlePanel"> <p>Citas Medicas</p></div>
                <div class="contenido">

                <?php 

                    $getCitas ="SELECT COUNT(id_cita) AS cantidad FROM citas";
                    $result = mysqli_query($conexion, $getCitas);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroCitas = $fila['cantidad'];
                ?>

                    <div class="Texto"> <p>Total Citas</p></div>
                    <div class="numerosBd"> <span class="numTarjeta"><?php echo $numeroCitas ?></span></div>
                </div>

             </a>
            
        
        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjNoSeSabe" class="tarjeta">
                <div class="titlePanel"> <p>Estadistica</p></div>
                <div class="contenido">

                <?php 

                    $citasCompletadas = "SELECT COUNT(*) AS total_citas, SUM(CASE WHEN estado = 'realizado' THEN 1 ELSE 0 END) AS citas_realizadas, ROUND( (SUM(CASE WHEN estado = 'realizado' THEN 1 ELSE 0 END) * 100.0) / COUNT(*), 2 ) AS porcentaje_realizadas FROM citas";
                    $result = mysqli_query($conexion, $citasCompletadas);

                    $fila= mysqli_fetch_assoc($result);

                    $porcentajeCitas = $fila['porcentaje_realizadas'];
                ?>
                    <div class="Texto"> <p>Citas Completadas</p></div>
                    <div class="numerosBd"> <span class="numTarjeta"><?php echo $porcentajeCitas ?>%</span></div>
                </div>

            </a>
    
        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjNoSeSabe" class="tarjeta">
                <div class="titlePanel"> <p>Ingresos por Citas</p>
            
                    <div class='filtroIngresos'>

                        <?php 
                        
                        $sqlFactCitas = "SELECT DISTINCT MONTH(fecha_emision) AS mes, YEAR(fecha_emision) AS anio 
                        FROM facturas_citas 
                        ORDER BY anio ASC, mes ASC";

                        $resultSqlCitas = mysqli_query($conexion, $sqlFactCitas);

                        $meses = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                        
                        ?>

                        <form action="" method="POST" id="formulario_ingresosCitas">
                            <!-- <label for="">Filtrar por Fecha</label> -->
                            <select name="mes_facturado" class='stilosSelectFact' id="mes_facturadoCitas">
                                 <option value="">Mes</option>
                                <?php while($fila = mysqli_fetch_assoc($resultSqlCitas)): 
                                    $mesNum = (int)$fila['mes'];
                                    $anio = $fila['anio'];
                                    $nombreMes = $meses[$mesNum];
                                ?>
                                <option value="<?php echo "$mesNum-$anio";?>">
                                    <?php echo "$nombreMes $anio";?>
                                </option>
                                <?php endwhile;?>
                            </select>
                        </form>
                    </div>
            
            
            
                </div>

                <?php 

                    $sqlCitas = "SELECT 
                        MONTH(fecha_emision) AS mes, 
                        SUM(monto_total) AS total 
                    FROM 
                        facturas_citas 
                    WHERE 
                    YEAR(fecha_emision) = YEAR(CURDATE()) 
                    AND MONTH(fecha_emision) = (
                        SELECT 
                            MAX(MONTH(fecha_emision)) 
                        FROM 
                            facturas_citas 
                        WHERE 
                            YEAR(fecha_emision) = YEAR(CURDATE())
                            AND estado_fact = 'pagada'
                    )
                    AND estado_fact = 'pagada'
                GROUP BY 
                MONTH(fecha_emision);";

                    $resultFacCts = mysqli_query($conexion, $sqlCitas);
                    $fila = mysqli_fetch_assoc($resultFacCts);

                    $mes = $fila['mes'];     // ej. 4
                    $totalFacturasCitas = $fila['total']; // ej. 2350.00
                ?>

                <div class="contenido">
                    <div class="Texto"> <p>Dinero recaudaro</p></div>
                    <div class="numerosBd"> <span class="numTarjeta" title="Ingresos de mes en curso" id='spanIngresosCitas'><?php echo $totalFacturasCitas  ?>$</span></div>
                </div>

            </a>
    
        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjEstadisticas" class="tarjeta">
                <div class="titlePanel"> <p>Emergencias</p></div>
                <?php 

                    $getEmergencias = "SELECT COUNT(id_emergencia) AS cantidad FROM emergencias_medicas";
                    $result = mysqli_query($conexion, $getEmergencias);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroEmergencias = $fila['cantidad'];

                    $EmergenciasActiva = "SELECT COUNT(id_emergencia) AS cantidad_en_proceso FROM emergencias_medicas WHERE estado_emergencia = 'En proceso'";
                    $resultEmeg = mysqli_query($conexion, $EmergenciasActiva);
                    $filaEmergActiva = mysqli_fetch_assoc($resultEmeg);
                    $emergEnCurso = $filaEmergActiva['cantidad_en_proceso'];
                ?>
                <div class="contenido">
                    <div class="Texto"><p>Total Emergencias</p></div>
                    <div class="numerosBd" style="position: relative;">
                        <span class="numTarjeta"><?php echo $numeroEmergencias; ?></span>
                        <span id="numPacientesMes" title="Indica Emergencias En Curso" class="badgeMes"><?php echo $emergEnCurso; ?></span>
                    </div>
                </div>

            </a>

        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjNoSeSabe" class="tarjeta">
                <div class="titlePanel"> <p>Hospitalizacion</p></div>
                
                <?php 

                    $HospitalizacionesCompletadas = "SELECT COUNT(hospitalizacion_id) AS total_hosp FROM hospitalizacion";
                    $result = mysqli_query($conexion, $HospitalizacionesCompletadas);

                    $fila= mysqli_fetch_assoc($result);

                    $numeroHospitalizaAciones = $fila['total_hosp'];


                    $getHospActiva = "SELECT COUNT(hospitalizacion_id ) AS cantidad FROM hospitalizacion WHERE estado = 'En curso'";
                    $resultMes = mysqli_query($conexion, $getHospActiva);
                    $filaActiva = mysqli_fetch_assoc($resultMes);
                     $hospEnCurso = $filaActiva['cantidad'];
                ?>

                <div class="contenido">
                    <div class="Texto"><p>Total Hospitalizaciones</p></div>
                    <div class="numerosBd" style="position: relative;">
                        <span class="numTarjeta"><?php echo $numeroHospitalizaAciones; ?></span>
                        <span id="numPacientesMes" title="Indica Hospitalizaciones En Curso" class="badgeMes"><?php echo $hospEnCurso; ?></span>
                    </div>
                </div>

            </a>
    
        </div>

        <div class="Panel__item"> 
            <a href="#" id="tarjNoSeSabe" class="tarjeta">
                <div class="titlePanel"> 
                    <p>Ingresos</p>

                    <div class='filtroIngresos'>

                        <?php 
                        
                        $sql = "SELECT DISTINCT MONTH(fecha_factura) AS mes, YEAR(fecha_factura) AS anio 
                        FROM facturas 
                        ORDER BY anio ASC, mes ASC";

                        $result = mysqli_query($conexion, $sql);

                        $meses = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                        
                        ?>

                        <form action="" method="POST" id="formulario_ingresos">
                            <!-- <label for="">Filtrar por Fecha</label> -->
                            <select name="mes_facturado" class='stilosSelectFact' id="mes_facturado">
                                 <option value="">Mes</option>
                                <?php while($fila = mysqli_fetch_assoc($result)): 
                                    $mesNum = (int)$fila['mes'];
                                    $anio = $fila['anio'];
                                    $nombreMes = $meses[$mesNum];
                                ?>
                                <option value="<?php echo "$mesNum-$anio"; ?>">
                                    <?php echo "$nombreMes $anio"; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </form>
                    </div>
            
                </div>
                <div class="contenido">

                <?php 

                    $sql = "SELECT MONTH(fecha_factura) AS mes, SUM(total_factura) AS total FROM facturas WHERE YEAR(fecha_factura) = YEAR(CURDATE()) AND MONTH(fecha_factura) = ( SELECT MAX(MONTH(fecha_factura)) FROM facturas WHERE YEAR(fecha_factura) = YEAR(CURDATE()) ) GROUP BY MONTH(fecha_factura)";

                    $result = mysqli_query($conexion, $sql);
                    $fila = mysqli_fetch_assoc($result);

                    $mes = $fila['mes'];     // ej. 4
                    $total = $fila['total']; // ej. 2350.00
                ?>
                    <div class="Texto"> <p>Dinero recaudaro</p></div>
                    <div class="numerosBd"> <span id='numeroIngresos' title="Ingresos de mes en curso" class="numTarjeta"><?php echo $total ?>$</span></div>
                </div>

            </a>
    
        </div>

        

    </div>

    </main>

    <script>

        document.getElementById('mes_facturado').addEventListener('change', function() {
            const filtro = this.value;

            console.log(filtro)
        
            // Si no hay valor seleccionado, no hacer nada
            if (!filtro) return;

            if(filtro === "totalCitas"){
                location.reload();            
            }

            // Crear los datos a enviar
            const formData = new FormData();
            formData.append('mes_facturado', filtro);

            // Enviar los datos al servidor usando fetch
                fetch('Crud_Admin/filtroMesIngreso.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    // Verificar si la respuesta es exitosa (código de estado 200)
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json(); // Parsear la respuesta como JSON
                })
                .then(data => {


                    if (data.success) {

                        
                        console.log(data.data[0].IgresoMensual)

                        document.getElementById("numeroIngresos").innerText =  data.data[0].IgresoMensual+'$';
                        

                        
                    } else {
                        
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });
        });


         document.getElementById('mes_facturadoCitas').addEventListener('change', function() {
            const filtro = this.value;

            console.log(filtro)
        
            // Si no hay valor seleccionado, no hacer nada
            if (!filtro) return;

            if(filtro === "totalCitas"){
                location.reload();            
            }

            // Crear los datos a enviar
            const formData = new FormData();
            formData.append('mes_facturadoCts', filtro);

            // Enviar los datos al servidor usando fetch
                fetch('Crud_Admin/filtroIngresosCitas.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    // Verificar si la respuesta es exitosa (código de estado 200)
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json(); // Parsear la respuesta como JSON
                })
                .then(data => {


                    if (data.success) {

                        
                        console.log(data.data[0].IgresoMensualCitas)

                        document.getElementById("spanIngresosCitas").innerText =  data.data[0].IgresoMensualCitas+'$';
                        

                        
                    } else {
                        
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });
        });

    </script>
</body>
</html>   