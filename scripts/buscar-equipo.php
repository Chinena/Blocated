<?php
include ('../config.php'); // Incluye el archivo de conexión

header('Content-Type: application/json');

// Obtener el término de búsqueda desde la solicitud GET
$term = $_GET['term'];

// Realizar la consulta a la base de datos para obtener sugerencias
$query = "SELECT name FROM devices WHERE name LIKE '%$term%'";
$result = $conn->query($query);

// Almacenar las sugerencias en un array
$suggestions = array();
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row['name'];
}

// Devolver las sugerencias como formato JSON
header('Content-Type: application/json');
echo json_encode($suggestions);
?>