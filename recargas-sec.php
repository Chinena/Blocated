<?php
include ('config.php'); // Incluye el archivo de conexión

session_start();
// Verifica si la variable de sesión 'usuario' está configurada
if (!isset($_SESSION['usuario'])) {
  echo'
  <script>
    alert("Por favor inicia sesión");
    window.location = "login.php";
  </script>';

    session_destroy();
  die();
}
if ($_SESSION['rol'] == 'admin') {
  // El usuario tiene permisos de administrador, puede ver todas las páginas
} elseif ($_SESSION['rol'] == 'operador') {
  // El usuario tiene permisos de operador, puede ver las páginas específicas
  $allowed_pages = array('index.php', 'recargas-sec.php');

  // Verifica si la página actual está permitida
  $current_page = basename($_SERVER['PHP_SELF']);
  if (!in_array($current_page, $allowed_pages)) {
      // Redirige a una página de permisos insuficientes o realiza alguna otra acción
      echo '<script>
        alert("Permisos insuficientes para acceder a esta página");
        window.location = "index.php"; // o cualquier otra página
      </script>';
      exit();
  }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
  
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
        <meta name="description" content="">
        <meta name="amp-script-src" content="">
        
        <title>Blocated</title>
        

        <!-- Fuente de letra Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Raleway:wght@500&display=swap" rel="stylesheet">

        <!-- Apoyo de Bootstrap -->
        <link href="assets/styles/bootstrap.css" rel="stylesheet" />

        <!-- Hoja de estilos -->
        <link href="assets/styles/styles.css" rel="stylesheet" />
        
        <!-- script AJAX -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- Tu script AJAX -->
        <script>
            function buscarEquipo() {
                var nombreEquipo = $('#equipo').val();

                $.ajax({
                    type: 'GET',
                    url: 'buscar_equipo.php', // Ruta a tu script PHP de búsqueda
                    data: { nombreEquipo: nombreEquipo },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            $('#simNumber').val(data.sim_number);
                            $('#active').val(data.active);
                            $('#fechaRecarga').val(data.FECHA_RECARGA);
                            $('#fechaCaducado').val(data.FECHA_CADUCADO);
                        } else {
                            // Manejar el caso en el que no se encuentren resultados
                            alert('Equipo no encontrado.');
                            // Puedes limpiar los campos en caso de que haya algún valor antiguo
                            limpiarCampos();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', status, error);
                    }
                });
            }

            // Función para limpiar los campos en caso de que no se encuentren resultados
            function limpiarCampos() {
                $('#simNumber').val('');
                $('#active').val('');
                $('#fechaRecarga').val('');
                $('#fechaCaducado').val('');
            }
        </script>

    </head>
    <body>
        <!-- Barra de Navegacion -->
        <div class="navbar-logo header fixed-header">
            <img src="assets/images/logo.png" layout="responsive" width="211.76470588235293" height="60" alt="Logo Ubicuo" class="mobirise-loader" /> 
            <nav>
                <ul>
                    <li><a href="index.php" >I N I C I O</a></li>
                    <li><a href="clients-sec.php" >C L I E N T E S</a></li>
                    <li><a href="recargas-sec.php" >R E C A R G A S</a></li>
                    <li><a href="scripts/cerrar-s.php">CERRAR SESIÓN</a></li>
                </ul>
            </nav>
        </div>

        <div class="seccion-recargas">
            <h1>Sección Recargas</h1> 

            <div class="contenido-recargas">
                <div class="buscador">
                    <div class="text-over-box">
                        <a>Nombre del Equipo</a>
                        <div class="input-group">
                            <input type="text" id="equipo" />
                            <button class="submit-button" onclick="buscarEquipo()">Buscar</button>
                        </div>
                    </div>
                </div>

                <div class="info-recargas">
                    <div class="text-over-box">
                        <a>Chip</a>
                        <input type="text" id="simNumber" value="" readonly disabled />
                    </div>
                    <div class="text-over-box">
                        <a>Activo</a>
                        <input type="text" id="active" value="" readonly disabled />
                    </div>
                </div>

                <div class="info-recargas">
                    <div class="text-over-box">
                        <a>Fecha de Recarga</a>
                        <input type="date" id="fechaRecarga" value="" style="color: grey; text-align: center;" readonly disabled />
                    </div>
                    <div class="text-over-box">
                        <a>Fecha de Caducidad</a>
                        <input type="date" id="fechaCaducado" value="" style="color: grey; text-align: center;" readonly disabled />
                    </div>
                </div>
            </div>        
        </div>

    </body>
</html>