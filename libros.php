<?php
session_start();

include 'header.php'; // Asume que ya contiene Bootstrap y el menú

// Conexión a la base de datos
include 'config/conexion.php';
// Verificar si se envió una búsqueda
$busqueda = isset($_GET['busqueda']) ? $conn->real_escape_string($_GET['busqueda']) : '';

// Modificar la consulta para incluir la búsqueda
?>
<div class="container mt-4">
    <form method="GET" action="libros.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="busqueda" class="form-control" placeholder="Buscar libros por título o autor" value="<?php echo htmlspecialchars($busqueda); ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
</div>
<?php
$query = "SELECT * FROM Libro";
if (!empty($busqueda)) {
    $query = "SELECT * FROM Libro WHERE titulo LIKE '%$busqueda%' OR autor LIKE '%$busqueda%'";
}
$resultado = $conn->query($query);
?>
<div class="container mt-4">
    <div class="row">
    <div class="col-12 col-md-3 mb-4">
    <!-- Botón para móviles -->
    <button class="btn btn-outline-secondary w-100 mb-2 d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#menuGeneros" aria-expanded="false" aria-controls="menuGeneros">
        Mostrar géneros
    </button>

    <div class="collapse d-md-block" id="menuGeneros">
        <div class="list-group">
            <a href="libros.php" class="list-group-item list-group-item-action <?php echo (!isset($_GET['genero']) || $_GET['genero'] === '') ? 'active' : ''; ?>">Todos los géneros</a>
            <?php
            // Obtener géneros desde la base de datos
            $queryGeneros = "SELECT * FROM Genero ORDER BY idGenero ASC";
            $resultadoGeneros = $conn->query($queryGeneros);
            while ($genero = $resultadoGeneros->fetch_assoc()) {
                $activo = (isset($_GET['genero']) && $_GET['genero'] == $genero['idGenero']) ? 'active' : '';
                echo "<a href='libros.php?genero=" . urlencode($genero['idGenero']) . "' class='list-group-item list-group-item-action $activo'>" . htmlspecialchars($genero['nombre']) . "</a>";
            }
            ?>
        </div>
    </div>
</div>

    <div class="col-md-9">
<?php
// Filtrar libros por género si se selecciona uno
if (isset($_GET['genero']) && $_GET['genero'] !== '') {
$generoSeleccionado = $conn->real_escape_string($_GET['genero']);
$query = "SELECT * FROM Libro WHERE genero = '$generoSeleccionado'";
if (!empty($busqueda)) {
    $query .= " AND (titulo LIKE '%$busqueda%' OR autor LIKE '%$busqueda%')";
}
} else if (!empty($busqueda)) {
$query = "SELECT * FROM Libro WHERE titulo LIKE '%$busqueda%' OR autor LIKE '%$busqueda%'";
} else {
$query = "SELECT * FROM Libro";
}
$resultado = $conn->query($query);
?>
    <div class="row">
        <?php while($libro = $resultado->fetch_assoc()) { ?>
            <div class="col-6 col-md-3 mb-3"> <!-- Agregado col-6 para que en móvil sean 2 columnas -->
                <div class="card h-100">
                    <?php 
                        $img_portada = $libro['portada'];
                        echo "<img src='img/libros/" .$img_portada."' class='card-img-top img-fluid' style='height: 200px; object-fit: cover;' alt='Portada'>"; // Reducido el tamaño de la imagen
                    ?>
                    <div class="card-body">
                        <h6 class="card-title"><?php echo htmlspecialchars($libro['titulo']); ?></h6> <!-- Cambiado h5 a h6 para un título más pequeño -->
                        <p class="card-text" style="font-size: 0.9rem;"><?php echo htmlspecialchars(substr($libro['descripcion'], 0, 80)) . '...'; ?></p> <!-- Reducido el tamaño del texto -->
                        <a href="libro.php?id=<?php echo $libro['idLibro']; ?>" class="btn btn-sm btn-primary">Ver más</a> <!-- Botón más pequeño -->
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php
$conn->close();
?>
