<?php

include("../conex_bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que la variable 'filtro' esté presente
    if (isset($_POST['mes_facturadoCts'])) {

        $mesAnio = $_POST['mes_facturadoCts']; // Ej: "5-2025"
        list($mes, $anio) = explode("-", $mesAnio);
        $mes = (int)$mes;
        $anio = (int)$anio;

        $datosFacturas = []; // Array donde se almacenarán las citas filtradas

        $sqlIngresos = "SELECT SUM(monto_total) AS total
                    FROM facturas_citas
                    WHERE MONTH(fecha_emision) = $mes
                      AND YEAR(fecha_emision) = $anio";
        

        $resIngresos = mysqli_query($conexion, $sqlIngresos);

        $filaIngresos = mysqli_fetch_assoc($resIngresos);
        $totalIngresos = $filaIngresos['total'] ?? 0;

            if($totalIngresos){

                
                $datosFacturas[] = [
                    'IgresoMensualCitas' => $totalIngresos
                ];

                echo json_encode([
                'success' => true,
                'data' => $datosFacturas
            ]);

            } else {
            // Si no se pasó el filtro
            echo json_encode([
            'success' => false,
            'error' => 'No se recibió el filtro.'
            ]);
      }
    }
}




?>