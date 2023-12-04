<?php
include ('../config.php');
include ('recargas.js');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
// Obtener el equipo desde la solicitud GET
$equipo = $_GET['equipo'];

// Consultar la base de datos
$query = "SELECT prueba_recargas.FECHA_RECARGA, prueba_recargas.FECHA_CADUCADO, prueba_recargas.MONTO, devices.name, devices.sim_number, devices.active 
FROM prueba_recargas INNER JOIN devices ON prueba_recargas.CHIP = devices.sim_number WHERE devices.name = '$equipo'";
$resultado = $conn->query($query);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Convertir los resultados a un array asociativo
    $fila = $resultado->fetch_assoc();

    // Enviar los resultados como JSON al cliente
    echo json_encode($fila);
} else {
    // Si no hay resultados, enviar una respuesta vacía
    echo json_encode(null);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>