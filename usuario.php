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

include 'header.php';
include 'config/conexion.php';

if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = $_SESSION['idUsuario'];
$nombreUsuario = $_SESSION['user'];

$query = "SELECT nombre_usuario FROM Usuario WHERE idUsuario = '$idUsuario'";
$resultado = mysqli_query($conn, $query);
$usuario = mysqli_fetch_assoc($resultado);
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <h3 class="mb-4 text-center">Tu Usuario</h3>
            <form action="/include/cambiar_username.php" method="post">
                <div class="mb-3">
                    <label for="nombreUsuario" class="form-label"><b>Nombre de usuario</b></label>
                    <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" value="<?php echo htmlspecialchars($nombreUsuario); ?>" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Cambiar nombre de usuario</button>
                </div>
            </form>
            <?php

            // Si esta todo perfecto
            if (isset($_GET['username']) && $_GET['username'] == 'cambiado') {
                echo "<div class='alert alert-success mt-3'>Nombre de usuario cambiado con éxito.</div>";
            }
            
            // Si el nombre de usuario literalmente no cambia
            elseif (isset($_GET['username']) && $_GET['username'] == 'igual') {
                echo "<div class='alert alert-danger mt-3'>El nuevo nombre de usuario es el mismo que el actual.</div>";
            }
            // Si el nombre de usuario ya existe
            elseif (isset($_GET['username']) && $_GET['username'] == 'usado') {
                echo "<div class='alert alert-danger mt-3'>Ese nombre de usuario ya está en uso. Vas a tener que ser mas creativo ;)</div>";
            }
            ?>
            <h3 class="mt-4 mb-4 text-center">Cambiar contraseña</h3>
            <form action="/include/cambiar_password.php" method="post">
                <div class="mb-3">
                    <label for="password" class="form-label"><b>Contraseña Actual</b></label>
                    <input type="password" class="form-control" id="password" name="pass_actual" required>

                    <label for="password" class="form-label"><b>Nueva contraseña</b></label>
                    <input type="password" class="form-control" id="password" name="pass_nueva1" required>
                    <p class="form-text">Máximo 254 Caracteres.</p>

                    <label for="password" class="form-label"><b>Nueva contraseña otra vez</b></label>
                    <input type="password" class="form-control" id="password" name="pass_nueva2" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                </div>
                </form>
            <?php
            // Si esta todo perfecto
            if (isset($_GET['password']) && $_GET['password'] == 'cambiada') {
                echo "<div class='alert alert-success mt-3'>Contraseña cambiada con éxito.</div>";
            }
            // Si la contraseña actual no es correcta
            elseif (isset($_GET['password']) && $_GET['password'] == 'incorrecta') {
                echo "<div class='alert alert-danger mt-3'>La contraseña actual es incorrecta.</div>";
            }
            // Si la nueva contraseña es igual a la actual
            elseif (isset($_GET['password']) && $_GET['password'] == 'igual') {
                echo "<div class='alert alert-danger mt-3'>La nueva contraseña no puede ser igual a la actual.</div>";
            }
            // Si las nuevas contraseñas no coinciden
            elseif (isset($_GET['password']) && $_GET['password'] == 'diferente') {
                echo "<div class='alert alert-danger mt-3'>Las nuevas contraseñas no coinciden.</div>";
            }
            ?>

            <h3 class="mt-4 mb-2 text-center">Eliminar cuenta</h3>
            <p class="text-center">Si decides eliminar tu cuenta, ten en cuenta que no podrás recuperarla.</p>
            <form action="/include/confirmar_eliminacion.php" method="post">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger">Eliminar cuenta</button>
                </div>
        </div>
    </div>
</div>

