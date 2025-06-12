<!--
_______________________________________________________________________________
 __       ______  ______  ______  ______   ______   ______  __       __  __    
/\ \     /\  ___\/\__  _\/\__  _\/\  ___\ /\  == \ /\  ___\/\ \     /\ \_\ \   
\ \ \____\ \  __\\/_/\ \/\/_/\ \/\ \  __\ \ \  __< \ \  __\\ \ \____\ \____ \  
 \ \_____\\ \_____\ \ \_\   \ \_\ \ \_____\\ \_\ \_\\ \_\   \ \_____\\/\_____\ 
  \/_____/ \/_____/  \/_/    \/_/  \/_____/ \/_/ /_/ \/_/    \/_____/ \/_____/ 
_______________________________________________________________________________
Desarrollado por Adrián Fernández Ternero
Licenciado bajo: AGPLv3
letterfly.net


https://github.com/Adrifer24/letterfly

-->


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
<html lang="es" data-bs-theme="light"">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Letterfly</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/css/estilos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="icon" type="image/png" href="/img/logo/favicon.png">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
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
        <button id="theme-toggle" class="btn btn-outline-secondary">
          <i class="bi bi-moon"></i>
        </button>
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
        <button id="theme-toggle" class="btn btn-outline-secondary">
          <i class="bi bi-moon"></i>
        </button>
      </ul>
    </div>
    <?php
    }
    ?>
  </div>
</nav>

<!-- El Script del Modo oscuro -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const storageKey = 'bs-theme';
  const btn       = document.getElementById('theme-toggle');

  // lee la preferencia guardada o elige "light" por defecto
  const getTheme = () => localStorage.getItem(storageKey) || 'light';

  // aplica el tema y actualiza el icono
  const setTheme = theme => {
    document.documentElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem(storageKey, theme);
    btn.innerHTML = theme === 'dark'
      ? '<i class="bi bi-moon"></i>'
      : '<i class="bi bi-sun"></i>';
  };

  // tema al cargar la página
  setTheme(getTheme());

  // cambia al hacer clic
  btn.addEventListener('click', () => {
    const nuevoTema = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
    setTheme(nuevoTema);
  });
});
</script>
