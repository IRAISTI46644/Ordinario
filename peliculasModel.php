<?php
include 'config.php';

class PeliculasModel {
    // atributos de la clase
    private $conexion;

    // constructor
    public function __construct() {
        $this->conexion = new PDO('mysql:host='.BD_HOST.';dbname='.BD_NAME, BD_USER, BD_PASSWORD);
    }

    function getPeliculas() {
        $sql = "SELECT * FROM canciones";
        $rows = $this->conexion->query($sql);
        $peliculas = $rows->fetchAll(PDO::FETCH_ASSOC);
        return json_decode(json_encode($peliculas));
    }

    function getPelicula($id) {
        $sql = "SELECT * FROM canciones WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);
        return json_decode(json_encode($pelicula));
    }

    function save($titulo, $artista, $duracion, $genero, $imagen) {
        $sql = $this->conexion->prepare("INSERT INTO canciones (titulo, artista, duracion, genero, imagen) VALUES (?, ?, ?, ?, ?)");
        $sql->execute([$titulo, $artista, $duracion, $genero, $imagen]);
        return $this->conexion->lastInsertId();
    }

    function update($id, $titulo, $artista, $duracion, $genero) {
        $sql = $this->conexion->prepare("
            UPDATE canciones SET titulo = ?, artista = ?, duracion = ?, genero = ? WHERE id = ?
        ");
        $sql->execute([$titulo, $artista, $duracion, $genero, $id]);
        return "Pelicula Actualizada";
    }

    function delete($id) {
        $sql = $this->conexion->prepare("DELETE FROM canciones WHERE id = ?");
        $sql->execute([$id]);
        return "Pelicula Eliminada";
    }

    function updateImg($id, $imagen) {
        $sql = $this->conexion->prepare("UPDATE canciones SET imagen = ? WHERE id = ?");
        $sql->execute([$imagen, $id]);
    }
}
