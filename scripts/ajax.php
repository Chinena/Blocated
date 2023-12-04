<?php
#$nombre = $_POST['razon_social'];
#echo "<h1>Hola " . $nombre . "</h1>";

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../config.php');

$razon_social = $_POST['razon_social'];
#$nombre_contacto = '%' + $_POST['nombre_contacto'] + '%';
$nombre_contacto = $_POST['nombre_contacto'];
$cliente = array();

//$stmt = mysqli_prepare($conn, 'SELECT * FROM clientes WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) = UPPER(?)');
$stmt = mysqli_prepare($conn, 'SELECT * FROM clientes WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) LIKE UPPER(?)');

if (!$stmt) {
    die('Error en la preparación de la consulta: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, 'ss', $razon_social, $nombre_contacto);

if (!mysqli_stmt_execute($stmt)) {
    die('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
}

$resultados = mysqli_stmt_get_result($stmt);

/*
ESTE ES EL BUENO
while ($query = mysqli_fetch_array($resultados)) {
    // Itera sobre los valores del array asociativo
    foreach ($query as $valor) {
        echo $valor . '|';
    }

    // Agrega los valores al array para enviarlos como respuesta JSON
    $cliente[] = $query;
}*/
while ($query = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
    $clientes[] = $query;
}

// Devuelve la información en formato JSON
echo json_encode($clientes); //comentar con # para cambios

mysqli_stmt_close($stmt);
