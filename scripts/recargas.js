$(document).ready(function () {
    $(".submit-button").click(function () {
        // Obtener el nombre del equipo
        var equipo = $("#equipo").val();

        // Realizar una solicitud AJAX al servidor PHP
        $.ajax({
            type: "GET",
            url: "recargas-sec.php",
            data: { equipo: equipo, ajax: 1 },  // Agregando el parámetro ajax
            dataType: "json",
            success: function(data) {
                // Procesar la respuesta del servidor y actualizar los campos
                if (data !== null) {
                    $("#simNumber").val(data.sim_number);
                    $("#active").val(data.active);
                    $("#fechaRecarga").val(data.FECHA_RECARGA);
                    $("#fechaCaducado").val(data.FECHA_CADUCADO);
                } else {
                    // Si no hay datos, puedes mostrar un mensaje o realizar otra acción
                    alert("No se encontraron datos para el equipo: " + equipo);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });
    });
});
