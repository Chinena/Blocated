<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';     
$usuario = 'root';     
$contrasena = '';    
$base_de_datos = 'pruebas'; 

$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>