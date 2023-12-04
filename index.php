<?php

include ('config.php'); // Incluye el archivo de conexión
include ('scripts/inicio.php'); // Incluye el archivo de consulta
//require_once('scripts/funciones.php'); //Para confirmar que no entre a la pagina sin haber iniciado sesion
//verificarInicioSesion(); //funcion

// Obtiene los datos de la base de datos
$datosCaducidadRecargas = controlRecargas($conn);
$datosCaducidadTomorrow = controlRecargasTomorrow($conn);

?>
<!DOCTYPE html>
<html >
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
  <link href="assets/styles/inicio.css" rel="stylesheet" />
  <link href="assets/styles/clientes.css" rel="stylesheet" />
  
</head>
<body> 

  <!-- Barra de Navegacion -->
  <div class="navbar-logo header fixed-header" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px;">
    <img src="assets/images/logo.png" layout="responsive" width="211.76470588235293" height="60" alt="Logo Ubicuo" class="mobirise-loader" /> 
    
      <nav style="padding-top: 5px;">
        <ul>
          <li><a href="#inicio" onclick="mostrarSeccion('inicio')">Inicio</a></li>
          <li><a href="#clientes" onclick="mostrarSeccion('clientes')">Clientes</a></li>
          <li><a href="#recargas" onclick="mostrarSeccion('recargas')">Recargas</a></li>
        </ul>
      </nav>
  
  </div>
    
  <!-- Contenido -->
    <!-- Inicio -->
  <section id="inicio">
    <br>
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

    <!-- Clientes -->
  <section id="clientes">
    <br>
    <div class="formulario" id="formulario" style="display: flex; justify-content: space-between;">
      <form>
        <br>
        <fieldset style="display: flex; flex-direction: row; align-items: center; justify-content: center;">
          <legend class="clientes">Buscar cliente por:</legend>
          <div>
            <span class="clientes" style="margin: 4px 10px;">Razon Social: </span>
            <input type="text" id="searchClient" autocomplete="off" style="text-align: center; width:200px;">
          </div>
          <div>
            <span class="clientes" style="margin: 4px 10px;">Nombre Contacto: </span>
            <input type="text" id="ClientWithName" autocomplete="off" style="text-align: center; width:200px;">
          </div>
          <div>
            <button class="searchButton" onclick="buscar_datos()">Buscar</button>
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
          <pre class="clientes">
            Razon Social:<span class="comentario"> *</span> <br><input type="text" name="razon_social" id="razon_social" autocomplete="off" required /><br>
            RFC:<span class="comentario"> *</span> <br><input type="text" name="rfc" id="rfc" autocomplete="off" required  /><br>
            Email Factura:<span class="comentario"> *</span> <br><input type="text" name="email_factura" id="email_factura" autocomplete="off" required /><br>
            Telefono Oficina:<span class="comentario"> *</span> <br><input type="text" name="tel_Oficina" id="tel_Oficina" autocomplete="off" required /><br>
          </pre>
        </div>
        <div>
          <pre class="clientes">
            Domicilio:<span class="comentario"> *</span> <br><input type="text" name="domicilio" id="domicilio" autocomplete="off" required /><br>
            Nombre Contacto:<span class="comentario"> *</span> <br><input type="text" name="contacto" id="contacto" autocomplete="off" required /><br>
            Email Contacto:<span class="comentario"> *</span> <br><input type="text" name="email_contacto" id="email_contacto" autocomplete="off" required /><br>
            Telefono Contacto:<span class="comentario"> *</span> <br><input type="text" name="tel_Contacto" id="tel_Contacto" autocomplete="off" required /><br><br>
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
      <div clas="botones">
      <!--<button type="button" onclick="guardar_cliente()">Agregar Cliente</button>-->
      <button type="button" id="button_agregar">Agregar Cliente</button>
        <input type="hidden" name="pagina_clientes" value="../index.php#clientes">
        <button id="boton_limpiar">Limpiar Campos</button>
        
      </div>

    <div class="popup" id="popup">
    <div class="popup-content">
        <span class="close-button" onclick="closePopup()">&times;</span>
        <h1 id="popup-title"></h1>
        <p id="popup-message"></p>
        <button class="continue-button">Continuar</button>
        <button class="cancel-button" onclick="closePopup()">Cancelar</button>
    </div>
    </div>
    </div> <!-- este es el div con id="formulario" -->
    <div id="cargando" class="cargando">
        <!--<span class="clientes">Cargando...</span>-->
        <div class="spinner-grow text-info" role="status"></div>
    </div>

  </section>

    <!-- Recargas -->
    <section id="recargas">
            <br>
            <h1>Sección Recargas</h1>

            <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="text-over-box">
                <a>Nombre del Equipo</a>
                <input type="text" id="equipo" />
                <button class="submit-button" onclick="buscarEquipo()">Buscar</button>
                </div>
            </div>
            <div class="col-2"></div>
            </div>

            <div class="row">
            <div class="col-3" style="margin-left: 170px;">
                <div class="text-over-box">
                <a>Chip</a>
                <input type="text" id="simNumber" value="" readonly disabled />
                </div>
                <div class="text-over-box">
                <a>Activo</a>
                <input type="text" id="active" value="" readonly disabled />
                </div>
            </div>

            <div class="col-2"></div>
            <div class="col-3">
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
        
        </section>
  <!-- Scripts -->
  <script src="scripts\seccion.js"></script>
  <script src="scripts\fecha.js"></script>
  <!--<script src="scripts\control.js"></script>-->
  <!--<script src="scripts\control-previsto.js"></script>-->
  <script src="scripts/clientes.js"></script>
  <script src="scripts\ajax.js"></script>
  <script src="scripts\recargas.js"></script>

</body>
</html>