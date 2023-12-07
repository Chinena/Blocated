<?php
require_once('../config.php');

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Consulta preparada para evitar la inyección SQL
$query = "SELECT * FROM usuarios WHERE nom_usuario = ? AND contraseña = ?";
$stmt = $conn->prepare($query);

// Verificar si la consulta preparada fue exitosa
if ($stmt) {
    // Vincular los parámetros
    $stmt->bind_param("ss", $usuario, $contraseña);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se encontró algún usuario
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $usuario_data = $result->fetch_assoc();

        // Iniciar una sesión
        session_start();

        // Almacenar información sobre el usuario en la sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $usuario_data['rol']; // Agregar la información del rol

        // Redireccionar a la página principal
        header("Location: ../index.php");
        exit();
    } else {
        echo '<script>alert("Inicio de sesión incorrecto"); window.location.href="../login.php";</script>';
        exit();
    }

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Manejar el error en caso de que la consulta preparada falle
    echo "Error en la consulta preparada: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
