<?php
include('../config.php');

// Evento de clic para el botón Recargar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recargarBtn'])) {
    $CHIP = $_POST['simNumber']; 
    $montoRecarga = $_POST['monto']; 

    // Mensajes de depuración
    error_log("CHIP: $CHIP, Monto: $montoRecarga");

    // Calcular días adicionales según el monto
    $diasRecarga = calcularDiasRecarga($montoRecarga);

    // Obtener fecha actual y fecha de caducidad
    $fechaActual = obtenerFechaActual();
    $fechaCaducidad = sumarDias($fechaActual, $diasRecarga);

    
    error_log("Fecha actual: $fechaActual, Fecha de caducidad calculada: $fechaCaducidad");

    // Actualizar la base de datos con los nuevos valores
    $query = "UPDATE prueba_recargas SET FECHA_RECARGA = '$fechaActual', FECHA_CADUCADO = '$fechaCaducidad', MONTO = '$montoRecarga' WHERE CHIP = '$CHIP'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Recarga realizada con éxito.']);
    } else {
        // Mensajes de depuración
        error_log("Error al realizar la recarga: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Error al realizar la recarga: ' . $conn->error]);
    }

    exit;  
}
?>
