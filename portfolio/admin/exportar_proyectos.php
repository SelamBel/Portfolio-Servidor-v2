<?php
require_once "../includes/conexion.php";
require_once "../includes/funciones.php";
session_start();
$rol = $_SESSION["rol"] ?? null;
if ($rol != "ADMIN") {
    header("Location: ../index.php");
    exit();
}

$conexion = conectarBD();
$proyectos = getProyectosBD($conexion);

if (empty($proyectos)) {
    header("Location: panel.php?error=" . urlencode("No hay proyectos actualmente, o no tienes acceso a la base de datos"));
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
