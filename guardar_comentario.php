<?php
session_start();
include 'config/conexion.php';

$idLibro = $_POST['idLibro'];
$puntuacion = $_POST['puntuacion'];
$comentario = $_POST['comentario'];
$idUsuario = $_SESSION['idUsuario'];

$sql = "DELETE FROM Opinion WHERE idUsuario = $idUsuario AND idLibro = $idLibro";
mysqli_query($conn, $sql);

$sql = "INSERT INTO Opinion (idUsuario, idLibro, puntuacion, comentario, fecha) VALUES ($idUsuario, $idLibro, $puntuacion, '$comentario', NOW())";
if (!mysqli_query($conn, $sql)) {
    die("ERROR AL INSERTAR: " . mysqli_error($conn));
}

header("Location: libro.php?id=" . $idLibro);
exit();

/*
<?php
session_start();
include 'config/conexion.php';

if (!isset($_SESSION['idUsuario'])) {
    die("Error: Usuario no autenticado.");
}

$idLibro = intval($_POST['idLibro']);
$puntuacion = intval($_POST['puntuacion']);
$comentario = mysqli_real_escape_string($conn, $_POST['comentario']);
$idUsuario = intval($_SESSION['idUsuario']);

// Eliminar la opinión anterior (no da error si no existe)
$sql_borrar = "DELETE FROM Opinion WHERE idUsuario = $idUsuario AND idLibro = $idLibro";
mysqli_query($conn, $sql_borrar); // aunque no exista, no pasa nada

// Insertar nueva opinión
$sql_insert = "INSERT INTO Opinion (idUsuario, idLibro, puntuacion, comentario, fecha)
               VALUES ($idUsuario, $idLibro, $puntuacion, '$comentario', NOW())";

if (!mysqli_query($conn, $sql_insert)) {
    die("Error al guardar el comentario: " . mysqli_error($conn));
}

header("Location: libro.php?id=$idLibro");
exit();
