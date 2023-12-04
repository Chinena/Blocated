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

    <title>Blocated</title>
</head>

<body class="text-center" style="background-color: #f5f5f5;">
    <div class="panel-login"> 
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
                <i class="password-toggle-icon fas fa-eye" onclick="togglePassword()"></i>
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
</script>

</body>
</html>