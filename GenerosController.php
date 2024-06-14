<?php
require 'GenerosModel.php';

class GenerosController {

    private $model;

    public function __construct() {
        $this->model = new GenerosModel();
    }

    // Obtener todos los géneros
    public function index() {
        return $this->model->getAllGeneros();
    }

    // Guardar un nuevo género
    public function store($generos) {
        if (!empty($generos)) {
            $this->model->saveGenero($generos);
            return 'Género agregado exitosamente';
        }
    }

    // Actualizar un género existente
    public function update($id, $generos) {
        if (!empty($generos)) {
            $this->model->updateGenero($id, $generos);
            return 'Género actualizado exitosamente';
        }
    }

    // Eliminar un género
    public function destroy($id) {
        $this->model->deleteGenero($id);
        return 'Género eliminado exitosamente';
    }
}
?>
