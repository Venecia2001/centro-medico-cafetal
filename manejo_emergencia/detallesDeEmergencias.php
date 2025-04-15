<?php 

include("../conex_bd.php");

if(!empty($_POST["idEmergencia"])) {

    $idEmergencia = $_POST['idEmergencia'];

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
    $stmt->bind_param("i", $idEmergencia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $emergencia = $resultado->fetch_all(MYSQLI_ASSOC);

    $consultaDeFecha = "SELECT fecha_factura, estado, total_factura FROM facturas WHERE emergencia_medica_id = $idEmergencia";
    $fechaFactura = mysqli_query($conexion, $consultaDeFecha);
    $fechaEstadoFactura = $fechaFactura->fetch_all(MYSQLI_ASSOC);

     // Segunda consulta: obtener tratamientos asociados a la emergencia
    $consultaTratamientos = "SELECT se.servicio_id, s.nombre_servicio, se.emergencia_medica_id, COUNT(*) AS cantidad, SUM(se.costo) AS total_costo FROM servicios_emergencia se JOIN servicios s ON se.servicio_id = s.id_servicio WHERE se.emergencia_medica_id = $idEmergencia  AND se.administrado_durante = 'Emergencia' GROUP BY se.servicio_id";
    $resultadoServ = mysqli_query($conexion, $consultaTratamientos);
    $serviciosRX = $resultadoServ->fetch_all(MYSQLI_ASSOC);

    $consultaMedicamentos = "SELECT COUNT(*) AS cantidad, SUM(me.costo_total) AS total_costo FROM medicamentos_emergencia me WHERE me.id_emergencia = $idEmergencia AND me.administrado_durante = 'Emergencia'";
    $resultadoMedicamentos = mysqli_query($conexion, $consultaMedicamentos);
    $medicamentosTotal = $resultadoMedicamentos->fetch_all(MYSQLI_ASSOC);

    $MedicamentosHosp = "SELECT COUNT(*) AS cantidad, SUM(me.costo_total) AS total_costo FROM medicamentos_emergencia me WHERE me.id_emergencia = $idEmergencia AND me.administrado_durante = 'Hospitalizacion'";
    $resultadoMedHosp = mysqli_query($conexion, $MedicamentosHosp);
    $costoTotalHosp = $resultadoMedHosp->fetch_all(MYSQLI_ASSOC);

    $serviciosHospitalizacion = "SELECT se.servicio_id, s.nombre_servicio, se.emergencia_medica_id, COUNT(*) AS cantidad, SUM(se.costo) AS total_costo FROM servicios_emergencia se JOIN servicios s ON se.servicio_id = s.id_servicio WHERE se.emergencia_medica_id = $idEmergencia AND se.administrado_durante = 'Hospitalizacion' GROUP BY se.servicio_id";
    $resultadoServHosp = mysqli_query($conexion, $serviciosHospitalizacion);
    $servHospitalizacion = $resultadoServHosp->fetch_all(MYSQLI_ASSOC);

    $estanciaHosp = "SELECT emergencia_medica_id, fecha_ingreso, fecha_alta, costo_por_dia, DATEDIFF(fecha_alta, fecha_ingreso) AS dias_hospitalizados, DATEDIFF(fecha_alta, fecha_ingreso) * costo_por_dia AS costo_total FROM hospitalizacion WHERE emergencia_medica_id = $idEmergencia";
    $resultadoEstancia = mysqli_query($conexion, $estanciaHosp);
    $diasHosp = $resultadoEstancia->fetch_all(MYSQLI_ASSOC);

    $medicamentosDetalles = "SELECT me.id_emergencia, me.presentacion, me.medicamento_id, me.dosis, me.costo_total, me.fecha_hora_administracion, m.nombre_medicamento, m.precio_unitario FROM medicamentos_emergencia me INNER JOIN medicamentos m ON me.medicamento_id = m.medicamento_id WHERE me.id_emergencia = $idEmergencia";
    $resultadoDetalles = mysqli_query($conexion, $medicamentosDetalles);
    $detalleDeMedicamentos = $resultadoDetalles->fetch_all(MYSQLI_ASSOC);


    echo json_encode(["fechaFactura" => $fechaEstadoFactura,"data" => $emergencia, "tratamientos" => $serviciosRX,"totalMed" => $medicamentosTotal, "totalHosp" => $costoTotalHosp, "servDeHospitalizacion" => $servHospitalizacion, "estanciaHosp" => $diasHosp, "detallesMed" => $detalleDeMedicamentos], JSON_PRETTY_PRINT);

} else {
    echo json_encode('No se encontraron datos de historial.');
}

?>
