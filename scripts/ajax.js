//Esconder el Spinner al cargar el documento
$(document).ready(function () {
    $('#cargando').hide();
});

//Buscar Cliente
function buscar_datos() {
    var razonSocial = $("#searchClient").val();
    var nombreContacto = $("#ClientWithName").val();

    //Para los que están ocultos (para actualizar correctamente)
    $("#razon_social_hidden").val(razonSocial);
    $("#contacto_hidden").val(nombreContacto);
    var razonSocialHidden = document.getElementById("razon_social_hidden").value;
    var contactoHidden = document.getElementById("contacto_hidden").value;
    console.log(razonSocialHidden);
    console.log(contactoHidden);

    var parametros = {
        "buscar": "1",
        "razon_social": razonSocial,
        "contacto": nombreContacto
    };

    $.ajax({
        data: parametros,
        dataType: 'json',
        url: 'scripts/bd_clientes.php',
        type: 'post',

        beforeSend: function () {
            //$('#respuesta').html("");
            $('#formulario').hide();
            $('#cargando').show();
        },
        error: function () {
            console.log('Ocurrió un error...');
        },
        complete: function () {
            // Mostrar formulario y ocultar spinner después de la llamada AJAX
            $('#cargando').hide();
            $('#formulario').show();
        },
        success: function (respuesta) {
            //$('#respuesta').html("");  // Limpiar el contenido anterior
            if (respuesta.existe === "0") {
                // No se encontraron resultados
                showPopup({
                    title: 'Cliente no encontrado',
                    content: 'No existe un cliente con la información proporcionada.',
                    showContinueButton: false,
                    showCancelButton: true
                });

                $("#razon_social").val("");
                $("#razon_social").prop("disabled", false);
                $("#rfc").val("");
                $("#email_factura").val("");
                $("#tel_Oficina").val("");
                $("#domicilio").val("");
                $("#contacto").val("");
                $("#contacto").prop("disabled", false);
                $("#email_contacto").val("");
                $("#tel_Contacto").val("");

                $("#activeCheckbox").prop("checked", activo == 0);
                $("#pago").val("1");
                $("#plan").val("1");
            } else {
                $("#razon_social").val(respuesta[0].razon_social);
                //$("#razon_social").prop("disabled", true); 
                $("#razon_social").prop("disabled", true);

                $("#rfc").val(respuesta[0].rfc);
                $("#email_factura").val(respuesta[0].email_factura);
                $("#tel_Oficina").val(respuesta[0].tel_oficina);
                $("#domicilio").val(respuesta[0].direccion);

                $("#contacto").val(respuesta[0].contacto);
                //$("#contacto").prop("disabled", true);
                $("#contacto").prop("disabled", true);

                $("#email_contacto").val(respuesta[0].email_contacto);
                $("#tel_Contacto").val(respuesta[0].tel_contacto);

                var activo = respuesta[0].activo;
                $("#activeCheckbox").prop("checked", activo == 1);
                $("#pago").val(respuesta[0].id_pago);
                $("#plan").val(respuesta[0].id_plan);

            }
            console.log(respuesta);
            $("#searchClient").val("");
            $("#ClientWithName").val("");
        }
    });
}
/*
document.getElementById('boton_eliminar').addEventListener('click', function () {
    var razonSocialHidden = document.getElementById("razon_social_hidden").value;
    var contactoHidden = document.getElementById("contacto_hidden").value;

    var parametros = {
        "eliminar": "1",
        "razon_social": $('#razon_social').val(),
        "rfc": $('#rfc').val(),
        "email_factura": $('#email_factura').val(),
        "tel_Oficina": $('#tel_Oficina').val(),
        "domicilio": $('#domicilio').val(),
        "contacto": $('#contacto').val(),
        "email_conctanto": $('#email_contacto').val(),
        "tel_Contacto": $('#tel_Contacto').val(),
        "activo": $('#activeCheckbox').is(':checked') ? 1 : 0,  // Valor del checkbox
        "pago": $('#pago').val(),  // Valor del select de Modalidad Pago
        "plan": $('#plan').val(),   // Valor del select de Plan

        "razon_social_hidden": razonSocialHidden,
        "contacto_hidden": contactoHidden
    };


    $.ajax({
        data: parametros,
        dataType: 'json',
        url: 'scripts/bd_clientes.php',
        type: 'post',

        beforeSend: function () {
            //$('#respuesta').html("");
            $('#formulario').hide();
            $('#cargando').show();
        },
        error: function () {
            console.log('Ocurrió un error...');
        },
        complete: function () {
            // Mostrar formulario y ocultar spinner después de la llamada AJAX
            $('#cargando').hide();
            $('#formulario').show();
        },
        success: function (respuesta) {
            if (respuesta.existe === "1") {
                // Éxito al eliminar
                showPopup({
                    title: 'Cliente eliminado',
                    content: 'Se eliminaron los datos en la base de datos',
                    showContinueButton: false,
                    showCancelButton: true
                });

                // Resto del código para limpiar los campos y realizar otras acciones después de eliminar

            } else {
                // Error al eliminar
                showPopup({
                    title: 'Error',
                    content: 'Error al eliminar el cliente: ' + respuesta.error,
                    showContinueButton: false,
                    showCancelButton: true
                });

                // Resto del código para manejar el error

            }
            console.log(respuesta);
            $("#searchClient").val("");
            $("#ClientWithName").val("");
        }
    });

});*/

/*
function guardar_cliente() {
    var parametros = {
        "guardar": "1", 
        "razon_social": $("#razon_social").val(),
        "rfc": $("#rfc").val(),
        "email_factura": $("#email_factura").val(),
        "tel_oficina": $("#tel_Oficina").val(),
        "domicilio": $("#domicilio").val(),
        "contacto": $("#contacto").val(),
        "email_contacto": $("#email_contacto").val(),
        "tel_Contacto": $("#email_Contacto").val(),
        "activo": $("#activeCheckbox").val(),
        "pago": $("#pago").val(),
        "plan": $("#plan").val()
      };

      $.ajax({
        data: parametros,
        dataType: 'json',
        url: 'scripts/bd_clientes.php',
        type: 'post',
    
        beforeSend: function () {
          //$('#respuesta').html("");
            $('#formulario').hide();
            $('#cargando').show();
        },
        error: function () {
            console.log('Ocurrió un error...');
        },
        complete: function(){
            // Mostrar formulario y ocultar spinner después de la llamada AJAX
            $('#cargando').hide();
            $('#formulario').show();
        },
        success: function (respuesta) {
            console.log(respuesta);
        }
      });
}*/