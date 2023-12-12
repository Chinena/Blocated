<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="assets/styles/styles.css" rel="stylesheet" />
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- Fuente de letra Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Raleway:wght@500&display=swap" rel="stylesheet">


    <title>Blocated</title>
</head>

<body style="background-color: #f5f5f5;">
    <div class="back-login">
        <video autoplay muted loop id="video-bg">
            <source src="assets\sketches\fondo-login.mp4" type="video/mp4">
        </video>
    </div> 

    <div class="panel-login"> 
        <main class="form-signin w-100 m-auto">
            <form action="./scripts/inicio-s.php" method="POST">
                <br><h1 class="h1-login">Control de Recargas Blocated</h1><br>
                <img src="assets/images/logo blocated.png" width="100" height="100" class="icon-login" alt="logo" draggable="false">

                <div class="user-container">
                <input type="usuario" id="floatingInput" name="usuario" /> 
                <label for="floatingInput">Usuario: </label>
                </div> 

                <div class="user-container">
                <input type="password" id="floatingPassword" name="contraseña" /> 
                <label for="floatingPassword" class="pass">Contraseña: </label>
                <span class="pass-eye">
                    <i class="fas fa-eye" onclick="password()" id="eye-open"></i>
                    <i class="fas fa-eye-slash" onclick="password()" id="eye-closed" style="display: none;"></i>
                </span>
                </div> 
        
            <br><br><br>
            <button class="btn btn-lg btn-primary btn-session" type="submit">Iniciar sesión</button>
        </form>
      </main> 
    </div> 
</body>

    <script>
    function password() {
        const passwordInput = document.getElementById('floatingPassword');
        const eyeOpenIcon = document.getElementById('eye-open');
        const eyeClosedIcon = document.getElementById('eye-closed');

        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        eyeOpenIcon.style.display = type === 'password' ? 'inline' : 'none';
        eyeClosedIcon.style.display = type === 'password' ? 'none' : 'inline';
    }

    function alertSession(config) {
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

    function closeAlertSession() {
        document.querySelector('.popup').style.display = 'none';
    }

    </script>

<!--
<body class="text-center" style="background-color: #f5f5f5;">

    
    <div> 
    <main class="form-signin w-100 m-auto">

      <form action="./scripts/inicio-s.php" method="POST">
        <h1 class="h1-login">Control de Recargas Blocated</h1><br>
        <img src="assets/images/favicon.png" width="50" height="50" alt="">

        <h2 class="h3 mb-3 fw-normal">Inicia sesión</h2>
        <div class="form-floating">
          <label for="floatingInput">Usuario</label>
          <input type="usuario" class="form-control" id="floatingInput" placeholder="xxxxx" name="usuario"> 
        </div> 
        <br> <br>
        <div class="form-group">
    <label for="floatingPassword">Contraseña</label>
    <div class="input-group">
        <input type="password" class="form-control" id="floatingPassword" placeholder="*" name="contraseña">
        <div class="input-group-append">
            <span class="input-group-text">
                <!--<i class="password-toggle-icon fas fa-eye" onclick="togglePassword()"></i> --/
                <i class="fas fa-eye" onclick="password()" id="eye-open"></i>
                <i class="fas fa-eye-slash" onclick="password()" id="eye-closed" style="display: none;"></i>
            </span>
        </div>
    </div>
</div>

        <br> <br>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar sesión</button>
      </form>
    </main>
    </div>

    <script>
    function togglePassword() {
        var passwordInput = document.getElementById("floatingPassword");
        var icon = document.querySelector(".password-toggle-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
    function password() {
    const passwordInput = document.getElementById('floatingPassword');
    const eyeOpenIcon = document.getElementById('eye-open');
    const eyeClosedIcon = document.getElementById('eye-closed');

    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    eyeOpenIcon.style.display = type === 'password' ? 'inline' : 'none';
    eyeClosedIcon.style.display = type === 'password' ? 'none' : 'inline';
  }
    </script>
    

</body> -->
</html>