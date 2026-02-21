<?php
session_start();
$rol = $_SESSION["rol"] ?? null;
if ($rol != "ADMIN") {
    header("Location: ../index.php");
    exit();
}

include_once "../includes/conexion.php";
include_once "../includes/funciones.php";
require_once '../datos.php';
$conexion = conectarBD();

if ($conexion === null) {
    header("Location: panel.php?error=" . urlencode("No se pueden crear proyectos en local"));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $categoria = $_POST['catSeleccionada'] ?? '';
    $tecnologias = $_POST['tecnologias'] ?? [];

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($_FILES['imagen']['type'], $tiposPermitidos)) {
        header("Location: panel.php?error=" . urlencode("Solo se permiten imágenes"));
        exit();
    }

    $nombreImagen = 'placeholder.png';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreImagen = uniqid('proyecto_') . '.' . $extension;
        $destino = "../static/img/img/" . $nombreImagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
    }

    $ok = crearProyecto($conexion, $titulo, $descripcion, $categoria, $tecnologias, $nombreImagen);

    if ($ok) {
        header("Location: panel.php");
    } else {
        header("Location: panel.php?error=" . urlencode("Error al crear el proyecto"));
    }
    exit();
}

$categorias = getCategorias($conexion);
if (empty($categorias)) $categorias = ["Backend", "Frontend", "Fullstack"];

$tecnologias = getTecnologias($conexion);
if (empty($tecnologias)) $tecnologias = ["HTML", "CSS", "Bootstrap", "PHP", "MySQL", "JavaScript", "PDO"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../static/css/topnav-footer.css">
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="../static/css/private.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php require_once '../templates/nav-admin.php'; ?>

    <main>
        <form id="newProyectForm" method="post" enctype="multipart/form-data">
            <h1>Nuevo proyecto</h1>
            <label for="newTitulo">Titulo: <input type="text" id="newTitulo" name="titulo" required></label>
            <label for="newDesc">Descripción: <textarea id="newDesc" name="descripcion" required></textarea></label>
            <label for="categoria">Categoria: <?php echo generarSelect($categorias, "", false) ?></label>
            <label for="tecnologias">Tecnologías: <?php echo generarMultiSelect($tecnologias); ?></label>
            <label for="imagen">Imagen: <input type="file" id="imagen" name="imagen"></label>
            <button type="submit" id="btnCrearNuevoProyecto">Crear Proyecto</button>
        </form>
    </main>
    <?php require_once '../templates/footer-admin.php'; ?>
</body>
</html>