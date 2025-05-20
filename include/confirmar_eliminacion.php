<?php
session_start();
include '../header.php';
include '../config/conexion.php';

if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php?estado=eliminado");
    exit;
}
$idUsuario = $_SESSION['idUsuario'];
$nombreUsuario = $_SESSION['user'];
?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <h3 class="mb-4 text-center">Eliminar cuenta</h3>
            <form action="/include/elimina_usuario.php" method="post">
                <div class="mb-3">
                    <label for="password" class="form-label"><b>Contraseña</b></label>
                    <input type="password" class="form-control" id="password" name="pass_actual" required>
                </div>

                <p class="form-text text-center">Al eliminar tu cuenta, perderás todos tus datos y no podrás recuperarlos.</p>
                <div class="mb-3">
                    <label for="confirmar" class="form-label"><b>Escribe "CONFIRMAR"</b></label>
                    <input type="text" class="form-control" id="confirmar" name="confirmar" required>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger">Eliminar cuenta</button>
                </div>

                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'confirmar') {
                        echo '<div class="alert alert-danger mt-3" role="alert">Por favor, escribe "CONFIRMAR" para eliminar tu cuenta.</div>';
                    } elseif ($_GET['error'] == 'contraseña') {
                        echo '<div class="alert alert-danger mt-3" role="alert">Contraseña incorrecta. Por favor, inténtalo de nuevo.</div>';
                    }
                }
                ?>
            </form>
        </div>
    </div>
</div>
