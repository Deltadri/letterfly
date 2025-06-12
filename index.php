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
session_start();
if (isset($_SESSION['user'])) {
    header("Location: libros.php");
    exit();
}
include ("header.php");
?>
<body class="inicio">
<?php
  echo "<div class='container mt-5'>";
  echo "<h1>Bienvendio/a a Letterfly</h1>";
  echo "<p>Tu rincón para compartir lo que lees</p>";
  echo "<a href='login.php' class='btn btn-lg hola ms-2 mt-2'>Iniciar sesión</a>";
  echo "<a href='registro.php' class='btn btn-dark btn-lg text-white ms-2 mt-2'>Regístrate</a>";
  echo "<a href='libros.php' class='btn btn-secondary btn-lg ms-2 mt-2'>Entrar Sin Cuenta</a>";
  echo "</div>";
  
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>