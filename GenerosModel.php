<?php
include 'config1.php';

class GenerosModel {
    private $conexion;

    public function __construct() {
        $this->conexion = new PDO('mysql:host=' . BD_HOST . ';dbname=' . BD_NAME, BD_USER, BD_PASSWORD);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Obtener todos los géneros
    public function getAllGeneros() {
        $sql = "SELECT * FROM generos";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un género por ID
    public function getGeneroById($id) {
        $sql = "SELECT * FROM generos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Guardar un nuevo género
    public function saveGenero($genero) {
        $sql = "INSERT INTO generos (genero) VALUES (?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$genero]);
        return $this->conexion->lastInsertId();
    }

    // Actualizar un género existente
    public function updateGenero($id, $genero) {
        $sql = "UPDATE generos SET genero = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$genero, $id]);
        return $stmt->rowCount();
    }

    // Eliminar un género
    public function deleteGenero($id) {
        $sql = "DELETE FROM generos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
?>
