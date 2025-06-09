<head>
    <link rel="stylesheet" href="css/libro.css">

    <style>
.valoracion-media {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.puntuacion-comentario.justify-content-center {
    font-size: 1.5rem;
}

.estrella {
    width: 32px;
    height: 32px;
}

.estrella.vacia {
    opacity: 0.2;
}
</style>

</head>

<?php
session_start();
include 'header.php';
include 'config/conexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-5'><h3>Libro no encontrado</h3></div>";
    exit();
}

$idLibro = mysqli_real_escape_string($conn, $_GET['id']);

// Obtener el libro y el autor
$consulta = "SELECT l.*, a.nombre AS nombreAutor
             FROM Libro l, Autor a
             WHERE l.idLibro = '$idLibro'
               AND l.autor = a.idAutor";

$resultado = mysqli_query($conn, $consulta);

if (mysqli_num_rows($resultado) === 0) {
    echo "<div class='container mt-5'><h3>Libro no encontrado</h3></div>";
    exit();
}

$libro = mysqli_fetch_assoc($resultado);

// Obtener géneros del libro
$consultaGeneros = "SELECT g.nombre 
                    FROM Genero g, LibroGenero lg 
                    WHERE lg.idLibro = '$idLibro' AND g.idGenero = lg.idGenero";
$generosResultado = mysqli_query($conn, $consultaGeneros);

$generos = [];
while ($fila = mysqli_fetch_assoc($generosResultado)) {
    $generos[] = $fila['nombre'];
}
$listaGeneros = implode(', ', $generos);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 text-center mb-3 mb-md-0">
            <img src="img/libros/<?php echo htmlspecialchars($libro['portada']); ?>" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover;" alt="Portada del libro">
        </div>
        <div class="col-md-8">
            <h2><?php echo htmlspecialchars($libro['titulo']); ?></h2>
            <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['nombreAutor']); ?></p>
            <p><strong>Géneros:</strong> <?php echo htmlspecialchars($listaGeneros); ?></p>
            <p><strong>Páginas:</strong> <?php echo htmlspecialchars($libro['paginas']); ?></p>
            <p><strong>Publicado:</strong> <?php echo htmlspecialchars($libro['fpublicacion']); ?></p>
            <hr>
            <p><?php echo nl2br(htmlspecialchars($libro['descripcion'])); ?></p>
            <a href="libros.php" class="btn btn-secondary mt-3">← Volver al catálogo</a>
        </div>

        <?php
            // Obtener la media de puntuación del libro
            $consulta = "SELECT AVG(puntuacion) AS media FROM Opinion WHERE idLibro = '$idLibro'";
            $resultado = mysqli_query($conn, $consulta);
            $media = 0;

            if ($media_consultada = mysqli_fetch_assoc($resultado)) {
                $media = round($media_consultada['media'], 1); // Redondeamos a 1 decimal
            }
        ?>
    
        <div class="row justify-content-center mt-4">
            <h3 class="mt-4">Comentarios</h3>
        <div class="col-12 col-md-8">
            
            <?php 
            if ($media > 0) { 
            ?>
            <div class="mb-4 text-center">
                <!--ChatGPTeada apoteosica aquí-->
                <h5 class="mb-1">Valoración media</h5>
                <div class="puntuacion-comentario justify-content-center">
                    <div class="valoracion-media"><?php echo $media; ?> / 5</div>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= floor($media)) {
                            echo "<img src='img/star.png' class='estrella' alt='★'>";
                        } else {
                            echo "<img src='img/star.png' class='estrella vacia' alt='☆'>";
                        }
                    }
            }
            ?>
                    </div>
                </div>
            </div>



            <?php
            // Obtener comentarios del libro
            $consultaComentarios = "SELECT o.*, u.nombre_usuario 
                                     FROM Opinion o, Usuario u 
                                     WHERE o.idLibro = '$idLibro' AND o.idUsuario = u.idUsuario 
                                     ORDER BY o.fecha DESC";
            $comentariosResultado = mysqli_query($conn, $consultaComentarios);

            if (isset($_SESSION['user'])) {
                echo "<h4 class='mt-4'>Deja tu comentario</h4>";
                echo "<form action='guardar_comentario.php' method='POST'>";
                echo "<input type='hidden' name='idLibro' value='" . htmlspecialchars($idLibro) . "'>";
                echo "<div class='mb-3'>";
                echo "<label for='puntuacion' class='form-label'>Puntuación (1-5)</label>";
                echo "<input type='number' name='puntuacion' class='form-control' min='1' max='5' required>";
                echo "</div>";
                echo "<div class='mb-3'>";
                echo "<label for='comentario' class='form-label'>Comentario</label>";
                echo "<textarea name='comentario' class='form-control' rows='3' maxlength='250' required></textarea>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-primary'>Enviar</button>";
                echo "</form>";
            }

            if (mysqli_num_rows($comentariosResultado) > 0) {
                while ($comentario = mysqli_fetch_assoc($comentariosResultado)) {
                    echo "<div class='card mb-3'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($comentario['nombre_usuario']) . "</h5>";

                    if (isset($_SESSION['user']) && $_SESSION['user'] === $comentario['nombre_usuario']) {
                        echo "<form action='eliminar_comentario.php' method='POST'>";
                        echo "<input type='hidden' name='idOpinion' value='" . htmlspecialchars($comentario['idOpinion']) . "'>";
                        echo "<input type='hidden' name='idLibro' value='" . htmlspecialchars($idLibro) . "'>";
                        echo "<button type='submit' class='btn btn-sm btn-danger mb-2'>Eliminar</button>";
                        echo "</form>";
                    }


                    // Mostrar puntuación con estrellas
                    $puntuacion = (int)$comentario['puntuacion'];
                    echo "<div class='puntuacion-comentario'>";
                    echo "<strong>$puntuacion</strong> ";
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $puntuacion) {
                            echo "<img src='img/star.png' class='estrella' alt='★'>";
                        } else {
                            echo "<img src='img/star.png' class='estrella vacia' alt='☆'>";
                        }
                    }
                    echo "</div>";

                    echo "<p class='card-text'>" . nl2br(htmlspecialchars($comentario['comentario'])) . "</p>";
                    echo "<p class='card-text'><small class='text-muted'>Publicado el " . htmlspecialchars($comentario['fecha']) . "</small></p>";
                    echo "</div>";
                    echo "</div>";
                }

            } else {
                echo "<p>No hay comentarios para este libro.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php mysqli_close($conn); ?>