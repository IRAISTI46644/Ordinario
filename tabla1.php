<?php 
require 'GenerosController.php';  
$controlador = new GenerosController();
$respuesta = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['genero']) && !isset($_POST['id'])) {
        // Acción de añadir
        $controlador->store($_POST['genero']);
        $respuesta = 'Género agregado exitosamente';
    } elseif (isset($_POST['id'], $_POST['editar'])) {
        // Acción de editar
        $controlador->update($_POST['id'], $_POST['genero']);
        $respuesta = 'Género actualizado exitosamente';
    } elseif (isset($_POST['id'], $_POST['eliminar'])) {
        // Acción de eliminar
        $controlador->destroy($_POST['id']);
        $respuesta = 'Género eliminado exitosamente';
    }
}

$generos = $controlador->index(); // Asumiendo que este método devuelve todos los géneros

include 'header.php'; 
?>

<!-- Modal para añadir nuevo género -->
<div class="modal fade" id="addGeneroModal" tabindex="-1" aria-labelledby="addGeneroModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addGeneroModalLabel">Añadir nuevo género</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tabla1.php" method="post">
          <div class="mb-3">
            <label for="genero" class="form-label">Género</label>
            <input type="text" class="form-control" id="genero" name="genero" required>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para editar género -->
<div class="modal fade" id="editGeneroModal" tabindex="-1" aria-labelledby="editGeneroModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editGeneroModalLabel">Editar género</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tabla1.php" method="post">
          <input type="hidden" id="edit-id" name="id">
          <div class="mb-3">
            <label for="edit-genero" class="form-label">Género</label>
            <input type="text" class="form-control" id="edit-genero" name="genero" maxlength="15" required>
          </div>
          <button type="submit" name="editar" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para ver detalles del género -->
<div class="modal fade" id="viewGeneroModal" tabindex="-1" aria-labelledby="viewGeneroModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewGeneroModalLabel">Detalles del Género</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Aquí se carga el contenido dinámicamente -->
      </div>
    </div>
  </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar este género?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<?php if (isset($respuesta)): ?>
<div class="row mt-3">
    <div class="col-md-4 offset-md-4">
        <div class="alert alert-success">
            <?= $respuesta ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col-md-3 offset-md-4">
        <!-- Botón para abrir el modal de añadir género -->
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addGeneroModal">
            <i class="fa-solid fa-plus"></i> Añadir
        </button>
        <a href="reporte.php" class="btn btn-outline-danger">
            <i class="fa-solid fa-file-pdf"></i> PDF
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover"> 
                <thead>
                    <tr>
                        <th>#</th>
                        <th>GÉNERO</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($generos as $i => $genero): ?>
                        <tr>
                            <td><?= ($i + 1) ?></td>
                            <td><?= htmlspecialchars($genero['genero']) ?></td>
                            <td>
                            <button type="button" class="btn btn-outline-success view-button" data-id="<?= $genero['id'] ?>" data-genero="<?= htmlspecialchars($genero['genero']) ?>" data-bs-toggle="modal" data-bs-target="#viewGeneroModal">
                                <i class="fa<!-- fa-solid fa-eye"></i> 
                            </button>
                            </td>
                            <td>
                                <!-- Botón para abrir el modal de edición -->
                                <button type="button" class="btn btn-outline-info edit-button" data-id="<?= $genero['id'] ?>" data-genero="<?= htmlspecialchars($genero['genero']) ?>" data-bs-toggle="modal" data-bs-target="#editGeneroModal">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>
                            </td>
                            
                            <td>
                                <!-- Formulario para eliminar género -->
                                <form action="tabla1.php" method="post">
                                    <input type="hidden" name="id" value="<?= $genero['id'] ?>">
                                    <button type="submit" name="eliminar" class="btn btn-outline-danger delete-button" data-id="<?= $genero['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                        <i class="fa-solid fa-trash-can"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

