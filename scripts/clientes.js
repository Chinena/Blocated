function showPopup(config) {
  var popup = document.getElementById('popup');
  var popupTitle = document.getElementById('popup-title');
  var popupMessage = document.getElementById('popup-message');

  popupTitle.innerHTML = config.title || 'Mensaje';
  popupMessage.innerHTML = config.content || '';
  popup.style.display = 'flex'; //block?

  var continueButton = document.querySelector('.continue-button');
  var deleteButton = document.querySelector('.delete-button');
  var cancelButton = document.querySelector('.cancel-button');

  continueButton.style.display = config.showContinueButton ? 'block' : 'none';
  deleteButton.style.display = config.showDeleteButton ? 'block' : 'none';
  cancelButton.style.display = config.showCancelButton ? 'block' : 'none';

  deleteButton.onclick = config.onDelete;
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
      title: 'Se actualizará la base de datos',
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
          content: 'No todos los datos están validados. Asegúrese de completar los campos en rojo.',
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
      // Restriccion de contener "@"
      const emailRestriccion = /@/;
      if (!emailRestriccion.test(elemento.value) && elemento.required) {
        showPopup({
          title: 'Error de validación',
          content: 'Verifique que los campos en rojo sean correctos.',
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
    if (elemento.name.includes('tel') && !/^\d+$/.test(elemento.value) && elemento.required) {
      showPopup({
        title: 'Error de validación',
        content: 'Verifique que los campos en rojo sean correctos.',
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

    //10 digitos para el Celular
    const maxCel = 10;
    if (elemento.name.includes('tel') && elemento.required && elemento.value.length !== maxCel) {
      showPopup({
        title: 'Error de validación',
        content: 'Asegurese que la cantidad de digitos del celular sea correcto.',
        showContinueButton: false,
        showCancelButton: true
      });
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

    //13 digitos para RFC
    const maxRFC = 13;
    if (elemento.name.includes('rfc') && elemento.value.length !== maxRFC) {
      showPopup({
        title: 'Error de validación',
        content: 'Asegurese que la cantidad de caracteres del RFC sea correcto.',
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

  $('#formulario').hide();
  $('#cargando').show();

  // Espera 2 segundos antes de enviar el formulario
  setTimeout(function () {
    // Envía el formulario al archivo PHP si todas las validaciones son exitosas
    document.getElementById('agregarCliente').submit();

    // Cierra el popup después de enviar el formulario
    closePopup();
    $('#cargando').hide();
    $('#formulario').show();

    // Recarga la página después de enviar el formulario
    //window.location.reload();
  }, 2000); // 2000 milisegundos = 2 segundos
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

  document.getElementById('respuesta').innerHTML = '';
  actualizarTextoBoton(false);
  $('#boton_eliminar').show();
  $('#boton_eliminar').hide();
});

/////// Eliminar cliente

document.getElementById('boton_eliminar').addEventListener('click', function () {
  showPopup({
    title: 'Confirmar eliminación',
    content: '¿Estás seguro de que deseas eliminar este cliente?',
    showContinueButton: false,
    showDeleteButton: true,
    showCancelButton: true,
    onDelete: function () {
      eliminar_cliente(); // El usuario ha confirmado la eliminación, ejecutar la solicitud AJAX
    }
  });
});

function eliminar_cliente() {
  var parametros = {
    "eliminar": "1",
    "razon_social": $('#razon_social').val(),
    "contacto": $('#contacto').val()
  };

  $('#formulario').hide();
  $('#cargando').show();

  $.ajax({
    data: parametros,
    dataType: 'json',
    url: 'scripts/bd_clientes.php',
    type: 'post',

    beforeSend: function () {
      //$('#respuesta').html("");
      $('#formulario').hide();
      $('#cargando').show();

      setTimeout(function () {
        $('#cargando').hide();
        $('#formulario').show();
      }, 2000);

    },
    error: function () {
      console.log('Ocurrió un error...');
    },
    complete: function () {
      // Mostrar formulario y ocultar spinner después de la llamada AJAX
      $('#cargando').hide();
      $('#formulario').show();
      actualizarTextoBoton(false);
    },
    success: function (respuesta) {
      $('#boton_eliminar').hide();
      if (respuesta.status === "success") {
        // Éxito al eliminar
        showPopup({
          title: 'Cliente eliminado',
          content: 'Se eliminaron los datos en la base de datos',
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

        $("#activeCheckbox").prop("checked", false);
        $("#pago").val("1");
        $("#plan").val("1");

      } else {
        // Error al eliminar
        showPopup({
          title: 'Error al eliminar',
          content: respuesta.message,
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

        $("#activeCheckbox").prop("checked", false);
        $("#pago").val("1");
        $("#plan").val("1");
      }
      console.log(respuesta);
      $("#searchClient").val("");
      $("#ClientWithName").val("");
    }
  });

};


