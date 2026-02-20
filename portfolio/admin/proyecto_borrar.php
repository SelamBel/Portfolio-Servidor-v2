<?php
session_start();
$rol = $_SESSION["rol"] ?? null;
if ($rol != "ADMIN") {
    header("Location: ../index.php");
    exit();
}

require_once "../includes/conexion.php";

$conexion = conectarBD();

if ($conexion === null) {
    header("Location: panel.php?error=No se pueden borrar datos en local");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexion->prepare("SELECT imagen FROM proyectos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $imagen = $stmt->fetchColumn();

    $linkImg = "../static/img/img/$imagen";
    if ($imagen && file_exists($linkImg)) {
        unlink($linkImg);
    }

    $stmt = $conexion->prepare("DELETE FROM proyectos WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: panel.php");
exit();