<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../config.php');

if(isset($_POST['buscar'])){
    #$razon_social = $_POST['razon_social'];
    #$nombre_contacto = $_POST['nombre_contacto'];
    $razon_social = mysqli_real_escape_string($conn, $_POST['razon_social']);
    $nombre_contacto = mysqli_real_escape_string($conn, $_POST['contacto']);

    $cliente = array();
    $cliente['existe'] = "0";

    $stmt = mysqli_prepare($conn, 'SELECT * FROM clientes WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) = UPPER(?)');

    if (!$stmt) {
        die('Error en la preparación de la consulta.');    # . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ss', $razon_social, $nombre_contacto);

    if (!mysqli_stmt_execute($stmt)) {
        die('Error al ejecutar la consulta.');  # . mysqli_stmt_error($stmt));
    }
    
    $resultados = mysqli_stmt_get_result($stmt);
   
    while ($query = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
        $cliente['existe'] = "1";
        $cliente[] = $query;
    }
    
    sleep(1); //duerme un segundo para mostrar el spinner de Cargando...

    $resultado = json_encode($cliente); 

    echo $resultado;

    mysqli_stmt_close($stmt);

}
########################################
if(isset($_POST['eliminar'])){

    ##$razon_social = mysqli_real_escape_string($conn, $_POST['razon_social']);
    #$rfc = mysqli_real_escape_string($conn, $_POST['rfc']);
    #$email_factura = mysqli_real_escape_string($conn, $_POST['email_factura']);
    #$tel_oficina = mysqli_real_escape_string($conn, $_POST['tel_Oficina']);
    #$domicilio = mysqli_real_escape_string($conn, $_POST['domicilio']);
    ##$nombre_contacto = mysqli_real_escape_string($conn, $_POST['contacto']);
    #$email_contacto = mysqli_real_escape_string($conn, $_POST['email_contacto']);
    #$tel_contacto = mysqli_real_escape_string($conn, $_POST['tel_Contacto']);

    // Campos ocultos
    $razon_social_hidden = isset($_POST['razon_social_hidden']) ? mysqli_real_escape_string($conn, $_POST['razon_social_hidden']) : '';
    $nombre_contacto_hidden = isset($_POST['contacto_hidden']) ? mysqli_real_escape_string($conn, $_POST['contacto_hidden']) : '';
    
    #$pago = mysqli_real_escape_string($conn, $_POST['pago']);
    #$plan = mysqli_real_escape_string($conn, $_POST['plan']);
    
    #$activo = isset($_POST["activo"]) ? 1 : 0; // Checkbox activo

    $existe = "0";

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

        //Consultar si existe para eliminar datos o regresar un error
        if ($existe == "1"){
            //Elimina cliente de la BD con HIDDEN
            $sql_eliminar = "DELETE FROM clientes WHERE razon_social = ? AND contacto = ?";
            $stmt_eliminar = mysqli_prepare($conn, $sql_eliminar);

            if (!$stmt_eliminar) {
                die('Error en la preparación de la consulta de eliminación: ' . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($stmt_eliminar, "ss", $razon_social_hidden, $nombre_contacto_hidden);

            if (mysqli_stmt_execute($stmt_eliminar)) {
                /*
                header("Location: ../index.php#clientes");
                exit;*/
                header('Content-Type: application/json');
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Eliminación exitosa',
                    'clienteEliminado' => array(
                        'razon_social' => $razon_social_hidden,
                        'contacto' => $nombre_contacto_hidden
                    )
                ));
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Error al eliminar el cliente'
                ));
                exit;
            }
            mysqli_stmt_close($stmt_eliminar);

        }else{
            //No hacer nada, devolver un error para mostrar ShowpopUp
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => 'error',
                'message' => 'No existe un cliente con la información proporcionada.'
            ));
            exit;
        }
    }else{  
        //Si los hidden NO CONTIENEN datos
        header('Content-Type: application/json');
            echo json_encode(array(
               'status' => 'error',
                'message' => 'No existe un cliente con la información proporcionada'
            ));
        exit;

        /*
        $stmt = mysqli_prepare($conn, 'SELECT * FROM clientes WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) = UPPER(?)');
        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, 'ss', $razon_social, $nombre_contacto);
        if (!mysqli_stmt_execute($stmt)) {
            die('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
        }

        $resultados = mysqli_stmt_get_result($stmt);
        // Verificar si existe o no en la base de datos
        while ($query = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
            $existe = "1";
        }

        //Consultar si existe para eliminar datos o regresar un error
        if ($existe == "1"){
            //Elimina cliente de la BD con razon_social y nombre_contacto
            $sql_eliminar = "DELETE FROM clientes WHERE razon_social = ? AND contacto = ?";
            $stmt_eliminar = mysqli_prepare($conn, $sql_eliminar);

            if (!$stmt_eliminar) {
                die('Error en la preparación de la consulta de eliminación: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt_eliminar, "ss", $razon_social, $nombre_contacto);

            if (mysqli_stmt_execute($stmt_eliminar)) {
                header("Location: ../index.php#clientes");
                exit;
            } else {
                echo "Error: " . $stmt_eliminar . "<br>" . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt_eliminar);

        } else {
            // No hacer nada, devolver un error para mostrar ShowpopUp
            if (mysqli_stmt_execute($stmt_eliminar)) {
                header("Location: ../index.php#clientes");
                exit;
            } else {
                echo "Error: " . $stmt_eliminar . "<br>" . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt_eliminar);
            
        }*/
    }

}
#########################################
if(isset($_POST['guardar'])){

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

/*

if(isset($_POST['guardar'])){
    $razon_social = $_POST['razon_social'];
    $nombre_contacto = $_POST['nombre_contacto'];
    
    $rfc = $_POST['rfc'];
    $email_factura = $_POST['email_factura'];
    $tel_Oficina = $_POST['tel_Oficina'];
    $domicilio = $_POST['domicilio'];
    $email_contacto = $_POST['email_contacto'];
    $tel_Contacto = $_POST['tel_Contacto'];
    
    $pago = intval($_POST['pago']);
    $plan = intval($_POST['plan']);
    $activo = isset($_POST['activo']) ? 1 : 0; // Checkbox activo

    $existe = "0";
    
    $stmt = mysqli_prepare($conn, 'SELECT * FROM clientes WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) = UPPER(?)');

    if (!$stmt) {
        die('Error en la preparación de la consulta: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ss', $razon_social, $nombre_contacto);

    if (!mysqli_stmt_execute($stmt)) {
        die('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
    }
    
    $resultados = mysqli_stmt_get_result($stmt);
   
    while ($query = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
        $existe = "1";
    }

    //Consultar si es crear un nuevo cliente o actualizar datos
    if ($existe == "1"){
        //Actualizar datos
        $actualizar = "UPDATE clientes SET 
        razon_social = $razon_social,
        rfc = $rfc,
        email_factura = $email_factura,
        tel_oficina = $tel_Oficina,
        contacto = $nombre_contacto,
        direccion = $domicilio,
        email_contacto = $email_contacto,
        id_pago = $pago,
        id_plan = $plan,
        activo = $activo
        
        WHERE UPPER(razon_social) = UPPER(?) AND UPPER(contacto) = UPPER(?)";
        mysqli_query($conn, $actualizar);

    }else{
        //Crear un nuevo cliente
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO clientes (razon_social, rfc, email_factura, tel_oficina, contacto, direccion, email_contacto, tel_contacto, id_pago, id_plan, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Crear la declaración preparada
        $stmt = mysqli_prepare($conn, $sql);

        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssisssiiii", $razon_social, $rfc, $email_factura, $tel_oficina, $contacto, $domicilio, $email_contacto, $tel_contacto, $pago, $plan, $activo);

        // Ejecutar la declaración
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../index.php#clientes");
            $resultado = json_encode($cliente); 

            echo $resultado;
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        // Cerrar la declaración
        mysqli_stmt_close($stmt);

    }
}*/

?>
