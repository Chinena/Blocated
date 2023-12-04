<?php
session_start();

function verificarInicioSesion() {
    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {
        // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
        header("Location: login.php");
        exit();
    }
}
?>