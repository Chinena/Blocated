<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../config.php');

if(isset($_POST['buscar'])){
    #$razon_social = $_POST['razon_social'];
    #$nombre_contacto = $_POST['nombre_contacto'];
    $razon_social = mysqli_real_escape_string($conn, $_POST['razon_social']);
    $nombre_contacto = mysqli_real_escape_string($conn, $_POST['nombre_contacto']);

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
