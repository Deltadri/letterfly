<?php

session_set_cookie_params(60 * 60 * 24 * 30); // Supuestamente 1 mes en segundos según Google
session_start();


// Para saber si seta ban y cerrarle la sesión
include 'config/conexion.php';
$consulta = "SELECT idUsuario, rol FROM Usuario WHERE idUsuario = '".$_SESSION['idUsuario']."'";
$resultado = mysqli_query($conn, $consulta);
$fila = mysqli_fetch_assoc($resultado);
$estado = $fila['rol'];  
if ($estado == 'bann') {
  session_unset();
  session_destroy();
  header("Location: /login.php?error=Cuenta suspendida");
}
mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Letterfly</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/estilos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<nav class="navbar navbar-expand-lg bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="/libros.php"><img src="/img/logo/logo.png" alt="" width="130"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <?php
    if (isset($_SESSION['user'])) { ?>
      <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
        <?php
        echo "<a class='nav-link text-dark' href='/usuario.php'>".$_SESSION['user']."</a>";
        ?>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/salir.php">Salir</a>
        </li>
      </ul>
    </div>
    <?php
    }
    else { ?>
      <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-dark" href="/login.php">Iniciar sesión</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/registro.php">Registrarse</a>
        </li>
      </ul>
    </div>
    <?php
    }
    ?>
  </div>
</nav>
