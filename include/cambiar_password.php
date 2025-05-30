<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$pass_actual = $_POST['pass_actual'];
$pass_nueva1 = $_POST['pass_nueva1'];
$pass_nueva2 = $_POST['pass_nueva2'];

$idUsuario = $_SESSION['idUsuario'];

// Verificar si la contraseña actual es correcta
$query = "SELECT password FROM Usuario WHERE idUsuario = '$idUsuario'";
$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado) == 1) {

    $linea = mysqli_fetch_assoc($resultado);

    if (password_verify($pass_actual, $linea['password'])) {
        // La contraseña actual es correcta, proceder a cambiarla
        if ($pass_nueva1 == $pass_nueva2) {
            // Verificar si la nueva contraseña es diferente de la actual
            if ($pass_actual != $pass_nueva1) {
                // Actualizar la contraseña en la base de datos

                $hash = password_hash($pass_nueva1, PASSWORD_DEFAULT);
                $query = "UPDATE Usuario SET password = '$hash' WHERE idUsuario = '$idUsuario'";

                mysqli_query($conn, $query);
                header("Location: ../usuario.php?password=cambiada");
            } else {
                header("Location: ../usuario.php?password=igual");
            }
        } 
        else {
            header("Location: ../usuario.php?password=diferente");
        }
    }
    else {
        // La contraseña actual es incorrecta
        header("Location: ../usuario.php?password=incorrecta");
    }
    
    
} else {
    header("Location: ../usuario.php?password=incorrecta");
}
exit;
?>
