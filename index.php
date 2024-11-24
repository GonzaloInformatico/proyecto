<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/Favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
</head>
<body>
    <img class="wave" src="img/wave.png">
    <div class="container">
        <div class="img">
            <img src="img/sitra.png">
        </div>
        <div class="login-content">
            <?php if(isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
            <div class="alert alert-danger" role="alert">
                Usuario o contraseña incorrectos. Por favor, inténtelo de nuevo.
            </div>
            <?php endif; ?>
            <form id="loginForm" method="post" action="controlLogin/controlador_login.php" onsubmit="return validarFormulario()">
                <img src="img/avatar.svg">
                <h2 class="title">BIENVENIDOd</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <input id="usuario" type="text" class="input" name="usuario">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input type="password" id="password" class="input" name="password">
                    </div>
                </div>
                <div class="view">
                    <div class="fas fa-eye verPassword" onclick="togglePassword()" id="verPassword"></div>
                </div>

                <input name="btningresar" class="btn" type="submit" value="INICIAR SESIÓN">
            </form>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/main.js"></script>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var passwordToggle = document.getElementById("verPassword");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordToggle.classList.remove("fa-eye");
                passwordToggle.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                passwordToggle.classList.remove("fa-eye-slash");
                passwordToggle.classList.add("fa-eye");
            }
        }

        function validarFormulario() {
            var usuario = document.getElementById("usuario").value;
            var password = document.getElementById("password").value;

            if (usuario.trim() === "" || password.trim() === "") {
                alert("Por favor, ingrese usuario y contraseña.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
