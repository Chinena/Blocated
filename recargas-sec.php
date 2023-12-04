<?php
include ('config.php'); // Incluye el archivo de conexión
?>

<!DOCTYPE html>
<html>
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

        <?php include('includes/scripts.php'); ?>

    </body>
</html>