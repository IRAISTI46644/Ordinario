<?php
require 'vendor/autoload.php';  // Incluir el autoload de Composer para FPDF
require 'peliculasController.php';  // Incluir el controlador de películas

use Fpdf\Fpdf;

// Crear una instancia de FPDF
$pdf = new Fpdf();

// Agregar una página
$pdf->AddPage();

// Establecer el título del documento en mayúsculas y con acentos
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode(strtoupper('Reporte de Películas')), 0, 1, 'C');

// Espaciado después del título
$pdf->Ln(10);

// Definir ancho de las columnas
$columnWidths = [10, 50, 50, 30, 30, 40];

// Crear la cabecera de la tabla de películas en mayúsculas y con acentos
$pdf->SetFont('Arial', 'B', 12);
for ($i = 0; $i < count($columnWidths); $i++) {
    $pdf->Cell($columnWidths[$i], 10, utf8_decode(getHeaderLabel($i)), 1, 0, 'C');
}
$pdf->Ln();

// Obtener las películas desde el controlador
$controlador = new PeliculasController();
$pelis = $controlador->index();

$pdf->SetFont('Arial', '', 10);
foreach ($pelis as $i => $pelicula) {
    $pdf->Cell($columnWidths[0], 10, $i + 1, 1, 0, 'C');  // #
    $pdf->Cell($columnWidths[1], 10, utf8_decode($pelicula->titulo), 1, 0, 'L');  // Título
    $pdf->Cell($columnWidths[2], 10, utf8_decode($pelicula->artista), 1, 0, 'L');  // Artista
    $pdf->Cell($columnWidths[3], 10, utf8_decode($pelicula->duracion), 1, 0, 'C');  // Duración
    $pdf->Cell($columnWidths[4], 10, utf8_decode($pelicula->genero), 1, 0, 'L');  // Género
    // Manejar la imagen (si es necesario)
    if (!empty($pelicula->imagen)) {
        $pdf->Cell($columnWidths[5], 10, $pdf->Image('img/' . $pelicula->imagen, $pdf->GetX() + 1, $pdf->GetY() + 1, 28, 0, 'JPEG'), 1, 1, 'C');  // Imagen
    } else {
        $pdf->Cell($columnWidths[5], 10, utf8_decode('No disponible'), 1, 1, 'C');  // Imagen (si no hay imagen)
    }
}

// Salida del PDF
$pdf->Output('D', 'Reporte_peliculas.pdf');  // Descargar el archivo como "Reporte_peliculas.pdf"

// Función auxiliar para obtener el nombre de la cabecera según el índice en mayúsculas y con acentos
function getHeaderLabel($index) {
    $headers = ['#', 'Título', 'Artista', 'Duración', 'Género', 'Imagen'];
    return isset($headers[$index]) ? utf8_decode(strtoupper($headers[$index])) : '';
}
?>
