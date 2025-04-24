<?php
$host = "localhost";
$user = "ltuser";
$pass = "LtAdriylaura2";
$db = "letterfly";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>