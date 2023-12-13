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
                    $("#active").val(data.active);
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
    
        // Limpia el contenido del campo de búsqueda
        document.getElementById('equipo').value = '';
    }

    // Función para mostrar el pop-up
    function showPopup(config) {
        $("#popup-title").text(config.title || 'Mensaje');
        $("#popup-message").text(config.content || '');
        $(".continue-button").toggle(config.showContinueButton);
        $(".cancel-button").toggle(config.showCancelButton);
        $("#popup").show();
    }

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
                    $("#active").val(data.active);
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
