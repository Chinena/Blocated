function buscarEquipo() {
    var equipo = document.getElementById('equipo').value;
    console.log("Equipo buscado:", equipo);
    // Realizar una solicitud AJAX a tu servidor PHP para obtener datos
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Procesar la respuesta del servidor
            var data = JSON.parse(xhr.responseText);
            console.log("Datos recibidos:", data);
            
            if (data) {
                document.getElementById('fechaRecarga').value = data.FECHA_RECARGA;
                document.getElementById('fechaCaducado').value = data.FECHA_CADUCADO;
                document.getElementById('simNumber').value = data.sim_number;
                document.getElementById('activo').value = data.active;
            }
        }
    };

    // Enviar la solicitud al servidor PHP
    xhr.open('GET', 'recargas_u.php?equipo=' + encodeURIComponent(equipo), true);
    xhr.send();
}

