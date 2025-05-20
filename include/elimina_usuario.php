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
            <?php
            $pass = $_POST['pass_actual'];
            $confirmar = $_POST['confirmar'];
            $query = "SELECT * FROM Usuario WHERE idUsuario = '$idUsuario'";
            $resultado = mysqli_query($conn, $query);
            $usuario = mysqli_fetch_assoc($resultado);
            if ($pass === $usuario['password']) {
                if ($confirmar === "CONFIRMAR") {
                    $query = "DELETE FROM Usuario WHERE idUsuario = '$idUsuario'";
                    mysqli_query($conn, $query);
                    header("Location: errores/cuenta_eliminada.php");
                    exit;
                } else {
                    header("Location: confirmar_eliminacion.php?error=confirmar");
                }
            } else {
                header("Location: confirmar_eliminacion.php?error=contraseña");
                exit;
            }
            ?>
        </div>
    </div>
</div>