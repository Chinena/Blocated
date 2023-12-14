<?php
include('../config.php');

// Función para calcular los días de recarga según el monto
function calcularDiasRecarga($monto) {
    switch ($monto) {
        case "10":
            return 7;
        case "20":
            return 10;
        case "30":
            return 15;
        case "50":
            return 30;
        default:
            return 0;
    }
}

function sumarDias($fecha, $dias) {
    $nuevaFecha = strtotime("+$dias days", strtotime($fecha));
    return date('Y-m-d', $nuevaFecha);
}

// Evento de clic para el botón Recargar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recargarBtn'])) {
    $CHIP = $_POST['simNumber'];
    $montoRecarga = $_POST['monto'];
    $fechaActual = $_POST['fechaActual']; // Lee la fecha actual del array $_POST


    // Calcular días adicionales según el monto
    $diasRecarga = calcularDiasRecarga($montoRecarga);

    // Obtener fecha actual y fecha de caducidad
    $fechaCaducidad = sumarDias($fechaActual, $diasRecarga);

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Actualizar la base de datos con los nuevos valores
        $query = "UPDATE prueba_recargas SET FECHA_RECARGA = '$fechaActual', FECHA_CADUCADO = '$fechaCaducidad', MONTO = '$montoRecarga' WHERE CHIP = '$CHIP'";

        if ($conn->query($query) === TRUE) {
            // Confirmar la transacción
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Recarga realizada con éxito.']);
        } else {
            // Revertir la transacción en caso de error
            $conn->rollback();
            // Mensajes de depuración
            error_log("Error al realizar la recarga: " . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Error al realizar la recarga: ' . $conn->error]);
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de excepción
        $conn->rollback();
        // Mensajes de depuración
        error_log("Error al realizar la recarga: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al realizar la recarga: ' . $e->getMessage()]);
    }
    exit;
}
?>
