<?php
require_once "../includes/conexion.php";

$conexion = conectarBD();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexion->prepare("SELECT imagen FROM proyectos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $imagen = $stmt->fetchColumn();

    $linkImg = "../static/img/img/$imagen";
    if ($imagen && file_exists($linkImg)) {
        unlink($linkImg );
    }

    $stmt = $conexion->prepare("DELETE FROM proyectos WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: panel.php");
exit();
