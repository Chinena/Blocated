<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establece el tipo de contenido
header('Content-Type: application/json');
header('Content-Type: application/javascript'); 

require('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera los datos del formulario
    /*
    $razon_social = $_POST['razon_social'];
    $rfc = $_POST['rfc'];
    $email_factura = $_POST['email_factura'];
    $tel_oficina = $_POST['tel_Oficina'];
    $domicilio = $_POST['domicilio'];
    $nombre_contacto = $_POST['contacto'];
    $email_contacto = $_POST['email_contacto'];
    $tel_contacto = $_POST['tel_Contacto'];*/

    $razon_social = mysqli_real_escape_string($conn, $_POST['razon_social']);
    $rfc = mysqli_real_escape_string($conn, $_POST['rfc']);
    $email_factura = mysqli_real_escape_string($conn, $_POST['email_factura']);
    $tel_oficina = mysqli_real_escape_string($conn, $_POST['tel_Oficina']);
    $domicilio = mysqli_real_escape_string($conn, $_POST['domicilio']);
    $nombre_contacto = mysqli_real_escape_string($conn, $_POST['contacto']);
    $email_contacto = mysqli_real_escape_string($conn, $_POST['email_contacto']);
    $tel_contacto = mysqli_real_escape_string($conn, $_POST['tel_Contacto']);

     // Campos ocultos
     $razon_social_hidden = isset($_POST['razon_social_hidden']) ? mysqli_real_escape_string($conn, $_POST['razon_social_hidden']) : '';
     $nombre_contacto_hidden = isset($_POST['contacto_hidden']) ? mysqli_real_escape_string($conn, $_POST['contacto_hidden']) : '';
    
    $pago = mysqli_real_escape_string($conn, $_POST['pago']);
    $plan = mysqli_real_escape_string($conn, $_POST['plan']);
    #$pago = intval($_POST['pago']);
    #$plan = intval($_POST['plan']);
    $activo = isset($_POST["activo"]) ? 1 : 0; // Checkbox activo

    $existe = "0";
    
    /*
    $stmt = mysqli_prepare($conn, 'SELECT * FROM clientes WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) = UPPER(?)');

    mysqli_stmt_bind_param($stmt, 'ss', $razon_social, $nombre_contacto);

    if (!$stmt) {
        die('Error en la preparación de la consulta: ' . mysqli_error($conn));
    }
    if (!mysqli_stmt_execute($stmt)) {
        die('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
    }
    
    $resultados = mysqli_stmt_get_result($stmt);
   
    while ($query = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
        $existe = "1";
    }

    //Consultar si es crear un nuevo cliente o actualizar datos
    if ($existe == "1"){
        //Actualiza datos
        $sql_actualizar = "UPDATE clientes SET rfc=?, email_factura=?, tel_oficina=?, direccion=?, email_contacto=?, tel_contacto=?, id_pago=?, id_plan=?, activo=? WHERE razon_social=? AND contacto=?";
        $stmt_actualizar = mysqli_prepare($conn, $sql_actualizar);

        if (!$stmt_actualizar) {
            die('Error en la preparación de la consulta de actualización: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt_actualizar, "ssissiiiiss", $rfc, $email_factura, $tel_oficina, $domicilio, $email_contacto, $tel_contacto, $pago, $plan, $activo, $razon_social, $nombre_contacto);

        if (mysqli_stmt_execute($stmt_actualizar)) {
            // Datos actualizados exitosamente en la base de datos
            // Redirigir después de procesar el formulario
            header("Location: ../index.php#clientes");
            exit;
        } else {
            echo "Error: " . $sql_actualizar . "<br>" . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_actualizar);
    }else{
        //Crea un nuevo cliente
        $sql_insertar = "INSERT INTO clientes (razon_social, rfc, email_factura, tel_oficina, contacto, direccion, email_contacto, tel_contacto, id_pago, id_plan, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insertar = mysqli_prepare($conn, $sql_insertar);

        if (!$stmt_insertar) {
            die('Error en la preparación de la consulta de inserción: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt_insertar, "sssisssiiii", $razon_social, $rfc, $email_factura, $tel_oficina, $nombre_contacto, $domicilio, $email_contacto, $tel_contacto, $pago, $plan, $activo);

        // Ejecutar la declaración
        if (mysqli_stmt_execute($stmt_insertar)) {
            // Datos almacenados exitosamente en la base de datos
            // Redirigir después de procesar el formulario
            header("Location: ../index.php#clientes");
            exit;
        } else {
            echo "Error: " . $sql_insertar . "<br>" . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt_insertar);
    }

    /*
      ESTE DEBE FUNCIONAR POR AHORA  // Se crea un nuevo cliente
        $sql_insertar = "INSERT INTO clientes (razon_social, rfc, email_factura, tel_oficina, contacto, direccion, email_contacto, tel_contacto, id_pago, id_plan, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insertar = mysqli_prepare($conn, $sql_insertar);
    
        mysqli_stmt_bind_param($stmt_insertar, "sssisssiiii", $razon_social, $rfc, $email_factura, $tel_oficina, $contacto, $domicilio, $email_contacto, $tel_contacto, $pago, $plan, $activo);
    
        // Ejecutar la declaración
        if (mysqli_stmt_execute($stmt_insertar)) {
            // Datos almacenados exitosamente en la base de datos
            // Redirigir después de procesar el formulario
            header("Location: ../index.php#clientes");
            exit;
        } else {
            echo "Error: " . $sql_insertar . "<br>" . mysqli_error($conn);
        }
        // Cerrar la declaración
        mysqli_stmt_close($stmt_insertar);
    }*---/
    mysqli_stmt_close($stmt);*/

    if (!empty($razon_social_hidden) && !empty($nombre_contacto_hidden)) {  //Si los hidden CONTIENEN datos
        $stmt = mysqli_prepare($conn, 'SELECT * FROM clientes WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) = UPPER(?)');
        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, 'ss', $razon_social_hidden, $nombre_contacto_hidden);
        if (!mysqli_stmt_execute($stmt)) {
            die('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
        }

        $resultados = mysqli_stmt_get_result($stmt);
        // Verificar si existe o no en la base de datos
        while ($query = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
            $existe = "1";
        }

        //Consultar si es crear un nuevo cliente o actualizar datos
        if ($existe == "1"){
            //Actualiza datos con HIDDEN
            $sql_actualizar = "UPDATE clientes SET rfc=?, email_factura=?, tel_oficina=?, direccion=?, email_contacto=?, tel_contacto=?, id_pago=?, id_plan=?, activo=? WHERE razon_social=? AND contacto=?";
            $stmt_actualizar = mysqli_prepare($conn, $sql_actualizar);

            if (!$stmt_actualizar) {
                die('Error en la preparación de la consulta de actualización: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt_actualizar, "ssissiiiiss", $rfc, $email_factura, $tel_oficina, $domicilio, $email_contacto, $tel_contacto, $pago, $plan, $activo, $razon_social_hidden, $nombre_contacto_hidden);

            if (mysqli_stmt_execute($stmt_actualizar)) {
                header("Location: ../index.php#clientes");
                exit;
            } else {
                echo "Error: " . $sql_actualizar . "<br>" . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt_actualizar);
        }else{
            //Crea un nuevo cliente
            $sql_insertar = "INSERT INTO clientes (razon_social, rfc, email_factura, tel_oficina, contacto, direccion, email_contacto, tel_contacto, id_pago, id_plan, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insertar = mysqli_prepare($conn, $sql_insertar);

            if (!$stmt_insertar) {
                die('Error en la preparación de la consulta de inserción: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt_insertar, "sssisssiiii", $razon_social_hidden, $rfc, $email_factura, $tel_oficina, $nombre_contacto_hidden, $domicilio, $email_contacto, $tel_contacto, $pago, $plan, $activo);

            if (mysqli_stmt_execute($stmt_insertar)) {
                header("Location: ../index.php#clientes");
                exit;
            } else {
                echo "Error: " . $sql_insertar . "<br>" . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt_insertar);
        }


    }else{ //Si los hidden NO CONTIENEN datos
        $stmt = mysqli_prepare($conn, 'SELECT * FROM clientes WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) = UPPER(?)');
        mysqli_stmt_bind_param($stmt, 'ss', $razon_social, $nombre_contacto);
        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . mysqli_error($conn));
        }
        if (!mysqli_stmt_execute($stmt)) {
            die('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
        }

        $resultados = mysqli_stmt_get_result($stmt);
        // Verificar si existe o no en la base de datos
        while ($query = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
            $existe = "1";
        }

        //Consultar si es crear un nuevo cliente o actualizar datos
        if ($existe == "1"){
            //Actualiza datos con HIDDEN
            $sql_actualizar = "UPDATE clientes SET rfc=?, email_factura=?, tel_oficina=?, direccion=?, email_contacto=?, tel_contacto=?, id_pago=?, id_plan=?, activo=? WHERE razon_social=? AND contacto=?";
            $stmt_actualizar = mysqli_prepare($conn, $sql_actualizar);

            if (!$stmt_actualizar) {
                die('Error en la preparación de la consulta de actualización: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt_actualizar, "ssissiiiiss", $rfc, $email_factura, $tel_oficina, $domicilio, $email_contacto, $tel_contacto, $pago, $plan, $activo, $razon_social, $nombre_contacto);

            if (mysqli_stmt_execute($stmt_actualizar)) {
                header("Location: ../index.php#clientes");
                exit;
            } else {
                echo "Error: " . $sql_actualizar . "<br>" . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt_actualizar);
        }else{
            //Crea un nuevo cliente
            $sql_insertar = "INSERT INTO clientes (razon_social, rfc, email_factura, tel_oficina, contacto, direccion, email_contacto, tel_contacto, id_pago, id_plan, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insertar = mysqli_prepare($conn, $sql_insertar);

            if (!$stmt_insertar) {
                die('Error en la preparación de la consulta de inserción: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt_insertar, "sssisssiiii", $razon_social, $rfc, $email_factura, $tel_oficina, $nombre_contacto, $domicilio, $email_contacto, $tel_contacto, $pago, $plan, $activo);

            if (mysqli_stmt_execute($stmt_insertar)) {
                header("Location: ../index.php#clientes");
                exit;
            } else {
                echo "Error: " . $sql_insertar . "<br>" . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt_insertar);
        }

    }
  
    mysqli_stmt_close($stmt);

}    
?>