<?php

    function controlRecargas($conn){
        $hoy = date('Y-m-d');
        $sql = "Select * from prueba_recargas where FECHA_CADUCADO = '$hoy'";

        //$sql = "Select * from prueba_recargas where monto > 25";
        $result = $conn->query($sql);

        $datos = array();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $datos[] = $row;
            }
        }
        return $datos;
    }

    function controlRecargasTomorrow($conn){
        $hoy = date('Y-m-d');
        //$sql = "Select FECHA_CADUCADO, MONTO from prueba_recargas where FECHA_CADUCADO > '$hoy' order by FECHA_CADUCADO asc";
        /*
        // PREVISION DE RECARGAS
        select FECHA_CADUCADO, MONTO, count(CHIP) as CANTIDAD_CLIENTES, sum(MONTO) as MONTO_TOTAL from prueba_recargas group by FECHA_CADUCADO;
        */
        $sql = "select FECHA_CADUCADO, MONTO, count(CHIP) as CANTIDAD_CLIENTES, sum(MONTO) as MONTO_TOTAL 
                from prueba_recargas 
                where FECHA_CADUCADO > '$hoy'
                group by FECHA_CADUCADO";
        $result = $conn->query($sql);

        $datos = array();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $datos[] = $row;
            }
        }
        return $datos;
    }

    function previsionRecargas($edad) {
        /*$hoy = strtotime(date('Y-m-d')); // Obtiene la fecha actual como un timestamp
        $diasRestantes = floor(($fechaCaducidad - $hoy) / (60 * 60 * 24)); // Calcula los días restantes
    
        if ($diasRestantes > 0 && $diasRestantes <= 7) {
            return 'fecha-2';
        } elseif ($diasRestantes > 7 && $diasRestantes <= 30) {
            return 'fecha-3';
        }*/

        if ($edad < 20) {
            return 'fecha-1';
        } elseif ($edad >= 20 && $edad <= 30) {
            return 'fecha-2';
        } else {
            return 'fecha-3';
        }
    
        //return 'fecha-1'; // Por defecto, el color más alto
    }

?>