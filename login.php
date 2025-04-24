<?php
//session_start(); // Siempre al principio del archivo
include ("header.php");

if (!isset($_SESSION['user'])) {
  if (!$_POST) {
    echo "<div class='container mt-5'>";
    echo "<h2>Iniciar sesión</h2>";
    echo "<form action='login.php' method='POST'>";
    echo "<div class='mb-3'>";
    echo "<label for='email' class='form-label'>Correo</label>";
    echo "<input type='email' class='form-control' id='email' name='email'>";
    echo "</div>";
    echo "<div class='mb-3'>";
    echo "<label for='pass' class='form-label'>Contraseña</label>";
    echo "<input type='password' class='form-control' name='pass' id='pass'>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Entrar</button>";
    echo "</form>";
    echo "</div>";
  }
  else {
      $email = $_POST["email"];
      $password = $_POST["pass"];
      // chequea si es correcto o que
      $base = mysqli_connect("localhost","ltuser","LtAdriylaura2","letterfly");

      $consulta = "SELECT nombre_usuario, email, password, rol FROM Usuario WHERE email='$email' AND password='$password'";
      $resultado = mysqli_query($base,$consulta);

      //echo mysqli_num_rows($resultado);
      if (mysqli_num_rows($resultado) == 1) {
        $datos = mysqli_fetch_assoc($resultado);

        // Comprobamos si esta baneado o no
        if ($datos['rol'] == 'bann') {
          echo "<br>";
          echo "<div class='text-center'>";
          echo "<img src='img/dibujitos/no2.png' alt='Baneado.png' width='200'>";
          echo "<br>";
          echo "<h3>Tu Cuenta ha sido suspendida</h3>";
          echo "<br>";
          echo "<br>";
          echo "<a href='login.php' class='btn btn-lg hola'>Reintentar</a>";
          echo "</div>";
          exit;
        }
        // Si no esta ban pues inicia sesion todo normal
        else {
          $_SESSION['email'] = $datos['email'];
          $_SESSION['user'] = $datos['nombre_usuario'];
          $_SESSION['rol'] = $datos['rol'];
        }

        header("Location: login.php");
      } else {
        echo "<br>";
        echo "<div class='text-center'>";
        echo "Email o contraseña incorrectos.";
        echo "<br>";
        echo "<br>";
        echo "<a href='login.php' class='btn btn-lg hola'>Reintentar</a>";
        echo "</div>";
      }
    
  }
  
}
else {
  echo "Sesion iniciada como".$_SESSION['user'];
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>