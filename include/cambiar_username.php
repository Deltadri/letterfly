<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = $_SESSION['idUsuario'];
$nuevonombreUsuario = mysqli_real_escape_string($conn, $_POST['nombreUsuario']);

// Verificar si el nuevo nombre de usuario ya existe
$consulta = "SELECT * FROM Usuario WHERE nombre_usuario = '$nuevonombreUsuario' AND idUsuario != '$idUsuario'";
$resultado = mysqli_query($conn, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    // El nombre de usuario ya existe, redirigir con un mensaje de error
    header("Location: ../usuario.php?username=usado");
    exit;
}

// Verificar si el nuevo nombre de usuario es diferente al actual
if ($nuevonombreUsuario == $_SESSION['user']) {
    // El nombre de usuario es el mismo, redirigir con un mensaje de error
    header("Location: ../usuario.php?username=igual");
    exit;
}

else {
    // Cambiar nombre de usuario
    mysqli_query($conn, "UPDATE Usuario SET nombre_usuario = '$nuevonombreUsuario' WHERE idUsuario = '$idUsuario'");
    $_SESSION['user'] = $nuevonombreUsuario;
    // Redirigir a la página de usuario
    header("Location: ../usuario.php?username=cambiado");
}
exit;
?>