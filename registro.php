
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letterfly</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/estilos.css" rel="stylesheet">
</head>
<?php
include ("header.php");
include ("config/conexion.php");
?>

<?php
if (!isset($_SESSION['user'])) {
    
    if (!$_POST) {
        echo "<div class='container mt-5'>";
        echo "<h2 style:>Crear Cuenta</h2>";
        echo "<form action='registro.php' method='POST'>";

        echo "<div class='mb-3'>";
        echo "<label for='user' class='form-label'>Usuario</label>";
        echo "<input type='text' class='form-control' id='user' name='user'>";
        echo "</div>";

        echo "<div class='mb-3'>";
        echo "<label for='email' class='form-label'>Correo</label>";
        echo "<input type='email' class='form-control' id='email' name='email'>";

        echo "</div>";
        

        echo "<div class='mb-3'>";
        echo "<label for='pass' class='form-label'>Contraseña</label>";
        echo "<input type='password' class='form-control' name='pass' id='pass'>";
        echo "</div>";

        echo "<div class='mb-3'>";
        echo "<label for='pass2' class='form-label'>Confirma la contraseña</label>";
        echo "<input type='password' class='form-control' name='pass2' id='pass2'>";
        echo "</div>";

        // Google Recaptcha
        echo "<div class='g-recaptcha' data-sitekey='6LeHSTsrAAAAALeY9dOk9lnyuD13uhyqXYGEkyLt'></div>";
        echo "<br/>";

        echo "<button type='submit' class='btn btn-primary'>Entrar</button>";
        echo "</form>";
        echo "</div>";
    }

    else {
        $user = $_POST['user'];
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $password2 = $_POST['pass2'];

        // Cosas del ReCaptcha (Lo encontré en la pagina de Google Recaptcha)
        include 'config/config.php';
        $secret = $recaptcha_secret;
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        
        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
        $captcha_success = json_decode($verify);

        // Si has completado el catpcha entra aquí
        if ($captcha_success->success) {
            // Comprueba si las 2 contraseñas son la misma
            if ($password == $password2) {
                include 'config/conexion.php';

                // Verifica si el usuario ya existe
                $consulta = "SELECT * FROM Usuario WHERE email='$email'";
                $resultado = mysqli_query($conn,$consulta);
    
                if (mysqli_num_rows($resultado) == 0) {
                    // Si no existe, inserta el nuevo usuario
                    $consulta = "INSERT INTO Usuario (nombre_usuario, email, password, rol) VALUES ('$user', '$email', '$password', 'user')";
                    mysqli_query($conn, $consulta);
                    echo "<br>";
                    echo "<div class='text-center'>";
                    echo "Usuario registrado con éxito.";
                    echo "<br>";
                    echo "<br>";
                    echo "<a href='login.php' class='btn btn-lg hola'>Iniciar sesión</a>";
                    echo "</div>";
                } else {
                    echo "<br>";
                    echo "<div class='text-center'>";
                    echo "El correo ya está registrado.";
                    echo "<br>";
                    echo "<br>";
                    echo "<a href='registro.php' class='btn btn-lg hola'>Reintentar</a>";
                    echo "</div>";
                }
            }

            else {
                echo "<br>";
                echo "<div class='text-center'>";
                echo "Las contraseñas no coinciden.";
                echo "<br>";
                echo "<br>";
                echo "<a href='registro.php' class='btn btn-lg hola'>Reintentar</a>";
                echo "</div>";
            }
        }
        // Si no has completado el captcha pues entra aquí
        else {
            echo "<br>";
            echo "<div class='text-center'>";
            echo "Por favor completa el captcha";
            echo "<br>";
            echo "<br>";
            echo "<a href='registro.php' class='btn btn-lg hola'>Reintentar</a>";
            echo "</div>";
        }
    }
}
?>
