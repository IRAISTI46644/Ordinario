<<?php
spl_autoload_register();
use operaciones\Archivo;

$archivo = new Archivo();

if (isset($_REQUEST['guardar']) && isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['contrasena']) && isset($_FILES['avatar'])) {
    $respuesta = $archivo->guardar($_POST['nombre'], $_POST['correo'], $_POST['contrasena'], $_FILES['avatar']);
} else if (isset($_REQUEST['actualizar']) && isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['contrasena']) && isset($_POST['posicion'])) {
    $respuesta = $archivo->editar($_POST['posicion'], $_POST['nombre'], $_POST['correo'], $_POST['contrasena'], $_FILES['avatar']);
} else if (isset($_REQUEST['eliminar']) && isset($_POST['posicion'])) {
    $respuesta = $archivo->eliminar($_POST['posicion']);
} else if (isset($_REQUEST['añadir']) && isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['contrasena']) && isset($_FILES['avatar'])) {
    $respuesta = $archivo->añadir($_POST['nombre'], $_POST['correo'], $_POST['contrasena'], $_FILES['avatar']);
}

$usuarios = $archivo->leer();

include 'header.php';
?>


<div class="row mt-3">
    <div class="table-responsive">
        <table class="table table-bordered table-hover"> 
            <thead>
                <tr>
                    <th>#</th>
                    <th>NOMBRE</th>
                    <th>CORREO</th>
                    <th>AVATAR</th>
                    <th>CONTRASEÑA</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <div class="row mt-3">
    <div class="col-md-4 offset-md-4">
        <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#usuarioModal">
            <i class="fa-solid fa-plus"></i> Añadir
        </a>
        <a href="reporte.php" class="btn btn-outline-danger">
        <i class="fa-solid fa-file-pdf"></i> PDF
        </a>
    </div>
</div>
                <?php foreach ($usuarios as $i => $usr): ?>
                    <tr>
                        <td><?= ($i + 1) ?></td>
                        <td><?= $usr['nombre'] ?></td>
                        <td><?= $usr['correo'] ?></td>
                        <td><img src="img/<?= $usr['avatar'] ?>" height="80"></td>
                        <td><?= $usr['contrasena'] ?></td>

                        <td>
                            <!-- Botón para abrir el modal de detalles -->
                            <a href="#" class="btn btn-outline-success text-dark" data-bs-toggle="modal" data-bs-target="#viewModal<?= $i ?>"><i class="fa-solid fa-circle-info"></i></a>

                            <!-- Modal de detalles -->
                            <div class="modal fade" id="viewModal<?= $i ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $i ?>" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel<?= $i ?>">Detalles del Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="img/<?= $usr['avatar'] ?>" alt="Avatar del usuario" style="width:100px;">
                                        </div>
                                        <div class="col-md-8">
                                            <h3><?= htmlspecialchars($usr['nombre']) ?></h3>
                                            <p><strong>Correo: </strong><?= htmlspecialchars($usr['correo']) ?></p>
                                            <p><strong>Contraseña: </strong><?= htmlspecialchars($usr['contrasena']) ?></p>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </td>
                        <!-- Botón para abrir el modal de edición -->
                        <!-- Botón para abrir el modal de edición -->
<td><a href="#" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#editUsuarioModal" onclick="openEditModal(<?= $i ?>, '<?= htmlspecialchars($usr['nombre'], ENT_QUOTES) ?>', '<?= htmlspecialchars($usr['correo'], ENT_QUOTES) ?>')"><i class="fa-solid fa-pen-to-square"></i></a></td>


                        <td>
                            <!-- Botón para abrir el modal de confirmación de eliminación -->
                            <button class="btn btn-outline-danger text-dark" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="document.getElementById('deleteId').value = '<?=$i?>';"><i class="fa-solid fa-trash-can"></i></button>

                            <!-- Modal de confirmación de eliminación -->
                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    ¿Estás seguro de que quieres eliminar este usuario?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="Usuarios.php" method="post">
                                        <input type="hidden" id="deleteId" name="posicion">
                                        <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para crear usuario -->
<div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="usuarioModalLabel">Crear Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="usuarioForm" action="Usuarios.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="nombre" class="form-label text-dark">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="30" required>
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label text-dark">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" maxlength="25" required>
          </div>
          <div class="mb-3">
            <label for="contrasena" class="form-label text-dark">Contraseña</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" maxlength="15" required>
          </div>
          <div class="mb-3">
            <label for="avatar" class="form-label text-dark">Avatar</label>
            <input type="file" class="form-control" id="avatar" name="avatar" maxlength="255">
          </div>
          <input type="hidden" id="posicion" name="posicion">
          <button type="submit" name="guardar" id="guardarBtn" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para editar -->
<div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="editUsuarioModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editUsuarioForm" action="Usuarios.php" method="post" enctype="multipart/form-data">
          <input type="hidden" id="editPosicion" name="posicion">
          <div class="mb-3">
            <label for="editNombre" class="form-label text-dark">Nombre</label>
            <input type="text" class="form-control" id="editNombre" name="nombre" maxlength="30" required>
          </div>
          <div class="mb-3">
            <label for="editCorreo" class="form-label text-dark">Correo</label>
            <input type="email" class="form-control" id="editCorreo" name="correo" maxlength="25" required>
          </div>
          <div class="mb-3">
            <label for="editContrasena" class="form-label text-dark">Contraseña</label>
            <input type="password" class="form-control" id="editContrasena" name="contrasena" maxlength="15">
          </div>
          <div class="mb-3">
            <label for="editAvatar" class="form-label text-dark">Avatar</label>
            <input type="file" class="form-control" id="editAvatar" name="avatar" maxlength="255">
          </div>
          <button type="submit" name="actualizar" id="editarBtn" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function openEditModal(posicion, nombre, correo) {
    document.getElementById('editPosicion').value = posicion;
    document.getElementById('editNombre').value = nombre;
    document.getElementById('editCorreo').value = correo;
    document.getElementById('editContrasena').value = '';

    var editModal = new bootstrap.Modal(document.getElementById('editUsuarioModal'));
    editModal.show();
}
</script>

<?php include 'footer.php'; ?>
