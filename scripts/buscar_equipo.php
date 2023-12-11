<?php
include('config.php');

// Obtener el nombre del equipo desde la solicitud GET
$nombreEquipo = isset($_GET['nombreEquipo']) ? $_GET['nombreEquipo'] : null;

if (!$nombreEquipo) {
    // Manejar el caso en el que no se proporciona el nombre del equipo
    echo json_encode(['error' => 'No se proporcionó el nombre del equipo.']);
    exit;
}

// Consultar la base de datos
$query = "SELECT
            prueba_recargas.FECHA_RECARGA,
            prueba_recargas.FECHA_CADUCADO,
            prueba_recargas.MONTO,
            devices.name,
            devices.sim_number,
            devices.active
          FROM
            prueba_recargas
          INNER JOIN
            devices ON prueba_recargas.CHIP = devices.sim_number
          WHERE
            devices.name LIKE '%$nombreEquipo%'";

$resultado = $conn->query($query);

// Verificar si se obtuvieron resultados
if (!$resultado) {
    // Manejar el caso en el que hay un error en la consulta
    echo json_encode(['error' => 'Error en la consulta: ' . $conn->error]);
    exit;
}

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
