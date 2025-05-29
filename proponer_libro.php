<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include 'header.php';
include 'config/conexion.php';

$titulo = isset($_GET['titulo']) ? htmlspecialchars($_GET['titulo']) : '';
$mensaje = "";

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $autor = mysqli_real_escape_string($conn, $_POST['autor']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $paginas = intval($_POST['paginas']);
    $fpublicacion = !empty($_POST['fpublicacion']) ? "'" . mysqli_real_escape_string($conn, $_POST['fpublicacion']) . "'" : "NULL";

    // Procesar géneros
    $generos = isset($_POST['generos']) ? implode(',', array_map(
        fn($g) => mysqli_real_escape_string($conn, $g),
        $_POST['generos']
    )) : '';

    // Subida de imagen
    $portada = null;
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $nombreOriginal = basename($_FILES['portada']['name']);
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        $portada = uniqid('portada_', true) . '.' . $extension;

        $rutaDestino = 'img/propuestas/' . $portada;
        move_uploaded_file($_FILES['portada']['tmp_name'], $rutaDestino);
    }

    // Insertar propuesta
    $sql = "INSERT INTO LibroPropuesto (titulo, autor_nombre, descripcion, paginas, fpublicacion, portada, generos)
            VALUES ('$titulo', '$autor', '$descripcion', $paginas, $fpublicacion, '$portada', '$generos')";

    $resultado = mysqli_query($conn, $sql);
    $mensaje = $resultado ? "Tu propuesta ha sido enviada correctamente." : "Hubo un error: " . mysqli_error($conn);
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Proponer un nuevo libro</h2>

    <?php if (!empty($mensaje)): ?>
        <div class="alert <?= $resultado ? 'alert-success' : 'alert-danger' ?>"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título del libro</label>
            <input type="text" class="form-control" name="titulo" id="titulo" required value="<?= $titulo ?>">
        </div>

        <div class="mb-3">
            <label for="autor" class="form-label">Nombre del autor</label>
            <input type="text" class="form-control" name="autor" id="autor" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required></textarea>
        </div>

        <div class="mb-3">
        <label class="form-label">Géneros</label>
            <div class="row">
            <?php
            $queryGeneros = "SELECT * FROM Genero ORDER BY nombre ASC";
            $resGeneros = mysqli_query($conn, $queryGeneros);
            while ($genero = mysqli_fetch_assoc($resGeneros)) {
                echo '<div class="col-md-4">';
                echo '  <div class="form-check">';
                echo '    <input class="form-check-input" type="checkbox" name="generos[]" value="' . $genero['nombre'] . '" id="genero_' . $genero['idGenero'] . '">';
                echo '    <label class="form-check-label" for="genero_' . $genero['idGenero'] . '">' . htmlspecialchars($genero['nombre']) . '</label>';
                echo '  </div>';
                echo '</div>';
            }
            ?>
            </div>
        </div>


        <div class="mb-3">
            <label for="paginas" class="form-label">Número de páginas</label>
            <input type="number" class="form-control" name="paginas" id="paginas" required>
        </div>

        <div class="mb-3">
            <label for="fpublicacion" class="form-label">Fecha de publicación (opcional)</label>
            <input type="date" class="form-control" name="fpublicacion" id="fpublicacion">
        </div>

        <div class="mb-3">
            <label for="portada" class="form-label">Portada (imagen)</label>
            <input type="file" class="form-control" name="portada" id="portada" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Enviar propuesta</button>
        <a href="libros.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
