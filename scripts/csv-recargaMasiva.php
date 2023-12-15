<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../config.php');

//Probablemente se deban cambiar el nombre de los campos y tabla
$sql = "UPDATE prueba_recargas
        SET
            FECHA_RECARGA = CURDATE() + INTERVAL 1 DAY,
            FECHA_CADUCADO =
                CASE
                    WHEN MONTO = 10 THEN CURDATE() + INTERVAL 8 DAY
                    WHEN MONTO = 50 THEN CURDATE() + INTERVAL 1 MONTH
                    ELSE FECHA_CADUCADO
                END
        WHERE
            MONTO IN (10, 50)
            AND FECHA_CADUCADO = CURDATE();";

if ($conn->query($sql) === TRUE) {
    echo "Actualización exitosa";
} else {
    echo "Error al actualizar la base de datos: " . $conn->error;
}

$conn->close();
?>