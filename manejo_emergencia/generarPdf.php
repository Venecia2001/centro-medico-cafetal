<?php

include("../conex_bd.php");

if(!empty($_POST["factura_id"])){

    ob_start(); // <- activa buffering

    $codigoEmergencia = $_POST['factura_id'];

    $consultaEmergenciaMed = "SELECT
    em.id_emergencia, 
    em.tipo_emergencia,
    em.id_paciente,
    em.id_paciente_temp,
    em.fecha_emergencia,
    em.diagnostico,
    em.descripcion,
    em.gravedad,
    em.estado_emergencia,
    c.nombre,
    c.apellido,
    pt.nombre AS nombre_paciente_temporal,
    pt.apellido AS apellido_temporal,
    med.nombre AS nombre_medico,
    med.apellido AS apellido_medico,
    fac.fecha_factura,
    fac.metodo_pago,
    fac.estado,
    hosp.fecha_alta,
    hosp.numero_cama
    FROM emergencias_medicas em
    LEFT JOIN usuarios c ON em.id_paciente = c.id
    LEFT JOIN paciente_temp pt ON em.id_paciente_temp = pt.codigo_CI
    LEFT JOIN usuarios med ON em.medico_responsable = med.id
    LEFT JOIN facturas fac ON em.id_emergencia = fac.emergencia_medica_id
    LEFT JOIN hospitalizacion hosp ON em.id_emergencia = hosp.emergencia_medica_id 
    WHERE em.id_emergencia = ?";

    $stmt = $conexion->prepare($consultaEmergenciaMed);
    $stmt->bind_param("i", $codigoEmergencia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $emergencia = $resultado->fetch_all(MYSQLI_ASSOC);

    $datos = $emergencia[0];

    $nombrePaciente = $datos['nombre'];
    $apellidoPaciente = $datos['apellido'];
    $nombrePacienteTemp = $datos['nombre_paciente_temporal'];
    $apellidoPacienteTemp = $datos['apellido_temporal'];
    $cedulaPaciente = $datos['id_paciente'];
    $cedulTemp = $datos['id_paciente_temp'];

    $idEmergenciaUnic = $datos['id_emergencia'];
    $fechaIngreso = $datos['fecha_emergencia'];
    $fechaDeAlta = $datos['fecha_alta'];

    $medicoNombre = $datos['nombre_medico'];
    $medicoApellido = $datos['apellido_medico'];

    $procesoEmergencias = $datos['diagnostico'];
    $cama = $datos['numero_cama'];

    $pacienteRegistrado = $nombrePaciente." ".$apellidoPaciente;
    $pacienteTemp = $nombrePacienteTemp." ".$apellidoPacienteTemp;
    
    $medicoResponsable = $medicoNombre." ".$medicoApellido;

    $consultaTratamientos = "SELECT se.servicio_id, s.nombre_servicio, se.emergencia_medica_id, COUNT(*) AS cantidad, SUM(se.costo) AS total_costo FROM servicios_emergencia se JOIN servicios s ON se.servicio_id = s.id_servicio WHERE se.emergencia_medica_id = $codigoEmergencia  GROUP BY se.servicio_id";
    $resultadoServ = mysqli_query($conexion, $consultaTratamientos);

    $consultaMedicamentos = "SELECT COUNT(*) AS cantidad, SUM(me.costo_total) AS total_costo FROM medicamentos_emergencia me WHERE me.id_emergencia = $codigoEmergencia";
    $resultadoMedicamentos = mysqli_query($conexion, $consultaMedicamentos);

    if($resultadoMedicamentos){
        
        while ($datos = $resultadoMedicamentos->fetch_assoc()) {

            $totalMedicamentosAdmin = $datos['total_costo'];
        }
    }

    $estanciaHosp = "SELECT emergencia_medica_id, fecha_ingreso, fecha_alta, costo_por_dia, DATEDIFF(fecha_alta, fecha_ingreso) AS dias_hospitalizados, DATEDIFF(fecha_alta, fecha_ingreso) * costo_por_dia AS costo_total FROM hospitalizacion WHERE emergencia_medica_id = $codigoEmergencia";
    $resultadoEstancia = mysqli_query($conexion, $estanciaHosp);

    if($resultadoEstancia){
        
        while ($datos = $resultadoEstancia->fetch_assoc()) {

            $totalDiasHospitalizacion = $datos['costo_total'];
        }
    }

    $consultaDeFecha = "SELECT fecha_factura, estado, total_factura FROM facturas WHERE emergencia_medica_id = $codigoEmergencia";
    $fechaFactura = mysqli_query($conexion, $consultaDeFecha);

    if($fechaFactura){
        
        while ($datos = $fechaFactura->fetch_assoc()) {

            $totalCosto = $datos['total_factura'];
            $estadoFac = $datos['estado'];
            $fechaFac = $datos['fecha_factura'];
        }
    }

    $medicamentosDetalles = "SELECT me.id_emergencia, me.presentacion, me.medicamento_id, me.dosis, me.costo_total, DATE(me.fecha_hora_administracion) AS fecha_administracion, m.nombre_medicamento, m.precio_unitario FROM medicamentos_emergencia me INNER JOIN medicamentos m ON me.medicamento_id = m.medicamento_id WHERE me.id_emergencia = $codigoEmergencia";
    $resultadoDetalles = mysqli_query($conexion, $medicamentosDetalles);

     // Crear nuevo PDF

     require_once __DIR__ . '/../vendor/autoload.php'; // ✅

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Clinica San Pedro');
        $pdf->SetTitle('Factura #' . $codigoEmergencia);
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();

    // Contenido de la factura (puedes cargarlo desde una base de datos)
    $html = '
        <style>
            h1, h2, h3, h4 { font-family: Arial, sans-serif; }
            .titulo { text-align: center; font-size: 24px; font-weight: bold; }
            .seccion { margin-bottom: 10px; }
            table { width: 100%; border-collapse: collapse; }
            th, td {padding: 3px; text-align: left; font-size: 10px;  }
            .total { font-weight: bold; text-align: right; }
            .subtotal {text-align: right; }
        </style>

        <div class="titulo">Clínica San Pedro</div>
        <h2 style="text-align:center;">Factura</h2>

        <h3>Datos del Paciente:</h3>
        <table>
            <tr><td><strong>Paciente:</strong></td><td>' . ($pacienteRegistrado ?: $pacienteTemp) . '</td></tr>
            <tr><td><strong>Cédula:</strong></td><td>' . ($cedulaPaciente ?: $cedulTemp) . '</td></tr>
            <tr><td><strong>Código Emergencia:</strong></td><td>'.$idEmergenciaUnic.'</td></tr>
            <tr><td><strong>Fecha de Ingreso:</strong></td><td>'.$fechaIngreso.'</td></tr>
            <tr><td><strong>Fecha de Alta:</strong></td><td>'.$fechaDeAlta.'</td></tr>
            <tr><td><strong>Médico Responsable:</strong></td><td>'.$medicoResponsable.'</td></tr>
             <tr><td><strong>Fecha Factura:</strong></td><td>'.$fechaFac.'</td></tr>
        </table>

        <h3>Costos Generales:</h3>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Servicio</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>';

                $total = 0;

                if ($resultadoServ) {
                    while ($datos = $resultadoServ->fetch_assoc()) {
                        $tipo = $datos['servicio_id'];
                        $nombre = $datos['nombre_servicio'];
                        $monto = $datos['total_costo'];


                        $html .= '<tr>
                            <td>' . $tipo . '</td>
                            <td>' . $nombre . '</td>
                            <td class="subtotal">$' . number_format($monto, 2) . '</td>
                        </tr>';
    
                    $total += $monto;
                }} else {
                    $html .= '<tr><td colspan="3">No hay servicios registrados</td></tr>';
                }

        $html .= '
                
                <tr>
                    <td>c0142</td>
                    <td>Medicamentos</td>
                    <td class="subtotal">'.$totalMedicamentosAdmin.'</td>
                </tr>
                <tr>
                    <td>C0100</td>
                    <td>Estancia Hospitalaria</td>
                    <td class="subtotal">'.$totalDiasHospitalizacion.'</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="totales">Total:</td>
                    <td class="total">'.$totalCosto.'</td>
                </tr>
            </tfoot>
        </table>

        <h3>Detalle de Medicametos:</h3>

        <table>
         <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Medicamenrto</th>
                    <th>Presentacion</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                </tr>
            </thead>
            <tbody>';

            if ($resultadoDetalles) {
                while ($datos = $resultadoDetalles->fetch_assoc()) {

                        $html .= '<tr>
                            <td>' .$datos['medicamento_id']. '</td>
                            <td>' . $datos['nombre_medicamento'] . '</td>
                            <td>' . $datos['presentacion'] . '</td>
                            <td>' . $datos['fecha_administracion'] . '</td>
                            <td>' . $datos['dosis'] . '</td>
                            <td>$' . $datos['precio_unitario'] . '</td>
                            <td class="subtotal">$' . $datos['costo_total'] . '</td>
                        </tr>';
            }} else {
                $html .= '<tr><td colspan="3">No hay medicamentos registrados</td></tr>';
            }


            $html .= '
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="totales">Total:</td>
                    <td class="total">'.$totalMedicamentosAdmin.'</td>
                </tr>
            </tfoot>
            

        </table>

        <h3>Estado de la Factura: <p><strong>'.$estadoFac.'</strong></p></h3>
        
        ';

        // **Escribir HTML en el PDF**
        $pdf->writeHTML($html, true, false, true, false, '');

        // **Generar el PDF**
        if (ob_get_length()) ob_end_clean(); // <- limpia cualquier salida previa

        $pdf->Output('factura.pdf', 'I'); // 'I' muestra el PDF en el navegador

}


?>