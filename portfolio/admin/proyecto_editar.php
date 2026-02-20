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
$id = $_GET["id"] ?? null;

if ($conexion === null) {
    header("Location: panel.php?error=" . urlencode("No se pueden guardar datos en local"));
    exit();
}

if ($id == null) {
    header("Location: panel.php?error=" . urlencode("Ha habido un error pasando el id para editar"));
    exit();
}

$proyecto = getProyectoById($conexion, $id);
if ($proyecto === null) {
    header("Location: panel.php?error=" . urlencode("Proyecto no encontrado"));
    exit();
}


$categorias = getCategorias($conexion);
if (empty($categorias)) $categorias = ["Backend", "Frontend", "Fullstack"];

$tecnologias = getTecnologias($conexion);
if (empty($tecnologias)) $tecnologias = ["HTML", "CSS", "Bootstrap", "PHP", "MySQL", "JavaScript", "PDO"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $categoria = $_POST['catSeleccionada'] ?? '';
    $tecnologias = $_POST['tecnologias'] ?? [];

    $nombreImagen = null;
    $tmpImagen = null;
    $extensionImagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmpImagen = $_FILES['imagen']['tmp_name'];
        $extensionImagen = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreImagen = uniqid('proyecto_') . '.' . $extensionImagen;
    }

    $ok = editarProyecto($conexion, $id, $titulo, $descripcion, $categoria, $tecnologias, $nombreImagen);

    if ($ok) {
        if ($tmpImagen !== null) {
            move_uploaded_file($tmpImagen, "../static/img/img/" . $nombreImagen);
        }
        header("Location: panel.php");
    } else {
        header("Location: panel.php?error=" . urlencode("Error al editar el proyecto"));
    }
    exit();
}

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
            <h1>Editar proyecto</h1>
            <label for="newTitulo">Titulo: <input type="text" id="newTitulo" name="titulo" required value=" <?php echo $proyecto["titulo"] ?> "></label>
            <label for="newDesc">Descripción: <textarea id="newDesc" name="descripcion" required> <?php echo $proyecto["descripcion"] ?> </textarea></label>
            <label for="categoria">Categoria: <?php echo generarSelect($categorias, $proyecto["categoria"], false) ?></label>
            <label for="tecnologias">Tecnologías: <?php echo generarMultiSelect($tecnologias, $proyecto["tecnologias"]); ?></label>
            <label for="imagen">Imagen: <input type="file" id="imagen" name="imagen"></label>
            <div class="divImg">
                <label>Imágen Actual: <img src="../<?php echo $proyecto['imagen']; ?>" alt="Imagen actual"></label>
                <label>Imágen Nueva: <img id="imgPreview" src="" alt="Sin imagen seleccionada" style="display:none;"></label>
            </div>
            <button type="submit" id="btnEditarProyecto">Editar Proyecto</button>
        </form>
    </main>
    <?php require_once '../templates/footer-admin.php'; ?>

    <script>
        // Este script es para la visualización de la imágen antes de la subida
        document.getElementById('imagen').addEventListener('change', function(e) {
            const preview = document.getElementById('imgPreview');
            const file = e.target.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    </script>
</body>

</html>