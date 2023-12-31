// Evento de clic para el botón Continuar en el pop-up
$("#popup .continue-button").click(function () {
    closePopup();
});

// Evento de clic para el botón Cancelar en el pop-up
$("#popup .cancel-button").click(function () {
    closePopup();
});

// Función para cerrar el pop-up
function closePopup() {
    document.querySelector('.popup').style.display = 'none';
    document.getElementById('equipo').value = '';

    $("#simNumber").val('');
    $("#active").val('');
    $("#fechaRecarga").val('');
    $("#fechaCaducado").val('');
    $("#numeroChipPlaceholder").val('');
}

// Función para mostrar el pop-up
function showPopup(config) {
    $("#popup-title").text(config.title || 'Mensaje');
    $("#popup-message").text(config.content || '');
    $(".continue-button").toggle(config.showContinueButton);
    $(".cancel-button").toggle(config.showCancelButton);
    $("#popup").show();
}


function mostrarMensajeExitoso(mensaje) {
    showPopup({
        title: 'Recarga exitosa',
        content: mensaje, 
        showContinueButton: true,
        showCancelButton: false
    });
}

function mostrarMensajeError(mensaje) {
    showPopup({
        title: 'Error en Recarga',
        content: mensaje,
        showContinueButton: false,
        showCancelButton: true
    });
}

$(document).ready(function () {
    $(".submit-button").click(function () {
        var equipo = $("#equipo").val();

        $.ajax({
            type: "GET",
            url: "recargas-sec.php",
            data: { equipo: equipo, ajax: 1 },
            dataType: "json",
            success: function (data) {
                if (data !== null) {
                    $("#simNumber").val(data.sim_number);
                    if (parseInt(data.active, 10) === 1) {
                        $("#active").val('SI');
                    } else {
                        $("#active").val('No');
                    }
                    $("#fechaRecarga").val(data.FECHA_RECARGA);
                    $("#fechaCaducado").val(data.FECHA_CADUCADO);
                } else {
                    showPopup({
                        title: 'Equipo no encontrado',
                        content: 'No se encontraron datos para el equipo: ' + equipo,
                        showContinueButton: false,
                        showCancelButton: true
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });
    });

    // Configurar autocompletado en el campo de búsqueda
    $("#equipo").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "GET",
                url: "/scripts/buscar-equipo.php",
                data: { term: request.term },
                dataType: "json",
                success: function(data) {
                    response(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud de autocompletado:", status, error);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            // Llenar los demás campos cuando se selecciona una sugerencia
            llenarCampos(ui.item.value);
        }
    });

    // Nueva función para llenar campos basado en el equipo seleccionado
    function llenarCampos(equipo) {
        $.ajax({
            type: "GET",
            url: "recargas-sec.php",
            data: { equipo: equipo, ajax: 1 },
            dataType: "json",
            success: function(data) {
                if (data !== null) {
                    $("#simNumber").val(data.sim_number);
                    if (parseInt(data.active, 10) === 1) {
                        $("#active").val('SI');
                    } else {
                        $("#active").val('No');
                    }
                    $("#fechaRecarga").val(data.FECHA_RECARGA);
                    $("#fechaCaducado").val(data.FECHA_CADUCADO);
                    $("#numeroChipPlaceholder").val(data.sim_number);

                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });
    }
});



$("#recargarBtn").click(function () {
    // Obtener datos necesarios
    var simNumber = $("#simNumber").val();
    var montoRecarga = $("#monto").val();
    var fechaActual = obtenerFechaActual(); // Asegúrate de tener esta función definida


    // Calcular días adicionales según el monto
    var diasRecarga = calcularDiasRecarga(montoRecarga);

    // Obtener fecha actual y fecha de caducidad
    var fechaCaducidad = sumarDias(fechaActual, diasRecarga);

 

    // Realizar la actualización en la base de datos
    $.ajax({
        type: "POST",
        url: "/scripts/actualizar-recarga.php",
        data: { recargarBtn: true, simNumber: simNumber, monto: montoRecarga, diasRecarga: diasRecarga, fechaActual: fechaActual },
        dataType: "json", // Asegúrate de que jQuery interprete la respuesta como JSON
        success: function (data) {
            if (data && data.success) {
                mostrarMensajeExitoso('Recarga realizada con éxito.');
         
            } else {
                mostrarMensajeError('Hubo un error al realizar la recarga.');

            }
        },        
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
            alert("Error al realizar la recarga. Por favor, intenta de nuevo.");
        }
    });
});


// Función para calcular los días de recarga según el monto
function calcularDiasRecarga(monto) {
    switch (monto) {
        case "10":
            return 7;
        case "20":
            return 10;
        case "30":
            return 15;
        case "50":
            return 30;
        default:
            return 0;
    }
}

// Función para obtener la fecha actual en formato YYYY-MM-DD
function obtenerFechaActual() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    return yyyy + '-' + mm + '-' + dd;
}

// Función para sumar días a una fecha
function sumarDias(fecha, dias) {
    var nuevaFecha = new Date(fecha);
    nuevaFecha.setDate(nuevaFecha.getDate() + dias);
    var dd = String(nuevaFecha.getDate()).padStart(2, '0');
    var mm = String(nuevaFecha.getMonth() + 1).padStart(2, '0');
    var yyyy = nuevaFecha.getFullYear();
    return yyyy + '-' + mm + '-' + dd;
}
