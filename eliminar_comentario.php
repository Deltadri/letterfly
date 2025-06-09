<?php
session_start();
include 'config/conexion.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$idOpinion = $_POST['idOpinion'];

$sql = "DELETE FROM Opinion WHERE idOpinion = '$idOpinion'";
if (mysqli_query($conn, $sql)) {
    // Redirigir a la página de libro después de eliminar el comentario
    header("Location: libro.php?id=" . $_POST['idLibro']);
} else {
    echo "Error al eliminar el comentario: " . mysqli_error($conn);
}
