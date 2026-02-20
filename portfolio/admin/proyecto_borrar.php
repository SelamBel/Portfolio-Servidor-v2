<?php
session_start();
$rol = $_SESSION["rol"] ?? null;
if ($rol != "ADMIN") {
    header("Location: ../index.php");
    exit();
}

require_once "../includes/conexion.php";
require_once "../includes/funciones.php";
$conexion = conectarBD();

if ($conexion === null) {
    header("Location: panel.php?error=" . urlencode("No se pueden borrar datos en local"));
    exit();
}

$id = $_GET['id'] ?? null;
if ($id === null) {
    header("Location: panel.php?error=" . urlencode("ID no proporcionado"));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conexion->prepare("SELECT imagen FROM proyectos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $imagen = $stmt->fetchColumn();

    $linkImg = "../static/img/img/$imagen";
    if ($imagen && file_exists($linkImg)) {
        unlink($linkImg);
    }

    $stmt = $conexion->prepare("DELETE FROM proyectos WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header("Location: panel.php");
    exit();
}

$proyecto = getProyectoById($conexion, $id);
if ($proyecto === null) {
    header("Location: panel.php?error=" . urlencode("Proyecto no encontrado"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Proyecto</title>
    <link rel="stylesheet" href="../static/css/topnav-footer.css">
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="../static/css/private.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php require_once '../templates/nav-admin.php'; ?>

    <main>
        <h1><i class="fa fa-trash"></i> Borrar proyecto</h1>
        <div class="confirmBox">
            <p>¿Estás seguro de que deseas borrar el proyecto 
               <strong><?php echo htmlspecialchars($proyecto['titulo']); ?></strong> 
               (ID: <?php echo $id; ?>)?
            </p>
        </div>
        <form id="confirmDelete" method="post" action="proyecto_borrar.php?id=<?php echo $id; ?>">
            <a id="cancelDelete" class="button" href="panel.php">Cancelar</a>
            <button type="submit" class="button btnBorrar">Borrar</button>
        </form>
    </main>

    <?php require_once '../templates/footer-admin.php'; ?>
</body>
</html>