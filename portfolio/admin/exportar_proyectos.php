<?php
require_once "../includes/conexion.php";
require_once "../includes/funciones.php";

$conexion = conectarBD();
$proyectos = getProyectosBD($conexion);

if (empty($proyectos)) {
    header("Location: panel.php");
    exit();
}

$nombreFichero = "proyectos.csv";

header('Content-Type: text/csv; charset=UTF-8');
header("Content-Disposition: attachment; filename=$nombreFichero");
$output = fopen('php://output', 'w');

// Se supone que evita problemas con ñs y tildes
fputs($output, "\xEF\xBB\xBF");

fputcsv($output, ['id','Título','Descripción','Categoría','Tecnologías'], ';');

foreach ($proyectos as $p) {
    fputcsv(
        $output,
        [
            $p['id'],
            $p['titulo'],
            $p['descripcion'],
            $p['categoria'],
            implode(', ', $p['tecnologias'])
        ],
        ';'
    );
}

exit();
