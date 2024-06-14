<?php

require 'peliculasModel.php';

class PeliculasController {

    function index() {
        $bd = new PeliculasModel();
        $peliculas = $bd->getPeliculas();
        return $peliculas;
    }

    function show($id) {
        $bd = new PeliculasModel();
        $pelicula = $bd->getPelicula($id);
        return $pelicula;
    }

    function store($titulo, $artista, $duracion, $genero, $image) {
        $bd = new PeliculasModel();
        $newId = $bd->save($titulo, $artista, $duracion, $genero, $image['name']);
        $imgFileName = $newId . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $this->guardarImagen($image, $imgFileName);
        $bd->updateImg($newId, $imgFileName);
        return $newId;
    }

    function update($id, $titulo, $artista, $duracion, $genero, $image) {
        $bd = new PeliculasModel();
        $edit = $bd->update($id, $titulo, $artista, $duracion, $genero);
        if (!empty($image['name'])) {
            $this->eliminarImagen($id);
            $imgFileName = $id . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
            $this->guardarImagen($image, $imgFileName);
            $bd->updateImg($id, $imgFileName);
        }
        return $edit;
    }

    function destroy($id) {
        $bd = new PeliculasModel();
        $this->eliminarImagen($id);
        $del = $bd->delete($id);
        return $del;
    }

    function eliminarImagen($id) {
        $peli = $this->show($id);
        $img = __DIR__ . '/img/' . $peli->imagen;
        if (file_exists($img)) {
            unlink($img);
        }
    }

    function guardarImagen($image, $imgFileName): void {
        $ubicacion = __DIR__ . '/img/' . $imgFileName;
        if (!move_uploaded_file($image['tmp_name'], $ubicacion)) {
            throw new Exception('Error al guardar la imagen.');
        }
    }
}
?>
