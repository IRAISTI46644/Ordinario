<?php
include 'header.php';
require 'peliculasController.php';

$controlador = new PeliculasController();

// Obtener detalles de la película si se proporciona un ID válido
if (isset($_GET['id'])) {
    $pelicula = $controlador->show($_GET['id']);
    if ($pelicula) {
        $titulo = $pelicula->titulo;
        $artista = $pelicula->artista;
        $duracion = $pelicula->duracion;
        $genero = $pelicula->genero;
        $imagen = $pelicula->imagen;
    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <div class="row mt-3">
        <div class="col-8">
            <div class="card shadow border border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title"><?= htmlspecialchars($titulo) ?></h5>
                    <a href="index.php" class="btn btn-primary float-end"><i class="bi bi-house-door-fill"></i> Volver al inicio</a>
                </div>
                <div class="card-body">
                    <p class="card-text">Artista: <?= htmlspecialchars($artista) ?></p>
                    <p class="card-text">Duración: <?= htmlspecialchars($duracion) ?></p>
                    <p class="card-text">Género: <?= htmlspecialchars($genero) ?></p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <img src="img/<?= htmlspecialchars($imagen) ?>" alt="<?= htmlspecialchars($titulo) ?>" style="max-width: 100%; height: auto;">
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
