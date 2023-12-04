function showPopup(config) {
  var popup = document.getElementById('popup');
  var popupTitle = document.getElementById('popup-title');
  var popupMessage = document.getElementById('popup-message');

  popupTitle.innerHTML = config.title || 'Mensaje';
  popupMessage.innerHTML = config.content || '';
  popup.style.display = 'flex'; //block?

  var continueButton = document.querySelector('.continue-button');
  var cancelButton = document.querySelector('.cancel-button');
  // Mostrar u ocultar el botón de Continuar y Cancelar según el parámetro
  continueButton.style.display = config.showContinueButton ? 'block' : 'none';
  cancelButton.style.display = config.showCancelButton ? 'block' : 'none';

}

function closePopup() {
  document.querySelector('.popup').style.display = 'none';
}

document.getElementById('button_agregar').addEventListener('click', function (event) {
  // Detener el envío del formulario por defecto
  event.preventDefault();

  // Llamar a la función de validación
  if (validarFormulario()) {
    // Mostrar el popup para indicar que se está agregando un cliente
    showPopup({
      title: 'Agregando un nuevo cliente',
      content: '¿Está seguro de que los datos son correctos?',
      showContinueButton: true,
      showCancelButton: true
    });
  } else {
    // Resaltar los campos con errores al presionar el botón
    resaltarCamposConError();
  }
});

function validarFormulario() {
  // Obtener todos los elementos del formulario
  var elementosFormulario = document.getElementById('agregarCliente').elements;
  var contieneError = false; // Variable para verificar si hay errores

  // Validar que los campos obligatorios no estén vacíos
  for (var i = 0; i < elementosFormulario.length; i++) {
    var elemento = elementosFormulario[i];

    // Verificar si el elemento es un campo de entrada de texto
    if (elemento.type === 'text' || elemento.type === 'textarea') {
      // Verificar si el campo es obligatorio y está vacío
      if (elemento.required && elemento.value.trim() === '') { //if (elemento.required && (elemento.value.trim() === '' || /^\s*$/.test(elemento.value))) {
        //closePopup();
        showPopup({
          title: 'Error de validación',
          content: 'No todos los datos están validados. Asegúrese de completar los campos obligatorios.',
          showContinueButton: false,
          showCancelButton: true
        });
        return false; // Evitar el envío del formulario si la validación falla

      }
    }


    //Respetar mayusculas y minusculas para email
    if (!elemento.name.includes('email')) {
      elemento.value = elemento.value.toUpperCase();
    } else {
      // Restriccion de contener "@ y .com" o "@ y .mx"
      const emailRestriccion = /@.*\.(com|mx)$/;
      if (!emailRestriccion.test(elemento.value)) {
        showPopup({
          title: 'Error de validación',
          content: 'Verifique que su cuenta de correo sea correcto.',
          showContinueButton: false,
          showCancelButton: true
        });

        // Cambiar el estilo del campo con error
        //...
        //elemento.style.border = '2px solid red';
        elemento.classList.add('error-email');

        contieneError = true; // Indicar que hay errores

        setTimeout((function (elemento) {
          return function () {
            // Restaurar el estilo del campo y quitar la clase de animación después del retraso
            elemento.style.border = '';
            elemento.classList.remove('error-email');
            elemento.classList.add('puff');
          }
        })(elemento), 2000);

      } else {
        // Restaurar el estilo del campo si no hay error
        elemento.style.border = '';
        elemento.classList.remove('error-email');
      }
    }

    // Verificar si el campo es un campo de teléfono y si su valor no es numérico
    if (elemento.name.includes('tel') && !/^\d+$/.test(elemento.value)) {
      showPopup({
        title: 'Error de validación',
        content: 'El campo de teléfono debe contener solo números.',
        showContinueButton: false,
        showCancelButton: true
      });
      //return false; // Evitar el envío del formulario si la validación falla
      // Cambiar el estilo del campo con error
      elemento.style.border = '2px solid red';
      elemento.classList.add('error-pulsating');

      contieneError = true; // Indicar que hay errores
      //resaltarCamposConError(); // Llamar a la función para resaltar campos

      // Programar una reversión de estilos después de un breve retraso (por ejemplo, 1 segundo)
      setTimeout((function (elemento) {
        return function () {
          // Restaurar el estilo del campo y quitar la clase de animación después del retraso
          elemento.style.border = '';
          elemento.classList.remove('error-pulsating');
          elemento.classList.add('puff');
        };
      })(elemento), 2000);
    } else {
      // Restaurar el estilo del campo si no hay error
      elemento.style.border = '';
      elemento.classList.remove('error-pulsating');
    }

  }

  // Si hay errores, no enviar el formulario
  if (contieneError) {
    return false;
  }
  // Ocultar el popup antes de enviar el formulario
  closePopup();

  return true;
}

// 
function continueAction() {
  // ESTE ES EL FUNCIONAL
  showPopup({
    title: 'Registro Exitoso',
    content: 'El cliente se ha registrado exitosamente.',
    showContinueButton: false,
    showCancelButton: false,
  });

  // Espera 2 segundos antes de enviar el formulario
  setTimeout(function () {
    // Envía el formulario al archivo PHP si todas las validaciones son exitosas
    document.getElementById('agregarCliente').submit();

    // Cierra el popup después de enviar el formulario
    closePopup();

    // Recarga la página después de enviar el formulario
    //window.location.reload();
  }, 2000); // 2000 milisegundos = 2 segundos
  
  //Pasarlo como AJAX?
  /*
    var razonSocialHidden = document.getElementById("razon_social_hidden").value;
    var contactoHidden = document.getElementById("contacto_hidden").value;

  var parametros = {
    "guardar": "1",
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
      //$('#formulario').hide();
      //$('#cargando').show();
      console.log('Antes de enviar...');
    },
    error: function () {
      console.log('Ocurrió un error...');
    },
    complete: function () {
      // Mostrar formulario y ocultar spinner después de la llamada AJAX
      //$('#cargando').hide();
      //$('#formulario').show();
      setTimeout(function () {
        // Envía el formulario al archivo PHP si todas las validaciones son exitosas
        //document.getElementById('agregarCliente').submit();
    
        // Cierra el popup después de enviar el formulario
        closePopup();
    
        // Recarga la página después de enviar el formulario
        //window.location.reload();
      }, 1000);
    },
    success: function (respuesta) {
      if (respuesta.success) {
        // Éxito, hacer algo si es necesario
        console.log(respuesta.message);
      } else {
        // Error, mostrar mensaje de error
        console.error(respuesta.message);
      }
    }
  });*/

}

// Función para resaltar los campos con errores
function resaltarCamposConError() {
  // Obtener todos los elementos del formulario
  var elementosFormulario = document.getElementById('agregarCliente').elements;

  // Iterar sobre los elementos del formulario
  for (var i = 0; i < elementosFormulario.length; i++) {
    var elemento = elementosFormulario[i];


    // Verificar si el campo es obligatorio y está vacío
    if (elemento.required && elemento.value.trim() === '') {
      // Eliminar la clase de animación existente antes de volver a añadirla
      elemento.classList.remove('error-pulsating');

      // Cambiar el estilo del campo con error y agregar la clase de animación
      elemento.style.border = '2px solid red';
      elemento.classList.add('error-pulsating');

      // Programar una reversión de estilos después de un breve retraso (por ejemplo, 1 segundo)
      setTimeout((function (elemento) {
        return function () {
          // Restaurar el estilo del campo y quitar la clase de animación después del retraso
          elemento.style.border = '';
          elemento.classList.remove('error-pulsating');
          elemento.classList.add('puff');
        };
      })(elemento), 2000);
    }
  }
}

// Agrega un event listener al botón de continuar dentro del popup
document.querySelector('.continue-button').addEventListener('click', continueAction);

document.getElementById('boton_limpiar').addEventListener('click', function () {
  // Obtener todos los elementos del formulario
  var elementosFormulario = document.getElementById('agregarCliente').elements;

  // Iterar sobre los elementos del formulario
  for (var i = 0; i < elementosFormulario.length; i++) {
    var elemento = elementosFormulario[i];

    // Verificar si el elemento es un campo de entrada de texto
    if (elemento.type === 'text' || elemento.type === 'textarea') {
      elemento.value = '';  // Limpiar el valor del campo
      elemento.disabled = false; //Especificamente para razon_social y contacto
    } else if (elemento.type === 'checkbox') {
      elemento.checked = false; // Desmarcar checkboxes
    } else if (elemento.tagName === 'SELECT') {
      elemento.selectedIndex = 0; // Restablecer el valor seleccionado del campo select al valor predeterminado
    }
  }
});

/////// Buscar cliente

/*function buscar() {
  //var razonSocial = document.getElementById("searchClient").value;
  var razonSocial = $("#searchClient").val();
  var nombreContacto = $("#ClientWithName").val();

  var parametros = {
    "razon_social": razonSocial,
    "nombre_contacto": nombreContacto
  };

  $.ajax({
    data: parametros,
    url: 'scripts/ajax.php',
    type: 'POST',

    beforeSend: function () {
      $('#respuesta').html("");
    },
    success: function (respuesta) {
      //console.log("Respuesta del servidor:", respuesta);
      $('#respuesta').html(respuesta);
      if (respuesta.length === 0) {
        // No se encontraron resultados
        showPopup({
          title: 'Cliente no encontrado',
          content: 'No existe un cliente con la información proporcionada.',
          showContinueButton: false,
          showCancelButton: true
        });
      } else {
        // Se encontraron resultados, mostrar la información
        //$('#respuesta').html(respuesta); ESTE ES EL BUENO ***********
        //$("#razon_social").val(cliente[0].razon_social);
        var cliente = respuesta.split('|'); 
        $("#razon_social").val(cliente[2]);
        $("#rfc").val(cliente[4]);
        $("#email_factura").val(cliente[6]);
        $("#tel_Oficina").val(cliente[8]);
        $("#domicilio").val(cliente[10]);
        $("#contacto").val(cliente[12]);
        $("#email_contacto").val(cliente[14]);
        $("#tel_Contacto").val(cliente[16]);

        $("#activeCheckbox").val(cliente[20]);
        $("#pago").val(cliente[22]);
        $("#plan").val(cliente[24]);
        

      }
    }
  });
}*/

/*
//ESTOS SON PARA PRUEBAS ES PARA PRUEBAS
var clientes;

function buscar() {
  //var razonSocial = document.getElementById("searchClient").value;
  var razonSocial = $("#searchClient").val();
  var nombreContacto = $("#ClientWithName").val();

  var parametros = {
    "razon_social": razonSocial,
    "nombre_contacto": nombreContacto
  };

  $.ajax({
    data: parametros,
    //dataType: 'json',
    url: 'scripts/ajax.php',
    type: 'POST',

    beforeSend: function () {
      $('#respuesta').html("");
    },
    success: function (respuesta) {
      //console.log("Respuesta del servidor:", respuesta);
      $('#respuesta').html("");  // Limpiar el contenido anterior

      if (respuesta.length === 0) {
        // No se encontraron resultados
        showPopup({
          title: 'Cliente no encontrado',
          content: 'No existe un cliente con la información proporcionada.',
          showContinueButton: false,
          showCancelButton: true
        });
      } else {
        // Se encontraron resultados, mostrar la lista
        clientes = JSON.parse(respuesta);
        clientes.forEach(function (cliente, index) {
          $('#respuesta').append('<div class="resultado-cliente" data-index="' + index + '">' + cliente.razon_social + ' - ' + cliente.contacto + '</div>');
        });

      }
    }
  });
}

// Esto es para seleccionar un cliente que se encuentren con el mismo nombre y la misma empresa
$(document).on('click', '.resultado-cliente', function () {
  var index = $(this).data('index');
  var clienteSeleccionado = clientes[index];

  // Actualizar los campos de entrada con los valores del cliente seleccionado
  $("#razon_social").val(clienteSeleccionado.razon_social);
  $("#rfc").val(clienteSeleccionado.rfc);

  $("#email_factura").val(clienteSeleccionado.email_factura);
  $("#tel_Oficina").val(clienteSeleccionado.tel_oficina);
  $("#domicilio").val(clienteSeleccionado.direccion);
  $("#contacto").val(clienteSeleccionado.contacto);
  $("#email_contacto").val(clienteSeleccionado.email_contacto);
  $("#tel_Contacto").val(clienteSeleccionado.tel_contacto);

  $("#activeCheckbox").val(clienteSeleccionado.activo);
  $("#pago").val(clienteSeleccionado.id_pago);
  $("#plan").val(clienteSeleccionado.id_plan);


  // Cerrar el contenedor de resultados
  $('#respuesta').html("");
});*/


/*function buscar() {
  //var razonSocial = document.getElementById("searchClient").value;
  var razonSocial = $("#searchClient").val();
  var nombreContacto = $("#ClientWithName").val();

  if (razonSocial.trim() === "") {
    showPopup({
      title: 'Error al buscar',
      content: 'Por favor, ingrese una razón social antes de buscar.',
      showContinueButton: false,
      showCancelButton: true
    });
  }

  var parametros = {
    "razon_social": razonSocial,
    "nombre_contacto": nombreContacto
  };

  $.ajax({
    data: parametros,
    url: 'scripts/ajax.php',
    type: 'POST',

    beforeSend: function () {
      $('#respuesta').html("");
    },
    success: function (respuesta) {
      console.log("Respuesta del servidor:", respuesta);
    var valores = respuesta.split('|');  // Separador usado en PHP

    // Imprimir el tipo y la estructura del objeto en la consola
    console.log(typeof valores);
    console.log(valores);

    // Iterar sobre los valores y mostrarlos en el div #respuesta
    for (var i = 0; i < valores.length; i++) {
        $('#respuesta').append(valores[i] + '<br>');
    }
      /*console.log("Respuesta del servidor:", respuesta);
      $('#respuesta').html(respuesta);
      var valores = respuesta.split('|');  // Separador usado en PHP
      for (var i = 0; i < valores.length; i++) {
        $('#respuesta').append(valores[i] + '<br>');
      }*/
/*try {
  // Intentar parsear la respuesta como JSON
  var clienteInfo = JSON.parse(respuesta);

  // Hacer algo con la información del cliente, por ejemplo, imprimir en la consola
  console.log(clienteInfo);
} catch (error) {
  // Si hay un error al parsear el JSON, imprimir el error en la consola
  console.error('Error al parsear la respuesta como JSON:', error);
}----/
}
});
}*/
/*
function searchClient() {
  var client = encodeURIComponent(document.getElementById('searchClient').value); //var client = document.getElementById('searchClient').value;
  console.log(client);
  window.location.href = 'consulta_cliente.php?searchClient=' + encodeURIComponent(client);
  //Llamar a consulta_cliente.php para mandar client
}*/