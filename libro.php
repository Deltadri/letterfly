<?php
session_start();
include 'header.php';
include 'config/conexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-5'><h3>Libro no encontrado</h3></div>";
    exit();
}

$idLibro = mysqli_real_escape_string($conn, $_GET['id']);

$consulta = "SELECT l.*, 
                 g.nombre AS nombreGenero, 
                 a.nombre AS nombreAutor
          FROM Libro l, Genero g, Autor a
          WHERE l.idLibro = '$idLibro'
            AND l.genero = g.idGenero
            AND l.autor = a.idAutor";

$resultado = mysqli_query($conn, $consulta);

if (mysqli_num_rows($resultado) === 0) {
    echo "<div class='container mt-5'><h3>Libro no encontrado</h3></div>";
    exit();
}

$libro = mysqli_fetch_assoc($resultado);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 text-center">
            <img src="img/libros/<?php echo htmlspecialchars($libro['portada']); ?>" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover;" alt="Portada del libro">
        </div>
        <div class="col-md-8">
            <h2><?php echo htmlspecialchars($libro['titulo']); ?></h2>
            <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['nombreAutor']); ?></p>
            <p><strong>Género:</strong> <?php echo htmlspecialchars($libro['nombreGenero']); ?></p>
            <p><strong>Páginas:</strong> <?php echo htmlspecialchars($libro['paginas']); ?></p>
            <p><strong>Publicado:</strong> <?php echo htmlspecialchars($libro['fpublicacion']); ?></p>
            <hr>
            <p><?php echo nl2br(htmlspecialchars($libro['descripcion'])); ?></p>
            <a href="libros.php" class="btn btn-secondary mt-3">← Volver al catálogo</a>
        </div>
    </div>
</div>

<?php mysqli_close($conn); ?>
