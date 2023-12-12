//Esconder el Spinner al cargar el documento
$(document).ready(function () {
    $('#cargando').hide();
});

//Buscar Cliente
/*
function buscar_datos() {
    var razonSocial = $("#searchClient").val();
    //var nombreContacto = $("#ClientWithName").val();

    //Para los que están ocultos (para actualizar correctamente)
    $("#razon_social_hidden").val(razonSocial);
    //$("#contacto_hidden").val(nombreContacto);
    var razonSocialHidden = document.getElementById("razon_social_hidden").value;
    //var contactoHidden = document.getElementById("contacto_hidden").value;
    console.log(razonSocialHidden);
    //console.log(contactoHidden);

    var parametros = {
        "buscar": "1",
        "razon_social": razonSocial,
        //"contacto": nombreContacto
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
                $('#boton_eliminar').show();
                actualizarTextoBoton(true);

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
}*/


// Manipulación con texto de Agregar - Actualizar
var botonAgregar = document.getElementById('button_agregar');
/*window.onload = function() {
    actualizarTextoBoton(false); // Llama a la función para establecer el texto del botón al cargar la página
};*/

// Función para actualizar el texto del botón
function actualizarTextoBoton(text) {
    botonAgregar.innerText = text ? 'Actualizar datos' : 'Agregar Cliente';
}

function buscar_datos() {
    var razonSocial = $("#searchClient").val();
    //var nombreContacto = $("#ClientWithName").val();

    //Para los que están ocultos (para actualizar correctamente)
    $("#razon_social_hidden").val(razonSocial);
    //$("#contacto_hidden").val(nombreContacto);
    var razonSocialHidden = document.getElementById("razon_social_hidden").value;
    //var contactoHidden = document.getElementById("contacto_hidden").value;
    console.log(razonSocialHidden);
    //console.log(contactoHidden);

    var parametros = {
        "buscar": "1",
        "razon_social": razonSocial,
        //"contacto": nombreContacto
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
            $('#respuesta').html("");  // Limpiar el contenido anterior
            //console.log(respuesta);
            $('#boton_eliminar').hide();
            actualizarTextoBoton(false);
            var activo = respuesta.existe === 0 ? 0 : 1;

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
                $('#boton_eliminar').show();
                actualizarTextoBoton(true);

                document.getElementById('mover').style.marginTop = '10px';  //Para el segundo fieldset

                // Obtener los valores del objeto como un array
                var clientes = Object.values(respuesta);

                // Filtrar solo las entradas que contienen datos de clientes (no 'existe')
                var clientesDatos = clientes.filter(function (cliente) {
                    return typeof cliente === 'object';
                });

                // Construir el listado de clientes
                var listadoClientes = '<ul class="clientes cliente-item-centrado">';
                clientesDatos.forEach(function (cliente, index) {
                    var activo = cliente.activo !== undefined ? cliente.activo : 0;
                    listadoClientes += '<li class="cliente-item" data-index="' + index + '">'
                        + '<span class="grosor">Razón Social:</span> ' + cliente.razon_social
                        + '&nbsp;&nbsp;&nbsp;<span class="grosor">Contacto:</span> ' + cliente.contacto
                        + '</li>';
                });
                listadoClientes += '</ul>';

                // Mostrar el listado en el div 'respuesta'
                $('#respuesta').html(listadoClientes);

                // Asignar un evento de clic a las filas de la tabla
                $('.cliente-item').on('click', function () {
                    var index = $(this).data('index');
                    var clienteSeleccionado = clientesDatos[index];

                    // Aquí puedes trabajar con el cliente seleccionado
                    console.log(clienteSeleccionado);

                    // Resto del código para asignar los valores del cliente...
                    $("#razon_social").val(clienteSeleccionado.razon_social);
                    //$("#razon_social").prop("disabled", true); 
                    //$("#razon_social").prop("disabled", true);

                    $("#rfc").val(clienteSeleccionado.rfc);
                    $("#email_factura").val(clienteSeleccionado.email_factura);
                    $("#tel_Oficina").val(clienteSeleccionado.tel_oficina);
                    $("#domicilio").val(clienteSeleccionado.direccion);

                    $("#contacto").val(clienteSeleccionado.contacto);
                    //$("#contacto").prop("disabled", true);
                    //$("#contacto").prop("disabled", true);

                    $("#email_contacto").val(clienteSeleccionado.email_contacto);
                    $("#tel_Contacto").val(clienteSeleccionado.tel_contacto);

                    var activo = clienteSeleccionado.activo;
                    $("#activeCheckbox").prop("checked", activo == 1);
                    $("#pago").val(clienteSeleccionado.id_pago);
                    $("#plan").val(clienteSeleccionado.id_plan);

                    // Ocultar el listado después de seleccionar un cliente
                    $('.cliente-item').parent().hide();

                });

            }
            console.log(respuesta);
            $("#searchClient").val("");
            $("#ClientWithName").val("");
        }
    });
}
