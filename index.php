<?php

include ('config.php'); // Incluye el archivo de conexión
include ('scripts/inicio.php'); // Incluye el archivo de consulta
//require_once('scripts/funciones.php'); //Para confirmar que no entre a la pagina sin haber iniciado sesion
//verificarInicioSesion(); //funcion

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

  
</head>
<body> 

  <!-- Barra de Navegacion -->
  <div class="navbar-logo header fixed-header">
    <img src="assets/images/logo.png" layout="responsive" width="211.76470588235293" height="60" alt="Logo Ubicuo" class="mobirise-loader" /> 
    <nav>
      <ul>
        <li><a href="#inicio" onclick="mostrarSeccion('inicio')">I N I C I O</a></li>
        <li><a href="clients-sec.php">C L I E N T E S</a></li>
        <li><a href="recargas-sec.php">R E C A R G A S</a></li>
        <li><a href="scripts/cerrar-s.php">CERRAR SESIÓN</a></li>
        
      </ul>
    </nav>
  </div>
    
  <!-- Contenido -->
    <!-- Inicio -->
  <section id="inicio">
    <div class="seccion-inicio">
      <h1>Control de Recargas Diarias</h1>
      <p class ="p-fecha" id="fecha"></p>
      <br>
      
      <div class="titulo-container">
        <h2 style="margin-left: 12%;">Hay <?php echo count($datosCaducidadRecargas); ?> chips que expiran hoy</h2>
        <h2 style="margin-right: 6%;">Previsión de recargas para los siguientes días</h2>
      </div>
      <div>
      <!--<button>Procesar</button>-->
      </div>
    </div>
    
    <div id="divTabla">
    <div class="table-margin-bottom">
      <table style="border-radius: 6px;">
          <thead>
              <tr style="font-weight: 900;">
                <th>Chip</th>
                <th>Fecha de Recarga</th>
                <th>Vencimiento</th>
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
    
    <div id="divTabla2">
      <table>
        <thead>
            <tr style="font-weight: 900;">
              <th>Dia</th>
              <th>Cantidad</th>
              <th>Chips</th>
              <th>Total Cantidad</th>
            </tr>
        </thead>
        <!--<tbody id="tbody2">-->
        <tbody>
            <?php foreach ($datosCaducidadTomorrow as $dato): ?>
              <tr>
                <td><?php echo $dato['FECHA_CADUCADO']; ?></td>
                <td>$ <?php echo $dato['MONTO']; ?></td>
                <td><?php echo $dato['CANTIDAD_CLIENTES']; ?></td>
                <td>$ <?php echo $dato['MONTO_TOTAL']; ?></td>
              </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
  

    
  <!-- Scripts -->
  <script src="scripts\seccion.js"></script>
  <script src="scripts\fecha.js"></script>
 

 

</body>
</html>