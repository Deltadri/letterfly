<?php
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
    include 'config/conexion.php';

    $consulta = "SELECT idUsuario, nombre_usuario, email, password, rol FROM Usuario WHERE email='$email'";

    $resultado = mysqli_query($conn,$consulta);

    //echo mysqli_num_rows($resultado);
      
    if (mysqli_num_rows($resultado) == 1) {
      $datos = mysqli_fetch_assoc($resultado);

      if (password_verify($password, $datos['password'])) {
        if ($datos['rol'] == 'bann') {
          echo "<br><div class='text-center'>
                  <img src='img/dibujitos/no2.png' width='200'><br>
                  <h3>Tu cuenta ha sido suspendida</h3><br><br>
                  <a href='login.php' class='btn btn-lg hola'>Reintentar</a>
                  </div>";
          exit;
        }

        $_SESSION['idUsuario'] = $datos['idUsuario'];
        $_SESSION['email'] = $datos['email'];
        $_SESSION['user'] = $datos['nombre_usuario'];
        $_SESSION['rol'] = $datos['rol'];

        header("Location: libros.php");
        exit;
      }

      else {
        echo "<div class='text-center'>
                <img src='img/dibujitos/no2.png' width='200'><br>
                <h3>Usuario o contraseña incorrectos</h3><br><br>
                <a href='login.php' class='btn btn-lg hola'>Reintentar</a>
              </div>";
      }
    }

    else {
        echo "<div class='text-center'>
                <img src='img/dibujitos/no2.png' width='200'><br>
                <h3>Usuario o contraseña incorrectos</h3><br><br>
                <a href='login.php' class='btn btn-lg hola'>Reintentar</a>
              </div>";
      }
  }
  
}
else {
  header("Location: libros.php");
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>