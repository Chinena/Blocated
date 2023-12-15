<?php

include ('config.php'); // Incluye el archivo de conexión
include ('scripts/inicio.php'); // Incluye el archivo de consulta


// Obtiene los datos de la base de datos
$datosCaducidadRecargas = controlRecargas($conn);
$datosCaducidadTomorrow = controlRecargasTomorrow($conn);

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
  
  <!-- Utilizar AJAX de forma Online -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Fuente de letra Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Raleway:wght@500&display=swap" rel="stylesheet">

  <!-- Apoyo de Bootstrap -->
  <link href="assets/styles/bootstrap.css" rel="stylesheet" />

  <!-- Hoja de estilos -->
  <link href="assets/styles/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  
</head>
<body> 

  <!-- Barra de Navegacion -->
  <div class="navbar-logo header fixed-header">
    <img src="assets/images/ubicuologo.png" layout="responsive" width="180" height="45" alt="Logo Ubicuo" class="mobirise-loader img-fondo" /> 
    <nav>
        <ul>
            <li><a href="index.php">I N I C I O</a></li>
            <li><a href="clients-sec.php">C L I E N T E S</a></li>
            <li><a href="recargas-sec.php">R E C A R G A S</a></li>
            <li><a href="scripts/cerrar-s.php" class="logout"><i class="fas fa-sign-out-alt" style="color: red;"></i></a></li>
        </ul>
    </nav>
</div>

    <!-- Inicio -->
  <section id="inicio">
    <div>
      <p class ="p-fecha" id="fecha"></p>
      <div class="titulo-container">
        <div class="column">
        <h2 style="margin-top:10px; margin-left: 25%; font-weight: 600;">Hay <span class="grosor" style="color: red; font-family: 'Raleway', sans-serif;"><?php echo count($datosCaducidadRecargas); ?></span> chips que expiran hoy</h2>
        <!--<h2 style="margin-right: 8%;">Previsión de recargas para los siguientes días</h2>-->

        <div id="divTabla">
          <div class="table-margin-bottom">
            <table id="dataTable" style="border-radius: 3px;">
                <thead>
                    <tr class="grosor">
                      <th>Chip</th>
                      <th>Fecha de Recarga</th>
                      <th>Fecha de Vencimiento</th>
                      <th>Monto</th>
                    </tr>
                </thead>
                <!--<tbody id="tbody">-->
                <tbody>
                  <?php foreach ($datosCaducidadRecargas as $dato): ?>
                    <tr>
                      <td><?php echo $dato['CHIP']; ?></td>
                      <td><?php echo $dato['FECHA_RECARGA']; ?></td>
                      <td><?php echo $dato['FECHA_CADUCADO']; ?></td>
                      <td>$ <?php echo $dato['MONTO']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
          </div>
        </div>

        </div>
        <div class="export-container small">
          <h2>Recarga Masiva</h2>
          <button id="btn-export" type="button" class="button export">Exportar CSV</button>
        </div>

        <div class="column2" style="float: rigth;">
          <!--<h2 style="text-align: center;">Grafica</h2>-->
          <h2 style="margin-right: 08%;">Previsión de recargas para los siguientes días</h2>
          <div id="divTabla2">
          <div class="table-margin-bottom">
            <table>
              <thead>
                  <tr class="grosor">
                    <th>Fecha de Vencimiento</th>
                    <th>Chips $10</th>
                    <th>Monto Total</th>
                    <th>Chips $50</th>
                    <th>Monto Total</th>
                  </tr>
              </thead>
              <!--<tbody id="tbody2">-->
              <tbody>
                  <?php foreach ($datosCaducidadTomorrow as $dato): ?>
                    <tr>
                      <td><?php echo $dato['FECHA_CADUCADO']; ?></td>
                      <td><?php echo $dato['CANTIDAD_CLIENTES_10']; ?></td>
                      <td>$ <?php echo $dato['MONTO_TOTAL_10']; ?></td>
                      <td><?php echo $dato['CANTIDAD_CLIENTES_50']; ?></td>
                      <td>$ <?php echo $dato['MONTO_TOTAL_50']; ?></td>
                    </tr>
                  <?php endforeach; ?>
              </tbody>
            </table>

            <!-- Contenedor para el mensaje -->
            <div id="mensaje-container" style="float: right; clear: both; margin-top: 20px;">
              <p id="mensaje" style="margin-left:100px"></p>
              <script>
                // Función para calcular la sumatoria de montos
                function calcularSumatoria() {
                  // Obtener todas las celdas de monto en la tabla
                  var celdasMontos = document.querySelectorAll('#divTabla2 table tbody tr td:nth-child(3), #divTabla2 table tbody tr td:nth-child(5)');

                  // Inicializar la sumatoria
                  var sumatoria = 0;

                  // Iterar sobre las celdas y sumar los montos
                  celdasMontos.forEach(function (celda) {
                    // Obtener el contenido de la celda y convertirlo a número
                    var monto = parseFloat(celda.textContent.replace('$', '').trim());

                    // Verificar si es un número válido y agregarlo a la sumatoria
                    if (!isNaN(monto)) {
                      sumatoria += monto;
                    }
                  });

                  return sumatoria;
                }

                // Obtener la sumatoria
                var sumatoriaMontos = calcularSumatoria();

                // Mostrar el mensaje con la sumatoria
                var mensaje = "Se prevé tener al menos $" + sumatoriaMontos + " para recargar esta semana";
                document.getElementById('mensaje').innerText = mensaje;
              </script>
            </div>

          </div>
          </div>
        </div>
      </div>
    </div>

    <!--
    <div id="divTabla">
    <div class="table-margin-bottom">
      <table style="border-radius: 6px;">
          <thead>
              <tr style="font-weight: 900;">
                <th>Chip</th>
                <th>Fecha de Recarga</th>
                <th>Fecha de Vencimiento</th>
                <th>Monto</th>
              </tr>
          </thead>
          <!--<tbody id="tbody">--/
          <tbody>
            <?php foreach ($datosCaducidadRecargas as $dato): ?>
              <tr>
                <td><?php echo $dato['CHIP']; ?></td>
                <td><?php echo $dato['FECHA_RECARGA']; ?></td>
                <td><?php echo $dato['FECHA_CADUCADO']; ?></td>
                <td>$ <?php echo $dato['MONTO']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
      </table>
    </div>
    </div>
    
    <!--<div id="divTabla2">
    <div class="table-margin-bottom">
      <table>
        <thead>
            <tr style="font-weight: 900;">
              <th>Fecha de Vencimiento</th>
              <th>Chips $10</th>
              <th>Monto Total</th>
              <th>Chips $50</th>
              <th>Monto Total</th>
            </tr>
        </thead>
        <!--<tbody id="tbody2">--/
        <tbody>
            <?php foreach ($datosCaducidadTomorrow as $dato): ?>
              <tr>
                <td><?php echo $dato['FECHA_CADUCADO']; ?></td>
                <td><?php echo $dato['CANTIDAD_CLIENTES_10']; ?></td>
                <td>$ <?php echo $dato['MONTO_TOTAL_10']; ?></td>
                <td><?php echo $dato['CANTIDAD_CLIENTES_50']; ?></td>
                <td>$ <?php echo $dato['MONTO_TOTAL_50']; ?></td>
              </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    </div>-->
    <div id="cargando" class="cargando">
      <div class="spinner-grow text-info" role="status"></div>
    </div>

  
  </section>
  

    
  <!-- Scripts -->
  <script src="scripts\seccion.js"></script>
  <script src="scripts\fecha.js"></script>
  <script src="scripts\procesar-csv.js"></script> 
  <script>
    const dataTable = document.getElementById('dataTable');

    //new TableCSVExporter(dataTable);
    //console.log(new TableCSVExporter(dataTable, false).convertToCSV());
    const btnExportToCsv = document.getElementById('btn-export');

    btnExportToCsv.addEventListener("click", () => {
      const exporter = new TableCSVExporter(dataTable, false); //se añade ', false' en los parametros si no quieres encabezados
      const csvOutput = exporter.convertToCSV();
      const csvBlob = new Blob([csvOutput], {type: "text/csv"});

      const blobUrl = URL.createObjectURL(csvBlob);
      //console.log(blobUrl);

      const currentDate = new Date().toISOString().split('T')[0];
      const fileName = `Recarga-Masiva ${currentDate}.csv`
      const anchorElement = document.createElement("a");

      anchorElement.href = blobUrl;
      anchorElement.download = fileName;
      anchorElement.click();

      setTimeout(() => {
        URL.revokeObjectURL(blobUrl);
      }, 500);
    
    })
  </script> 

</body>
</html>