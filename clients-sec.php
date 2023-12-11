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
            <img src="assets/images/logo.png" layout="responsive" width="211.76470588235293" height="60" alt="Logo Ubicuo" class="mobirise-loader img-fondo" /> 
            <nav>
                <ul>
                    <li><a href="index.php" >I N I C I O</a></li>
                    <li><a href="clients-sec.php" >C L I E N T E S</a></li>
                    <li><a href="recargas-sec.php" >R E C A R G A S</a></li>
                    <li><a href="scripts/cerrar-s.php" class="logout">CERRAR SESIÓN</a></li>
                </ul>
            </nav>
        </div> 
        
        <div class="seccion-clientes">
            <h1>Sección Clientes</h1> 

            <div class="formulario" id="formulario" style="display: flex; justify-content: space-between;">
            <form>
                <br>
                <fieldset style="display: flex; flex-direction: row; align-items: center; justify-content: center;">
                <legend class="clientes">Buscar cliente por:</legend>
                <div style="margin-top: 6px;">
                    <span class="clientes" style="margin: 4px 10px;">Razon Social: </span>
                    <input type="text" id="searchClient" autocomplete="off" style="text-align: center; width:200px;">
                </div>
                <div style="margin-top: 6px;">
                    <span class="clientes" style="margin: 4px 10px;">Nombre Contacto: </span>
                    <input type="text" id="ClientWithName" autocomplete="off" style="text-align: center; width:200px;">
                </div>
                <div>
                    <button type="button" class="searchButton button clean" onclick="buscar_datos()">Buscar</button>
                </div>

                    <!-- 
                    <span class="clientes">Razon Social: </span>
                    <input type="text" 
                        id="searchClient" 
                        autocomplete="off" 
                        style="float: none; text-align: center; width:200px;">
                    <span class="clientes">Nombre Contacto: </span>
                    <input type="text" 
                        id="ClientWithName" 
                        autocomplete="off" 
                        style="float: none; text-align: center; width:200px;">
                    
                    <button class="searchButton" onclick="buscar_datos()">Buscar</button>-->
                </fieldset>
                <div id="respuesta"></div>
                <br>
            </form>
                
            <fieldset style="padding-bottom: 0;">
                <legend class="clientes">Datos del cliente:</legend> 
                <p class="comentario" style="text-align: right; margin-top: 0;">*Campos obligatorios</p>
                
                <form method="POST" id="agregarCliente" action="scripts/clientes.php"> 
                    
                    <div class="clientes-form">
                        <div>
                        <input type="hidden" id="razon_social_hidden" name="razon_social_hidden">
                        <pre class="clientes">
                            Razon Social:<span class="comentario"> *</span> <br><input type="text" name="razon_social" id="razon_social" autocomplete="off" required /><br>
                            RFC:<span class="comentario"> *</span> <br><input type="text" name="rfc" id="rfc" autocomplete="off" maxlength="13" required  /><br>
                            Email Factura:<span class="comentario"> *</span> <br><input type="text" name="email_factura" id="email_factura" autocomplete="off" required /><br>
                            Telefono Oficina:<span class="comentario"> *</span> <br><input type="text" name="tel_Oficina" id="tel_Oficina" maxlength="10" autocomplete="off" required /><br>
                        </pre>
                        </div>
                        <div>
                        <input type="hidden" id="contacto_hidden" name="contacto_hidden">
                        <pre class="clientes">
                            Domicilio:<span class="comentario"> *</span> <br><input type="text" name="domicilio" id="domicilio" autocomplete="off" required /><br>
                            Nombre Contacto:<span class="comentario"> *</span> <br><input type="text" name="contacto" id="contacto" autocomplete="off" required /><br>
                            Email Contacto:<span class="comentario"> *</span> <br><input type="text" name="email_contacto" id="email_contacto" autocomplete="off" required /><br>
                            Telefono Contacto:<span class="comentario"> *</span> <br><input type="text" name="tel_Contacto" id="tel_Contacto" maxlength="10" autocomplete="off" required /><br><br>
                        </pre>
                        </div>
                        <div id="infoAdicional"> 
                        <pre class="clientes status-clients">
                            Estatus Cliente: <input type="checkbox" value="1" name="activo" id="activeCheckbox" class="custom-checkbox" autocomplete="off" />Activo<br>
                            Modalidad Pago:  <select name="pago" id="pago" autocomplete="off">
                                            <option value="1">Tarjeta de crédito</option>
                                            <option value="2">PayPal</option>
                                            <option value="3">Efectivo</option>
                                            </select><br>
                            Plan:  <select name="plan" id="plan" autocomplete="off">
                            <option value="1">Mensual</option>
                            <option value="2">Si</option>
                            <option value="3">Otro</option>
                            </select> 
                        </pre>   
                        </div>
                    </div>
                </form>
            </fieldset>

            <div class="botones">
                <!--<button type="button" onclick="guardar_cliente()">Agregar Cliente</button>-->
                <button type="button" id="button_agregar" class="button add">Agregar Cliente</button>
                <input type="hidden" name="pagina_clientes" value="../index.php#clientes">
                <button id="boton_limpiar" class="button clean">Limpiar Campos</button>
                <button id="boton_eliminar" class="button delete" style="display:none;">Eliminar Cliente</button>
            </div>

            <div class="popup" id="popup">
                <div class="popup-content">
                    <span class="close-button" onclick="closePopup()">&times;</span>
                    <h1 id="popup-title"></h1>
                    <p id="popup-message"></p>
                    <button class="continue-button">Continuar</button>
                    <button class="delete-button" style="display: none;">Eliminar</button>
                    <button class="cancel-button" onclick="closePopup()">Cancelar</button>
                </div>
            </div>
                </div> <!-- este es el div con id="formulario" -->
                <div id="cargando" class="cargando">
                    <!--<span class="clientes">Cargando...</span>-->
                    <div class="spinner-grow text-info" role="status"></div>
                </div>
                
        </div>       
            <script src="scripts/clientes.js"></script>
            <script src="scripts\ajax.js"></script>
            <script src="scripts\seccion.js"></script>
    </body>
</html>