<!--
_______________________________________________________________________________
 __       ______  ______  ______  ______   ______   ______  __       __  __    
/\ \     /\  ___\/\__  _\/\__  _\/\  ___\ /\  == \ /\  ___\/\ \     /\ \_\ \   
\ \ \____\ \  __\\/_/\ \/\/_/\ \/\ \  __\ \ \  __< \ \  __\\ \ \____\ \____ \  
 \ \_____\\ \_____\ \ \_\   \ \_\ \ \_____\\ \_\ \_\\ \_\   \ \_____\\/\_____\ 
  \/_____/ \/_____/  \/_/    \/_/  \/_____/ \/_/ /_/ \/_/    \/_____/ \/_____/ 
_______________________________________________________________________________
Desarrollado por Adrián Fernández Ternero
Licenciado bajo: AGPLv3
letterfly.net


https://github.com/Adrifer24/letterfly

-->
<?php
session_start();

include 'header.php';

include 'config/conexion.php'; // Este archivo debe crear una conexión tipo: $conn = mysqli_connect(...);

// Búsqueda segura
$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conn, $_GET['busqueda']) : '';
?>
<div class="container mt-4">
    <form method="GET" action="libros.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="busqueda" class="form-control" placeholder="Buscar libros por título o autor" value="<?php echo htmlspecialchars($busqueda); ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
</div>

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
                    $queryGeneros = "SELECT * FROM Genero ORDER BY nombre ASC";;
                    $resultadoGeneros = mysqli_query($conn, $queryGeneros);
                    while ($genero = mysqli_fetch_assoc($resultadoGeneros)) {
                        $activo = (isset($_GET['genero']) && $_GET['genero'] == $genero['idGenero']) ? 'active' : '';
                        echo "<a href='libros.php?genero=" . urlencode($genero['idGenero']) . "' class='list-group-item list-group-item-action $activo'>" . htmlspecialchars($genero['nombre']) . "</a>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <?php
            if (isset($_GET['genero']) && $_GET['genero'] !== '') {
                $generoSeleccionado = mysqli_real_escape_string($conn, $_GET['genero']);
                $query = "
                    SELECT Libro.*
                    FROM Libro
                    JOIN LibroGenero ON Libro.idLibro = LibroGenero.idLibro
                    JOIN Autor ON Libro.autor = Autor.idAutor
                    WHERE LibroGenero.idGenero = '$generoSeleccionado'
                ";
                if (!empty($busqueda)) {
                    $query .= " AND (Libro.titulo LIKE '%$busqueda%' OR Autor.nombre LIKE '%$busqueda%')";
                }

            } else if (!empty($busqueda)) {
                $query = "
                SELECT Libro.*
                FROM Libro
                JOIN Autor ON Libro.autor = Autor.idAutor
                WHERE Libro.titulo LIKE '%$busqueda%' OR Autor.nombre LIKE '%$busqueda%'
            ";

            } else {
                $query = "SELECT * FROM Libro";
            }

            $resultado = mysqli_query($conn, $query);
            ?>
            <div class="row">
                <?php while($libro = mysqli_fetch_assoc($resultado)) { ?>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card h-100">
                            <?php 
                                $img_portada = $libro['portada'];
                                echo "<img src='img/libros/" . $img_portada . "' class='card-img-top img-fluid' style='height: 200px; object-fit: cover;' alt='Portada'>";
                            ?>
                            <div class="card-body">
                                <h6 class="card-title"><?php echo htmlspecialchars($libro['titulo']); ?></h6>
                                <p class="card-text" style="font-size: 0.9rem;"><?php echo htmlspecialchars(substr($libro['descripcion'], 0, 80)) . '...'; ?></p>
                                <a href="libro.php?id=<?php echo $libro['idLibro']; ?>" class="btn btn-sm btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                <?php } 
                
                $numResultados = mysqli_num_rows($resultado);

                if ($numResultados === 0) {
                    echo "
                    <div class='col-12'>
                        <div class='alert alert-warning text-center'>
                            No Hay Resultados
                        </div>
                        <div class='text-center'>
                            <a href='proponer_libro.php?titulo=" . urlencode($busqueda) . "' class='btn btn-success'>
                                ¿No está? ¡Proponlo tú!
                            </a>
                        </div>
                    </div>";
                }

                
                ?>
            </div>
        </div>
    </div>
</div>
<?php
mysqli_close($conn);
?>
