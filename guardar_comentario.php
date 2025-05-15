<?php
session_start();
include 'config/conexion.php';
include 'header.php';
$idLibro = $_POST['idLibro'];
$puntuacion = $_POST['puntuacion'];
$comentario = $_POST['comentario'];
$idUsuario = $_SESSION['idUsuario'];

// Elimina opinión anterior si la hay
$sql_borrar = "DELETE FROM Opinion WHERE idUsuario = $idUsuario AND idLibro = $idLibro";
mysqli_query($conn, $sql_borrar);

// Y guardar el comentario nuevo
$sql = "INSERT INTO Opinion (idUsuario, idLibro, puntuacion, comentario, fecha) VALUES ($idUsuario, $idLibro, $puntuacion, '$comentario', NOW())";
mysqli_query($conn, $sql);

header("Location: libro.php?id=" . $idLibro);
exit();