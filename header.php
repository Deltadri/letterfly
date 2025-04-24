<?php

// Para crear la sesion (se guarda 1 dia la cookie)
session_set_cookie_params(86400); // Es 1 dia en segundos
session_start();

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
    <a class="navbar-brand" href="libros.php"><img src="/img/logo/logo.png" alt="" width="130"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <?php
    if (isset($_SESSION['user'])) { ?>
      <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
        <?php
        echo "<a class='nav-link text-dark' href='https://x.com/'".$_SESSION['user'].">".$_SESSION['user']."</a>";
        ?>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="https://www.instagram.com/adri_fer24/?hl=bg">Instagram</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="https://www.facebook.com/profile.php?id=61561413042239">Facebook</a>
        </li>
      </ul>
    </div>
    <?php
    }
    else { ?>
      <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-dark" href="login.php">Iniciar sesión</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="https://www.instagram.com/adri_fer24/?hl=bg">Instagram</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="https://www.facebook.com/profile.php?id=61561413042239">Facebook</a>
        </li>
      </ul>
    </div>
    <?php
    }
    ?>
  </div>
</nav>
