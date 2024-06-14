<?php
require 'peliculascontroller.php';

$controlador = new PeliculasController();

if (isset($_REQUEST['guardar']) && isset($_POST['titulo']) && isset($_POST['artista']) && isset($_POST['duracion']) && isset($_POST['genero']) && isset($_FILES['imagen'])) {
    $respuesta = $controlador->store($_POST['titulo'], $_POST['artista'], $_POST['duracion'], $_POST['genero'], $_FILES['imagen']);
}

$boton = 'guardar';
$formTitulo = 'Agregar Película';
$titulo = '';
$artista = '';
$duracion = '';
$genero = '';
$imagen = '';
$accion = 'formulario.php';
$requiered = 'required';

if (isset($_GET['p'])) {
    $peli = $controlador->show($_GET['p']);
    $boton = 'editar';
    $formTitulo = 'Editar Película';
    $titulo = $peli->titulo;
    $artista = $peli->artista;
    $duracion = $peli->duracion;
    $genero = $peli->genero;
    $imagen = $peli->imagen;
    $accion = 'index.php';
    $requiered = '';
}

include 'header.php';
?>
<br>
<br>
<div class="container mt-5">
    <?php if (isset($respuesta)): ?>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="alert alert-success text-center">
                Película Guardada
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card border-1 element-with-animated-shadow">
                <div class="card-header bg-dark text-white text-center">
                    <i class="fas fa-film me-2"></i><?= $formTitulo ?>
                </div>
                <div class="card-body">
                    <form action="<?= $accion ?>" method="post" enctype="multipart/form-data">
                        <?php if (isset($_GET['p'])): ?>
                        <input type="hidden" name="id" value="<?= $_GET['p'] ?>">
                        <?php endif ?>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-dark text-white"><i class="bi bi-balloon"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control border-info" name="titulo" id="titulo" value="<?= $titulo ?>" placeholder="titulo" required>
                                <label for="titulo">Título</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-users"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control border-info" name="artista" id="artista" value="<?= $artista ?>" placeholder="artista" required>
                                <label for="artista">Artista</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-dark text-white"><i class="fas fa-film"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control border-info" name="duracion" id="duracion" value="<?= $duracion ?>" placeholder="duracion" required>
                                <label for="duracion">Duración</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-clock"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control border-info" name="genero" id="genero" value="<?= $genero ?>" placeholder="genero" required>
                                <label for="genero">Género</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-image"></i></span>
                            <div class="form-floating">
                                <input type="file" class="form-control border-info" name="imagen" id="imagen" accept="image/*" <?= $requiered ?> >
                                <label for="imagen">Imagen</label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="<?= $boton ?>" class="btn btn-warning">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

