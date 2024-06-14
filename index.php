<?php 
require 'peliculasController.php';

$controlador = new PeliculasController();

if (isset($_REQUEST['eliminar']) && isset($_POST['id'])) {
    $respuesta = $controlador->destroy($_POST['id']);
}

if (isset($_REQUEST['editar']) && isset($_POST['titulo']) && isset($_POST['artista']) && isset($_POST['duracion']) && isset($_POST['genero']) && isset($_FILES['imagen'])) {
    $respuesta = $controlador->update($_POST['id'], $_POST['titulo'], $_POST['artista'], $_POST['duracion'], $_POST['genero'], $_FILES['imagen']);
}

$pelis = $controlador->index();

include 'header.php'; 
?>

<div class="container mt-5">
    <?php if (isset($respuesta)): ?>
    <div class="row mt-5">
        <div class="col-md-10 offset-md-2">
            <div class="alert alert-success text-center">
                <?=$respuesta?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col-md-10 offset-md-2">
            <div class="table-responsive element-with-animated-shadow">
                <table class="table table-bordered table-hover"> 
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Artista</th>
                            <th>Duración</th>
                            <th>Género</th>
                            <th>Imagen</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pelis as $i => $pelicula): ?>
                            <tr>
                                <td><?=($i+1)?></td>
                                <td><?=$pelicula->titulo?></td>
                                <td><?=$pelicula->artista?></td>
                                <td><?=$pelicula->duracion?></td>
                                <td><?=$pelicula->genero?></td>
                                <td>
                                    <img src="img/<?=$pelicula->imagen?>" width="60px">
                                </td>
                                <td>
                                    <a href="formulario.php?p=<?=$pelicula->id?>" class="btn btn-outline-info"><i class="bi bi-pencil-square"></i> Editar</a>
                                </td>
                                <td>
                                    <a href="detalle.php?id=<?=$pelicula->id?>" class="btn btn-outline-success"><i class="bi bi-info-square-fill"></i> Información</a>
                                </td>
                                <td>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="id" value="<?=$pelicula->id?>">
                                        <button name="eliminar" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 offset-md-2 text-center">
            <a href="formulario.php" class="btn btn-info">
                <i class="fa-solid fa-plus"></i> Añadir
            </a>
            <a href="reporte.php" class="btn btn-danger">PDF</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
